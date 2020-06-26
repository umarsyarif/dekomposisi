<?php

namespace App\Http\Controllers;

use App\Uji;
use App\Latih;
use App\Musiman;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Imports\UjiImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class UjiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page(Request $request)
    {
        $filter = $request->filter;
        if ($filter == null) {
            $uji = Uji::orderBy('waktu')->get();
        } else if ($filter == 'tahun') {
            $uji = Uji::select(DB::raw('YEAR(waktu) as year'))->orderBy('year')->distinct()->get();
            foreach ($uji as $row) {
                $jumlah = Uji::whereYear('waktu', $row->year)->get();
                $row->jumlah = $jumlah;
            }
        } else if ($filter == 'bulan') {
            $uji = Uji::select(DB::raw('MONTH(waktu) as month, YEAR(waktu) as year'))->orderBy('year')->distinct()->get();
            foreach ($uji as $row) {
                $jumlah = Uji::whereYear('waktu', $row->year)->whereMonth('waktu', $row->month)->get();
                $row->jumlah = $jumlah;
            }
        }
        $data = [
            'filter' => $filter,
            'uji' => $uji
        ];
        return view('data-uji.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $string = $request->bulan;
        $bulan = explode('-', $string)[0];
        $bulan = date('m', strtotime($bulan));
        $tahun = explode('-', $string)[1];
        $period = new DatePeriod(
            new DateTime($tahun . '-' . $bulan++ . '-01'),
            new DateInterval('P1D'),
            new DateTime($tahun . '-' . $bulan . '-01')
        );
        foreach ($period as $key => $value) {
            Uji::updateOrCreate(['waktu' => $value->format('Y-m-d')]);
        }
        return $this->page($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Uji  $uji
     * @return \Illuminate\Http\Response
     */
    public function show(Uji $uji)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Uji  $uji
     * @return \Illuminate\Http\Response
     */
    public function edit(Uji $uji)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Uji  $uji
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Uji $uji)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Uji  $uji
     * @return \Illuminate\Http\Response
     */
    public function destroy(Uji $uji)
    {
        //
    }

    public function import(Request $request)
    {
        Excel::import(new UjiImport, $request->file('file'));
        return redirect()->route('data-uji.page', ['filter' => $request->filter])->with('success', 'Data berhasil disimpan!');
    }

    public function akurasi(Request $request)
    {
        $tanggal = explode('-', $request->tanggal);
        $awal = date('Y-m-d', strtotime($tanggal[0]));
        $akhir = date('Y-m-d', strtotime($tanggal[1]));
        $now = now();
        if ($awal >= '2020-01-01' && $akhir < $now) {
            $xt = Latih::all()->count();
            $last = Latih::orderBy('waktu', 'DESC')->pluck('waktu')->first();
            $diff = $last->diff($awal)->format('%a');
            $xt += $diff;
            $a = Cache::get('a', null);
            $b = Cache::get('b', null);
            $penyesuaian = Cache::get('penyesuaian', null);
            $this->cekCache($a, $b, $penyesuaian);
            // get data uji
            $uji = Uji::whereDate('waktu', '>=', $awal)->whereDate('waktu', '<=', $akhir)->get();
            if ($uji->isEmpty()) {
                return redirect()->route('data-uji.page', ['filter' => $request->filter])->with('error', 'Data aktual tidak ada!');
            }
            foreach ($uji as $row) {
                $tgl = $row->waktu;
                $musiman = Musiman::whereMonth('waktu', $tgl->format('m'))->whereDay('waktu', $tgl->format('d'))->first();
                $row->musiman = $musiman->medial * $penyesuaian;
            }
            $data = [
                'uji' => $uji,
                'a' => $a,
                'b' => $b,
                'xt' => $xt,
                'tanggal' => $request->tanggal
            ];
            return view('data-uji.akurasi', $data);
        }
        return redirect()->route('data-uji.page', ['filter' => $request->filter])->with('error', 'Data aktual tidak ada!');
    }

    public function cekCache($a, $b, $penyesuaian)
    {
        if (is_null($a) || is_null($b)) {
            return redirect()->route('prediksi.data-trend');
        }
        if (is_null($penyesuaian)) {
            return redirect()->route('prediksi.data-musiman');
        }
    }
}
