<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_proyek');
            $table->string('customer_id')->nullable();
            $table->string('invoice_id');
            $table->string('progress');
            $table->string('bank');
            $table->string('tgl_transfer')->nullable();
            $table->string('dana_masuk')->nullable();
            $table->string('total_dana_masuk')->nullable();
            $table->string('sisa_pembayaran')->nullable();
            $table->string('bank_charge')->nullable();
            $table->string('no_giro')->nullable();
            $table->string('nilai_giro')->nullable();
            $table->string('tgl_terima_giro')->nullable();
            $table->string('tgl_giro_cair')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
