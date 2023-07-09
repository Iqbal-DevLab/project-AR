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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice')->unique();
            $table->string('no_invoice_before')->nullable();
            $table->string('kode_proyek')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('no_faktur_pajak');
            $table->string('tgl_invoice');
            $table->string('tgl_ttk')->nullable();
            $table->string('batas_jatuh_tempo')->nullable();
            $table->string('tgl_jatuh_tempo')->nullable();
            $table->string('progress');
            $table->string('tagihan');
            $table->string('nilai_tagihan');
            $table->string('koreksi_dp')->nullable();
            $table->string('ppn_nominal');
            $table->string('pph')->nullable();
            $table->string('pph_nominal')->nullable();
            $table->string('lain_lain')->nullable();
            $table->string('total_tagihan');
            $table->string('sisa_pembayaran')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('status');
            $table->string('tgl_lunas')->nullable();
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
        Schema::dropIfExists('invoice');
    }
};
