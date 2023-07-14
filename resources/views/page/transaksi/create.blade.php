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
                                <select class="form-control" name="status" id="status">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var danaMasukInput = document.getElementById('dana_masuk');
            var nilaiGiroInput = document.getElementById('nilai_giro');
            var bankChargeInput = document.getElementById('bank_charge');
            var totalDanaMasukInput = document.getElementById('total_dana_masuk_i');

            function updateTotalDanaMasuk(Transfer) {
                // Mendapatkan nilai dana masuk
                const danaMasuk = parseFloat(danaMasukInput.value.replace(/\D/g,
                    "")) || 0; // Menghapus karakter selain digit

                // Mendapatkan nilai bank charge
                const bankCharge = parseFloat(bankChargeInput.value.replace(/\D/g,
                    "")) || 0; // Menghapus karakter selain digit

                // Menghitung total dana masuk setelah dikurangi bank charge atau sama dengan dana masuk jika bank charge belum diisi
                const totalDanaMasuk = bankCharge ? (danaMasuk - bankCharge) : danaMasuk;

                // if (nilaiGiro) {
                //     totalDanaMasukInput.value = nilaiGiro;

                // } else {
                // Memperbarui nilai total dana masuk
                totalDanaMasukInput.value = totalDanaMasuk >= 0 ? totalDanaMasuk.toLocaleString("id-ID") :
                    0; // Menampilkan format angka dengan tanda titik sebagai pemisah ribuan dan mengatur nilai default menjadi 0 jika negatif
                // }
            }

            if (danaMasukInput) {
                danaMasukInput.addEventListener('input', function(event) {
                    // Hilangkan semua karakter selain angka
                    var danaMasuk = this.value.replace(/\D/g, '');

                    // Format danaMasuk dengan tanda koma setiap 3 angka
                    danaMasuk = danaMasuk.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                    // Set nilai input field
                    this.value = danaMasuk;
                    updateTotalDanaMasuk(danaMasuk);
                });
            }

            if (nilaiGiroInput) {
                nilaiGiroInput.addEventListener('input', function(event) {
                    // Hilangkan semua karakter selain angka
                    var nilaiGiro = this.value.replace(/\D/g, '');

                    // Format nilaiGiro dengan tanda koma setiap 3 angka
                    nilaiGiro = nilaiGiro.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                    // Set nilai input field
                    this.value = nilaiGiro;
                    console.log(nilaiGiro);
                    // updateTotalDanaMasuk(nilaiGiro);
                });
            }

            if (bankChargeInput) {
                bankChargeInput.addEventListener('input', function(event) {
                    // Hilangkan semua karakter selain angka
                    var bankCharge = this.value.replace(/\D/g, '');

                    // Format bankCharge dengan tanda koma setiap 3 angka
                    bankCharge = bankCharge.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                    // Set nilai input field
                    this.value = bankCharge;
                    updateTotalDanaMasuk();
                });
            }
        });
    </script>

    <script>
        const noInvoiceInput = document.getElementById('no_invoice_i');
        const invoiceIdInput = document.getElementById('invoice_id_i');
        const customerIdInput = document.getElementById('customer_id_i');
        const namaProyekInput = document.getElementById('nama_proyek_i');
        const kodeProyekInput = document.getElementById('kode_proyek_i');
        const progressInput = document.getElementById('progress_i');
        const tagihanInput = document.getElementById('tagihan_i');
        const ppnNominalInput = document.getElementById('ppn_nominal_i');
        const pphSelect = document.getElementById('pph_i');
        const pphNominalInput = document.getElementById('pph_nominal_i');
        const biayaLainnyaInput = document.getElementById('biayalain_i');
        const totalNominalInput = document.getElementById('total_nominal_i');
        const nilaiTagihanInput = document.getElementById('nilai_tagihan_i');
        const arInput = document.getElementById('ar_i');
        const tglTtkInput = document.getElementById('tgl_ttk_i');
        const batasJatuhTempoInput = document.getElementById('batas_jatuh_tempo_i');
        const tglJatuhTempoInput = document.getElementById('tgl_jatuh_tempo_i');
        const koreksiDpInput = document.getElementById('koreksi_dp_i');
        const cariDataButton = document.getElementById('cari_data_i');
        const loadingButton = document.getElementById('loading');
        const loadingSubmitButton = document.getElementById('loadingSubmit');
        const submitBtn = document.getElementById('submit');

        const pphOption = document.createElement('option');
        pphOption.value = '--Pilih PPh--';
        pphOption.text = '--Pilih PPh--';
        pphSelect.add(pphOption);
        hideLoadingIndicator();
        loadingSubmitButton.style.display = 'none';
        cariDataButton.addEventListener('click', function() {

            showLoadingIndicator();
            // Ambil opsi yang dipilih pada datalist #no
            const selectedOption = document.querySelector(`#no option[value="${noInvoiceInput.value}"]`);

            setTimeout(function() {
                hideLoadingIndicator();
                // Sembunyikan indikator loading
                // Jika opsi yang dipilih ditemukan
                if (selectedOption) {
                    namaProyekInput.value = selectedOption.textContent.trim();
                    invoiceIdInput.value = selectedOption.dataset.invoiceId;
                    customerIdInput.value = selectedOption.dataset.customerId;
                    kodeProyekInput.value = selectedOption.dataset.kodeProyek;
                    progressInput.value = selectedOption.dataset.progress;
                    tglTtkInput.value = selectedOption.dataset.tglTtk;
                    batasJatuhTempoInput.value = selectedOption.dataset.batasJatuhTempo;
                    tglJatuhTempoInput.value = selectedOption.dataset.tglJatuhTempo;
                    batasJatuhTempoInput.value = selectedOption.dataset.batasJatuhTempo;
                    tagihanInput.value = selectedOption.dataset.tagihan.replace(/\B(?=(\d{3})+(?!\d))/g,
                        '.') + ',-';
                    pphSelect.value = selectedOption.dataset.pph;
                    pphNominalInput.value = selectedOption.dataset.pphNominal.replace(
                            /\B(?=(\d{3})+(?!\d))/g, '.') +
                        ',-';
                    pphSelect.disabled = true;
                    ppnNominalInput.value = selectedOption.dataset.ppnNominal.replace(
                            /\B(?=(\d{3})+(?!\d))/g, '.') +
                        ',-';
                    biayaLainnyaInput.value = selectedOption.dataset.lainLain.replace(
                            /\B(?=(\d{3})+(?!\d))/g, '.') +
                        ',-';
                    totalNominalInput.value = selectedOption.dataset.totalTagihan.replace(
                        /\B(?=(\d{3})+(?!\d))/g,
                        '.') + ',-';
                    koreksiDpInput.value = selectedOption.dataset.koreksiDp.replace(
                        /\B(?=(\d{3})+(?!\d))/g,
                        '.') + ',-';
                    nilaiTagihanInput.value = selectedOption.dataset.nilaiTagihan.replace(
                        /\B(?=(\d{3})+(?!\d))/g,
                        '.') + ',-';
                    arInput.value = selectedOption.dataset.ar.replace(
                        /\B(?=(\d{3})+(?!\d))/g,
                        '.') + ',-';
                } else {
                    const noInvoice = {!! json_encode($proyek) !!};
                    let validasiNoInvoice = noInvoice.find(item => item.no_invoice === noInvoiceInput
                        .value);
                    if (validasiNoInvoice) {} else {
                        swal.fire({
                            icon: 'warning',
                            title: 'Data Not Found.',
                            text: 'No Invoice tidak ditemukan!'
                        });

                        namaProyekInput.value = '';
                        noInvoiceInput.value = '';
                        kodeProyekInput.value = '';
                        progressInput.value = '';
                        tagihanInput.value = '';
                        pphSelect.value = '--Pilih PPh--';
                        pphNominalInput.value = '';
                        ppnNominalInput.value = '';
                        biayaLainnyaInput.value = '';
                        totalNominalInput.value = '';
                    }
                }
            }, 500); // Simulasikan waktu delay 1 detik
        });

        function showLoadingIndicator() {
            // Sembunyikan tombol cari_data_i
            cariDataButton.style.display = 'none';

            // Tampilkan tombol loading
            loadingButton.style.display = 'block';
        }

        function hideLoadingIndicator() {
            // Tampilkan tombol cari_data_i
            cariDataButton.style.display = 'block';

            // Sembunyikan tombol loading
            loadingButton.style.display = 'none';
        }

        submitBtn.addEventListener('click', function() {
            submitBtn.style.display = 'none';
            loadingSubmitButton.style.display = 'inline-block';
        });
    </script>

    <script>
        const switchEl = document.getElementById('switch');
        const nonGiro = document.getElementById('nonGiro');
        const tglTransferInput = document.getElementById('tgl_transfer');
        const danaMasukInput = document.getElementById('dana_masuk');
        const statusPembayaranSelect = document.getElementById('status');
        const noGiroInput = document.getElementById('no_giro');
        const tglTerimaGiroInput = document.getElementById('tgl_terima_giro');
        const tglGiroCairInput = document.getElementById('tgl_giro_cair');
        const nilaiGiroInput = document.getElementById('nilai_giro');
        const statusSelect = document.getElementById('status');
        const submitBtn2 = document.getElementById('submit');
        var totalDanaMasukInput = document.getElementById('total_dana_masuk_i');

        switchEl.addEventListener('change', function() {
            if (this.checked) {
                // Switch is on (GIRO)
                nonGiro.hidden = true;
                giro.hidden = false
                tglTransferInput.value = '';
                danaMasukInput.value = '';
                statusPembayaranSelect.value = '';
                statusSelect.value = 'BELUM DIBAYAR'
                statusSelect.disabled = true;
                totalDanaMasukInput.value = '';

            } else {
                // Switch is off (NON-GIRO)
                nonGiro.hidden = false;
                giro.hidden = true;
                statusPembayaranSelect.value = '';
                noGiroInput.value = '';
                tglTerimaGiroInput.value = '';
                tglGiroCairInput.value = '';
                nilaiGiroInput.value = '';
                statusSelect.disabled = false;
                totalDanaMasukInput.value = '';

            }
        });

        submitBtn.addEventListener('click', function() {
            // Set disabled menjadi false untuk elemen select sebelum mengirim data ke database
            statusSelect.disabled = false;
        });
    </script>
@endsection
