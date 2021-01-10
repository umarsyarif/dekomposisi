<?php

namespace App\Http\Controllers;

use App\Dataset;
use App\Kecamatan;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Http\Request;
use App\Imports\DatasetImport;
use App\Exports\DatasetExport;
use App\Jobs\ProcessIndeksMusiman;
use App\Jobs\ProcessTrend;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

class DatasetController extends Controller
{
    public function page(Request $request)
    {
        $filter = $request->filter;
        $kecamatan = $request->kecamatan;
        if ($filter == 'tahun') {
            $dataset = Dataset::getYear();
            foreach ($dataset as $row) {
                $row->jumlah = Dataset::getPerYear($row->year, $kecamatan);
            }
        } else if ($filter == 'bulan') {
            $dataset = Dataset::getMonth();
            foreach ($dataset as $row) {
                $row->jumlah = Dataset::getPerMonth($row->year, $row->month, $kecamatan);
            }
        } else {
            $dataset = Cache::rememberForever('dataset-harian', function () use ($kecamatan) {
                return Dataset::getPerKecamatan($kecamatan);
            });
        }

        $allKecamatan = Kecamatan::all();

        $data = [
            'dataset' => $dataset,
            'allKecamatan' => $allKecamatan,
            'filter' => $filter,
            'kecamatan' => $kecamatan,
        ];
        return view('pages.datasets', $data);
    }

    public function devide(Request $request)
    {
        $kecamatan = $request->kecamatan;

        if ($kecamatan) {
            $dataLatih = Dataset::getDataLatih($kecamatan);
            $dataUji = Dataset::getDataUji($kecamatan);
        }

        $allKecamatan = Kecamatan::all();
        $data = [
            'dataLatih' => $dataLatih ?? [],
            'dataUji' => $dataUji ?? [],
            'kecamatan' => $kecamatan,
            'allKecamatan' => $allKecamatan
        ];
        return view('pages.pembagian-data', $data);
    }

    public function store(Request $request)
    {
        $kecamatan = $request->kecamatan;
        if ($request->new == 'tahunan') {
            $tahun = $request->tahun;
            $period = new DatePeriod(
                new DateTime($tahun . '-01-01'),
                new DateInterval('P1D'),
                new DateTime($tahun + 1 . '-01-01')
            );
            foreach ($period as $key => $value) {
                Dataset::updateOrCreate([
                    'waktu' => $value->format('Y-m-d'),
                    'kecamatan_id' => $kecamatan
                ]);
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
                Dataset::updateOrCreate([
                    'waktu' => $value->format('Y-m-d'),
                    'kecamatan_id' => $kecamatan
                ]);
            }
        }
        $this->forgetCache();
        return $this->page($request);
    }

    public function update(Request $request, Dataset $data)
    {
        $data->update([$request->name => $request->value]);
        $this->forgetCache();
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
        Cache::flush();
    }

    public function processQueue()
    {
        // $size = Queue::size('trend');
        // if ($size > 1) {
        //     Queue::get
        // }
        // ProcessTrend::dispatch()->onQueue('trend');
        // $allKecamatan = Kecamatan::all();
        // foreach ($allKecamatan as $kecamatan) {
        //     $queueName = 'kecamatan-' . $kecamatan->id;
        //     Queue::size($queueName);
        //     $job = ProcessIndeksMusiman::dispatch($kecamatan)->onQueue($queueName);
        // }
    }
}
