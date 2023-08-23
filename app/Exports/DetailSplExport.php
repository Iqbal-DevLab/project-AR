<?php

namespace App\Exports;

use App\Models\DetailSpl;
use App\Models\Spl;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetailSplExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $date;
    public function __construct($sdate, $edate)
    {
        $this->sdate = $sdate;
        $this->edate = $edate;
    }

    public function collection()
    {
        // $data = DB::select('EXEC p_export_excel @start_date = ?, @end_date = ?', [
        //     $this->sdate,
        //     $this->edate
        // ]);
        $data = DB::table('t_detail_spl')
            ->select('t_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_spl.keterangan', 't_karyawan.nik_karyawan', 't_karyawan.nama_karyawan', 'r_bagian.nama_bagian', 't_karyawan.tarif_lembur', 't_karyawan.status_kontrak', DB::raw('CASE WHEN t_spl.id_jenis_hari = 1 THEN "Hari Kerja" WHEN t_spl.id_jenis_hari = 0 THEN "Hari Libur" END AS id_jenis_hari'), 't_spl.istirahat', 't_spl.start_jam', 't_spl.end_jam', 't_spl.tgl_lembur', 't_spl.end_date', 't_spl.tgl_pengajuan', 't_detail_spl.lama_lembur', 't_detail_spl.uang_makan', 't_detail_spl.poin_lembur', 't_detail_spl.tarif_total_lembur', 't_approval.tgl_approval_spv', 't_approval.tgl_approval_manager', 't_spl.updated_by', 't_spl.created_at')
            ->join('t_spl', 't_detail_spl.spl_id', '=', 't_spl.id')
            ->join('t_karyawan', 't_detail_spl.karyawan_id', '=', 't_karyawan.id')
            ->join('r_bagian', 't_karyawan.bagian_id', '=', 'r_bagian.id')
            ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
            ->whereBetween('t_spl.tgl_pengajuan', [$this->sdate, $this->edate])
            ->where('t_approval.status', '=', '2')
            ->get();
        // dd($data);
        return collect($data);
    }

    public function headings(): array
    {
        return ["ID SPL", "Kode Proyek", "Nama Proyek", "Keterangan", "NIK", "Nama Karyawan", "Bagian", "Tarif Lembur", "Status Kontrak", "Jenis Hari", "Istirahat", "Start Jam", "End Jam", "Start Date", "End Date", "Tanggal Pengajuan", "Lama Lembur", "Uang Makan", "Poin Lembur", "Tarif Total Lembur", "Tanggal Approval SPV", "Tanggal Approval Manager", "Updated By", "Created At"];
    }
}
