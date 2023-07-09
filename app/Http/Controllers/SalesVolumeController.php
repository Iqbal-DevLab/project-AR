<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesTarget;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class SalesVolumeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $get = DB::table('invoice')
            ->join('proyek', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
            ->join('sales', 'proyek.sales_id', '=', 'sales.id')
            ->join('payment_terms', 'proyek.payment_terms_id', '=', 'payment_terms.id')
            ->select('proyek.nama_proyek', 'proyek.nama_customer', 'proyek.kode_proyek', 'proyek.nilai_kontrak', 'invoice.no_invoice', 'invoice.progress', 'invoice.tagihan', 'invoice.ppn_nominal', 'invoice.total_tagihan', 'invoice.tgl_invoice', 'invoice.tgl_jatuh_tempo', 'invoice.koreksi_dp', 'invoice.nilai_tagihan', 'invoice.keterangan', 'sales.nama_sales')
            ->where('invoice.status', '!=', 'DIBATALKAN')
            ->orderBy('invoice.tgl_invoice', 'desc');

        if ($request->tgl_awal and $request->tgl_akhir) {
            $tgl_awal = Carbon::createFromFormat('d-m-Y', $request->tgl_awal)->format('Y-m-d');
            $tgl_akhir = Carbon::createFromFormat('d-m-Y', $request->tgl_akhir)->format('Y-m-d');

            $result = $get->whereBetween(DB::raw("CONVERT(DATE, invoice.tgl_invoice, 105)"), [$tgl_awal, $tgl_akhir])->get();
        }

        $result = $get->get();


        $total_sales_volume = DB::table('invoice')
            ->where('kode_proyek', $request->kode_proyek)
            ->select(DB::raw('SUM(CAST(total_tagihan AS decimal(18))) as total'))
            ->first()
            ->total;

        return view('page.sales_volume.index', compact('result'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
