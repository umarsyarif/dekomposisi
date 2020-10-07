<?php

namespace App;

use stdClass;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['waktu'];

    public static function getDataLatih()
    {
        $lastYear = self::getLastYear();
        $dataLatih = self::whereYear('waktu', '!=', $lastYear)->get();
        return $dataLatih;
    }

    public static function getDataUji($month = 0)
    {
        $lastYear = self::getLastYear();
        $dataUji = self::whereYear('waktu', $lastYear)
            ->when($month != 0, function ($q) use ($month) {
                return $q->whereMonth('waktu', $month);
            })
            ->get();
        return $dataUji;
    }

    public static function getNilaiTrend()
    {
        $dataLatih = self::getDataLatih();
        $sum = [
            'x2' => 0,
            'logy' => 0,
            'xlogy' => 0
        ];
        $index = 0;
        $count = count($dataLatih);
        foreach ($dataLatih as $row) {
            $row->y = $row->jumlah;
            $row->x = $count % 2 == 0 ? ($index - round($count / 2)) * 2 + 1 : ($index - round($count / 2)) + 1;
            $row->xy = $row->x * $row->y;
            $row->x2 = pow($row->x, 2);
            $row->y2 = pow($row->y, 2);

            $log10y = log10($row->y);
            $row->logy = !is_infinite($log10y) ? $a = round($log10y, 3) : $a = 0;
            $row->xlogy = !is_infinite($log10y) ? $b = round($row->x * $a, 3) : $b = 0;

            $sum['x2'] += $row->x2;
            $sum['logy'] += $a;
            $sum['xlogy'] += $b;
            $index++;
        }

        $a = pow(10, $sum['logy'] / $count);
        $b = pow(10, $sum['xlogy'] / $sum['x2']);

        $data = [
            'data' => $dataLatih,
            'a' => round($a, 9),
            'b' => round($b, 9)
        ];
        return $data;
    }

    public static function getNilaiIndeksMusiman()
    {
        $dataLatih = self::getDataLatih();
        $years = self::getYear();
        $years->pop();
        $dateRange = self::getDate();
        $movingAverage = self::movingAverage($dataLatih);
        $penyesuaian = 0;
        foreach ($dateRange as $row) {
            $jumlah = collect([]);
            $ma = collect([]);
            foreach ($years->pluck('year') as $year) {
                $date = date('Y-m-d H:i:s', mktime(0, 0, 0, $row->month, $row->day, $year));
                $x = $dataLatih->where('waktu', $date)->first();
                $currentMa = $movingAverage->firstWhere('waktu', $date)->ma;
                if ($currentMa == null) {
                    $ma->put($year, null);
                } else {
                    $ma->put($year, $currentMa != 0 ? $x->jumlah / $currentMa * 100 : 0);
                }
                if ($row->month == 2 && $row->day == 29 && $year % 4 != 0) {
                    $jumlah->put($year, null);
                    $ma->put($year, null);
                } else {
                    $jumlah->put($year, $x->jumlah);
                }
            }
            $row->jumlah = $jumlah;
            $row->ma = $ma;
            $row->medial = round(($ma->sum() - $ma->min() - $ma->max()) / 2, 2);
            $penyesuaian += $row->medial;
            // save
            $tgl = date('Y-m-d', mktime(0, 0, 0, $row->month, $row->day));
            Musiman::updateOrCreate([
                'waktu' => $tgl
            ], [
                'medial' => $row->medial
            ]);
        }
        $penyesuaian = round((366 / $penyesuaian), 9);
        $jumlahIndeksMusiman = 0;
        foreach ($dateRange as $row) {
            $medial = round($row->medial, 2);
            $jumlahIndeksMusiman += round($medial * $penyesuaian, 2);
        }
        $data = [
            'data' => $dateRange,
            'year' => $years,
            'penyesuaian' => $penyesuaian,
            'jumlahIndeks' => round($jumlahIndeksMusiman)
        ];
        return $data;
    }

    public static function getPeramalan($date)
    {
        $tanggal = explode(' - ', $date);
        $awal = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal[0])));
        $akhir = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal[1])));
        $uji = new DatePeriod(
            new DateTime($awal),
            new DateInterval('P1D'),
            new DateTime($akhir . ' +1 day')
        );
        $xt = Dataset::getDataLatih()->count();
        $last = Dataset::getDataLatih()->sortByDesc('waktu')->pluck('waktu')->first();
        $diff = $last->diff($awal)->format('%a');
        $xt += $diff;
        $nilai = [
            'a' => Cache::get('a', null),
            'b' => Cache::get('b', null),
            'penyesuaian' => Cache::get('penyesuaian', null),
        ];
        $prediksi = collect();
        foreach ($uji as $row) {
            $tmp = new stdClass();
            $tgl = $row;
            $musiman = Musiman::whereMonth('waktu', $tgl->format('m'))->whereDay('waktu', $tgl->format('d'))->first();
            $tmp->musiman = $musiman->medial * $nilai['penyesuaian'];
            $tmp->waktu = $tgl;
            $prediksi->push($tmp);
        }
        $data = [
            'tanggal' => $date,
            'years' => Dataset::getYear(),
            'uji' => $prediksi,
            'a' => $nilai['a'],
            'b' => $nilai['b'],
            'xt' => $xt
        ];
        return $data;
    }

    public static function getEvaluasi($data)
    {
        $dataUji = self::getDataUji();
        $xt = $data['xt'];
        $jumlah = [
            'aditif' => 0, 'multiplikatif' => 0
        ];
        foreach ($data['uji'] as $row) {
            $row->jumlah = $dataUji->firstWhere('waktu', $row->waktu)->jumlah;
            $result = $data['a'] * pow($data['b'], $xt);
            $row->xt = $xt;
            $row->aditif = round($result + $row->musiman);
            $row->error_aditif = $row->jumlah ? ($row->jumlah - $row->aditif) / $row->jumlah : 0;
            $row->multiplikatif = round($result * $row->musiman);
            $row->error_multiplikatif = $row->jumlah ? ($row->jumlah - $row->multiplikatif) / $row->jumlah : 0;
            $jumlah['aditif'] += $row->error_aditif;
            $jumlah['multiplikatif'] += $row->error_multiplikatif;
            $xt++;
        }
        $data['jumlah'] = $jumlah;

        return $data;
    }

    public static function movingAverage($data)
    {
        $result = collect([]);
        $x = 1;
        $y = count($data);
        $start = 0;
        $end = 365;
        $jumlah = $data->pluck('jumlah');
        foreach ($data as $row) {
            $currentResult = new stdClass();
            $currentResult->waktu = date($row['waktu']);
            $currentResult->jumlah = $row['jumlah'];
            if ($x > 183 && $y > 183) {
                $tmp = $jumlah->slice($start, $end)->sum() / 7;
                $currentResult->ma = $tmp;
                $start++;
            } else {
                $currentResult->ma = null;
            }
            $result->push($currentResult);
            $x++;
            $y--;
        }
        return $result;
    }

    public static function getDate()
    {
        $date = self::select(DB::raw('DAY(waktu) as day, MONTH(waktu) as month'))
            ->orderBy('month')
            ->distinct()
            ->get();
        return $date;
    }

    public static function getMonth()
    {
        $month = self::select(DB::raw('MONTH(waktu) as month, YEAR(waktu) as year'))
            ->orderBy('year')
            ->distinct()
            ->get();
        return $month;
    }

    public static function getYear()
    {
        $year = self::select(DB::raw('YEAR(waktu) as year'))
            ->orderBy('year')
            ->distinct()
            ->get();
        return $year;
    }

    public static function getLastYear()
    {
        $lastYear = self::select(DB::raw('YEAR(waktu) as year'))
            ->orderBy('year', 'DESC')
            ->distinct()
            ->first();
        return $lastYear->year;
    }
}
