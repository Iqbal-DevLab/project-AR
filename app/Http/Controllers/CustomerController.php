<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::all();

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
