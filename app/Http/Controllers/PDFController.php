<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Options;

class PDFController extends Controller
{
    public function salesVolumePDF()
    {
        $get = DB::table('invoice')
            ->join('proyek', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
            ->join('sales', 'proyek.sales_id', '=', 'sales.id')
            ->join('payment_terms', 'proyek.payment_terms_id', '=', 'payment_terms.id')
            ->select(
                'proyek.nama_proyek',
                'proyek.nama_customer',
                'proyek.kode_proyek',
                'proyek.nilai_kontrak',
                'invoice.no_invoice',
                'invoice.progress',
                'invoice.tagihan',
                'invoice.ppn_nominal',
                'invoice.total_tagihan',
                'invoice.tgl_invoice',
                'invoice.tgl_jatuh_tempo',
                'invoice.koreksi_dp',
                'invoice.nilai_tagihan',
                'invoice.keterangan',
                'sales.nama_sales'
            )
            ->where('invoice.status', '!=', 'DIBATALKAN')
            ->where('invoice.progress', 'NOT LIKE', '%DP%')
            ->orderBy('invoice.tgl_invoice', 'desc');

        if (request('tgl_awal') && request('tgl_akhir')) {
            $tgl_awal = Carbon::createFromFormat('d-m-Y', request('tgl_awal'))->format('Y-m-d');
            $tgl_akhir = Carbon::createFromFormat('d-m-Y', request('tgl_akhir'))->format('Y-m-d');

            $get->whereBetween(DB::raw("CONVERT(DATE, invoice.tgl_invoice, 105)"), [$tgl_awal, $tgl_akhir]);
        }

        $result = $get->get();

        $html = view('page.sales_volume.export-pdf', compact('result'))->render();

        $options = new Options();
        $options->setDpi(72);
        $options->setIsRemoteEnabled(true);
        $options->setIsHtml5ParserEnabled(true);
        $options->setChroot(public_path());
        $options->setIsFontSubsettingEnabled(true);


        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->getOptions()->set('renderer', 'gd'); // Menggunakan GD sebagai renderer gambar
        $dompdf->loadHtml($html);
        $pdfName = 'sales-volume ' . request('tgl_awal') . '-' . request('tgl_akhir');

        $dompdf->render();

        $dompdf->stream($pdfName . ".pdf");
    }

    public function invoicePDF()
    {
        $get = DB::table('invoice')
            ->select('invoice.id', 'invoice.tgl_ttk', 'invoice.ar', 'invoice.total_tagihan', 'invoice.status', 'invoice.progress', 'proyek.nama_proyek', 'proyek.kode_proyek', 'proyek.nilai_kontrak', 'invoice.no_invoice', 'invoice.no_invoice_before', 'invoice.tgl_invoice', 'invoice.tgl_jatuh_tempo', 'invoice.keterangan', 'invoice.created_at', 'sales.nama_sales')
            ->join('proyek', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
            ->join('sales', 'proyek.sales_id', '=', 'sales.id')
            ->join('payment_terms', 'proyek.payment_terms_id', '=', 'payment_terms.id')
            ->where('status', '!=', 'DIBATALKAN')
            ->orderBy('invoice.id', 'desc');

        if (request('tgl_awal') && request('tgl_akhir')) {
            $tgl_awal = Carbon::createFromFormat('d-m-Y', request('tgl_awal'))->format('Y-m-d');
            $tgl_akhir = Carbon::createFromFormat('d-m-Y', request('tgl_akhir'))->format('Y-m-d');

            $get->whereBetween(DB::raw("CONVERT(DATE, invoice.tgl_invoice, 105)"), [$tgl_awal, $tgl_akhir]);
        }

        if (request('status') && request('status') !== 'SEMUA STATUS') {
            $get->where('invoice.status', '=', request('status'));
        }

        $result = $get->get();

        $html = view('page.invoice.export-pdf', compact('result'))->render();

        $options = new Options();
        $options->setDpi(72);
        $options->setIsRemoteEnabled(true);
        $options->setIsHtml5ParserEnabled(true);
        $options->setChroot(public_path());
        $options->setIsFontSubsettingEnabled(true);


        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->getOptions()->set('renderer', 'gd'); // Menggunakan GD sebagai renderer gambar
        $dompdf->loadHtml($html);
        $pdfName = 'invoice ' . request('tgl_awal') . '-' . request('tgl_akhir');

        $dompdf->render();

        $dompdf->stream($pdfName . ".pdf");
    }
}
