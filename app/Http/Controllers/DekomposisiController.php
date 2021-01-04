<?php

namespace App\Http\Controllers;

use App\Dataset;
use App\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DekomposisiController extends Controller
{
    public function nilaiTrend(Request $request)
    {
        $kecamatan = $request->kecamatan;

        if ($kecamatan) {
            $nilaiTrend = Cache::rememberForever('trend-' . $kecamatan, function ()  use ($kecamatan) {
                return Dataset::getNilaiTrend($kecamatan);
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
            $nilaiIndeksMusiman = Cache::rememberForever('musiman-' . $kecamatan, function () use ($kecamatan) {
                return Dataset::getNilaiIndeksMusiman($kecamatan);
            });
        }

        $allKecamatan = Kecamatan::all();

        $data = [
            'allKecamatan' => $allKecamatan,
            'kecamatan' => $kecamatan,
            'data' => $nilaiIndeksMusiman['data'] ?? [],
            'year' => $nilaiIndeksMusiman['year'] ?? [],
            'penyesuaian' => $nilaiIndeksMusiman['penyesuaian'] ?? '',
            'jumlahIndeks' => $nilaiIndeksMusiman['jumlahIndeks'] ?? '',
        ];
        return view('pages.nilai-musiman', $data);
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
        $data['allKecamatan'] = Kecamatan::all();

        return view('pages.peramalan', $data);
    }

    public function peramalanApi(Request $request)
    {
        if (!is_null($request->tanggal)) {
            $data = Dataset::getPeramalan($request->tanggal);
            $allKecamatan = Kecamatan::get();
            $reply = [
                'data' => $data,
                'allKecamatan' => $allKecamatan,
            ];
            return response()->json($reply);
        }
    }

    public function evaluasi(Request $request)
    {
        $kecamatan = $request->kecamatan;

        if ($kecamatan) {
            $dataUji = Dataset::getDataUji($kecamatan);
            $first = $dataUji->first()->waktu;
            $last = $dataUji->last()->waktu;
            $tanggal = $first->format('d/m/Y') . ' - ' . $last->format('d/m/Y');

            $peramalan = Dataset::getPeramalan($tanggal);
            $evaluasi = Dataset::getEvaluasi($kecamatan, $peramalan);
        }

        $allKecamatan = Kecamatan::all();
        $data = [
            'kecamatan' => $kecamatan,
            'allKecamatan' => $allKecamatan,
            'evaluasi' => $evaluasi,
            'jumlah' => $evaluasi['jumlah'],
            'uji' => $evaluasi['uji'],
        ];
        // return $data;
        return view('pages.evaluasi', $data);
    }
}
