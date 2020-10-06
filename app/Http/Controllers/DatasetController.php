<?php

namespace App\Http\Controllers;

use App\Dataset;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Http\Request;
use App\Imports\DatasetImport;
use App\Exports\DatasetExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class DatasetController extends Controller
{
    public function page(Request $request)
    {
        $filter = $request->filter;
        if ($filter == 'tahun') {
            $dataset = Dataset::getYear();
            foreach ($dataset as $row) {
                $row->jumlah = Dataset::whereYear('waktu', $row->year)->get();
            }
        } else if ($filter == 'bulan') {
            $dataset = Dataset::getMonth();
            foreach ($dataset as $row) {
                $row->jumlah = Dataset::whereYear('waktu', $row->year)->whereMonth('waktu', $row->month)->get();
            }
        } else {
            $dataset = Dataset::all();
        }

        $data = [
            'dataset' => $dataset,
            'filter' => $filter
        ];
        return view('pages.datasets', $data);
    }

    public function devide(Request $request)
    {
        $dataLatih = Dataset::getDataLatih();
        $dataUji = Dataset::getDataUji();

        $data = [
            'dataLatih' => $dataLatih,
            'dataUji' => $dataUji
        ];
        return view('pages.pembagian-data', $data);
    }

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
                Dataset::updateOrCreate(['waktu' => $value->format('Y-m-d')]);
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
                Dataset::updateOrCreate(['waktu' => $value->format('Y-m-d')]);
            }
        }
        $this->forgetCache();
        return $this->page($request);
    }

    public function update(Request $request, Dataset $data)
    {
        $data->update([$request->name => $request->value]);
    }

    public function destroy(Request $request)
    {
        if (is_null($request->month)) {
            Dataset::whereYear('waktu', $request->year)->delete();
        } else {
            Dataset::whereYear('waktu', $request->year)->whereMonth('waktu', $request->month)->delete();
        }
        $this->forgetCache();
        return redirect()->route('dataset.page', ['filter' => $request->filter])->with('success', 'Data berhasil dihapus!');
    }

    public function import(Request $request)
    {
        Excel::import(new DatasetImport, $request->file('file'));
        $this->forgetCache();
        return redirect()->route('dataset.page', ['filter' => $request->filter])->with('success', 'Data berhasil disimpan!');
    }

    public function export(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        if ($tahun == null) {
            return 'Tahun tidak boleh kosong!';
        }
        $data = Dataset::select('waktu', 'jumlah')->whereYear('waktu', $tahun)->get();
        $name = !is_null($bulan) ? 'titik-api(' . date('F', mktime(0, 0, 0, $bulan, 10)) . ' ' . $tahun . ').xlsx' : 'titik-api(' . $tahun . ').xlsx';
        if ($data->count() > 0) {
            return Excel::download(new DatasetExport($bulan, $tahun), $name);
        }
        return redirect()->route('dataset.page')->with('error', 'Data tidak ditemukan!');
    }

    public function forgetCache()
    {
        Cache::forget('trend');
        Cache::forget('musiman');
    }
}
