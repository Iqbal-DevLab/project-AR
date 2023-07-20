<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\invoice;
use App\Models\Customer;
use App\Models\Proyek;
use App\Models\Salestarget;
use App\Models\PaymentTerms;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $get = DB::table('invoice')
            ->select('invoice.id', 'invoice.tgl_ttk', 'invoice.ar', 'invoice.total_tagihan', 'invoice.status', 'invoice.progress', 'proyek.nama_proyek', 'proyek.kode_proyek', 'proyek.nilai_kontrak', 'invoice.no_invoice', 'invoice.no_invoice_before', 'invoice.tgl_invoice', 'invoice.tgl_jatuh_tempo', 'invoice.keterangan', 'invoice.created_at', 'sales.nama_sales')
            ->join('proyek', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
            ->join('sales', 'proyek.sales_id', '=', 'sales.id')
            ->join('payment_terms', 'proyek.payment_terms_id', '=', 'payment_terms.id')
            ->where('status', '!=', 'DIBATALKAN')
            ->orderBy('invoice.id', 'desc');

        if ($request->tgl_awal && $request->tgl_akhir) {
            $tgl_awal = Carbon::createFromFormat('d-m-Y', $request->tgl_awal)->format('Y-m-d');
            $tgl_akhir = Carbon::createFromFormat('d-m-Y', $request->tgl_akhir)->format('Y-m-d');

            $get->whereBetween(DB::raw("CONVERT(DATE, invoice.tgl_invoice, 105)"), [$tgl_awal, $tgl_akhir]);
        }

        if ($request->status && $request->status !== 'SEMUA STATUS') {
            $get->where('invoice.status', '=', $request->status);
        }

        $result = $get->get();

        // $get = DB::table('invoice')
        //     ->select('invoice.id', 'invoice.tgl_ttk', 'invoice.ar', 'invoice.total_tagihan', 'invoice.status', 'invoice.progress', 'proyek.nama_proyek', 'proyek.kode_proyek', 'proyek.nilai_kontrak', 'invoice.no_invoice', 'invoice.no_invoice_before', 'invoice.tgl_invoice', 'invoice.tgl_jatuh_tempo', 'invoice.keterangan', 'invoice.created_at', 'sales.nama_sales')
        //     ->join('proyek', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
        //     ->join('sales', 'proyek.sales_id', '=', 'sales.id')
        //     ->join('payment_terms', 'proyek.payment_terms_id', '=', 'payment_terms.id')
        //     ->orderBy('invoice.id', 'desc');

        // $bulan = $request->input('bulan');
        // $tahun = $request->input('tahun');

        // if ($bulan && $tahun) {
        //     $tgl_awal = Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->startOfMonth();
        //     $tgl_akhir = Carbon::createFromFormat('Y-m-d', "{$tahun}-{$bulan}-01")->endOfMonth();

        //     $get->whereBetween(DB::raw("CONVERT(DATE, invoice.tgl_invoice, 105)"), [$tgl_awal, $tgl_akhir]);
        // }

        // $result = $get->get();

        return view('page.invoice.index', compact('result'));
    }

    public function create()
    {
        $invoice = DB::table('invoice')->get();
        $payment_terms = PaymentTerms::All();

        $proyek = DB::table('proyek')
            ->select('proyek.*', 'sales.nama_sales', 'payment_terms.id as payment_terms_id')
            ->join('sales', 'sales.id', '=', 'proyek.sales_id')
            ->join('customer', 'customer.id', '=', 'proyek.customer_id')
            ->join('payment_terms', 'payment_terms.id', '=', 'proyek.payment_terms_id')
            ->get();

        $dataInvoice = DB::table('invoice')
            ->select('proyek.nilai_kontrak', 'invoice.tgl_ttk', 'invoice.ar', 'invoice.ar', 'invoice.total_tagihan', 'invoice.status', 'invoice.progress', 'proyek.kode_proyek', 'proyek.nama_customer', 'invoice.no_invoice', 'invoice.no_invoice_before', 'invoice.tgl_jatuh_tempo', 'payment_terms.DP', 'payment_terms.APPROVAL', 'payment_terms.BMOS', 'payment_terms.AMOS', 'payment_terms.TESTCOMM', 'payment_terms.RETENSI')
            ->join('proyek', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
            ->join('sales', 'proyek.sales_id', '=', 'sales.id')
            ->join('payment_terms', 'proyek.payment_terms_id', '=', 'payment_terms.id')
            ->orderBy('invoice.id', 'asc')
            ->get();

        return view('page.invoice.create', compact('invoice', 'dataInvoice', 'proyek', 'payment_terms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_proyek' => 'required',
            'nama_proyek' => 'required',
            'no_invoice' => 'required|unique:invoice',
            'no_faktur_pajak' => 'required',
            'tgl_invoice' => 'required',
            'progress' => 'required',
            'tagihan' => 'required',
            'pph' => 'required',
            'total_tagihan' => 'required',
        ], [
            'kode_proyek.required' => 'Kode proyek tidak boleh kosong!',
            'nama_proyek.required' => 'Nama proyek tidak boleh kosong!',
            'no_invoice.unique' => 'No. invoice sudah ada!',
            'no_invoice.required' => 'No. invoice tidak boleh kosong!',
            'no_faktur_pajak.required' => 'No. faktur pajak tidak boleh kosong!',
            'tgl_invoice.required' => 'Tanggal invoice tidak boleh kosong!',
            'progress.required' => 'Progress tidak boleh kosong!',
            'tagihan.required' => 'Tagihan tidak boleh kosong!',
            'pph.required' => 'PPh tidak boleh kosong!',
            'total_tagihan.required' => 'Total tagihan tidak boleh kosong!',
        ]);

        $tagihan = $request->tagihan ? str_replace(['.', ',-'], '', $request->tagihan) : null;
        $nilai_tagihan = $request->nilai_tagihan ? str_replace(['.', ',-'], '', $request->nilai_tagihan) : null;
        $koreksi_dp = $request->koreksi_dp ? str_replace(['.', ',-'], '', $request->koreksi_dp) : null;
        $total_tagihan = $request->total_tagihan ? str_replace(['.', ',-'], '', $request->total_tagihan) : null;
        $ppn_nominal = $request->ppn_nominal ? str_replace(['.', ',-'], '', $request->ppn_nominal) : null;
        $pph_nominal = $request->pph_nominal ? str_replace(['.', ',-'], '', $request->pph_nominal) : null;
        $lain_lain = $request->lain_lain ? str_replace(['.', ',-'], '', $request->lain_lain) : null;

        DB::table('invoice')->insert([
            'kode_proyek' => $request->kode_proyek,
            'customer_id' => $request->customer_id,
            'no_invoice' => $request->no_invoice,
            'no_faktur_pajak' => $request->no_faktur_pajak,
            'no_invoice_before' => null,
            'tgl_invoice' => $request->tgl_invoice,
            'tagihan' => $tagihan,
            'nilai_tagihan' => $nilai_tagihan,
            'koreksi_dp' => $koreksi_dp,
            'ppn_nominal' => $ppn_nominal,
            'pph' => $request->pph,
            'pph_nominal' => $pph_nominal,
            'lain_lain' => $lain_lain,
            'total_tagihan' => $total_tagihan,
            'ar' => $total_tagihan,
            'progress' => $request->progress,
            'status' => 'KWITANSI BELUM DITERIMA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('proyek')
            ->where('kode_proyek', $request->kode_proyek)
            ->update([
                'keterangan' => $request->keterangan
            ]);
        return redirect('/invoice')->with('success', 'Invoice berhasil dibuat!');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim melalui permintaan (request)
        // $request = $request->validate([
        //     'tgl_ttk' => 'required|date_format:d-m-Y',
        //     'batas_jatuh_tempo' => 'required',
        //     'keterangan' => 'required',
        // ]);

        // Perbarui data faktur menggunakan DB::table
        DB::table('invoice')->where('id', $id)->update([
            'tgl_ttk' => $request->tgl_ttk,
            'keterangan' => $request->keterangan,
            'batas_jatuh_tempo' => $request->batas_jatuh_tempo ? $request->batas_jatuh_tempo : $request->batas_jatuh_tempo_lainnya,
            'tgl_jatuh_tempo' => $request->tgl_jatuh_tempo,
            'status' => 'MENUNGGU PEMBAYARAN'
        ]);

        // Redirect ke halaman yang sesuai atau kirimkan respons
        // Misalnya, Anda dapat mengalihkan kembali ke halaman indeks dengan pesan sukses
        return redirect()->back()->with('success', 'Tanggal TTK berhasil diperbarui');
    }

    public function cancel($id)
    {
        $invoice = DB::table('invoice')->where('id', $id)->first();

        if ($invoice->status === 'DIBATALKAN') {
            return redirect()->back()->with('info', 'Invoice sudah dibatalkan sebelumnya.');
        }

        DB::table('invoice')->where('id', $id)->update([
            'status' => 'DIBATALKAN',
            'no_invoice_before' => $invoice->no_invoice,
            'no_invoice' =>  $invoice->no_invoice . '[Batal]'
        ]);

        return redirect()->back()->with('success', 'Invoice berhasil dibatalkan.');
    }

    public function destroy($id)
    {
        //
    }
}
