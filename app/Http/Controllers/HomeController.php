<?php

namespace App\Http\Controllers;

use App\Dataset;
use App\Kecamatan;
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
            'jumlah' => Dataset::sum('jumlah'),
            'allKecamatan' => Kecamatan::pluck('nama', 'id')
        ];
        return view('welcome2', $data);
    }

    public function dashboard()
    {
        $this->middleware('auth');
        // data pertahun

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
        $data = [
            'data' => $dataset,
            'year' => $year,
            'chart' => $data
        ];
        return view('pages.dashboard', $data);
    }

    public function chart(Request $request)
    {
        $data = Dataset::getYear()->pluck('year');
        $jumlah = $data->map(function ($item) {
            return Dataset::whereYear('waktu', $item)->sum('jumlah');
        });
        $dataset = [
            'judul' => '',
            'labels' => $data,
            'jumlah' => $jumlah
        ];

        $bulan = $request->bulan ?? 1;
        $dataUji = Dataset::getDataUji($bulan);
        $getperamalan = Dataset::getPeramalan($dataUji->first()->waktu->format('d/m/Y') . ' - ' . $dataUji->last()->waktu->format('d/m/Y'));
        $ramalan = [
            'judul' => $dataUji->first()->waktu->format('F Y'),
            'labels' => $dataUji->pluck('waktu')->map(function ($x) {
                return $x->format('d');
            }),
            'jumlah' => $dataUji->pluck('jumlah'),
            'ramalan' => $getperamalan
        ];
        $data = [
            'dataset' => $dataset,
            'ramalan' => $ramalan
        ];
        return response()->json($data);
    }
}
