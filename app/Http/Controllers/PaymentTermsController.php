<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentTerms;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class PaymentTermsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $payment_terms = PaymentTerms::all();
        return view('page.payment_terms.index', compact('payment_terms'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $dp = $request->DP ? $request->DP . '%' : null;
        $approval = $request->APPROVAL ? $request->APPROVAL . '%' : null;
        $bmos = $request->BMOS ? $request->BMOS . '%' : null;
        $amos = $request->AMOS ? $request->AMOS . '%' : null;
        $testcomm = $request->TESTCOMM ? $request->TESTCOMM . '%' : null;
        $retensi = $request->RETENSI ? $request->RETENSI . '%' : null;

        $existingEntry = DB::table('payment_terms')
            ->where('DP', $dp)
            ->where('APPROVAL', $approval)
            ->where('BMOS', $bmos)
            ->where('AMOS', $amos)
            ->where('TESTCOMM', $testcomm)
            ->where('RETENSI', $retensi)
            ->first();
        if ($existingEntry) {
            return redirect('/payment-terms')->with('warning', 'TOP dengan nilai yang sama sudah ada di database!');
        }
        DB::table('payment_terms')->insert([
            'DP' => $dp,
            'APPROVAL' => $approval,
            'BMOS' => $bmos,
            'AMOS' => $amos,
            'TESTCOMM' => $testcomm,
            'RETENSI' => $retensi,
        ]);

        return redirect('/payment-terms')->with('success', 'TOP berhasil dibuat!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $payment_terms = PaymentTerms::find($id);
        return view('payment_terms.edit', compact('payment_terms'));
    }

    public function update(Request $request, $id)
    {
        DB::table('payment_terms')
            ->where('id', $id)
            ->update([
                'DP' => $request->DP,
                'APPROVAL' => $request->APPROVAL,
                'BMOS' => $request->BMOS,
                'AMOS' => $request->AMOS,
                'TESTCOMM' => $request->TESTCOMM,
                'RETENSI' => $request->RETENSI,
            ]);
        return redirect()->route('payment_terms.index');
    }

    public function destroy($id)
    {
        DB::table('payment_terms')->where('id', $id)->delete();
        return redirect()->route('payment_terms.index');
    }
}
