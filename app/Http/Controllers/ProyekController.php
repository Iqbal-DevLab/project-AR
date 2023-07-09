<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\Salestarget;
use App\Models\PaymentTerms;

class ProyekController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $proyek = DB::table('proyek')
            ->select('proyek.*', 'sales.nama_sales', 'payment_terms.id as payment_terms_id')
            ->join('sales', 'sales.id', '=', 'proyek.sales_id')
            ->join('payment_terms', 'payment_terms.id', '=', 'proyek.payment_terms_id')
            ->get();

        $customer = Customer::select('nama_customer', 'id')->get();
        $sales = Sales::select('nama_sales', 'id')->get();

        $payment_terms = PaymentTerms::all();

        return view('page.proyek.index', compact('proyek', 'customer', 'sales', 'payment_terms'));
    }

    public function create(Request $request)
    {
        $proyek = DB::table('proyek')
            ->select('proyek.*', 'sales.nama_sales', 'payment_terms.id as payment_terms_id')
            ->join('sales', 'sales.id', '=', 'proyek.sales_id')
            ->join('payment_terms', 'payment_terms.id', '=', 'proyek.payment_terms_id')
            ->get();

        $customer = Customer::select('nama_customer', 'id')->get();
        $sales = Sales::select('nama_sales', 'id')->get();

        $payment_terms = PaymentTerms::all();

        return view('page.proyek.create', compact('proyek', 'customer', 'sales', 'payment_terms'));
    }

    public function store(Request $request)
    {

        $rules = [
            'nama_proyek' => 'required|max:255|unique:proyek',
            'kode_proyek' => 'required|unique:proyek',
            'nilai_kontrak' => 'required',
            'no_po' => 'required',
            'status_po' => 'required',
            'nama_customer' => 'required',
            'kategori_proyek' => 'required',
            'nama_sales' => 'required',
            'payment_terms' => 'required',
        ];

        if ($request->kategori_proyek == 'BUMN') {
            $rules += [
                'tgl_awal' => 'required',
                'tgl_akhir' => 'required',
            ];
        }

        $request->validate($rules, [
            'nama_proyek.required' => 'Nama proyek tidak boleh kosong!',
            'nama_proyek.max' => 'Nama proyek terlalu panjang!',
            'nama_proyek.unique' => 'Nama proyek sudah ada!',
            'kode_proyek.required' => 'Kode proyek tidak boleh kosong!',
            'kode_proyek.unique' => 'Kode proyek sudah ada!',
            'nilai_kontrak.required' => 'Harga kontrak tidak boleh kosong!',
            'no_po.required' => 'No. PO tidak boleh kosong!',
            'status_po.required' => 'Status PO tidak boleh kosong!',
            'nama_customer.required' => 'Nama pemesan tidak boleh kosong!',
            'kategori_proyek.required' => 'Kategori proyek tidak boleh kosong!',
            'tgl_awal.required' => 'Tanggal awal pelaksanaan tidak boleh kosong!',
            'tgl_akhir.required' => 'Tanggal akhir pelaksanaan tidak boleh kosong!',
            'nama_sales.required' => 'Nama sales tidak boleh kosong!',
            'payment_terms.required' => 'Payment terms tidak boleh kosong!',
        ]);

        $harga = str_replace('.', '', $request->nilai_kontrak);
        $convtahun = Carbon::parse($request->tgl_jatuh_tempo)->year;

        DB::table('proyek')->insert([
            'nama_proyek' => $request->nama_proyek,
            'kode_proyek' => $request->kode_proyek,
            'nilai_kontrak' =>  $harga,
            'no_po' => $request->no_po,
            'status_po' => $request->status_po,
            'nama_customer' => $request->nama_customer,
            'customer_id' => $request->customer_id,
            'sales_id' => $request->sales_id,
            'kategori_proyek' => $request->kategori_proyek,
            'payment_terms_id' => $request->payment_terms_id,
            'keterangan' => $request->keterangan,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $sales = Salestarget::select('target_tercapai')
            ->where('sales_id', $request->sales_id)
            ->first();

        $target = $sales->target_tercapai ?? 0;
        $updateTercapai = (int)$target + (int)$harga;

        Salestarget::where('sales_id', $request->sales_id)->where('tahun', $convtahun)->update([
            'target_tercapai' => $updateTercapai
        ]);

        return redirect('proyek')->with('success', 'Proyek baru berhasil ditambahkan!');;
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        DB::table('proyek')
            ->where('id', $id)
            ->update([
                'status_po' => $request->status_po,
                'keterangan' => $request->keterangan,
            ]);

        // Lakukan sesuatu setelah berhasil memperbarui data

        return redirect('/proyek')->with('success', 'Status PO berhasil diperbaui!');
    }
}
