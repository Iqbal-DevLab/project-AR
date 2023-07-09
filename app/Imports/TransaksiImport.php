<?php

namespace App\Imports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class TransaksiImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Transaksi([
            'nama_proyek' => $row['nama_proyek'],
            'bank' => $row['bank'],
            'tgl_transfer' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_transfer']),
            'no_giro' => $row['no_giro'],
            'tgl_giro_cair' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_giro_cair']),
            'tgl_terima_giro' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_terima_giro']),
            'dana_masuk' => $row['dana_masuk'],
            'type' => $row['type'],
            'status' => $row['status'],
        ]);
    }
}
