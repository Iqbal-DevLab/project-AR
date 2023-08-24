<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesTarget;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesTargetController extends Controller
{
    public function index(Request $request)
    {
        $salesname = Sales::all();
        $salestarget = SalesTarget::all();


        // $salestarget = '';
        $sales = Sales::select('nama_sales')
            ->groupBy('nama_sales')
            ->get();
        $salest = SalesTarget::select('tahun')
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

        $salesTarget = DB::table('sales')
            ->select([
                'sales.nama_sales',
                'sales_target.target',
                'sales.type',
                DB::raw('MONTH(CONVERT(DATE, invoice.tgl_invoice, 103)) as bulan'),
                DB::raw('YEAR(CONVERT(DATE, invoice.tgl_invoice, 103)) as tahun'),
                DB::raw('SUM(CONVERT(DECIMAL(18), invoice.nilai_tagihan)) as total_nilai_tagihan'),
                DB::raw('SUM(CONVERT(DECIMAL(18), invoice.koreksi_dp)) as total_koreksi_dp'),
            ])
            ->leftJoin('proyek', 'proyek.sales_id', '=', 'sales.id')
            ->leftJoin('invoice', 'invoice.kode_proyek', '=', 'proyek.kode_proyek')
            ->leftJoin('sales_target', 'sales.id', '=', 'sales_target.sales_id')
            ->leftJoin('payment_terms', 'proyek.payment_terms_id', '=', 'payment_terms.id')
            ->where(function ($query) {
                $query->where('invoice.status', '!=', 'Dibatalkan')
                    ->where('invoice.progress', 'NOT LIKE', '%DP%')
                    ->orWhereNull('invoice.kode_proyek');
            })
            ->groupBy([
                'sales.nama_sales',
                'sales_target.target',
                'sales.type',
                DB::raw('MONTH(CONVERT(DATE, invoice.tgl_invoice, 103))'),
                DB::raw('YEAR(CONVERT(DATE, invoice.tgl_invoice, 103))'),
            ])
            ->orderBy('sales.nama_sales', 'asc')
            ->get();

        $dataTarget = [];
        foreach ($salesTarget as $data) {
            $namaSales = $data->nama_sales;
            $bulanInvoice = "bulan_" . $data->bulan;

            // Mengecek apakah data sudah ada dalam grup
            if (!isset($dataTarget[$namaSales])) {
                $dataTarget[$namaSales] = [
                    'nama_sales' => $namaSales,
                    'target' => floatval($data->target),
                    'type' => $data->type,
                    'tahun' =>  intval($data->tahun),
                    'total_sales_volume' => 0.0, // Initialize total_sales_volume to 0.0
                ];
            }

            // Mengubah tipe data string menjadi float untuk nilai sales_volume dan koreksi_dp
            $salesVolume = floatval($data->total_nilai_tagihan) + floatval($data->total_koreksi_dp);

            // Menambahkan data sales_volume ke dalam grup
            $dataTarget[$namaSales][$bulanInvoice] = $salesVolume;

            // Menambahkan data sales_volume ke total_sales_volume
            $dataTarget[$namaSales]['total_sales_volume'] += $salesVolume;
        }

        return view('page.salestarget.index', compact('salesTarget', 'dataTarget'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $targets = str_replace(['.'], '', $request->target);

        DB::table('sales_target')->insert([
            'sales_id' => $request->sales_id,
            'target' => $targets,
            'tahun' => $request->tahun,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        return redirect('/sales')->with('success', 'Berhasil menambahkan target sales!');;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
