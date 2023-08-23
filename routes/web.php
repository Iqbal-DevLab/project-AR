<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesTargetController;
use App\Http\Controllers\PaymentTermsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SalesVolumeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role_id == 1) {
            return redirect('/monitoring');
        } elseif (Auth::user()->role_id == 2) {
            return redirect('/sales');
        } elseif (Auth::user()->role_id == 3) {
            return redirect('/produksi');
        } elseif (Auth::user()->role_id == 4) {
            return redirect('/logistik');
        }
    } else {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/authlogin', 'authlogin')->name('authlogin');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group(['middleware' => ['finance']], function () {

    //route index
    // Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');

    //route proyek
    Route::get('proyek', [ProyekController::class, 'index'])->name('proyek.index');
    Route::get('proyek/create', [ProyekController::class, 'create'])->name('proyek.create');
    Route::post('proyek', [ProyekController::class, 'store'])->name('proyek.store');
    Route::put('proyek/{id}/update', [ProyekController::class, 'update'])->name('proyek.update');
    Route::post('proyek/upload', [ProyekController::class, 'upload.proyek'])->name('finance-proyek-upload');

    //route transaksi
    Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('transaksi/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('transaksi/{id}/update', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::get('/transaksi/{id}/cancel', [TransaksiController::class, 'cancel'])->name('transaksi.cancel');
    Route::post('transaksi/upload', [TransaksiController::class, 'uploadTransaksi'])->name('finance-transaksi-upload');

    //route monitoring
    Route::get('monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('monitoring/detail/', [MonitoringController::class, 'show'])->name('monitoring.detail');

    //route customer
    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('customer', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('customer/{id}', [CustomerController::class, 'update'])->name('customer.update');

    //route sales
    Route::get('sales', [SalesController::class, 'index'])->name('sales.index');
    Route::post('sales', [SalesController::class, 'store'])->name('sales.store');
    Route::get('sales/{id}/edit', [SalesControlelr::class, 'edit'])->name('sales.edit');
    Route::put('sales/{id}', [SalesController::class, 'update'])->name('sales.update');

    //route sales target
    Route::get('sales-target', [SalesTargetController::class, 'index'])->name('sales-target.index');
    Route::post('sales-target', [SalesTargetController::class, 'store'])->name('sales-target.store');

    //route sales volume
    Route::get('sales-volume', [SalesVolumeController::class, 'index'])->name('sales-volume.index');
    Route::post('sales-volume', [SalesVolumeController::class, 'store'])->name('sales-volume.store');

    //route payment terms
    Route::get('payment-terms', [PaymentTermsController::class, 'index'])->name('payment-terms.index');
    Route::post('payment-terms', [PaymentTermsController::class, 'store'])->name('payment-terms.store');
    Route::delete('/payment-terms/{id}', [PaymentTermsController::class, 'destroy'])->name('payment-terms.destroy');

    //route invoice
    Route::get('invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('invoice', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::put('invoice/{id}/update', [InvoiceController::class, 'update'])->name('invoice.update');
    Route::get('/invoice/{id}/cancel', [InvoiceController::class, 'cancel'])->name('invoice.cancel');

    //export pdf
    Route::get('/sales-volume-pdf', [PDFController::class, 'salesVolumePDF'])->name('sales-volume.pdf');
    Route::get('/invoice-pdf', [PDFController::class, 'invoicePDF'])->name('invoice.pdf');
    Route::get('/ar-monitoring-pdf', [PDFController::class, 'monitoringPDF'])->name('AR-Monitoring.pdf');
});
