<?php

namespace App\Http\Controllers;

use App\Dataset;
use App\Uji;
use App\Latih;
use App\Musiman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('home', 'chart');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($page)
    {
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }

        return abort(404);
    }

    public function home()
    {
        $this->middleware('guest');
        $data = [
            'latih' => Dataset::getDataLatih()->count(),
            'tahun' => Dataset::getYear()->count(),
            'jumlah' => Dataset::sum('jumlah')
        ];
        return view('welcome2', $data);
    }

    public function dashboard()
    {
        $this->middleware('auth');
        // data pertahun

        // $dataset = Dataset::whereYear('waktu', 2014);
        $dataset = [
            'all' => Dataset::all(),
            'latih' => Dataset::getDataLatih(),
            'uji' => Dataset::getDataUji(),
        ];
        $data = [
            'labels' => $dataset['uji']->pluck('waktu')->map(function ($x) {
                return $x->format('d');
            }),
            'jumlah' => $dataset['uji']->pluck('jumlah'),
            'aditif' => $dataset['uji']->pluck('jumlah'),
            'multiplikatif' => $dataset['uji']->pluck('jumlah')
        ];
        $year = Dataset::getYear();
        $year->pop();
        $data = [
            'data' => $dataset,
            'year' => $year,
            'chart' => $data
        ];
        // return $data;
        return view('pages.dashboard', $data);
    }

    public function chart(Request $request)
    {
        $dataUji = Dataset::getDataUji(12);
        $ramalan = [
            'judul' => date('F Y', '2019/12/01'),
            'labels' => $dataUji->pluck('waktu')->map(function ($x) {
                return $x->format('d');
            }),
            'jumlah' => $dataUji->pluck('jumlah'),
            'aditif' => $dataUji->pluck('jumlah'),
            'multiplikatif' => $dataUji->pluck('jumlah')
        ];
        $data = [
            'dataset' => Dataset::all(),
            'ramalan' => $ramalan
        ];
        return response()->json($data);
    }

    // public function prediksi($bulan, $tahun)
    // {
    //     $awal = date('Y-m-d', strtotime($tahun . '-' . $bulan . '-01'));
    //     $akhir = date('Y-m-d', strtotime($awal . '+ 1 month'));
    //     $now = now();
    //     if ($awal >= '2020-01-01' && $akhir < $now) {
    //         $xt = Latih::all()->count();
    //         $last = Latih::orderBy('waktu', 'DESC')->pluck('waktu')->first();
    //         $diff = $last->diff($awal)->format('%a');
    //         $xt += $diff;
    //         $a = Cache::get('a', null);
    //         $b = Cache::get('b', null);
    //         $penyesuaian = Cache::get('penyesuaian', null);
    //         $this->cekCache($a, $b, $penyesuaian);
    //         // get data uji
    //         $uji = Uji::whereDate('waktu', '>=', $awal)->whereDate('waktu', '<=', $akhir)->get();
    //         if ($uji->isEmpty()) {
    //             return redirect()->route('data-uji.page', ['filter' => ''])->with('error', 'Data aktual tidak ada!');
    //         }
    //         foreach ($uji as $row) {
    //             $tgl = $row->waktu;
    //             $musiman = Musiman::whereMonth('waktu', $tgl->format('m'))->whereDay('waktu', $tgl->format('d'))->first();
    //             $row->musiman = $musiman->medial * $penyesuaian;
    //         }
    //         $aditif = array_map(function ($x) use ($a, $b, $xt) {
    //             return ($a * pow($b, $xt++)) + $x['musiman'];
    //         }, $uji->toArray());
    //         $multiplikatif = array_map(function ($x) use ($a, $b, $xt) {
    //             return ($a * pow($b, $xt++)) * $x['musiman'];
    //         }, $uji->toArray());
    //         return [
    //             'aditif' => $aditif,
    //             'multiplikatif' => $multiplikatif,
    //         ];
    //     }
    // }

    // public function cekCache($a, $b, $penyesuaian)
    // {
    //     if (is_null($a) || is_null($b)) {
    //         return redirect()->route('prediksi.data-trend');
    //     }
    //     if (is_null($penyesuaian)) {
    //         return redirect()->route('prediksi.data-musiman');
    //     }
    // }

    // public function getYear()
    // {
    //     $year = Latih::select(DB::raw('YEAR(waktu) as year'))->orderBy('year')->distinct()->get();
    //     $year = $year->pluck('year');
    //     return $year;
    // }
}
