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
            ->where('invoice.status', '!=', 'Dibatalkan')
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
            ->where('status', '!=', 'Dibatalkan')
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

    public function monitoringPDF()
    {
        // $results = DB::table('invoice as i')
        //     ->leftJoin('proyek as p', 'p.kode_proyek', '=', 'i.kode_proyek')
        //     ->leftJoin('payment_terms as pt', 'pt.id', '=', 'p.payment_terms_id')
        //     ->leftJoin('sales as s', 's.id', '=', 'p.sales_id')
        //     ->where('i.status', '!=', 'Dibatalkan')
        //     ->where('i.ar', '<=', DB::raw('total_tagihan'))
        //     ->where('i.ar', '<>', 0)
        //     ->select(
        //         'p.nama_customer',
        //         'p.nama_proyek',
        //         's.nama_sales',
        //         'p.nilai_kontrak',
        //         'pt.DP',
        //         'pt.APPROVAL',
        //         'pt.BMOS',
        //         'pt.AMOS',
        //         'pt.TESTCOMM',
        //         'pt.RETENSI',
        //         'p.kode_proyek',
        //         'i.no_invoice',
        //         'i.tgl_ttk',
        //         'i.progress',
        //         'i.ar',
        //         'p.keterangan',
        //         'i.batas_jatuh_tempo',
        //         'i.tgl_jatuh_tempo',
        //         DB::raw('CONVERT(INT, total_tagihan) - CONVERT(INT, i.ar) AS pembayaranSudahDiterima')
        //     )
        //     ->orderBy('p.nama_customer')
        //     ->orderBy('p.nama_proyek')
        //     ->get();

        $mainQuery = DB::table('invoice AS i')
            ->leftJoin('proyek AS p', 'p.kode_proyek', '=', 'i.kode_proyek')
            ->leftJoin('payment_terms AS pt', 'pt.id', '=', 'p.payment_terms_id')
            ->leftJoin('sales AS s', 's.id', '=', 'p.sales_id')
            ->where('i.status', '!=', 'Dibatalkan')
            ->where('i.ar', '<=', DB::raw('TRY_CONVERT(INT, total_tagihan)'))
            ->where('i.ar', '<>', '0')
            ->select(
                'p.nama_customer',
                'p.nama_proyek',
                's.nama_sales',
                'p.nilai_kontrak',
                'pt.DP',
                'pt.APPROVAL',
                'pt.BMOS',
                'pt.AMOS',
                'pt.TESTCOMM',
                'pt.RETENSI',
                'p.kode_proyek',
                'i.no_invoice',
                'i.tgl_ttk',
                'i.progress',
                'i.ar',
                'p.keterangan',
                'i.batas_jatuh_tempo',
                'i.tgl_jatuh_tempo'
            );

        $subQuery = DB::table('invoice AS i')
            ->leftJoin('proyek AS p', 'p.kode_proyek', '=', 'i.kode_proyek')
            ->where('i.status', '!=', 'Dibatalkan')
            ->groupBy('p.nama_proyek')
            ->select(
                'p.nama_proyek',
                DB::raw('SUM(TRY_CONVERT(INT, total_tagihan) - TRY_CONVERT(INT, i.ar)) AS pembayaranSudahDiterima')
            );

        $result = DB::table(DB::raw("({$mainQuery->toSql()}) AS a"))
            ->mergeBindings($mainQuery)
            ->joinSub($subQuery, 'b', function ($join) {
                $join->on('a.nama_proyek', '=', 'b.nama_proyek');
            })
            ->orderBy('a.nama_customer')
            ->get();

        $proyek = DB::table('proyek')
            ->join('customer', 'proyek.nama_customer', '=', 'customer.nama_customer')
            ->join('sales', 'sales.id', '=', 'proyek.sales_id')
            ->join('payment_terms', 'proyek.payment_terms_id', '=', 'payment_terms.id')
            ->select(
                'proyek.*',
                'sales.nama_sales',
                'payment_terms.DP',
                'payment_terms.APPROVAL',
                'payment_terms.BMOS',
                'payment_terms.AMOS',
                'payment_terms.TESTCOMM',
                'payment_terms.RETENSI'
            )
            ->orderBy('customer.nama_customer')
            // ->where('proyek.nama_customer', $customer->nama_customer)
            ->get();

        $monitoringTable = [];
        foreach ($proyek as $item) {

            $invoice = [];

            $invoiceData = DB::table('invoice')
                ->select('invoice.tgl_lunas', 'invoice.id', 'invoice.ar', 'invoice.tgl_ttk', 'invoice.total_tagihan', 'invoice.status', 'invoice.progress', 'invoice.no_invoice', 'invoice.no_invoice_before', 'invoice.tagihan', 'invoice.tgl_invoice', 'invoice.tgl_jatuh_tempo', 'invoice.batas_jatuh_tempo', 'invoice.keterangan', 'invoice.created_at')
                ->where('invoice.kode_proyek', $item->kode_proyek)
                ->where(
                    'invoice.status',
                    '!=',
                    'Dibatalkan'
                )
                ->get();

            foreach ($invoiceData as $invoiceItem) {
                $invoice[] = $invoiceItem;
            }
            $transaksi = []; // Define an empty array for transactions

            $transaksiData = DB::table('transaksi')
                ->select('invoice.no_invoice', 'invoice.tagihan', 'invoice.nilai_tagihan', 'invoice.total_tagihan', 'invoice.progress', 'invoice.tgl_ttk', 'transaksi.ar', 'transaksi.dana_masuk', 'transaksi.bank', 'transaksi.nilai_giro', 'transaksi.total_dana_masuk', 'invoice.tgl_invoice', 'invoice.tgl_jatuh_tempo', 'transaksi.tgl_transfer', 'transaksi.status')
                ->join('proyek', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
                ->join('invoice', 'invoice.id', '=', 'transaksi.invoice_id')
                ->where('transaksi.kode_proyek', $item->kode_proyek)
                ->whereIn('transaksi.status', ['Sudah Dibayar', 'Belum Dibayar'])
                ->where(
                    'transaksi.status',
                    '!=',
                    'Dibatalkan'
                )
                ->get();

            foreach ($transaksiData as $transaksiItem) {
                $transaksi[] = $transaksiItem; // Append each transaction data to the $transaksi array
            }

            $pembayaranSudahDiterima = DB::table('transaksi')
                ->where('status', 'Sudah Dibayar')
                ->where('kode_proyek', $item->kode_proyek)
                ->select(DB::raw('SUM(CAST(total_dana_masuk AS decimal(18))) as totalPembayaranSudahDiterima'))
                ->first()
                ->totalPembayaranSudahDiterima;

            $pembayaranBelumDiterima = DB::table('invoice')
                ->where(
                    'invoice.status',
                    '!=',
                    'Dibatalkan'
                )
                ->where('kode_proyek', $item->kode_proyek)
                ->select(DB::raw('SUM(CAST(ar AS decimal(18))) as totalPembayaranBelumDiterima'))
                ->first()
                ->totalPembayaranBelumDiterima;

            $sisaTagihan = max(0, $item->nilai_kontrak * 111 / 100 - $pembayaranSudahDiterima - $pembayaranBelumDiterima);

            $totalNilaiTagihan = DB::table('invoice')
                ->where('kode_proyek', $item->kode_proyek)
                ->select(DB::raw('SUM(CAST(total_tagihan AS decimal(18))) as totalNilaiTagihan'))
                ->first()
                ->totalNilaiTagihan;

            $progressTypes = ['DP', 'APPROVAL', 'BMOS', 'AMOS', 'TESTCOMM', 'RETENSI'];

            $monitoringTable[$item->id] = [
                'proyek' => $item,
                'invoice' => $invoice,
                'transaksi' => $transaksi,
                'pembayaranSudahDiterima' => $pembayaranSudahDiterima,
                'pembayaranBelumDiterima' => $pembayaranBelumDiterima,
                'sisaTagihan' => $sisaTagihan,
                'totalNilaiTagihan' => $totalNilaiTagihan,
            ];

            foreach ($progressTypes as $type) {
                $tagihanColumn = "tagihan{$type}";
                $arColumn = "ar{$type}";

                $monitoringTable[$item->id][$tagihanColumn] = DB::table('invoice')
                    ->where('kode_proyek', $item->kode_proyek)
                    ->where('progress', 'LIKE', "%{$type}%")
                    ->select(DB::raw("SUM(CAST(total_tagihan AS decimal(18))) as {$tagihanColumn}"))
                    ->first()
                    ->$tagihanColumn;

                $monitoringTable[$item->id][$arColumn] = DB::table('invoice')
                    ->where('kode_proyek', $item->kode_proyek)
                    ->where('progress', 'LIKE', "%{$type}%")
                    ->select(DB::raw("SUM(CAST(ar AS decimal(18))) as {$arColumn}"))
                    ->first()
                    ->$arColumn;
            }
        }

        $results = DB::table(function ($query) {
            $query->select(
                'p.nama_customer',
                'p.nama_proyek',
                's.nama_sales',
                'p.nilai_kontrak',
                'pt.DP',
                'pt.APPROVAL',
                'pt.BMOS',
                'pt.AMOS',
                'pt.TESTCOMM',
                'pt.RETENSI',
                'p.kode_proyek',
                'i.no_invoice',
                'i.tgl_ttk',
                'i.progress',
                'i.ar',
                'p.keterangan',
                'i.batas_jatuh_tempo',
                'i.tgl_jatuh_tempo',
                'i.total_tagihan',
                DB::raw("CASE WHEN i.progress like '%RETENSI%' then CONVERT(INT, i.total_tagihan) - CONVERT(INT, i.ar) end RET"),
                DB::raw("CASE WHEN i.progress like '%TESCOMM%' then CONVERT(INT, i.total_tagihan) - CONVERT(INT, i.ar) end TESTC"),
                DB::raw("CASE WHEN i.progress like '%MOS%' then CONVERT(INT, i.total_tagihan) - CONVERT(INT, i.ar) end MOS")
            )
                ->from('invoice AS i')
                ->leftJoin('proyek AS p', 'p.kode_proyek', '=', 'i.kode_proyek')
                ->leftJoin('payment_terms AS pt', 'pt.id', '=', 'p.payment_terms_id')
                ->leftJoin('sales AS s', 's.id', '=', 'p.sales_id')
                ->where('i.status', '!=', 'DIBATALKAN')
                ->whereColumn('i.ar', '<=', 'total_tagihan')
                ->where('i.ar', '<>', 0);
        }, 'a')
            ->joinSub(function ($query) {
                $query->select(
                    'p.nama_proyek',
                    DB::raw("SUM(CONVERT(INT, total_tagihan) - CONVERT(INT, i.ar)) AS pembayaranSudahDiterima")
                )
                    ->from('invoice AS i')
                    ->leftJoin('proyek AS p', 'p.kode_proyek', '=', 'i.kode_proyek')
                    ->where('i.status', '!=', 'DIBATALKAN')
                    ->groupBy('p.nama_proyek');
            }, 'b', 'a.nama_proyek', '=', 'b.nama_proyek')
            ->orderBy('a.nama_customer')
            ->get();

        // dd($results);
        // return view('page.monitoring.export-pdf', compact('proyek', 'monitoringTable', 'results'));
        $html = view('page.monitoring.export-pdf', compact('proyek', 'monitoringTable', 'results'))->render();

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
        $pdfName = 'AR Monitoring ' . request('tgl_awal') . '-' . request('tgl_akhir');

        $dompdf->render();

        $dompdf->stream($pdfName . ".pdf");
    }
}
