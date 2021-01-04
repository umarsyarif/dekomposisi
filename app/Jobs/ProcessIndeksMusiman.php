<?php

namespace App\Jobs;

use App\Musiman;
use App\Kecamatan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessIndeksMusiman implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $kecamatan;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Kecamatan $kecamatan)
    {
        $this->kecamatan = $kecamatan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $kecamatan = $this->kecamatan;
        $dataLatih = Kecamatan::getDataLatih($kecamatan);
        $years = Kecamatan::getYear();
        $years->pop();
        $dateRange = Kecamatan::getDate();
        $movingAverage = Kecamatan::movingAverage($dataLatih);
        $penyesuaian = 0;
        foreach ($dateRange as $row) {
            $jumlah = collect([]);
            $ma = collect([]);
            foreach ($years->pluck('year') as $year) {
                $date = date('Y-m-d H:i:s', mktime(0, 0, 0, $row->month, $row->day, $year));
                $x = $dataLatih->where('waktu', $date)->first();
                $currentMa = $movingAverage->firstWhere('waktu', $date)->ma;
                if ($currentMa == null) {
                    $ma->put($year, null);
                } else {
                    $ma->put($year, $currentMa != 0 ? $x->jumlah / $currentMa * 100 : 0);
                }
                if ($row->month == 2 && $row->day == 29 && $year % 4 != 0) {
                    $jumlah->put($year, null);
                    $ma->put($year, null);
                } else {
                    $jumlah->put($year, $x->jumlah);
                }
            }
            $row->jumlah = $jumlah;
            $row->ma = $ma;
            $row->medial = round(($ma->sum() - $ma->min() - $ma->max()) / 2, 2);
            $penyesuaian += $row->medial;
            // save
            $tgl = date('Y-m-d', mktime(0, 0, 0, $row->month, $row->day));
            Musiman::updateOrCreate([
                'waktu' => $tgl
            ], [
                'medial' => $row->medial
            ]);
        }
        $penyesuaian = round((366 / $penyesuaian), 9);
        $jumlahIndeksMusiman = 0;
        foreach ($dateRange as $row) {
            $medial = round($row->medial, 2);
            $jumlahIndeksMusiman += round($medial * $penyesuaian, 2);
        }
        $data = [
            'data' => $dateRange,
            'year' => $years,
            'penyesuaian' => $penyesuaian,
            'jumlahIndeks' => round($jumlahIndeksMusiman)
        ];
        return $data;
    }
}
