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
        Schema::create('proyek', function (Blueprint $table) {
            $table->id();
            $table->string('nama_proyek')->unique();
            $table->string('kode_proyek');
            $table->string('nilai_kontrak');
            $table->string('status_po');
            $table->string('kategori_proyek');
            $table->string('no_po')->nullable();
            $table->string('tgl_awal')->nullable();
            $table->string('tgl_akhir')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('nama_customer');
            $table->string('sales_id');
            $table->string('payment_terms_id');
            $table->string('keterangan')->nullable();
            $table->string('nilai_kontrak_rev1')->nullable();
            $table->string('nilai_kontrak_rev2')->nullable();
            $table->string('nilai_kontrak_rev3')->nullable();
            $table->string('nilai_kontrak_rev4')->nullable();
            $table->string('nilai_kontrak_rev5')->nullable();
            $table->string('nilai_kontrak_rev6')->nullable();
            $table->string('nilai_kontrak_rev7')->nullable();
            $table->string('nilai_kontrak_rev8')->nullable();
            $table->string('nilai_kontrak_rev9')->nullable();
            $table->string('nilai_kontrak_rev10')->nullable();
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
        Schema::dropIfExists('proyek');
    }
};
