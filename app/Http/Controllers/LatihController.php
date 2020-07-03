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
        $this->middleware('auth');
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
        $tahun = $request->tahun;
        $period = new DatePeriod(
            new DateTime($tahun . '-01-01'),
            new DateInterval('P1D'),
            new DateTime($tahun + 1 . '-01-01')
        );
        foreach ($period as $key => $value) {
            Latih::updateOrCreate(['waktu' => $value->format('Y-m-d')]);
        }
        Cache::forget('musiman');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $year
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $year)
    {
        $data = Latih::whereYear('waktu', $year)->get()->each(function ($data) {
            $data->delete();
        });
        Cache::forget('musiman');
        return redirect()->route('data-latih.page', ['filter' => $request->filter])->with('success', 'Data berhasil dihapus!');
    }

    public function export(Request $request)
    {
        $tahun = $request->tahun;
        if ($tahun == null) {
            return 'ads';
        }
        $data = Latih::select('waktu', 'jumlah')->whereYear('waktu', $tahun)->get();
        if ($data->count() > 0) {
            return Excel::download(new ApiExport($tahun), 'titik-api(' . $tahun . ').xlsx');
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
