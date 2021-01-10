<?php

namespace App\Exports;

use App\Dataset;
use App\Kecamatan;
use DateTime;
use DatePeriod;
use DateInterval;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Symfony\Component\VarDumper\Cloner\Data;

class DatasetExport implements FromCollection, WithColumnFormatting, WithHeadings
{
    protected $api;
    protected $dates;
    protected $allKecamatan;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;

        $this->allKecamatan = Kecamatan::all();
        $this->dates = $this->getDates($month, $year);
    }

    public function getDates($month, $year)
    {
        $start = $year . '-' . ($month ?? '01') . '-01';
        $end = ($month ? $year : $year + 1) . '-' . ($month ? $month + 1 : '01') . '-01';
        $period = new DatePeriod(
            new DateTime($start),
            new DateInterval('P1D'),
            new DateTime($end)
        );
        return $period;
    }

    public function collection()
    {
        $data = collect();
        foreach ($this->dates as $date) {
            $row = [$date->format('d/m/Y')];
            foreach ($this->allKecamatan as $kecamatan) {
                $jumlah = Dataset::whereDate('waktu', $date)
                    ->where('kecamatan_id', $kecamatan->id)
                    ->first()
                    ->jumlah;
                array_push($row, $jumlah > 0 ? $jumlah : '0');
            }
            $data->push($row);
        }
        return $data;
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function headings(): array
    {
        $data = [
            'Tanggal',
        ];
        foreach ($this->allKecamatan as $kecamatan) {
            array_push($data, $kecamatan->nama);
        }
        return $data;
    }
}
