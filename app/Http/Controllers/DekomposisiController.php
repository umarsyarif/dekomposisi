<?php

namespace App\Http\Controllers;

use App\Musiman;
use App\Dataset;
use stdClass;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DekomposisiController extends Controller
{
    public function nilaiTrend(Request $request)
    {
        $nilaiTrend = Cache::rememberForever('trend', function () {
            $data = Dataset::getNilaiTrend();

            Cache::put('a', $data['a']);
            Cache::put('b', $data['b']);
            return $data;
        });

        return view('pages.nilai-trend', $nilaiTrend);
    }

    public function nilaiIndeksMusiman(Request $request)
    {
        $nilaiIndeksMusiman = Cache::rememberForever('musiman', function () {
            $data = Dataset::getNilaiIndeksMusiman();

            Cache::put('penyesuaian', $data['penyesuaian']);
            return $data;
        });

        return view('pages.nilai-musiman', $nilaiIndeksMusiman);
    }

    public function peramalan(Request $request)
    {
        if (is_null($request->tanggal)) {
            $data = [
                'years' => Dataset::getYear()
            ];
            return view('pages.peramalan', $data);
        }

        $data = Dataset::getPeramalan($request->tanggal);
        return view('pages.peramalan', $data);
    }

    public function evaluasi(Request $request)
    {
        $dataUji = Dataset::getDataUji();
        $first = $dataUji->first()->waktu;
        $last = $dataUji->last()->waktu;
        $tanggal = $first->format('d/m/Y') . ' - ' . $last->format('d/m/Y');

        $peramalan = Dataset::getPeramalan($tanggal);
        $evaluasi = Dataset::getEvaluasi($peramalan);
        return view('pages.evaluasi', $evaluasi);
    }
}
