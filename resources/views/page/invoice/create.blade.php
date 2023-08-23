@extends('layouts.dashboard')
@section('content')
    <style>
        .table td,
        .table th {
            font-size: 0.875rem;
        }
    </style>
    <div class="content">
        @php
            $hargaKontrak = 0;
            
            $dp = 0;
            $approval = 0;
            $bmos = 0;
            $amos = 0;
            $testcomm = 0;
            $retensi = 0;
        @endphp
        <div class="block shadow">
            <div class="block-header block-header-default">
                <h3 class="block-title">Data Invoice <small>Sudah Dibuat</small></h3>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter table-hover js-dataTable-simple">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th class="text-center" style="width: 15%">No Invoice</th>
                                <th class="text-center">Progress</th>
                                <th class="text-center" style="width: 15%">
                                    Tanggal TTK
                                </th>
                                <th class="text-center">Tanggal Jatuh Tempo</th>
                                <th class="text-center">Total Tagihan</th>
                                <th class="text-center">AR</th>
                                <th class="text-center" style="width: 15%">Status</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="block shadow bg-white">
            <div class="block-header block-header-default">
                <h3 class="block-title text-center">BUAT INVOICE</h3>
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
                        <form id="form_invoice" action="{{ route('invoice.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="kode_proyek" class="col-form-label fs-6">KODE PROYEK
                                    </label>
                                    <div class="input-group">
                                        <input class="form-control" list="kode" id="kode_proyek" name="kode_proyek"
                                            autocomplete="off" placeholder="Ketik untuk mencari KODE PROYEK..."
                                            aria-describedby="refresh_kode_proyek" readonly
                                            onfocus="javascript: this.removeAttribute('readonly')">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary fw-bold" title="Refresh Kode Proyek"
                                                type="button" id="refresh_kode_proyek"><i class="fa-solid fa-rotate"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <datalist id="kode">
                                        @forelse ($proyek as $i)
                                            <option value="{{ $i->kode_proyek }}"
                                                data-payment-terms-id="{{ $i->payment_terms_id }}"
                                                data-customer-id="{{ $i->customer_id }}"
                                                data-keterangan="{{ $i->keterangan }}">
                                                {{ $i->nama_proyek }} </option>
                                        @empty
                                            <span>Data kosong</span>
                                        @endforelse
                                    </datalist>
                                </div>
                                <div class="col mb-3">
                                    <label for="nama_proyek" class=" col-form-label fs-6">NAMA
                                        PROYEK</label>
                                    <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" readonly
                                        placeholder="Nama proyek akan muncul disini ...">
                                </div>
                            </div>
                            <div>
                                <input hidden class="form-control" id="payment_terms_id" name="payment_terms_id" readonly>
                            </div>
                            <div>
                                <input hidden class="form-control" id="customer_id" name="customer_id" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="no_invoice" class="col-form-label fs-6">NO. INVOICE</label>
                                <input type="text" class="form-control" name="no_invoice" autocomplete="off"
                                    placeholder="Masukkan No. Invoice" value="{{ old('no_invoice') }}">
                            </div>
                            <div class="mb-3">
                                <label for="no_faktur_pajak" class="col-form-label fs-6">NO. FAKTUR PAJAK</label>
                                <input type="text" class="form-control" name="no_faktur_pajak" autocomplete="off"
                                    placeholder="Masukkan No. Faktur Pajak" value="{{ old('no_faktur_pajak') }}">
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="tgl_invoice" class="col-form-label fs-6">TANGGAL
                                        INVOICE</label>
                                    <div class="input-group date align-items-center">
                                        <input type="text" class="js-datepicker form-control" id="tgl_invoice"
                                            name="tgl_invoice" autocomplete="off" data-week-start="1"
                                            data-autoclose="true" data-today-highlight="true"
                                            data-date-format="dd-mm-yyyy" value="{{ old('tgl_invoice') }}"
                                            placeholder="dd-MM-yyyy">
                                        <div class="input-group-append">
                                            <label for="tgl_invoice" class="input-group-text align-self-center"
                                                style="cursor:pointer"><i class="fa fa-calendar"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col mb-3">
                                    <label for="progress" class="col-form-label fs-6">PROGRESS PEMBAYARAN</label>
                                    <select class="custom-select" disabled name="progress" id="progress">
                                        <option hidden value=''>--Pilih Progress Pembayaran--</option>
                                        <option id="DP" style="display: none;"></option>
                                        <option id="APPROVAL" style="display: none;"></option>
                                        <option id="BMOS" style="display: none;"></option>
                                        <option id="AMOS" style="display: none;"></option>
                                        <option id="TESTCOMM" style="display: none;"></option>
                                        <option id="RETENSI" style="display: none;"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tagihan" class="col-form-label fs-6">Sub Total
                                </label>
                                <span class="align-self-center">(Rp)</span>
                                <div class="input-group">
                                    <input type="text" class="form-control" oninput="formatCurrencyInput(this)"
                                        id="tagihan" name="tagihan" placeholder="">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary fw-bold" title="Refresh Nilai Tagihan"
                                            type="button" id="refresh_tagihan"><i class="fa-solid fa-rotate"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="border text-center">
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <div class="mt-2 px-2 mx-2">
                                            <label>
                                                Koreksi DP</label>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" name="koreksi_dp" class="form-control col-md-5"
                                            oninput="formatCurrencyInput(this)" id="koreksi_dp" placeholder=0>
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
                                            class="form-control-plaintext col-md-5" id="nilai_tagihan"
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
                                            class="form-control-plaintext col-md-5" id="ppn_nominal" name="ppn_nominal">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <label for="pph" class="fs-6"></label>
                                        <select class="custom-select" name="pph" id="pph">
                                            <option selected hidden value="0">--Pilih PPh--</option>
                                            <option value="0">Tidak Ada</option>
                                            <option value="1,5%">PPh 1,5%</option>
                                            <option value="2%">PPh 2%</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary fw-bold" hidden title="Refresh Pilihan PPh"
                                                type="button" id="refresh_pph"><i class="fa-solid fa-rotate"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0"
                                            class="form-control-plaintext col-md-5" name="pph_nominal" id="pph_nominal">
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
                                        <input type="text" name="lain_lain" class="form-control col-md-5"
                                            oninput="formatCurrencyInput(this)" id="biayalain" placeholder=0>
                                    </div>
                                </div>
                            </div>
                            <div class="border text-center text-monospace">
                                {{-- <div class="row">
                                    <div class="col input-group">
                                        <label for="TOTAL" class="col-form-label col-md-9 fs-6">Total Tagihan
                                            Sebelumnya +
                                            PPN(11%)</label>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0" class="form-control col-md-5"
                                            id="total_nominal" name="total_tagihan">
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col input-group">
                                        <label for="TOTAL" class="col-form-label col-md-9 fs-6">Total Tagihan +
                                            PPN(11%)</label>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0" class="form-control col-md-5"
                                            id="total_nominal" name="total_tagihan">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary fw-bold" title="Hitung Total" type="button"
                                                id="hitung"><i class="fa-solid fa-divide"></i> Hitung
                                            </button>
                                            <button class="btn btn-secondary fw-bold" title="Hitung Ulang Total"
                                                type="button" id="update"><i class="fa-solid fa-divide"></i> Hitung
                                            </button>
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary fw-bold" title="Refresh Semua"
                                                    type="button" id="refresh_all"><i class="fa-solid fa-rotate"></i>
                                                    Refresh
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="keterangan" class="col-form-label fs-6">
                                    KETERANGAN</label>
                                <textarea class="form-control" placeholder="Ketik keterangan tambahan disini..." id="keterangan" name="keterangan"
                                    rows="3" style="resize: none;"></textarea>
                            </div>
                            <div class="footer text-right">
                                <button type="submit" id="submit" class="btn btn-alt-primary">
                                    <i class="fa fa-check"></i> BUAT INVOICE
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

    <script src="{{ asset('/') }}resources/views/js/invoice_create.js"></script>

    <script>
        const invoiceData = {!! json_encode($dataInvoice) !!};
        const paymentTermsData = {!! json_encode($payment_terms) !!};
        const kodeProyek = {!! json_encode($proyek) !!};
    </script>
@endsection
