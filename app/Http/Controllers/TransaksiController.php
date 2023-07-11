<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        // $transaksi = DB::table('transaksi')
        //     ->join('proyek', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
        //     ->join('invoice', 'transaksi.invoice_id', '=', 'invoice.id')
        //     ->select('transaksi.id', 'transaksi.invoice_id', 'invoice.no_invoice', 'transaksi.progress', 'transaksi.bank', 'transaksi.tgl_transfer', 'transaksi.no_giro', 'transaksi.nilai_giro', 'transaksi.tgl_terima_giro', 'transaksi.tgl_giro_cair', 'transaksi.dana_masuk', 'transaksi.status', 'transaksi.kode_proyek', 'proyek.nama_proyek', 'proyek.nama_customer')
        //     ->groupBy('transaksi.id', 'transaksi.invoice_id', 'invoice.no_invoice', 'transaksi.progress', 'transaksi.bank', 'transaksi.tgl_transfer', 'transaksi.no_giro', 'transaksi.nilai_giro', 'transaksi.tgl_terima_giro', 'transaksi.tgl_giro_cair', 'transaksi.dana_masuk', 'transaksi.status', 'transaksi.kode_proyek', 'proyek.nama_proyek', 'proyek.nama_customer')
        //     ->where('transaksi.invoice_id', '!=', null)
        //     ->get();

        $get = DB::table('transaksi')
            ->select('transaksi.id', 'transaksi.invoice_id', 'invoice.no_invoice', 'invoice.no_invoice_before', 'invoice.tagihan', 'invoice.total_tagihan', 'transaksi.progress', 'transaksi.bank', 'transaksi.total_dana_masuk', 'transaksi.tgl_transfer', 'transaksi.no_giro', 'transaksi.nilai_giro', 'transaksi.tgl_terima_giro', 'transaksi.tgl_giro_cair', 'transaksi.dana_masuk', 'transaksi.status', 'transaksi.kode_proyek', 'proyek.nama_proyek', 'proyek.nama_customer')
            ->groupBy('transaksi.id', 'transaksi.invoice_id', 'invoice.no_invoice', 'invoice.no_invoice_before', 'invoice.tagihan', 'invoice.total_tagihan', 'transaksi.progress', 'transaksi.bank', 'transaksi.total_dana_masuk', 'transaksi.tgl_transfer', 'transaksi.no_giro', 'transaksi.nilai_giro', 'transaksi.tgl_terima_giro', 'transaksi.tgl_giro_cair', 'transaksi.dana_masuk', 'transaksi.status', 'transaksi.kode_proyek', 'proyek.nama_proyek', 'proyek.nama_customer')
            ->join('proyek', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
            ->join('invoice', 'transaksi.invoice_id', '=', 'invoice.id')
            ->where('transaksi.status', '!=', 'DIBATALKAN')
            ->whereNotNull('transaksi.invoice_id');

        if ($request->tgl_awal && $request->tgl_akhir) {
            $tgl_awal = Carbon::createFromFormat('d-m-Y', $request->tgl_awal)
                ->format('Y-m-d');
            $tgl_akhir = Carbon::createFromFormat('d-m-Y', $request->tgl_akhir)
                ->format('Y-m-d');

            if ($request->filter_select) {
                $filter_select = $request->filter_select;
                switch ($filter_select) {
                    case 'TANGGAL_TRANSFER':
                        $get->whereBetween(DB::raw("CONVERT(DATE, transaksi.tgl_transfer, 105)"), [$tgl_awal, $tgl_akhir]);
                        break;
                    case 'TANGGAL_TERIMA_GIRO':
                        $get->whereBetween(DB::raw("CONVERT(DATE, transaksi.tgl_terima_giro, 105)"), [$tgl_awal, $tgl_akhir]);
                        break;
                    case 'TANGGAL_GIRO_CAIR':
                        $get->whereBetween(DB::raw("CONVERT(DATE, transaksi.tgl_giro_cair, 105)"), [$tgl_awal, $tgl_akhir]);
                        break;
                        // Tambahkan case untuk pilihan filter lainnya jika diperlukan
                }
            }
        }

        $transaksi = $get->get();

        foreach ($transaksi as $t) {
            if ($t->status == 'SUDAH DIBAYAR') {
                $totalDanaMasuk = DB::table('transaksi')
                    ->select(DB::raw('SUM(CAST(total_dana_masuk AS DECIMAL(12))) AS total_dana_masuk'))
                    ->where('invoice_id', $t->invoice_id)
                    ->where('status', '!=', 'DIBATALKAN')
                    ->first();

                if ($totalDanaMasuk->total_dana_masuk >= $t->total_tagihan) {
                    DB::table('invoice')
                        ->where('id', $t->invoice_id)
                        ->where('status', '!=', 'DIBATALKAN')
                        ->update(['status' => 'TAGIHAN TELAH DILUNASI', 'tgl_lunas' => $t->tgl_transfer]);
                } elseif ($totalDanaMasuk->total_dana_masuk <= $t->total_tagihan) {
                    DB::table('invoice')
                        ->where('id', $t->invoice_id)
                        ->where('status', '!=', 'DIBATALKAN')
                        ->update(['status' => 'TAGIHAN MENUNGGU PELUNASAN']);
                }
            }
        }

        $notifications = [];

        foreach ($transaksi as $t2) {
            if ($t2->status === 'BELUM DIBAYAR' && !empty($t2->tgl_giro_cair) && empty($t2->tgl_transfer)) {
                $tglGiroCair = Carbon::createFromFormat('d-m-Y', $t2->tgl_giro_cair);

                if ($tglGiroCair instanceof Carbon) {
                    $currentDate = Carbon::now()->startOfDay();

                    // Hitung perbedaan hari antara tgl_giro_cair dan tanggal sekarang
                    $daysDiff = $currentDate->diffInDays($tglGiroCair, false);

                    // Buat notifikasi berdasarkan perbedaan hari
                    if ($daysDiff == 0) {
                        $notification = [
                            'no_invoice' => $t2->no_invoice,
                            'nama_proyek' => $t2->nama_proyek,
                            'nama_customer' => $t2->nama_customer,
                            'keterangan' => 'Hari ini adalah batas waktu pembayaran giro',
                            'icon' => '<i class="fa fa-fw fa-exclamation-triangle text-warning"></i>'
                        ];
                        $notifications[] = $notification;
                    } elseif ($daysDiff < 0) {
                        $notification = [
                            'no_invoice' => $t2->no_invoice,
                            'nama_proyek' => $t2->nama_proyek,
                            'nama_customer' => $t2->nama_customer,
                            'keterangan' => 'Pembayaran giro kadaluwarsa ' . abs($daysDiff) . ' hari lalu',
                            'icon' => '<i class="fa fa-fw fa-times text-danger"></i>'
                        ];
                        $notifications[] = $notification;
                    } elseif ($daysDiff > 0 && $daysDiff <= 7) {
                        $notification = [
                            'no_invoice' => $t2->no_invoice,
                            'nama_proyek' => $t2->nama_proyek,
                            'nama_customer' => $t2->nama_customer,
                            'keterangan' => 'Pembayaran giro akan kadaluwarsa ' . $daysDiff . ' hari dari sekarang',
                            'icon' => '<i class="fa fa-fw fa-exclamation-triangle text-warning"></i>'
                        ];
                        $notifications[] = $notification;
                    }
                }
            }
        }

        $getDibatalkan = DB::table('transaksi')
            ->select('transaksi.id', 'transaksi.invoice_id', 'invoice.no_invoice', 'invoice.no_invoice_before', 'invoice.tagihan', 'invoice.total_tagihan', 'transaksi.progress', 'transaksi.bank', 'transaksi.total_dana_masuk', 'transaksi.tgl_transfer', 'transaksi.no_giro', 'transaksi.nilai_giro', 'transaksi.tgl_terima_giro', 'transaksi.tgl_giro_cair', 'transaksi.dana_masuk', 'transaksi.status', 'transaksi.kode_proyek', 'proyek.nama_proyek', 'proyek.nama_customer')
            ->groupBy('transaksi.id', 'transaksi.invoice_id', 'invoice.no_invoice', 'invoice.no_invoice_before', 'invoice.tagihan', 'invoice.total_tagihan', 'transaksi.progress', 'transaksi.bank', 'transaksi.total_dana_masuk', 'transaksi.tgl_transfer', 'transaksi.no_giro', 'transaksi.nilai_giro', 'transaksi.tgl_terima_giro', 'transaksi.tgl_giro_cair', 'transaksi.dana_masuk', 'transaksi.status', 'transaksi.kode_proyek', 'proyek.nama_proyek', 'proyek.nama_customer')
            ->join('proyek', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
            ->join('invoice', 'transaksi.invoice_id', '=', 'invoice.id')
            ->where('transaksi.status',  'DIBATALKAN')
            ->whereNotNull('transaksi.invoice_id')
            ->get();


        return view('page.transaksi.index', compact('transaksi', 'notifications', 'getDibatalkan'));
    }

    public function create()
    {
        $transaksi = DB::table('transaksi')
            ->select('transaksi.*', 'proyek.nama_proyek')
            ->join('proyek', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
            ->get();

        $proyek = DB::table('invoice')
            ->join('proyek', 'proyek.kode_proyek', '=', 'invoice.kode_proyek')
            ->select('invoice.id', 'invoice.customer_id', 'invoice.no_invoice', 'proyek.nama_proyek', 'invoice.sisa_pembayaran', 'invoice.tgl_ttk', 'invoice.batas_jatuh_tempo', 'invoice.tgl_jatuh_tempo', 'invoice.koreksi_dp', 'invoice.nilai_tagihan', 'invoice.progress', 'proyek.kode_proyek', 'invoice.tagihan', 'invoice.pph', 'invoice.pph_nominal', 'invoice.ppn_nominal', 'invoice.lain_lain', 'invoice.total_tagihan')
            ->where('invoice.status', '!=', 'DIBATALKAN')
            ->where('invoice.status', '!=', 'TAGIHAN TELAH DILUNASI')
            ->whereNotNull('invoice.tgl_ttk')
            ->get();

        return view('page.transaksi.create', compact('transaksi', 'proyek'));
    }

    public function store(Request $request)
    {
        $rules = [
            'no_invoice' => 'required',
            'nama_proyek' => 'required',
            'kode_proyek' => 'required',
            'progress' => 'required',
            'status' => 'required',
            'bank' => 'required',
        ];

        if ($request->switch == 'on') {
            $rules += [
                'no_giro' => 'required',
                'tgl_terima_giro' => 'required',
                'tgl_giro_cair' => 'required',
                'nilai_giro' => 'required',
            ];
        } else {
            $rules += [
                'tgl_transfer' => 'required',
                'dana_masuk' => 'required',
            ];
        }

        $request->validate($rules, [
            'no_invoice.required' => 'No. invoice tidak boleh kosong!',
            'nama_proyek.required' => 'Nama proyek tidak boleh kosong!',
            'kode_proyek.required' => 'Kode proyek tidak boleh kosong!',
            'progress.required' => 'Progress pembayaran tidak boleh kosong!',
            'bank.required' => 'Nama bank tidak boleh kosong!',
            'tgl_transfer' => 'Tanggal transfer tidak boleh kosong!',
            'dana_masuk' => 'Dana masuk tidak boleh kosong!',
            'no_giro' => 'No giro tidak boleh kosong!',
            'tgl_terima_giro' => 'Tanggal terima giro tidak boleh kosong!',
            'tgl_giro_cair' => 'Tanggal giro cair tidak boleh kosong!',
            'nilai_giro' => 'Nilai giro tidak boleh kosong!',
            'status.required' => 'Status pembayaran tidak boleh kosong!',
        ]);

        $dana = $request->dana_masuk ? str_replace(['.', ',-'], '', $request->dana_masuk) : null;
        $total_dana_masuk = $request->total_dana_masuk ? str_replace(['.', ',-'], '', $request->total_dana_masuk) : null;
        $bank_charge = $request->bank_charge ? str_replace(['.', ',-'], '', $request->bank_charge) : null;
        $nilai_giro = $request->nilai_giro ? str_replace(['.', ',-'], '', $request->nilai_giro) : null;
        $sisa_pembayaran = $request->sisa_pembayaran ? str_replace(['.', ',-'], '', $request->sisa_pembayaran) : null;

        DB::table('transaksi')->insert([
            'kode_proyek' => $request->kode_proyek,
            'customer_id' => $request->customer_id,
            'invoice_id' => $request->invoice_id,
            'progress' => $request->progress,
            'bank' => $request->bank,
            'tgl_transfer' => $request->tgl_transfer,
            'no_giro' => $request->no_giro,
            'tgl_terima_giro' => $request->tgl_terima_giro,
            'tgl_giro_cair' => $request->tgl_giro_cair,
            'nilai_giro' => $nilai_giro,
            'dana_masuk' => $dana,
            'sisa_pembayaran' => $sisa_pembayaran,
            'total_dana_masuk' => $total_dana_masuk,
            'bank_charge' => $bank_charge,
            'status' => $request->status,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // Menghitung sisa pembayaran
        $total_tagihan = str_replace(['.', ',-'], '', $request->total_tagihan);
        $sisa_pembayaran = str_replace(['.', ',-'], '', $request->sisa_pembayaran);
        $total_nilai = $total_dana_masuk ? $total_dana_masuk : $nilai_giro;

        //Pembayaran Transfer
        if ($sisa_pembayaran) {
            $sisa_pembayaran = $sisa_pembayaran - $total_dana_masuk;
        } else {
            $sisa_pembayaran = $total_tagihan - $total_dana_masuk;
        }

        // Mengupdate sisa_pembayaran pada invoice
        DB::table('invoice')
            ->where('id', $request->invoice_id)
            ->update(['sisa_pembayaran' => $sisa_pembayaran]);


        return redirect('transaksi')->with('success', 'Pembayaran baru berhasil ditambahkan.');;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $transaksi = DB::table('transaksi')
            ->join('invoice', 'transaksi.invoice_id', '=', 'invoice.id')
            ->join('proyek', 'proyek.kode_proyek', '=', 'invoice.kode_proyek')
            ->select('transaksi.*', 'transaksi.id as transaksi_id', 'invoice.id as invoice_id', 'invoice.no_invoice', 'invoice.koreksi_dp', 'invoice.nilai_tagihan', 'invoice.batas_jatuh_tempo', 'invoice.tgl_ttk', 'invoice.tgl_jatuh_tempo', 'proyek.nama_proyek', 'invoice.progress', 'proyek.kode_proyek', 'invoice.tagihan', 'invoice.pph', 'invoice.pph_nominal', 'invoice.ppn_nominal', 'invoice.lain_lain', 'invoice.total_tagihan')
            ->where('transaksi.id', $id)
            ->first();

        return view('page.transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $dana =  $request->dana_masuk ?  str_replace(['.', 'Rp', ' '], '', $request->dana_masuk) : null;
        $nilai_giro = $request->nilai_giro ? str_replace(['.', 'Rp', ' '], '', $request->nilai_giro) : null;
        $total_dana_masuk = $request->total_dana_masuk ? str_replace(['.', 'Rp', ' '], '', $request->total_dana_masuk) : null;

        DB::table('transaksi')->where('id', $id)->update([
            'kode_proyek' => $request->kode_proyek,
            'invoice_id' => $request->invoice_id,
            'progress' => $request->progress,
            'bank' => $request->bank,
            'tgl_transfer' => $request->tgl_transfer,
            'no_giro' => $request->no_giro,
            'tgl_terima_giro' => $request->tgl_terima_giro,
            'tgl_giro_cair' => $request->tgl_giro_cair,
            'nilai_giro' => $nilai_giro,
            'dana_masuk' => $dana,
            'total_dana_masuk' => $total_dana_masuk,
            'status' => $request->status,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // Menghitung sisa pembayaran
        $total_tagihan = $request->total_tagihan ?  str_replace(['.', 'Rp', ' ', ',-'], '', $request->total_tagihan) : null;
        $sisa_pembayaran = $request->sisa_pembayaran ?  str_replace(['.', 'Rp', ' ', ',-'], '', $request->sisa_pembayaran) : null;

        //Pembayaran Transfer
        if ($sisa_pembayaran) {
            $sisa_pembayaran = $sisa_pembayaran - $total_dana_masuk;
        } else {
            $sisa_pembayaran = $total_tagihan - $total_dana_masuk;
        }

        // Mengupdate sisa_pembayaran pada invoice
        DB::table('invoice')
            ->where('id', $request->invoice_id)
            ->update(['sisa_pembayaran' => $sisa_pembayaran]);

        return redirect('transaksi')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function cancel($id)
    {
        $transaksi = DB::table('transaksi')
            ->select('invoice.total_tagihan', 'transaksi.invoice_id', 'transaksi.total_dana_masuk', 'transaksi.status as transaksiStatus', 'invoice.status as invoiceStatus', 'invoice.id as invoiceId', 'transaksi.id as transaksiId')
            ->where('transaksi.id', $id)
            ->where('transaksi.status', '!=', 'DIBATALKAN')
            // ->groupBy('invoice.total_tagihan')
            ->join('invoice', 'transaksi.invoice_id', '=', 'invoice.id')
            // ->get();
            ->first();
        // dd($transaksi);

        if ($transaksi->transaksiStatus === 'DIBATALKAN') {
            return redirect()->back()->with('info', 'Transaksi sudah dibatalkan sebelumnya.');
        }

        // Ambil nomor invoice
        // $invoice = DB::table('invoice')->where('id', $transaksi->invoice_id)->first();


        $totalDanaMasuk = DB::table('transaksi')
            ->select(DB::raw('SUM(CAST(total_dana_masuk AS DECIMAL(12))) AS total_dana_masuk'), 'invoice.total_tagihan')
            ->where('transaksi.id', $transaksi->transaksiId)
            ->where('transaksi.status', '!=', 'DIBATALKAN')
            ->groupBy('transaksi.total_dana_masuk', 'invoice.total_tagihan')
            ->join('invoice', 'transaksi.invoice_id', '=', 'invoice.id')
            ->first();
        $invoice = DB::table('invoice')
            ->where('invoice.id', $transaksi->invoice_id)
            ->first();
        // dd($totalDanaMasuk->total_dana_masuk, $transaksi->total_tagihan, $invoice->sisa_pembayaran);
        $AR = $totalDanaMasuk->total_dana_masuk + $invoice->sisa_pembayaran;
        if ($AR == 0) {

            DB::table('invoice')
                ->where('invoice.id', $transaksi->invoice_id)
                ->update(['status' => 'TAGIHAN TELAH DILUNASI', 'tgl_lunas' => $transaksi->tgl_transfer]);
        } elseif ($AR == $transaksi->total_tagihan) {

            DB::table('invoice')
                ->where('invoice.id', $transaksi->invoice_id)
                ->update(['status' => 'MENUNGGU PEMBAYARAN', 'sisa_pembayaran' => $invoice->sisa_pembayaran + $transaksi->total_dana_masuk]);
        } elseif ($AR != $transaksi->total_tagihan) {

            DB::table('invoice')
                ->where('invoice.id', $transaksi->invoice_id)
                ->update(['status' => 'TAGIHAN MENUNGGU PELUNASAN', 'sisa_pembayaran' => $invoice->sisa_pembayaran + $transaksi->total_dana_masuk]);
        }



        // transaksi.update
        DB::table('transaksi')->where('id', $id)->update(['status' => 'DIBATALKAN']);

        return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan.');
    }



    public function destroy($id)
    {
        //
    }
}
