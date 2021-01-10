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

        $dataset = [
            'all' => Dataset::sum('jumlah'),
            'latih' => 0,
            'uji' => 0,
        ];

        $allKecamatan = Kecamatan::all();
        foreach ($allKecamatan as $kecamatan) {
            $latih = Dataset::getDataLatih($kecamatan->id);
            $dataset['latih'] += $latih->count();
            $uji = Dataset::getDataUji($kecamatan->id);
            $dataset['uji'] += $uji->count();
        }

        $year = Dataset::getYear();
        $data = [
            'data' => $dataset,
            'year' => $year,
        ];
        return view('pages.dashboard', $data);
    }

    public function chart(Request $request)
    {
        $tahun = $request->tahun ?? 2014;

        $data = Dataset::getYear()->pluck('year');
        $jumlah = $data->map(function ($item) {
            return Dataset::whereYear('waktu', $item)->sum('jumlah');
        });
        $dataset = [
            'judul' => '',
            'labels' => $data,
            'jumlah' => $jumlah
        ];

        $allKecamatan = Kecamatan::all();
        $data = [];
        foreach ($allKecamatan as $row) {
            $jumlah = Dataset::getDataLatih($row->id, $tahun)
                ->sum('jumlah');
            array_push($data, $jumlah);
        }
        $kecamatan = [
            'judul' => $tahun,
            'labels' => $allKecamatan->pluck('nama'),
            'jumlah' => $data
        ];

        $data = [
            'dataset' => $dataset,
            'kecamatan' => $kecamatan
        ];
        return response()->json($data);
    }
}
