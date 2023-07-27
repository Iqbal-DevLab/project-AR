@extends('layouts.dashboard')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Bootstrap Forms Validation -->
        <h2 class="content-heading">Halaman Transaksi</h2>
        <div class="block shadow bg-white">
            <div class="block-header block-header-default">
                <h3 class="block-title text-center">Form Edit Transaksi</h3>
                <div class="block-options">
                </div>
            </div>
            <div class="block-content">
                <div class="row justify-content-center py-20">
                    <div class="col-xl-10">
                        <form action={{ route('transaksi.update', $transaksi->transaksi_id) }} method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="no_invoice" class="col-form-label fs-6">NO. INVOICE</label>
                                <div class="input-group">
                                    <input class="form-control" list="no" id="no_invoice_i" name="no_invoice"
                                        autocomplete="off" readonly value="{{ $transaksi->no_invoice }}"
                                        placeholder="Ketik untuk mencari No. Invoice...">
                                    <div class="input-group-append">
                                        <button class="btn btn-alt-primary rounded fw-bold" title="Cari Invoice"
                                            type="button" disabled id="cari_data_i"><i
                                                class="fa-solid fa-magnifying-glass"></i>
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nama_proyek" class="col-form-label fs-6">NAMA
                                        PROYEK</label>
                                    <input class="form-control" value="{{ $transaksi->nama_proyek }}" readonly
                                        id="nama_proyek_i" placeholder="Nama Proyek">
                                </div>
                                <div class="col mb-3" hidden>
                                    <label for="invoice_id" class="col-form-label fs-6">
                                        INVOICE ID</label>
                                    <input class="form-control" readonly value="{{ $transaksi->invoice_id }}"
                                        id="invoice_id_i" name="invoice_id" placeholder="invoice ID">
                                </div>
                                <div class="col mb-3">
                                    <label for="kode_proyek" class="col-form-label fs-6">KODE
                                        PROYEK</label>
                                    <input type="text" class="form-control" value="{{ $transaksi->kode_proyek }}"
                                        name="kode_proyek" id="kode_proyek_i" readonly required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="dana_masuk" class="col-form-label fs-6">PROGRESS PEMBAYARAN</label>
                                <input type="text" readonly value="{{ $transaksi->progress }}" class="form-control"
                                    id="progress_i" name="progress">
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="tgl_ttk" class="col-form-label fs-6">TANGGAL
                                        TTK</label>
                                    <div class="input-group date align-items-center">
                                        <input type="text" disabled value="{{ $transaksi->tgl_ttk }}"
                                            class="js-datepicker form-control" id="tgl_ttk_i" name="tgl_ttk"
                                            autocomplete="off" data-week-start="1" data-autoclose="true"
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
                                        <input type="text" disabled value="{{ $transaksi->tgl_jatuh_tempo }}"
                                            class="js-datepicker form-control" id="tgl_jatuh_tempo_i" name="tgl_jatuh_tempo"
                                            autocomplete="off" data-week-start="1" data-autoclose="true"
                                            data-today-highlight="true" data-date-format="dd-mm-yyyy"
                                            placeholder="dd-MM-yyyy">
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
                                            class="form-control-plaintext col-md-2"
                                            value="{{ $transaksi->batas_jatuh_tempo }}" id="batas_jatuh_tempo_i">
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
                                        <input type="text" value="@currency($transaksi->tagihan),-" readonly placeholder="0"
                                            class="form-control-plaintext col-md-5">
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
                                        <input type="text" value="@currency($transaksi->koreksi_dp),-" readonly name="koreksi_dp"
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
                                        <input type="text" value="@currency($transaksi->nilai_tagihan),-" readonly placeholder="0"
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
                                        <input type="text" value="@currency($transaksi->ppn_nominal),-" readonly placeholder="0"
                                            class="form-control-plaintext col-md-5" id="ppn_nominal_i"
                                            name="ppn_nominal">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <label for="pph" class="fs-6"></label>
                                        <select class="custom-select" disabled name="pph" id="pph_i">
                                            <option selected hidden value="0">--Pilih PPh--</option>
                                            <option value="0" @if ($transaksi->pph == '') selected @endif>
                                                Tidak Ada</option>
                                            <option value="1,5%" @if ($transaksi->pph == '1,5%') selected @endif>
                                                PPh 1,5%</option>
                                            <option value="2%" @if ($transaksi->pph == '2%') selected @endif>
                                                PPh 2%</option>
                                        </select>
                                    </div>
                                    <div class="col input-group">
                                        <input type="text" value="@currency($transaksi->pph_nominal),-" readonly placeholder="0"
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
                                        <input type="text" value="@currency($transaksi->lain_lain),-" readonly name="lain_lain"
                                            class="form-control-plaintext col-md-5" id="biayalain_i" placeholder=0>
                                    </div>
                                </div>
                            </div>
                            <div class="border text-center mb-3">
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <label for="total_tagihan" class="col-form-label col-md-9 fs-6">Total
                                            Pembayaran + PPN(11%)</label>
                                    </div>
                                    <div class="col input-group">
                                        <input type="text" value="@currency($transaksi->total_tagihan),-" readonly required
                                            placeholder="0" class="form-control col-md-5" id="total_nominal_i"
                                            name="total_tagihan">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <label for="ar" class="col-form-label col-md-9 fs-6">Sisa
                                            Pembayaran</label>
                                    </div>
                                    <div class="col input-group">
                                        <input type="text" value="@currency($transaksi->ar),-" readonly required
                                            placeholder="0" class="form-control col-md-5" id="total_nominal_i"
                                            name="ar">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <label for="total_dana_masuk" class="col-form-label col-md-9 fs-6">Total Dana
                                            Masuk</label>
                                    </div>
                                    <div class="col input-group">
                                        <input type="text" value="@currency($transaksi->total_dana_masuk)" readonly placeholder="0"
                                            class="form-control col-md-5" id="total_dana_masuk_i"
                                            name="total_dana_masuk">
                                    </div>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" type="checkbox" id="switch" name="switch"
                                    {{ $transaksi->no_giro ? 'checked' : '' }} disabled>
                                <label class="custom-control-label fs-6" for="switch">PEMBAYARAN
                                    DENGAN GIRO</label>
                            </div>
                            <div class="mb-3">
                                <label for="bank" class="col-form-label fs-6">NAMA
                                    BANK</label>
                                <select class="form-control" id="bank" required name="bank">
                                    <option value="Bank BRI" @if ($transaksi->bank == 'Bank BRI') selected @endif>
                                        Bank BRI</option>
                                    <option value="Bank BCA" @if ($transaksi->bank == 'Bank BCA') selected @endif>
                                        Bank BCA</option>
                                    <option value="Bank MANDIRI" @if ($transaksi->bank == 'Bank MANDIRI') selected @endif>
                                        Bank MANDIRI</option>
                                    <option value="Bank BNI" @if ($transaksi->bank == 'Bank BNI') selected @endif>
                                        Bank BNI</option>
                                    <option value="Bank OCBC NISP" @if ($transaksi->bank == 'Bank OCBC NISP') selected @endif>
                                        Bank OCBC NISP</option>
                                </select>
                            </div>
                            <div id="nonGiro" {{ $transaksi->tgl_transfer ? '' : 'hidden' }}>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="tgl_transfer" class="col-form-label fs-6">TANGGAL
                                            TRANSFER</label>
                                        <div class="input-group date align-items-center">
                                            <input type="text" class="js-datepicker form-control" id="tgl_transfer"
                                                name="tgl_transfer" autocomplete="off" data-week-start="1"
                                                data-autoclose="true" data-today-highlight="true"
                                                data-date-format="dd-mm-yyyy" placeholder="dd-MM-yyyy"
                                                value="{{ $transaksi->tgl_transfer ? \Carbon\Carbon::parse($transaksi->tgl_transfer)->format('d-m-Y') : '' }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text align-self-center" style="cursor:pointer"><i
                                                        class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="dana_masuk" class="col-form-label fs-6">DANA MASUK
                                            (Rp)</label>
                                        <input type="text" readonly value="@currency($transaksi->dana_masuk)"
                                            class="form-control dana_masuk" id="dana_masuk" name="dana_masuk">
                                    </div>
                                    <div class="col mb-3">
                                        <label for="bank_charge" class="col-form-label fs-6">BANK CHARGE
                                            (Rp)</label>
                                        <input type="text" value="@currency($transaksi->bank_charge)" readonly class="form-control"
                                            placeholder="6.500" id="bank_charge" name="bank_charge">
                                    </div>
                                </div>
                            </div>
                            <div id="giro"{{ $transaksi->no_giro ? '' : 'hidden' }}>
                                <div class="mb-3">
                                    <label for="no_giro" class="col-form-label fs-6">NO.
                                        GIRO</label>
                                    <input type="text" class="form-control" id="no_giro" name="no_giro"
                                        value="{{ $transaksi->no_giro }}">
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
                                                data-date-format="dd-mm-yyyy" placeholder="dd-MM-yyyy"
                                                value="{{ $transaksi->tgl_terima_giro ? \Carbon\Carbon::parse($transaksi->tgl_terima_giro)->format('d-m-Y') : '' }}">
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
                                                data-date-format="dd-mm-yyyy" placeholder="dd-MM-yyyy"
                                                value="{{ $transaksi->tgl_giro_cair ? \Carbon\Carbon::parse($transaksi->tgl_giro_cair)->format('d-m-Y') : '' }}">
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
                                        readonly value="@currency($transaksi->nilai_giro)">
                                </div>

                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="tgl_transfer" class="col-form-label fs-6">TANGGAL
                                            CAIR <span class="text-danger">*</span></label>
                                        <div class="input-group date align-items-center">
                                            <input type="text" class="js-datepicker form-control" id="tgl_transfer"
                                                name="tgl_transfer" autocomplete="off" data-week-start="1"
                                                data-autoclose="true" data-today-highlight="true"
                                                data-date-format="dd-mm-yyyy" placeholder="dd-MM-yyyy"
                                                value="{{ $transaksi->tgl_transfer ? \Carbon\Carbon::parse($transaksi->tgl_transfer)->format('d-m-Y') : '' }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text align-self-center" style="cursor:pointer"><i
                                                        class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col mb-3">
                                        <label for="dana_masuk" class="col-form-label fs-6 dana_masuk">DANA MASUK
                                            (Rp) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control dana_masuk" id="dana_masuk_giro"
                                            name="dana_masuk">
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="status" class="col-form-label fs-6">STATUS <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" required name="status">
                                    <option value="Belum Dibayar" @if ($transaksi->status == 'Belum Dibayar') selected @endif>
                                        Belum Dibayar</option>
                                    <option value="Sudah Dibayar" @if ($transaksi->status == 'Sudah Dibayar') selected @endif>
                                        Sudah Dibayar</option>
                                </select>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-alt-success">
                                    <i class="fa fa-check"></i> SIMPAN
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('sweetalert::alert')

    <script src="{{ asset('/') }}resources/views/js/transaksi_edit.js"></script>
@endsection
