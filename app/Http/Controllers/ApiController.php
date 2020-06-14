<?php

namespace App\Http\Controllers;

use App\Api;
use App\Exports\ApiExport;
use App\Imports\ApiImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ApiController extends Controller
{
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Api  $api
     * @return \Illuminate\Http\Response
     */
    public function show(Api $api)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Api  $api
     * @return \Illuminate\Http\Response
     */
    public function edit(Api $api)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Api  $api
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Api $api)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Api  $api
     * @return \Illuminate\Http\Response
     */
    public function destroy(Api $api)
    {
        //
    }

    public function export(Request $request)
    {
        $tahun = $request->tahun;
        $data = Api::select('waktu', 'jumlah')->whereYear('waktu', $tahun)->get();
        if ($data->count() > 0) {
            return Excel::download(new ApiExport($tahun), 'titik-api(' . $tahun . ').xlsx');
        }
        return redirect()->route('page', 'data-latih')->with('error', 'Data tidak ditemukan!');
    }

    public function import(Request $request)
    {
        Excel::import(new ApiImport, $request->file('file'));
        return redirect()->route('page', 'data-latih')->with('success', 'Data berhasil disimpan!');
    }

    public function getYear()
    {
        $data = Api::orderBy('waktu')->get();
        $x = [];
        foreach ($data as $row) {
            array_push($x, date('Y', strtotime($row->waktu)));
        }
        $years = array_unique($x);
        return $years;
    }
}
