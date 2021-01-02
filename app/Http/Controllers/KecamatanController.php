<?php

namespace App\Http\Controllers;

use App\Kecamatan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function page()
    {
        $kecamatan = Kecamatan::get();

        $data = [
            'kecamatan' => $kecamatan
        ];
        return view('pages.kecamatan', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Kecamatan::create($request->all());

        return redirect()->route('kecamatan.page')->with('success', 'Data berhasil ditambah!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kecamatan $kecamatan)
    {
        $kecamatan->update($request->all());

        return redirect()->route('kecamatan.page')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();

        return redirect()->route('kecamatan.page')->with('success', 'Data berhasil dihapus!');
    }
}
