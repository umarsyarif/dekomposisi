<?php

namespace App\Exports;

use App\Uji;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class UjiExport implements FromQuery, WithMapping, WithColumnFormatting, WithHeadings
{
    protected $api;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function query()
    {
        if (is_null($this->month)) {
            return Uji::query()->select('waktu', 'jumlah')->whereYear('waktu', $this->year);
        } else {
            return Uji::query()->select('waktu', 'jumlah')->whereYear('waktu', $this->year)->whereMonth('waktu', $this->month);
        }
    }

    public function map($api): array
    {
        return [
            Date::PHPToExcel($api->waktu),
            $api->jumlah > 0 ? $api->jumlah : '0',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jumlah titik api',
        ];
    }
}
