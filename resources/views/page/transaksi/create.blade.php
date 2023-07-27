@extends('layouts.dashboard')
@section('content')
    <div class="content">
        {{-- <h2 class="content-heading">Halaman Transaksi</h2> --}}
        <div class="block shadow bg-white">
            <div class="block-header block-header-default">
                <h3 class="block-title text-center">Form Pembayaran</h3>
                <div class="block-options">
                </div>
            </div>
            <div class="block-content">
                <div class="row justify-content-center py-20">
                    <div class="col-xl-10">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action={{ route('transaksi.store') }} method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="no_invoice" class="col-form-label fs-6">NO. INVOICE</label>
                                <div class="input-group">
                                    <input class="form-control" list="no" id="no_invoice_i" name="no_invoice"
                                        autocomplete="off" placeholder="Ketik untuk mencari NO. INVOICE ...">
                                    <div class="input-group-append">
                                        <button class="btn btn-alt-primary rounded fw-bold" title="Cari Invoice"
                                            type="button" id="cari_data_i"><i class="fa-solid fa-magnifying-glass"></i>
                                            Cari
                                        </button>
                                        <button class="btn btn-alt-primary" type="button" disabled id="loading">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span> Cari
                                        </button>
                                    </div>
                                </div>
                                <datalist id="no">
                                    @forelse ($proyek as $p)
                                        <option value="{{ $p->no_invoice }}" data-kode-proyek="{{ $p->kode_proyek }}"
                                            data-progress="{{ $p->progress }}" data-tagihan="{{ $p->tagihan }}"
                                            data-invoice-id="{{ $p->id }}" data-customer-id="{{ $p->customer_id }}"
                                            data-ppn-nominal="{{ $p->ppn_nominal }}" data-pph="{{ $p->pph }}"
                                            data-pph-nominal="{{ $p->pph_nominal }}" data-lain-lain="{{ $p->lain_lain }}"
                                            data-total-tagihan="{{ $p->total_tagihan }}"
                                            data-nilai-tagihan="{{ $p->nilai_tagihan }}"
                                            data-koreksi-dp="{{ $p->koreksi_dp }}" data-tgl-ttk="{{ $p->tgl_ttk }}"
                                            data-tgl-jatuh-tempo="{{ $p->tgl_jatuh_tempo }}"
                                            data-batas-jatuh-tempo="{{ $p->batas_jatuh_tempo }}"
                                            data-ar="{{ $p->ar }}">
                                            {{ $p->nama_proyek }}</option>
                                    @empty
                                        <span>Data kosong</span>
                                    @endforelse
                                </datalist>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nama_proyek" class="col-form-label fs-6">NAMA
                                        PROYEK</label>
                                    <input class="form-control" name="nama_proyek" readonly id="nama_proyek_i"
                                        placeholder="Nama proyek akan muncul disini ...">
                                </div>
                                <div class="col mb-3" hidden>
                                    <label for="invoice_id" class="col-form-label fs-6">
                                        INVOICE ID</label>
                                    <input class="form-control" readonly id="invoice_id_i" name="invoice_id"
                                        placeholder="invoice ID">
                                </div>
                                <div class="col mb-3" hidden>
                                    <label for="customer_id" class="col-form-label fs-6">
                                        CUSTOMER ID</label>
                                    <input class="form-control" readonly id="customer_id_i" name="customer_id"
                                        placeholder="Customer ID">
                                </div>
                                <div class="col mb-3">
                                    <label for="kode_proyek" class="col-form-label fs-6">KODE
                                        PROYEK</label>
                                    <input type="text" class="form-control" name="kode_proyek" id="kode_proyek_i"
                                        readonly placeholder="Kode proyek akan muncul disini ...">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="dana_masuk" class="col-form-label fs-6">PROGRESS PEMBAYARAN</label>
                                <input type="text" placeholder="--Pilih Progress Pembayaran--" readonly
                                    class="form-control" id="progress_i" name="progress">
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="tgl_ttk" class="col-form-label fs-6">TANGGAL
                                        TTK</label>
                                    <div class="input-group date align-items-center">
                                        <input type="text" disabled class="js-datepicker form-control" id="tgl_ttk_i"
                                            name="tgl_ttk" autocomplete="off" data-week-start="1" data-autoclose="true"
                                            data-today-highlight="true" data-date-format="dd-mm-yyyy"
                                            placeholder="dd-MM-yyyy">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary fw-bold" type="button"><i
                                                    class="fa fa-calendar"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col mb-3">
                                    <label for="tgl_jatuh_tempo" class="col-form-label fs-6">TANGGAL
                                        JATUH TEMPO</label>
                                    <div class="input-group date align-items-center">
                                        <input type="text" disabled class="js-datepicker form-control"
                                            id="tgl_jatuh_tempo_i" name="tgl_jatuh_tempo" autocomplete="off"
                                            data-week-start="1" data-autoclose="true" data-today-highlight="true"
                                            data-date-format="dd-mm-yyyy" placeholder="dd-MM-yyyy">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary fw-bold" type="button"><i
                                                    class="fa fa-calendar"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border text-center">
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <div class="mt-2 px-2 mx-2">
                                            <label>
                                                Jatuh Tempo</label>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <input type="text" readonly placeholder="0"
                                            class="form-control-plaintext col-md-2" id="batas_jatuh_tempo_i">
                                        <div class="input-group-append w-25 d-flex align-items-center">
                                            <span class="input-group-plaintext">Hari</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <div class="mt-2 px-2 mx-2">
                                            <label>
                                                Sub Total</label>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0"
                                            class="form-control-plaintext col-md-5" id="tagihan_i">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <div class="mt-2 px-2 mx-2">
                                            <label>
                                                Koreksi DP</label>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly name="koreksi_dp"
                                            class="form-control-plaintext col-md-5" id="koreksi_dp_i" placeholder=0>
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <div class="mt-2 px-2 mx-2">
                                            <label>
                                                Nilai Tagihan</label>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0"
                                            class="form-control-plaintext col-md-5" id="nilai_tagihan_i"
                                            name="nilai_tagihan">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <div class="mt-2 px-2 mx-2">
                                            <label>
                                                PPN 11%</label>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0"
                                            class="form-control-plaintext col-md-5" id="ppn_nominal_i"
                                            name="ppn_nominal">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <label for="pph" class="fs-6"></label>
                                        <select class="custom-select" disabled name="pph" id="pph_i">
                                            <option selected hidden value="0">--Pilih PPh--</option>
                                            <option value="0">Tidak ada</option>
                                            <option value="1,5%">PPh 1,5%</option>
                                            <option value="2%">PPh 2%</option>
                                        </select>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0"
                                            class="form-control-plaintext col-md-5" name="pph_nominal"
                                            id="pph_nominal_i">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <div class="mt-2 px-2 mx-2">
                                            <label>
                                                Lain-lain</label>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly name="lain_lain"
                                            class="form-control-plaintext col-md-5" id="biayalain_i" placeholder=0>
                                    </div>
                                </div>
                            </div>
                            <div class="border text-center mb-3">
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <label for="total_tagihan" class="col-form-label col-md-9 fs-6">Total Pembayaran +
                                            PPN(11%)</label>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0" class="form-control col-md-5"
                                            id="total_nominal_i" name="total_tagihan">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <label for="ar" class="col-form-label col-md-9 fs-6">Sisa
                                            Pembayaran</label>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0" class="form-control col-md-5"
                                            id="ar_i" name="ar">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <label for="total_dana_masuk" class="col-form-label col-md-9 fs-6">Total Dana
                                            Masuk</label>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0" class="form-control col-md-5"
                                            id="total_dana_masuk_i" name="total_dana_masuk">
                                    </div>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" type="checkbox" id="switch" name="switch">
                                <label class="custom-control-label fs-6" for="switch">PEMBAYARAN
                                    DENGAN GIRO</label>
                            </div>
                            <div class="mb-3">
                                <label for="nama_bank" class="col-form-label fs-6">NAMA
                                    BANK</label>
                                <select class="form-control" id="bank" name="bank">
                                    <option value="" hidden>--Pilih Nama Bank--</option>
                                    <option value="BANK BRI">BANK BRI</option>
                                    <option value="BANK BCA">BANK BCA</option>
                                    <option value="BANK MANDIRI">BANK MANDIRI</option>
                                    <option value="BANK BNI">BANK BNI</option>
                                    <option value="BANK OCBC NISP">BANK OCBC NISP</option>
                                </select>
                            </div>
                            <div id="nonGiro">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="tgl_transfer" class="col-form-label fs-6">TANGGAL TRANSFER</label>
                                        <div class="input-group date align-items-center">
                                            <input type="text" class="js-datepicker form-control" id="tgl_transfer"
                                                name="tgl_transfer" autocomplete="off" data-week-start="1"
                                                data-autoclose="true" data-today-highlight="true"
                                                data-date-format="dd-mm-yyyy" placeholder="dd-MM-yyyy">
                                            <div class="input-group-append">
                                                <span class="input-group-text align-self-center" style="cursor:pointer"><i
                                                        class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="dana_masuk" class="col-form-label fs-6">DANA MASUK
                                            (Rp)</label>
                                        <input type="text" class="form-control"
                                            placeholder="Masukkan Nominal Dana Masuk" id="dana_masuk" name="dana_masuk">
                                    </div>
                                    <div class="col mb-3">
                                        <label for="bank_charge" class="col-form-label fs-6">BANK CHARGE
                                            (Rp)</label>
                                        <input type="text" class="form-control"
                                            placeholder="Masukkan Biaya Admin Bank" id="bank_charge" name="bank_charge">
                                    </div>
                                </div>
                            </div>
                            <div id="giro" hidden>
                                <div class="mb-3">
                                    <label for="no_giro" class="col-form-label fs-6">NO.
                                        GIRO</label>
                                    <input type="text" autocomplete="off" class="form-control" id="no_giro"
                                        name="no_giro" placeholder="Masukkan NO. GIRO">
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="tgl_terima_giro" class="col-form-label fs-6">TANGGAL
                                            TERIMA
                                            GIRO</label>
                                        <div class="input-group date align-items-center">
                                            <input type="text" class="js-datepicker form-control" id="tgl_terima_giro"
                                                name="tgl_terima_giro" autocomplete="off" data-week-start="1"
                                                data-autoclose="true" data-today-highlight="true"
                                                data-date-format="dd-mm-yyyy" placeholder="dd-MM-yyyy">
                                            <div class="input-group-append">
                                                <span class="input-group-text align-self-center" style="cursor:pointer"><i
                                                        class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="tgl_giro_cair" class="col-form-label fs-6">TANGGAL
                                            GIRO CAIR</label>
                                        <div class="input-group date align-items-center">
                                            <input type="text" class="js-datepicker form-control" id="tgl_giro_cair"
                                                name="tgl_giro_cair" autocomplete="off" data-week-start="1"
                                                data-autoclose="true" data-today-highlight="true"
                                                data-date-format="dd-mm-yyyy" placeholder="dd-MM-yyyy">
                                            <div class="input-group-append">
                                                <span class="input-group-text align-self-center" style="cursor:pointer"><i
                                                        class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nilai_giro" class="col-form-label fs-6">NILAI GIRO
                                        (Rp)</label>
                                    <input type="text" class="form-control" id="nilai_giro" name="nilai_giro"
                                        placeholder="Masukkan NILAI GIRO">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="col-form-label fs-6">STATUS PEMBAYARAN</label>
                                <select class="form-control" disabled name="status" id="status">
                                    <option value="" hidden>--Pilih Status--</option>
                                    <option value="BELUM DIBAYAR">BELUM DIBAYAR</option>
                                    <option selected value="SUDAH DIBAYAR">SUDAH DIBAYAR</option>
                                </select>
                            </div>
                            <div class="text-right">
                                <button type="submit" id="submit" class="btn btn-alt-success">
                                    <i class="fa fa-check"></i> SIMPAN
                                </button>
                                <button class="btn btn-alt-success" type="button" disabled id="loadingSubmit">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('sweetalert::alert')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('/') }}resources/views/js/transaksi_create.js"></script>

    <script>
        const noInvoice = {!! json_encode($proyek) !!};
    </script>
@endsection
