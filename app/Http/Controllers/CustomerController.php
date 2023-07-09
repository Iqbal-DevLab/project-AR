<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $customer = Customer::all();
        // $customer = Customer::select('nama_customer')
        //     ->groupBy('nama_customer')
        //     ->get();

        // $grade = DB::table('proyek')
        //     ->select('proyek.*', 'transaksi.tgl_giro_cair', 'transaksi.status', 'transaksi.tgl_transfer')
        //     ->leftJoin('transaksi', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
        //     ->join('customer', 'customer.nama_customer', '=', 'proyek.nama_customer')
        //     ->groupBy('proyek.nama_customer')
        //     ->get();
        // dd($grade);


        // $proyek = DB::table('proyek')
        //     ->select('proyek.*', 'transaksi.tgl_giro_cair', 'transaksi.status', 'transaksi.tgl_transfer',)
        //     ->leftJoin('transaksi', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
        //     ->join('customer', 'customer.nama_customer', '=', 'proyek.nama_customer')
        //     // ->groupBy('customer.nama_customer')  
        //     ->where('proyek.id', 1)
        //     ->first();
        // // dd($proyek);

        // $tgl_jatuh_tempo = Carbon::parse($proyek->tgl_jatuh_tempo)->strtotime();
        // $tgl_transfer = Carbon::parse($proyek->tgl_transfer);

        // dd($tgl_jatuh_tempo);

        // if ($tgl_jatuh_tempo->lessThan($tgl_transfer)) {
        //     $telat_hari = $tgl_jatuh_tempo->diffInDays($tgl_transfer, false);
        // } else {
        //     $telat_hari = 0;
        // }
        // $hari = '';
        // if ($telat_hari > 0) {
        //     $hari = $telat_hari;
        // }

        // dd($hari);
        // $grade = DB::table('proyek')
        //     ->select('proyek.nama_customer', DB::raw('SUM(DATEDIFF(transaksi.tgl_transfer, tgl_jatuh_tempo)) as days_since_last_post'))
        //     ->join('transaksi', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
        //     ->groupBy('proyek.nama_customer')
        //     ->get();
        // dd($grade);

        return view('page.customer.index', compact('customer'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|unique:customer',
            'nama_contact' => 'required',
        ], [
            'nama_customer.required' => 'Nama customer tidak boleh kosong!',
            'nama_customer.unique' => 'Nama customer sudah ada!',
            'nama_contact.required' => 'Nama contact tidak boleh kosong!',
        ]);

        DB::table('customer')->insert([
            'nama_customer' => $request->nama_customer,
            'nama_contact' => $request->nama_contact,
        ]);

        return redirect('/customer')->with('success', 'Customer berhasil ditambahkan!');;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $customer = DB::table('customer')->where('id', $id)->first();

        return view('page.customer.index', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_customer' => 'required|unique:customer,nama_customer,' . $id,
            'nama_contact' => 'required',
        ], [
            'nama_customer.required' => 'Nama customer tidak boleh kosong!',
            'nama_customer.unique' => 'Nama customer sudah ada!',
            'nama_contact.required' => 'Nama contact tidak boleh kosong!',
        ]);

        DB::table('customer')->where('id', $id)->update([
            'nama_customer' => $request->nama_customer,
            'nama_contact' => $request->nama_contact,
        ]);

        return redirect()->route('customer.index')->with('success', 'Data customer berhasil diperbarui!');
    }

    public function destroy($id)
    {
        //
    }
}
