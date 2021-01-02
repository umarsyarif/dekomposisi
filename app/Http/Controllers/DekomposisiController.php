<?php

namespace App\Http\Controllers;

use App\Musiman;
use App\Dataset;
use App\Kecamatan;
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
        $kecamatan = $request->kecamatan;

        if ($kecamatan) {
            $nilaiTrend = Cache::rememberForever('trend-' . $kecamatan, function () use ($kecamatan) {
                $data = Dataset::getNilaiTrend($kecamatan);

                Cache::put('a-' . $kecamatan, $data['a']);
                Cache::put('b-' . $kecamatan, $data['b']);
                return $data;
            });
        }

        $allKecamatan = Kecamatan::all();

        $data = [
            'data' => $nilaiTrend['data'] ?? [],
            'a' => $nilaiTrend['a'] ?? '',
            'b' => $nilaiTrend['b'] ?? '',
            'kecamatan' => $kecamatan,
            'allKecamatan' => $allKecamatan,
        ];

        return view('pages.nilai-trend', $data);
    }

    public function nilaiIndeksMusiman(Request $request)
    {
        $kecamatan = $request->kecamatan;

        if ($kecamatan) {
            $nilaiIndeksMusiman = Cache::rememberForever('musiman', function () {
                $data = Dataset::getNilaiIndeksMusiman();

                Cache::put('a-' . $kecamatan, $data['a']);
                Cache::put('b-' . $kecamatan, $data['b']);

                Cache::put('penyesuaian', $data['penyesuaian']);
                return $data;
            });
        }

        $allKecamatan = Kecamatan::all();
        return view('pages.nilai-musiman', $nilaiIndeksMusiman);


        // $nilaiIndeksMusiman = Cache::rememberForever('musiman', function () {
        //     $data = Dataset::getNilaiIndeksMusiman();

        //     Cache::put('penyesuaian', $data['penyesuaian']);
        //     return $data;
        // });

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

    public function peramalanApi(Request $request)
    {
        if (!is_null($request->tanggal)) {
            $data = Dataset::getPeramalan($request->tanggal);
            $reply['data'] = $data;
            return response()->json($reply);
        }
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
