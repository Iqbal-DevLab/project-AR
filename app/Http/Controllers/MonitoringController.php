<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index()
    {
        $customers1 = DB::table('customer')
            ->join('proyek', 'proyek.customer_id', '=', 'customer.id')
            ->groupBy('customer.id', 'customer.nama_customer')
            ->select(
                DB::raw('SUM(CAST(proyek.nilai_kontrak AS decimal(18))) as totalHargaKontrak'),
                'customer.id',
                'customer.nama_customer'
            )
            ->get();

        $customers2 = DB::table('customer')
            ->join(
                'invoice',
                'customer.id',
                '=',
                'invoice.customer_id'
            )
            ->groupBy('customer.id')
            ->where('invoice.status', '!=', 'Dibatalkan')
            ->select(
                DB::raw('SUM(CAST(invoice.total_tagihan AS decimal(18))) as totalNilaiTagihan'),
                'customer.id',
            )
            ->get();


        $customers3 = DB::table('customer')
            ->join('transaksi', 'transaksi.customer_id', '=', 'customer.id')
            ->where('transaksi.status', '!=', 'Dibatalkan')
            ->groupBy('customer.id')
            ->select(
                DB::raw('SUM(CAST(transaksi.total_dana_masuk AS decimal(18))) as pembayaranSudahDiterima'),
                'customer.id',
            )
            ->get();

        $customers4 = DB::table('customer')
            ->join(
                'invoice',
                'customer.id',
                '=',

                'invoice.customer_id'
            )
            ->groupBy('customer.id')
            ->where('invoice.status', 'Menunggu Pembayaran')
            ->select(
                DB::raw('SUM(CAST(invoice.total_tagihan AS decimal(18))) as pembayaranBelumDiterima'),
                'customer.id',
            )
            ->get();

        $customers5 = DB::table('customer')
            ->join(
                'invoice',
                'customer.id',
                '=',

                'invoice.customer_id'
            )
            ->groupBy('customer.id')
            ->where(
                'invoice.status',
                '!=',
                'Dibatalkan'
            )
            ->select(
                DB::raw('SUM(CAST(invoice.ar AS decimal(18))) as AR'),
                'customer.id',
            )
            ->get();

        $combinedCustomers = [];

        foreach ($customers1 as $customer1) {
            $combinedCustomer = $customer1;

            foreach ($customers2 as $customer2) {
                if ($customer1->id == $customer2->id) {
                    $combinedCustomer->totalNilaiTagihan = "";
                    $combinedCustomer->totalNilaiTagihan = $customer2->totalNilaiTagihan;
                    break;
                }
            }

            foreach ($customers3 as $customer3) {
                if ($customer1->id == $customer3->id) {
                    $combinedCustomer->pembayaranSudahDiterima = "";
                    $combinedCustomer->pembayaranSudahDiterima = $customer3->pembayaranSudahDiterima;
                    break;
                }
            }

            // foreach ($customers4 as $customer4) {
            //     if ($customer1->id == $customer4->id) {
            //         $combinedCustomer->pembayaranBelumDiterima = "";
            //         $combinedCustomer->pembayaranBelumDiterima = $customer4->pembayaranBelumDiterima;
            //         break;
            //     }
            // }

            foreach ($customers5 as $customer5) {
                if ($customer1->id == $customer5->id) {
                    $combinedCustomer->AR = "";
                    $combinedCustomer->AR = $customer5->AR;
                    break;
                }
            }
            $totalHargaKontrak = isset($combinedCustomer->totalHargaKontrak) ? $combinedCustomer->totalHargaKontrak : 0;
            $pembayaranSudahDiterima = isset($combinedCustomer->pembayaranSudahDiterima) ? $combinedCustomer->pembayaranSudahDiterima : 0;
            // $pembayaranBelumDiterima = isset($combinedCustomer->pembayaranBelumDiterima) ? $combinedCustomer->pembayaranBelumDiterima : 0;
            $AR = isset($combinedCustomer->AR) ? $combinedCustomer->AR : 0;


            $sisaTagihan = max(0, $totalHargaKontrak * 111 / 100 - $pembayaranSudahDiterima - $AR);
            $combinedCustomer->sisaTagihan = $sisaTagihan;
            $combinedCustomers[] = $combinedCustomer;
        }
        // dd($combinedCustomers);

        $tableDP = DB::table('invoice')
            ->select('invoice.id', 'invoice.nilai_tagihan', 'invoice.tgl_ttk', 'invoice.ar', 'invoice.total_tagihan', 'invoice.status', 'invoice.progress', 'proyek.nama_proyek', 'proyek.kode_proyek', 'proyek.nama_customer', 'invoice.no_invoice', 'invoice.tagihan', 'invoice.tgl_invoice', 'invoice.tgl_jatuh_tempo')
            ->join('proyek', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
            ->where(function ($query) {
                $query->where('invoice.status', '!=', 'Dibatalkan')
                    ->where('invoice.status', '!=', 'Tagihan Telah Dilunasi');
            })
            ->where('invoice.progress', 'LIKE', '%DP%')
            ->orderBy('invoice.id', 'desc')
            ->get();

        $tableBMOS = DB::table('invoice')
            ->select('transaksi.nilai_giro', 'invoice.nilai_tagihan', 'transaksi.status as transaksiStatus', 'invoice.id', 'invoice.tgl_ttk', 'invoice.ar', 'invoice.total_tagihan', 'invoice.status as invoiceStatus', 'invoice.progress', 'proyek.nama_proyek', 'proyek.kode_proyek', 'proyek.nama_customer', 'invoice.no_invoice', 'invoice.tagihan', 'invoice.tgl_invoice', 'invoice.tgl_jatuh_tempo')
            ->join('proyek', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
            ->leftJoin('transaksi', 'invoice.id', '=', 'transaksi.invoice_id')
            ->where(function ($query) {
                $query->where('invoice.status', '!=', 'Dibatalkan')
                    ->where('invoice.status', '!=', 'Tagihan Telah Dilunasi');
            })
            ->where('invoice.progress', 'LIKE', '%BMOS%')
            ->where(function ($query) {
                $query->where('transaksi.status', '!=', 'Dibatalkan')
                    ->orWhereNull('transaksi.status');
            })
            ->orderBy('invoice.id', 'desc')
            ->get();

        return view('page.monitoring.index', compact('combinedCustomers', 'tableDP', 'tableBMOS'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show()
    {
        $customer = DB::table('customer')
            ->where('customer.id', request('id'))
            ->first();

        $proyek = DB::table('proyek')
            ->join('customer', 'proyek.nama_customer', '=', 'customer.nama_customer')
            ->join('sales', 'sales.id', '=', 'proyek.sales_id')
            ->join('payment_terms', 'proyek.payment_terms_id', '=', 'payment_terms.id')
            ->select('proyek.*', 'sales.nama_sales', 'payment_terms.DP', 'payment_terms.APPROVAL', 'payment_terms.BMOS', 'payment_terms.AMOS', 'payment_terms.TESTCOMM', 'payment_terms.RETENSI')
            ->where('proyek.nama_customer', $customer->nama_customer)
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

            $transaksi = [];

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
                $transaksi[] = $transaksiItem;
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
        // dd($customer, $proyek, $monitoringTable);
        return view('page.monitoring.detail', compact('proyek', 'customer', 'monitoringTable'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        dd($request);
        DB::table('proyek')
            ->where('kode_proyek', $request->kode_proyek)
            ->update([
                'keterngan' => $request->keterangan
            ]);

        return redirect()->back()->with('success', 'Keterangan berhasil diperbarui');
    }

    public function destroy($id)
    {
        //
    }
}
