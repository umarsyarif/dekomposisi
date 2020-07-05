<?php

namespace App\Http\Controllers;

use App\Latih;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Exports\ApiExport;
use App\Imports\ApiImport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class LatihController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['update']);
    }

    public function page(Request $request)
    {
        $filter = $request->filter;
        if ($filter == null) {
            $latih = Latih::orderBy('waktu')->get();
        } else if ($filter == 'tahun') {
            $latih = Latih::select(DB::raw('YEAR(waktu) as year'))->orderBy('year')->distinct()->get();
            foreach ($latih as $row) {
                $jumlah = Latih::whereYear('waktu', $row->year)->get();
                $row->jumlah = $jumlah;
            }
        } else if ($filter == 'bulan') {
            $latih = Latih::select(DB::raw('MONTH(waktu) as month, YEAR(waktu) as year'))->orderBy('year')->distinct()->get();
            foreach ($latih as $row) {
                $jumlah = Latih::whereYear('waktu', $row->year)->whereMonth('waktu', $row->month)->get();
                $row->jumlah = $jumlah;
            }
        }
        $data = [
            'filter' => $filter,
            'latih' => $latih
        ];
        return view('data-latih.index', $data);
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
        if ($request->new == 'tahunan') {
            $tahun = $request->tahun;
            $period = new DatePeriod(
                new DateTime($tahun . '-01-01'),
                new DateInterval('P1D'),
                new DateTime($tahun + 1 . '-01-01')
            );
            foreach ($period as $key => $value) {
                Latih::updateOrCreate(['waktu' => $value->format('Y-m-d')]);
            }
        } else if ($request->new == 'bulanan') {
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
                Latih::updateOrCreate(['waktu' => $value->format('Y-m-d')]);
            }
        }
        return $this->page($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Latih  $latih
     * @return \Illuminate\Http\Response
     */
    public function show(Latih $latih)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Latih  $latih
     * @return \Illuminate\Http\Response
     */
    public function edit(Latih $latih)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Latih  $latih
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Latih $latih)
    {
        $latih->update([$request->name => $request->value]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $year
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (is_null($request->month)) {
            Latih::whereYear('waktu', $request->year)->delete();
        } else {
            Latih::whereYear('waktu', $request->year)->whereMonth('waktu', $request->month)->delete();
        }
        Cache::forget('trend');
        Cache::forget('musiman');
        return redirect()->route('data-latih.page', ['filter' => $request->filter])->with('success', 'Data berhasil dihapus!');
    }

    public function export(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        if ($tahun == null) {
            return 'Tahun tidak boleh kosong!';
        }
        $data = Latih::select('waktu', 'jumlah')->whereYear('waktu', $tahun)->get();
        $name = !is_null($bulan) ? 'titik-api(' . date('F', mktime(0, 0, 0, $bulan, 10)) . ' ' . $tahun . ').xlsx' : 'titik-api(' . $tahun . ').xlsx';
        if ($data->count() > 0) {
            return Excel::download(new ApiExport($bulan, $tahun), $name);
        }
        return redirect()->route('data-latih.page')->with('error', 'Data tidak ditemukan!');
    }

    public function import(Request $request)
    {
        Excel::import(new ApiImport, $request->file('file'));
        Cache::forget('musiman');
        return redirect()->route('data-latih.page', ['filter' => $request->filter])->with('success', 'Data berhasil disimpan!');
    }

    public function getYear()
    {
        $year = Latih::select(DB::raw('YEAR(waktu) as year'))->orderBy('year')->distinct()->get();
        $year = $year->pluck('year');
        return $year;
    }
}
