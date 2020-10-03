<?php

namespace App\Imports;

use App\Dataset;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DatasetImport implements ToCollection, WithHeadingRow
{
    use Importable;
    /**
     * @param collection $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $waktu = Date::excelToDateTimeObject($row['tanggal'])->format('Y-m-d');
            $jumlah = $row['jumlah_titik_api'];

            if (!isset($jumlah)) {
                return null;
            }

            Dataset::updateOrCreate(
                [
                    'waktu'  => $waktu
                ],
                [
                    'waktu'  => $waktu,
                    'jumlah' => $jumlah,
                ]
            );
        }
    }
}
