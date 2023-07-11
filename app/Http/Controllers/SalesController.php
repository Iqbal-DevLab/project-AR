<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Sales;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $sales = DB::table('sales')
            ->select('sales.id', 'sales_target.sales_id', 'sales.nama_sales', 'sales.contact_sales', 'sales.type', 'sales_target.target', 'sales_target.tahun')
            ->leftjoin('sales_target', 'sales_target.sales_id', '=', 'sales.id')
            ->get();

        return view('page.sales.index', compact('sales'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sales' => 'required|unique:sales',
            'type' => 'required',
        ], [
            'nama_sales.required' => 'Nama sales tidak boleh kosong!',
            'nama_sales.unique' => 'Nama sales sudah ada!',
            'type.required' => 'Tipe sales tidak boleh kosong!',
        ]);

        DB::table('sales')->insert([
            'nama_sales' => $request->nama_sales,
            'contact_sales' => $request->contact_sales,
            'type' => $request->type,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // $targets = str_replace([','], '', $request->target);

        // DB::table('sales_target')->insert([
        //     'sales_id' => $request->sales_id,
        //     'target' => $targets,
        //     'tahun' => $request->tahun,
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        // ]);

        return redirect('/sales')->with('success', 'Berhasil menambahkan Sales!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $sales = DB::table('sales')->where('id', $id)->first();

        return view('page.sales.index', compact('sales'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
        ], [
            'nama_sales.required' => 'Nama sales tidak boleh kosong!',
            'type.required' => 'Tipe sales tidak boleh kosong!',
        ]);

        DB::table('sales')->where('sales.id', $id)->update([
            'nama_sales' => $request->nama_sales,
            'contact_sales' => $request->contact_sales,
            'type' => $request->type,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ]);
        return redirect('/sales')->with('success', 'Berhasil Perbarui Sales!');;
    }

    public function destroy($id)
    {
        //
    }
}
