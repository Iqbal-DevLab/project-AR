<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\Transaksi;
use App\Models\Salestarget;
use App\Imports\ProyekImport;
use App\Imports\TransaksiImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index page supervisor
    // public function index()
    // {
    //     // $customer = Customer::select('nama_customer')
    //     //     ->groupBy('nama_customer')
    //     //     ->get();
    //     return view('page.index');
    // }

    public function proyek()
    {

        // $proyeks = DB::table('proyek')->select('proyek.*', 'sales.nama_sales')
        //     ->join('sales', 'sales.id', '=', 'proyek.sales_id')
        //     ->get();
        // // dd($proyeks);

        // $customer = Customer::select('nama_customer')
        //     ->groupBy('nama_customer')
        //     ->get();
        // $sales = Sales::select('nama_sales', 'id')->get();

        // return view('page.finance.proyek.index', compact('proyeks', 'customer', 'sales'));
    }

    public function proyekstore(Request $request)
    {
        // $harga = str_replace('.', '', $request->nilai_kontrak);
        // $convtahun = Carbon::parse($request->tgl_jatuh_tempo)->year;

        // DB::table('proyek')->insert([
        //     'nama_proyek' => $request->nama_proyek,
        //     'nama_customer' => $request->nama_customer,
        //     'nilai_kontrak' =>  $harga,
        //     'kode_proyek' => $request->kode_proyek,
        //     'tgl_jatuh_tempo' => $request->tgl_jatuh_tempo,
        //     'sales_id' => $request->sales_id,
        //     'term_of_payment' => $request->term_of_payment,
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        // ]);


        // $sales = Salestarget::select('target_tercapai')
        //     ->where('sales_id', $request->sales_id)
        //     ->first();

        // $target = $sales->target_tercapai ?? 0;
        // $updateTercapai = (int)$target + (int)$harga;


        // Salestarget::where('sales_id', $request->sales_id)->where('tahun', $convtahun)->update([
        //     'target_tercapai' => $updateTercapai

        // ]);

        // Alert::toast('Proyek Berhasil ditambahkan', 'success');
        // return redirect('proyek');
    }

    public function transaksi()
    {
        // $transaksi = DB::table('transaksi')->select('transaksi.*', 'proyek.nama_proyek')->join('proyek', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')->get();
        // $proyek = db::table('proyek')->get();


        // return view('page.finance.transaksi.index', compact('transaksi', 'proyek'));
    }

    public function transaksitore(Request $request)
    {
        // $dana = str_replace('.', '', $request->dana_masuk);
        // DB::table('transaksi')->insert([
        //     'kode_proyek' => $request->kode_proyek,
        //     'tgl_transfer' => $request->tgl_transfer,
        //     'no_giro' => $request->no_giro,
        //     'tgl_terima_giro' => $request->tgl_terima_giro,
        //     'tgl_giro_cair' => $request->tgl_giro_cair,
        //     'bank' => $request->bank,
        //     'dana_masuk' => $dana,
        //     'type' => $request->type,
        //     'status' => $request->status,
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        // ]);

        // Alert::toast('Transaksi Berhasil ditambahkan', 'success');

        // return redirect('finance/transaksi');
    }

    public function editTransaksi($id)
    {
        // // $transaksi = DB::table('transaksi')->where('id', $id)->first();
        // $transaksi = DB::table('transaksi')->find($id);
        // return view('finance.transaksi.edit', compact('transaksi'));
    }

    public function updateTransaksi(Request $request, $id)
    {
        $dana = str_replace('.', '', $request->dana_masuk);

        DB::table('transaksi')->where('id', $id)->update([

            'tgl_transfer' => $request->tgl_transfer,
            'tgl_giro_cair' => $request->tgl_giro_cair,
            'tgl_terima_giro' => $request->tgl_terima_giro,
            'bank' => $request->bank,
            'dana_masuk' => $dana,
            'no_giro' => $request->no_giro,
            'type' => $request->type,
            'status' => $request->status,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        Alert::toast('Transaksi Berhasil diupdate', 'success');

        return redirect('finance/transaksi');
    }

    public function uploadProyek(Request $request)
    {

        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $proyekFileName = rand() . $file->getClientOriginalName();

        // upload ke folder proyek di dalam folder public
        $file->move('proyek', $proyekFileName);

        // import data
        Excel::import(new ProyekImport, public_path('/proyek/' . $proyekFileName));
        // Excel::import(new ProyekImport, $request->file('file')->store('files'));
        Alert::toast('Berhasil upload proyek', 'success');

        return redirect('/finance/proyek');
    }

    public function uploadTransaksi(Request $request)
    {

        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $FileName = rand() . $file->getClientOriginalName();

        // upload ke folder proyek di dalam folder public
        $file->move('Transaksi', $FileName);

        // import data
        Excel::import(new TransaksiImport, public_path('/Transaksi/' . $FileName));
        // Excel::import(new ProyekImport, $request->file('file')->store('files'));
        Alert::toast('Berhasil upload Transaksi', 'success');

        return redirect('/finance/transaksi');
    }
    public function customer(Request $request)
    {
        // $customer = Customer::all();
        // // $customer = Customer::select('nama_customer')
        // //     ->groupBy('nama_customer')
        // //     ->get();

        // // $grade = DB::table('proyek')
        // //     ->select('proyek.*', 'transaksi.tgl_giro_cair', 'transaksi.status', 'transaksi.tgl_transfer')
        // //     ->leftJoin('transaksi', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
        // //     ->join('customer', 'customer.nama_customer', '=', 'proyek.nama_customer')
        // //     ->groupBy('proyek.nama_customer')
        // //     ->get();
        // // dd($grade);


        // // $proyek = DB::table('proyek')
        // //     ->select('proyek.*', 'transaksi.tgl_giro_cair', 'transaksi.status', 'transaksi.tgl_transfer',)
        // //     ->leftJoin('transaksi', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
        // //     ->join('customer', 'customer.nama_customer', '=', 'proyek.nama_customer')
        // //     // ->groupBy('customer.nama_customer')  
        // //     ->where('proyek.id', 1)
        // //     ->first();
        // // // dd($proyek);

        // // $tgl_jatuh_tempo = Carbon::parse($proyek->tgl_jatuh_tempo)->strtotime();
        // // $tgl_transfer = Carbon::parse($proyek->tgl_transfer);

        // // dd($tgl_jatuh_tempo);

        // // if ($tgl_jatuh_tempo->lessThan($tgl_transfer)) {
        // //     $telat_hari = $tgl_jatuh_tempo->diffInDays($tgl_transfer, false);
        // // } else {
        // //     $telat_hari = 0;
        // // }
        // // $hari = '';
        // // if ($telat_hari > 0) {
        // //     $hari = $telat_hari;
        // // }

        // // dd($hari);
        // // $grade = DB::table('proyek')
        // //     ->select('proyek.nama_customer', DB::raw('SUM(DATEDIFF(transaksi.tgl_transfer, tgl_jatuh_tempo)) as days_since_last_post'))
        // //     ->join('transaksi', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
        // //     ->groupBy('proyek.nama_customer')
        // //     ->get();
        // // dd($grade);

        // return view('page.customer.index', compact('customer'));
    }
    function addcustomer(Request $request)
    {
        // // dd($request->except(['_token','submit']));
        // DB::table('customer')->insert([
        //     'nama_customer' => $request->nama_customer,
        //     'nama_contact' => $request->nama_contact,
        // ]);
        // Alert::toast('Berhasil menambahkan Customer', 'success');
        // return redirect('/customer');
    }
    public function monitoring(Request $request)
    {
        $monitoring = Customer::all();
        $customer = Customer::select('nama_customer')
            ->groupBy('nama_customer')
            ->get();

        $get = DB::table('proyek')->select('proyek.nama_proyek', 'proyek.*');
        if ($request->nama_customer) {
            $gettable = $get->where('proyek.nama_customer', $request->nama_customer)
                ->get();
        }
        $gettable = $get->get();


        return view('page.finance.monitoring.index', compact('monitoring', 'customer', 'gettable'));
    }

    public function detailmonitoring(Request $request)
    {
        $id = request('id');
        $kode = request('kode_proyek');
        $proyek = DB::table('proyek')
            ->select('proyek.*', 'transaksi.dana_masuk', 'transaksi.tgl_giro_cair', 'transaksi.status', 'transaksi.tgl_transfer', 'sales.nama_sales')
            ->leftJoin('transaksi', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
            ->join('sales', 'sales.id', '=', 'proyek.sales_id')
            ->where('proyek.id', $id)->first();

        $riwayatTransaksi = DB::table('transaksi')
            ->select('transaksi.dana_masuk', 'transaksi.tgl_giro_cair', 'transaksi.status', 'transaksi.tgl_transfer', 'proyek.tgl_jatuh_tempo')
            ->join('proyek', 'transaksi.kode_proyek', '=', 'proyek.kode_proyek')
            ->where('transaksi.kode_proyek', $kode)
            ->orderBy('transaksi.kode_proyek')
            ->get();


        return view('page.finance.monitoring.detail', compact('proyek', 'riwayatTransaksi'));
    }

    public function sales()
    {
        $sales = Sales::all();

        return view('page.sales.index', compact('sales'));
    }
    function addsales(Request $request)
    {
        // dd($request->except(['_token','submit']));

        DB::table('sales')->insert([
            'nama_sales' => $request->nama_sales,
            'contact_sales' => $request->contact_sales,
            'type' => $request->type,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);



        Alert::toast('Berhasil menambahkan Sales', 'success');
        return redirect('/sales');
    }

    public function salestarget(Request $request)
    {

        $salesname = Sales::all();
        $salestarget = Salestarget::all();


        // $salestarget = '';
        $sales = Sales::select('nama_sales')
            ->groupBy('nama_sales')
            ->get();
        $salest = Salestarget::select('tahun')
            ->groupBy('tahun')
            ->get();
        // dd($salestarget);


        $sales = '';
        $proyek = '';
        if ($request->sales_id) {
            $sales = DB::table('sales_target')->select('target', 'target_tercapai', 'tahun', 'sales_id', 'sales.nama_sales')
                ->leftJoin('sales', 'sales.id', '=', 'sales_target.sales_id')
                ->where('sales_id', $request->sales_id)->where('tahun', $request->tahun)
                ->get();
            // dd($request->tahun);    

            $proyek = DB::table('proyek')->where('sales_id', $request->sales_id)
                ->select(DB::raw('MONTH(tgl_jatuh_tempo) AS bulan'), DB::raw('SUM(nilai_kontrak) AS total'))
                ->groupBy(DB::raw('MONTH(tgl_jatuh_tempo)'))
                ->get();
        }

        return view('page.salestarget.index', compact('salesname', 'sales', 'proyek', 'salest'));
    }

    public function addsalestarget(Request $request)
    {
        $targets = str_replace(['.'], '', $request->target);

        DB::table('sales_target')->insert([
            'sales_id' => $request->sales_id,
            'target' => $targets,
            'tahun' => $request->tahun,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);



        Alert::toast('Berhasil menambahkan Target Sales', 'success');
        return redirect('/sales');
    }
}
