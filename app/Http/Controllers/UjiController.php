<?php

namespace App\Http\Controllers;

use App\Uji;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UjiController extends Controller
{
    public function page(Request $request)
    {
        $filter = $request->filter;
        if ($filter == null) {
            $latih = Uji::orderBy('waktu')->get();
        } else if ($filter == 'tahun') {
            $latih = Uji::select(DB::raw('YEAR(waktu) as year'))->orderBy('year')->distinct()->get();
            foreach ($latih as $row) {
                $jumlah = Uji::whereYear('waktu', $row->year)->get();
                $row->jumlah = $jumlah;
            }
        } else if ($filter == 'bulan') {
            $latih = Uji::select(DB::raw('MONTH(waktu) as month, YEAR(waktu) as year'))->orderBy('year')->distinct()->get();
            foreach ($latih as $row) {
                $jumlah = Uji::whereYear('waktu', $row->year)->whereMonth('waktu', $row->month)->get();
                $row->jumlah = $jumlah;
            }
        }
        $data = [
            'filter' => $filter,
            'latih' => $latih
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
}
