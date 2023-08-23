<?php

namespace App\Imports;

use App\Models\Proyek;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProyekImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Proyek([
            'nama_proyek' => $row['nama_proyek'],
            'nama_customer' => $row['nama_customer'],
            'nilai_kontrak' => $row['nilai_kontrak'],
            'kode_proyek' => $row['kode_proyek'],
            'tgl_jatuh_tempo' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_jatuh_tempo']),
            'sales' => $row['sales'],
            'status' => $row['status'],
            'term_of_payment' => $row['term_of_payment'],
        ]);
    }
}
