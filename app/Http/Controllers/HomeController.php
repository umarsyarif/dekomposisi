<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth')->except('home');
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
            'latih' => Latih::all()->count(),
            'tahun' => $this->getYear()->count(),
            'jumlah' => Latih::sum('jumlah')
        ];
        // return $data;
        return view('welcome2', $data);
    }

    public function dashboard()
    {
        $this->middleware('auth');
        // data pertahun
        $latih = Latih::select(DB::raw('YEAR(waktu) as year'))->orderBy('year')->distinct()->get();
        $year = $latih->pluck('year')->toArray();
        $jumlah = [];
        foreach ($latih as $row) {
            $tmp = Latih::whereYear('waktu', $row->year)->get()->sum('jumlah');
            array_push($jumlah, $tmp);
            $row->jumlah = $jumlah;
        }
        // data akurasi
        $tmp = Uji::orderBy('waktu', 'DESC')->distinct('waktu')->first();
        $month = $tmp->waktu->format('m');
        $tahun = $tmp->waktu->format('Y');
        $waktu = $tmp->waktu->format('F') . ' ' . $tahun;
        $tmp = Uji::whereMonth('waktu', $month)->whereYear('waktu', $tahun)->get()->toArray();
        $uji['waktu'] = array_map(function ($x) {
            return date('d', strtotime($x['waktu']));
        }, $tmp);
        $uji['jumlah'] = array_map(function ($x) {
            return $x['jumlah'];
        }, $tmp);
        $data = [
            'jumlah' => $jumlah,
            'year' => $year,
            'waktu' => $waktu,
            'uji' => $uji,
            'prediksi' => $this->prediksi($month, $tahun),
            'latih' => Latih::all()->count(),
            'aktual' => Uji::all()->count()
        ];
        // return $data;
        return view('pages.dashboard', $data);
    }

    public function prediksi($bulan, $tahun)
    {
        $awal = date('Y-m-d', strtotime($tahun . '-' . $bulan . '-01'));
        $akhir = date('Y-m-d', strtotime($awal . '+ 1 month'));
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
                return redirect()->route('data-uji.page', ['filter' => ''])->with('error', 'Data aktual tidak ada!');
            }
            foreach ($uji as $row) {
                $tgl = $row->waktu;
                $musiman = Musiman::whereMonth('waktu', $tgl->format('m'))->whereDay('waktu', $tgl->format('d'))->first();
                $row->musiman = $musiman->medial * $penyesuaian;
            }
            $aditif = array_map(function ($x) use ($a, $b, $xt) {
                return ($a + pow($b, $xt++)) + $x['musiman'];
            }, $uji->toArray());
            $multiplikatif = array_map(function ($x) use ($a, $b, $xt) {
                return ($a + pow($b, $xt++)) * $x['musiman'];
            }, $uji->toArray());
            return [
                'aditif' => $aditif,
                'multiplikatif' => $multiplikatif,
            ];
        }
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

    public function getYear()
    {
        $year = Latih::select(DB::raw('YEAR(waktu) as year'))->orderBy('year')->distinct()->get();
        $year = $year->pluck('year');
        return $year;
    }
}
