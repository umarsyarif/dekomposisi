<?php

namespace App\Imports;

use App\Dataset;
use App\Kecamatan;
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
        $allKecamatan = Kecamatan::all();
        foreach ($rows as $row) {

            if (!is_numeric($row['tanggal'])) {
                return null;
            }

            $waktu = Date::excelToDateTimeObject($row['tanggal'])->format('Y-m-d');

            foreach ($allKecamatan as $kecamatan) {

                $row_name = strtolower(str_replace(' ', '_', $kecamatan->nama));
                $jumlah = $row[$row_name];

                if (!isset($jumlah)) {
                    return null;
                }

                Dataset::updateOrCreate(
                    [
                        'waktu'  => $waktu,
                        'kecamatan_id' => $kecamatan->id
                    ],
                    [
                        'waktu'  => $waktu,
                        'jumlah' => $jumlah,
                        'kecamatan_id' => $kecamatan->id
                    ]
                );
            }
        }
    }
}
