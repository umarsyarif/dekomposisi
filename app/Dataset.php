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

    protected $appends = [
        'ma'
    ];

    public static function getDataLatih($kecamatan = null, $tahun = null)
    {
        $lastYear = self::getLastYear();
        $dataLatih = self::where('kecamatan_id', $kecamatan)
            ->whereYear('waktu', '!=', $lastYear)
            ->when($tahun, function ($q) use ($tahun) {
                return $q->whereYear('waktu', $tahun);
            })
            ->get();
        return $dataLatih;
    }

    public static function getDataUji($kecamatan = null, $month = 0)
    {
        $lastYear = self::getLastYear();
        $dataUji = self::whereYear('waktu', $lastYear)
            ->where('kecamatan_id', $kecamatan)
            ->when($month != 0, function ($q) use ($month) {
                return $q->whereMonth('waktu', $month);
            })
            ->get();
        return $dataUji;
    }

    public static function getByDate($kecamatan, $date)
    {
        return self::when($kecamatan, function ($q) use ($kecamatan) {
            return $q->where('kecamatan_id', $kecamatan);
        })->whereDate('waktu', $date)->first();
    }

    public static function getPerYear($year, $kecamatan = null)
    {
        return self::with('kecamatan')
            ->whereYear('waktu', $year)
            ->when($kecamatan, function ($q) use ($kecamatan) {
                return $q->where('kecamatan_id', $kecamatan);
            })->get();
    }

    public static function getPerMonth($year, $month, $kecamatan = null)
    {
        return self::with('kecamatan')
            ->whereYear('waktu', $year)->whereMonth('waktu', $month)
            ->when($kecamatan, function ($q) use ($kecamatan) {
                return $q->where('kecamatan_id', $kecamatan);
            })->get();
    }

    public static function getPerKecamatan($kecamatan = null)
    {
        return self::with('kecamatan')
            ->when($kecamatan, function ($q) use ($kecamatan) {
                return $q->where('kecamatan_id', $kecamatan);
            })->get();
    }

    public static function getNilaiTrend($kecamatan)
    {
        $dataLatih = self::getDataLatih($kecamatan);
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
        Cache::put('a-' . $kecamatan, $data['a']);
        Cache::put('b-' . $kecamatan, $data['b']);
        return $data;
    }

    public static function getNilaiIndeksMusiman($kecamatan)
    {
        $years = self::getYear();
        $years->pop();
        $dateRange = self::getDate();
        $penyesuaian = 0;
        $medial = collect();
        foreach ($dateRange as $row) {
            $data = collect([]);
            foreach ($years->pluck('year') as $year) {
                $date = date('Y-m-d H:i:s', mktime(0, 0, 0, $row->month, $row->day, $year));
                $x = self::getByDate($kecamatan, $date);
                $data->put($year, $x->ma);
                if ($row->month == 2 && $row->day == 29 && $year % 4 != 0) {
                    $data->put($year, null);
                }
            }
            $row->data = $data ?? null;
            $row->medial = round(($data->sum() - $data->min() - $data->max()) / 2, 2);
            $penyesuaian += $row->medial;
            $date = date('d-F', mktime(0, 0, 0, $row->month, $row->day, $year));
            $medial[$date] = $row->medial;
        }
        $penyesuaian = round((366 / $penyesuaian), 9);
        Cache::put('medial-' . $kecamatan, $medial);
        Cache::put('penyesuaian-' . $kecamatan, $penyesuaian);
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
        $allKecamatan = Kecamatan::pluck('id');
        $xt = collect();
        $a = collect();
        $b = collect();
        $penyesuaian = collect();
        foreach ($allKecamatan as $kecamatan) {
            $tmp = self::getDataLatih($kecamatan)->count();
            $last = self::getDataLatih($kecamatan)->sortByDesc('waktu')->pluck('waktu')->first();
            $diff = $last->diff($awal)->format('%a');
            $tmp += $diff;
            $xt[$kecamatan] = $tmp;

            $tmp = Cache::get('a-' . $kecamatan, function () use ($kecamatan) {
                self::getNilaiTrend($kecamatan);
                return Cache::get('a-' . $kecamatan, null);
            });
            $a[$kecamatan] = $tmp;
            $tmp = Cache::get('b-' . $kecamatan, function () use ($kecamatan) {
                self::getNilaiTrend($kecamatan);
                return Cache::get('b-' . $kecamatan, null);
            });
            $b[$kecamatan] = $tmp;
            $tmp = Cache::get('penyesuaian-' . $kecamatan, function () use ($kecamatan) {
                self::getNilaiIndeksMusiman($kecamatan);
                return Cache::get('penyesuaian-' . $kecamatan, null);
            });
            $penyesuaian[$kecamatan] = $tmp;
            $tmp = Cache::get('medial-' . $kecamatan, function () use ($kecamatan) {
                self::getNilaiIndeksMusiman($kecamatan);
                return Cache::get('medial-' . $kecamatan, null);
            });
            $medial[$kecamatan] = $tmp;
        }
        $prediksi = collect();
        foreach ($uji as $row) {
            $tmp = new stdClass();
            $tgl = $row;
            $tmp->waktu = $tgl;
            $prediksi->push($tmp);
        }
        $data = [
            'tanggal' => $date,
            'medial' => $medial,
            'penyesuaian' => $penyesuaian,
            'uji' => $prediksi,
            'a' => $a,
            'b' => $b,
            'xt' => $xt
        ];
        return $data;
    }

    public static function getEvaluasi($kecamatan)
    {
        return Cache::rememberForever('evaluasi-' . $kecamatan, function () use ($kecamatan) {
            $dataUji = self::getDataUji($kecamatan);
            $first = $dataUji->first()->waktu;
            $last = $dataUji->last()->waktu;
            $tanggal = $first->format('d/m/Y') . ' - ' . $last->format('d/m/Y');
            $data = self::getPeramalan($tanggal);

            $dataUji = self::getDataUji($kecamatan);
            $xt = $data['xt'];
            $jumlah = [
                'aditif' => 0, 'multiplikatif' => 0
            ];

            foreach ($data['uji'] as $row) {
                $musiman = $data['medial'][$kecamatan][$row->waktu->format('d-F')] * $data['penyesuaian'][$kecamatan];
                $row->jumlah = $dataUji->firstWhere('waktu', $row->waktu)->jumlah;
                $result = $data['a'][$kecamatan] * pow($data['b'][$kecamatan], $xt[$kecamatan]);
                $row->xt = $xt;
                $row->aditif = round($result + $musiman);
                $row->error_aditif = $row->jumlah != $row->aditif ? abs($row->jumlah - $row->aditif) / max($row->jumlah, $row->aditif) : 0;
                $row->multiplikatif = round($result * $musiman);
                $row->error_multiplikatif = $row->jumlah != $row->multiplikatif ? abs($row->jumlah - $row->multiplikatif) / max($row->jumlah, $row->multiplikatif) : 0;
                $jumlah['aditif'] += abs($row->error_aditif * 100);
                $jumlah['multiplikatif'] += abs($row->error_multiplikatif * 100);
                $xt++;
            }
            $data['jumlah'] = $jumlah;

            return $data;
        });
    }

    public static function getAllEvaluasi()
    {
        $allKecamatan = Kecamatan::all();

        $data['uji'] = 0;
        $jumlah = ['aditif' => 0, 'multiplikatif' => 0];
        foreach ($allKecamatan as $kecamatan) {
            $evaluasi = self::getEvaluasi($kecamatan->id);
            // dd($evaluasi);
            $jumlah['aditif'] += $evaluasi['jumlah']['aditif'];
            $jumlah['multiplikatif'] += $evaluasi['jumlah']['multiplikatif'];
            $data['uji'] += $evaluasi['uji']->count();
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

    public function getMaAttribute()
    {
        $kecamatan = $this->kecamatan()->first();
        if (is_null($kecamatan)) {
            return null;
        }

        $movingAverage = Cache::rememberForever('ma-' . $kecamatan->id, function () use ($kecamatan) {
            return self::movingAverage(self::getDataLatih($kecamatan->id));
        });

        $currentMa = $movingAverage->firstWhere('waktu', $this->waktu)->ma;
        if ($currentMa == null) {
            return null;
        }
        return $currentMa != 0 ? $this->jumlah / $currentMa * 100 : 0;
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
        return optional($lastYear)->year;
    }

    public function kecamatan()
    {
        return $this->belongsTo('App\Kecamatan');
    }
}
