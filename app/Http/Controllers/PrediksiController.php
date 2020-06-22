<?php

namespace App\Http\Controllers;

use App\Uji;
use App\Latih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class PrediksiController extends Controller
{
    public function page()
    {
        return view('proses-prediksi.index');
    }

    public function trend()
    {
        $data = Latih::orderBy('waktu')->get();
        foreach ($data as $row) {
            //
        }
        $data = [
            'data' => $data
        ];
        return view('proses-prediksi.data-trend', $data);
    }

    public function musiman()
    {
        $data = Latih::orderBy('waktu')->get()->toArray();
        $years = $this->getYear();
        $date = $this->getdate();
        $result = $this->movingAverage($data);
        // return $result;
        $penyesuaian = 0;
        foreach ($date as $row) {
            $jumlah = new stdClass();
            $ma = new stdClass();
            foreach ($years as $year) {
                $tgl = date('Y-m-d', mktime(0, 0, 0, $row->month, $row->day, $year));
                $x = Latih::whereDate('waktu', $tgl)->first();
                $currentMa = $this->getMovingAverage($tgl, $result);
                if ($currentMa == null) {
                    $ma->$year = null;
                } else {
                    $ma->$year =  $currentMa != 0 ? $x->jumlah / $currentMa * 100 : 0;
                }
                if ($row->month == 2 && $row->day == 29 && $year % 4 != 0) {
                    $jumlah->$year = null;
                    $ma->$year = null;
                } else {
                    $jumlah->$year = $x->jumlah;
                }
            }
            $row->jumlah = $jumlah;
            $row->ma = $ma;
            $row->medial = $this->medial($ma);
            $penyesuaian += $row->medial;
        }
        $penyesuaian = 365 / $penyesuaian;
        // return $penyesuaian;
        $data = [
            'data' => $date,
            'year' => $years,
            'penyesuaian' => $penyesuaian
        ];
        return view('proses-prediksi.data-musiman', $data);
    }

    public function medial($data)
    {
        $ma = array_diff((array) $data, array(NULL));
        $jumlah = count($ma) - 2;
        return $jumlah > 0 ? (array_sum($ma) - min($ma) - max($ma)) / $jumlah : 0;
    }

    public function getMovingAverage($date, $data)
    {
        foreach ($data as $row) {
            if (date('Y-m-d', strtotime($row->waktu)) == $date) {
                return $row->ma;
            }
        }
    }

    public function movingAverage($data)
    {
        $result = [];
        $x = 1;
        $y = count($data);
        $start = 0;
        $end = 365;
        $jumlah = array_map(function ($n) {
            return $n['jumlah'];
        }, $data);
        foreach ($data as $row) {
            $currentResult = new stdClass();
            $currentResult->waktu = $row['waktu'];
            $currentResult->jumlah = $row['jumlah'];
            if ($x > 183 && $y > 183) {
                $tmp = array_sum(array_slice($jumlah, $start, $end)) / 7;
                $currentResult->ma = $tmp;
                // echo 'x ' . $x . '| ' . $start . '(' . $jumlah[$start] . ') -' . $end . '(' . $jumlah[$end] . ') = ' . $tmp;
                // echo '<br/>';
                $start++;
            } else {
                $currentResult->ma = null;
            }
            array_push($result, $currentResult);
            $x++;
            $y--;
        }
        return $result;
    }

    public function getYear()
    {
        $year = Latih::select(DB::raw('YEAR(waktu) as year'))->orderBy('year')->distinct()->get();
        $year = $year->pluck('year');
        return $year;
    }

    public function getDate()
    {
        $day = Latih::select(DB::raw('DAY(waktu) as day, MONTH(waktu) as month'))->orderBy('month')->distinct()->get();
        return $day;
    }
}
