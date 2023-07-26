<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\Customer;

class MonitoringController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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
            ->where('invoice.status', '!=', 'DIBATALKAN')
            ->select(
                DB::raw('SUM(CAST(invoice.total_tagihan AS decimal(18))) as totalNilaiTagihan'),
                'customer.id',
            )
            ->get();

        $customers3 = DB::table('customer')
            ->join('transaksi', 'transaksi.customer_id', '=', 'customer.id')
            ->where('transaksi.status', '!=', 'DIBATALKAN')
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
            ->where('invoice.status', 'MENUNGGU PEMBAYARAN')
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
                'DIBATALKAN'
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

            foreach ($customers4 as $customer4) {
                if ($customer1->id == $customer4->id) {
                    $combinedCustomer->pembayaranBelumDiterima = "";
                    $combinedCustomer->pembayaranBelumDiterima = $customer4->pembayaranBelumDiterima;
                    break;
                }
            }

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

        // dd($combinedCustomers, $customers1, $customers2, $customers3, $customers4);
        // dd();

        // $customers2 = DB::table('customer')
        //     ->join('proyek', 'proyek.nama_customer', '=', 'customer.nama_customer')
        //     ->join('invoice', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
        //     ->groupBy('customer.id', 'customer.nama_customer')
        //     ->select(
        //         DB::raw('SUM(CAST(proyek.nilai_kontrak AS decimal(18))) as totalHargaKontrak'),
        //         DB::raw('SUM(CAST(invoice.total_tagihan AS decimal(18))) as totalNilaiTagihan'),
        //         'customer.id',
        //         'customer.nama_customer'
        //     )
        //     ->get();

        // $customers1 = DB::table('customer')
        //     ->join('proyek', 'proyek.nama_customer', '=', 'customer.nama_customer')
        //     ->groupBy('customer.id', 'customer.nama_customer')
        //     ->select(
        //         DB::raw('SUM(CAST(proyek.nilai_kontrak AS decimal(18))) as totalHargaKontrak'),
        //         'customer.id',
        //         'customer.nama_customer'
        //     )
        //     ->get();

        // $customers2 = DB::table('customer')
        //     ->join('proyek', 'proyek.nama_customer', '=', 'customer.nama_customer')
        //     ->join('invoice', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
        //     ->groupBy('customer.id', 'customer.nama_customer')
        //     ->select(
        //         DB::raw('SUM(CAST(proyek.nilai_kontrak AS decimal(18))) as totalHargaKontrak'),
        //         DB::raw('SUM(CAST(invoice.total_tagihan AS decimal(18))) as totalNilaiTagihan'),
        //         'customer.id',
        //         'customer.nama_customer'
        //     )
        //     ->get();

        // $customers3 = DB::table('customer')
        //     ->join('proyek', 'proyek.nama_customer', '=', 'customer.nama_customer')
        //     ->join('transaksi', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
        //     ->groupBy('customer.id', 'customer.nama_customer')
        //     ->select(
        //         DB::raw('SUM(CAST(proyek.nilai_kontrak AS decimal(18))) as totalHargaKontrak'),
        //         DB::raw('SUM(CAST(transaksi.total_dana_masuk AS decimal(18))) as pembayaranSudahDiterima'),
        //         'customer.id',
        //         'customer.nama_customer'
        //     )
        //     ->get();

        // $customers4 = DB::table('customer')
        //     ->join('proyek', 'proyek.nama_customer', '=', 'customer.nama_customer')
        //     ->join('invoice', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
        //     ->groupBy('customer.id', 'customer.nama_customer')
        //     ->select(
        //         DB::raw('SUM(CAST(proyek.nilai_kontrak AS decimal(18))) as totalHargaKontrak'),
        //         DB::raw('SUM(CAST(invoice.total_tagihan AS decimal(18))) as pembayaranBelumDiterima'),
        //         'customer.id',
        //         'customer.nama_customer'
        //     )
        //     ->where('status', 'MENUNGGU PEMBAYARAN')
        //     ->get();

        // $combinedCustomers = [];

        // if ($customers3->pembayaranSudahDiterima != null && $customers4->pembayaranBelumDiterima != null) {
        //     foreach ($customers1 as $customer1) {
        //             $combinedCustomer = $customer1;

        //         foreach ($customers2 as $customer2) {
        //             if ($customer1->id == $customer2->id) {
        //                 $combinedCustomer->totalNilaiTagihan = $customer2->totalNilaiTagihan;
        //                 break;
        //             }
        //         }

        //         foreach ($customers3 as $customer3) {
        //             if ($customer1->id == $customer3->id) {
        //                 $combinedCustomer->pembayaranSudahDiterima = $customer3->pembayaranSudahDiterima;
        //                 break;
        //             }
        //         }

        //         foreach ($customers4 as $customer4) {
        //             if ($customer1->id == $customer4->id) {
        //                 $combinedCustomer->pembayaranBelumDiterima = $customer4->pembayaranBelumDiterima;
        //                 break;
        //             }
        //         }

        //         $sisaTagihan = max(0, $combinedCustomer->totalHargaKontrak * 111 / 100 - $combinedCustomer->pembayaranSudahDiterima - $combinedCustomer->pembayaranBelumDiterima);


        //         // $sisaTagihan = max(0, $combinedCustomer->totalHargaKontrak * 111 / 100 - $combinedCustomer->pembayaranSudahDiterima - $combinedCustomer->pembayaranBelumDiterima);
        //         $combinedCustomer->sisaTagihan = $sisaTagihan;

        //         $combinedCustomers[] = $combinedCustomer;
        //     } 
        // } else {
        //         $combinedCustomer->totalNilaiTagihan = null;
        //         $combinedCustomer->pembayaranSudahDiterima = null;
        //         $combinedCustomer->pembayaranBelumDiterima = null;
        //         $sisaTagihan = null;
        //     }

        // dd($combinedCustomers);


        // dd($customers1, $customers2, $customersF);

        $tableDP = DB::table('invoice')
            ->select('invoice.id', 'invoice.nilai_tagihan', 'invoice.tgl_ttk', 'invoice.ar', 'invoice.total_tagihan', 'invoice.status', 'invoice.progress', 'proyek.nama_proyek', 'proyek.kode_proyek', 'proyek.nama_customer', 'invoice.no_invoice', 'invoice.tagihan', 'invoice.tgl_invoice', 'invoice.tgl_jatuh_tempo')
            ->join('proyek', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
            ->where('invoice.status', '!=', 'DIBATALKAN')
            ->where('invoice.status', '!=', 'TAGIHAN TELAH DILUNASI')
            ->orderBy('invoice.id', 'desc')
            ->get();

        $tableBMOS = DB::table('invoice')
            ->select('transaksi.nilai_giro', 'invoice.nilai_tagihan', 'transaksi.status as transaksiStatus', 'invoice.id', 'invoice.tgl_ttk', 'invoice.ar', 'invoice.total_tagihan', 'invoice.status as invoiceStatus', 'invoice.progress', 'proyek.nama_proyek', 'proyek.kode_proyek', 'proyek.nama_customer', 'invoice.no_invoice', 'invoice.tagihan', 'invoice.tgl_invoice', 'invoice.tgl_jatuh_tempo')
            ->join('proyek', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
            ->leftJoin('transaksi', 'invoice.id', '=', 'transaksi.invoice_id')
            ->where('invoice.status', '!=', 'DIBATALKAN')
            ->where('invoice.status', '!=', 'TAGIHAN TELAH DILUNASI')
            ->orderBy('invoice.id', 'desc')
            ->get();

        // dd($tableDPdanBMOS);

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
                    'DIBATALKAN'
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
                ->whereIn('transaksi.status', ['SUDAH DIBAYAR', 'BELUM DIBAYAR'])
                ->where(
                    'transaksi.status',
                    '!=',
                    'DIBATALKAN'
                )
                ->get();

            foreach ($transaksiData as $transaksiItem) {
                $transaksi[] = $transaksiItem; // Append each transaction data to the $transaksi array
            }

            $pembayaranSudahDiterima = DB::table('transaksi')
                ->where('status', 'SUDAH DIBAYAR')
                ->where('kode_proyek', $item->kode_proyek)
                ->select(DB::raw('SUM(CAST(total_dana_masuk AS decimal(18))) as totalPembayaranSudahDiterima'))
                ->first()
                ->totalPembayaranSudahDiterima;

            $pembayaranBelumDiterima = DB::table('invoice')
                ->where(
                    'invoice.status',
                    '!=',
                    'DIBATALKAN'
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

            // $tagihanDP = DB::table('invoice')
            //     ->where('kode_proyek', $item->kode_proyek)
            //     ->where('progress', 'LIKE', '%DP%')
            //     ->select(DB::raw('SUM(CAST(total_tagihan AS decimal(18))) as tagihanDP'))
            //     ->first()
            //     ->tagihanDP;

            // $arDP = DB::table('invoice')
            //     ->where('kode_proyek', $item->kode_proyek)
            //     ->where('progress', 'LIKE', '%DP%')
            //     ->select(DB::raw('SUM(CAST(ar AS decimal(18))) as arDP'))
            //     ->first()
            //     ->arDP;

            // $tagihanAPPROVAL = DB::table('invoice')
            //     ->where('kode_proyek', $item->kode_proyek)
            //     ->where('progress', 'LIKE', '%APPROVAL%')
            //     ->select(DB::raw('SUM(CAST(total_tagihan AS decimal(18))) as tagihanAPPROVAL'))
            //     ->first()
            //     ->tagihanAPPROVAL;

            // $arAPPROVAL = DB::table('invoice')
            //     ->where('kode_proyek', $item->kode_proyek)
            //     ->where('progress', 'LIKE', '%APPROVAL%')
            //     ->select(DB::raw('SUM(CAST(ar AS decimal(18))) as arAPPROVAL'))
            //     ->first()
            //     ->arAPPROVAL;

            // $tagihanBMOS = DB::table('invoice')
            //     ->where('kode_proyek', $item->kode_proyek)
            //     ->where('progress', 'LIKE', '%BMOS%')
            //     ->select(DB::raw('SUM(CAST(total_tagihan AS decimal(18))) as tagihanBMOS'))
            //     ->first()
            //     ->tagihanBMOS;

            // $arBMOS = DB::table('invoice')
            //     ->where('kode_proyek', $item->kode_proyek)
            //     ->where('progress', 'LIKE', '%BMOS%')
            //     ->select(DB::raw('SUM(CAST(ar AS decimal(18))) as arBMOS'))
            //     ->first()
            //     ->arBMOS;

            // $tagihanAMOS = DB::table('invoice')
            //     ->where('kode_proyek', $item->kode_proyek)
            //     ->where('progress', 'LIKE', '%AMOS%')
            //     ->select(DB::raw('SUM(CAST(total_tagihan AS decimal(18))) as tagihanAMOS'))
            //     ->first()
            //     ->tagihanAMOS;

            // $arAMOS = DB::table('invoice')
            //     ->where('kode_proyek', $item->kode_proyek)
            //     ->where('progress', 'LIKE', '%AMOS%')
            //     ->select(DB::raw('SUM(CAST(ar AS decimal(18))) as arAMOS'))
            //     ->first()
            //     ->arAMOS;

            // $tagihanTESTCOMM = DB::table('invoice')
            //     ->where('kode_proyek', $item->kode_proyek)
            //     ->where('progress', 'LIKE', '%TESTCOMM%')
            //     ->select(DB::raw('SUM(CAST(total_tagihan AS decimal(18))) as tagihanTESTCOMM'))
            //     ->first()
            //     ->tagihanTESTCOMM;

            // $arTESTCOMM = DB::table('invoice')
            //     ->where('kode_proyek', $item->kode_proyek)
            //     ->where('progress', 'LIKE', '%TESTCOMM%')
            //     ->select(DB::raw('SUM(CAST(ar AS decimal(18))) as arTESTCOMM'))
            //     ->first()
            //     ->arTESTCOMM;

            // $tagihanRETENSI = DB::table('invoice')
            //     ->where('kode_proyek', $item->kode_proyek)
            //     ->where('progress', 'LIKE', '%RETENSI%')
            //     ->select(DB::raw('SUM(CAST(total_tagihan AS decimal(18))) as tagihanRETENSI'))
            //     ->first()
            //     ->tagihanRETENSI;

            // $arRETENSI = DB::table('invoice')
            //     ->where('kode_proyek', $item->kode_proyek)
            //     ->where('progress', 'LIKE', '%RETENSI%')
            //     ->select(DB::raw('SUM(CAST(ar AS decimal(18))) as arRETENSI'))
            //     ->first()
            //     ->arRETENSI;

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

            // $monitoringTable[$item->id] = [
            //     'proyek' => $item,
            //     'invoice' => $invoice,
            //     'transaksi' => $transaksi,
            //     'pembayaranSudahDiterima' => $pembayaranSudahDiterima,
            //     'pembayaranBelumDiterima' => $pembayaranBelumDiterima,
            //     'sisaTagihan' => $sisaTagihan,
            //     'totalNilaiTagihan' => $totalNilaiTagihan,
            //     'tagihanDP' => $tagihanDP,
            //     'arDP' => $arDP,
            //     'tagihanAPPROVAL' => $tagihanAPPROVAL,
            //     'arAPPROVAL' => $arAPPROVAL,
            //     'tagihanBMOS' => $tagihanBMOS,
            //     'arBMOS' => $arBMOS,
            //     'tagihanAMOS' => $tagihanAMOS,
            //     'arAMOS' => $arAMOS,
            //     'tagihanTESTCOMM' => $tagihanTESTCOMM,
            //     'arTESTCOMM' => $arTESTCOMM,
            //     'tagihanRETENSI' => $tagihanRETENSI,
            //     'arRETENSI' => $arRETENSI,
            // ];
        }

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
