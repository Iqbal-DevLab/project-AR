@extends('layouts.dashboard')
@section('content')
    <div class="content">
        <div class="block shadow bg-white">
            <div class="block-header block-header-default">
                <h3 class="block-title text-center">Form Proyek Baru</h3>
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
                        <form action="{{ route('proyek.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nama_proyek" class=" col-form-label fs-6">NAMA
                                            PROYEK</label>
                                        <input type="text" class="form-control" id="nama_proyek" name="nama_proyek"
                                            placeholder="Masukkan Nama Proyek" pattern="[a-zA-Z 0-9/()_-]+"
                                            style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()"
                                            value="{{ old('nama_proyek') }}">
                                    </div>
                                    <div class="col mb-3">
                                        <label for="kode_proyek" class="col-form-label fs-6">KODE
                                            PROYEK</label>
                                        <input type="text" class="form-control" id="kode_proyek" name="kode_proyek"
                                            placeholder="Masukkan Kode Proyek" value="{{ old('kode_proyek') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="harga" class="col-form-label fs-6">HARGA
                                        KONTRAK</label>
                                    <input type="text" class="form-control" id="harga" name="nilai_kontrak"
                                        placeholder="Masukkan Harga Kontrak" value="{{ old('nilai_kontrak') }}"
                                        @if (old('nilai_kontrak')) readonly @endif>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="no_po" class="col-form-label fs-6">NO. PO</label>
                                        <input class="form-control" placeholder="Masukkan Nomor PO" name="no_po"
                                            id="no_po" value="{{ old('no_po') }}">
                                    </div>
                                    <div class="col mb-3">
                                        <label for="status_po" class="col-form-label fs-6">STATUS PO</label>
                                        <select class="custom-select" name="status_po" id="status_po">
                                            <option selected value=''>--Pilih Status--</option>
                                            <option value="BELUM DITERIMA"
                                                {{ old('status_po') === 'BELUM DITERIMA' ? 'selected' : '' }}>BELUM DITERIMA
                                            </option>
                                            <option value="SUDAH DITERIMA"
                                                {{ old('status_po') === 'SUDAH DITERIMA' ? 'selected' : '' }}>SUDAH DITERIMA
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nama_customer" class="col-form-label fs-6">NAMA PEMESAN
                                        </label>
                                        <div class="input-group">
                                            <input class="form-control" list="pemesan" id="nama_customer"
                                                name="nama_customer" autocomplete="off"
                                                placeholder="Ketik untuk mencari PEMESAN..."
                                                aria-describedby="refresh_customer" value="{{ old('nama_customer') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary fw-bold" title="Refresh Pemesan"
                                                    type="button" id="refresh_customer"><i class="fa-solid fa-rotate"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <datalist id="pemesan">
                                            @forelse ($customer as $i)
                                                <option value="{{ $i->nama_customer }}">
                                                    {{ $i->id }}</option>
                                            @empty
                                                <span>Data kosong</span>
                                            @endforelse
                                        </datalist>
                                    </div>
                                    <div class="col mb-3" hidden>
                                        <label for="customer_id" class="col-form-label fs-6">
                                            ID CUSTOMER</label>
                                        <input type="text" class="form-control" name="customer_id" id="customer_id"
                                            value="{{ old('customer_id') }}" readonly />
                                    </div>
                                    <div class="col mb-3">
                                        <label for="kategori_proyek" class="col-form-label fs-6">
                                            KATEGORI PROYEK</label>
                                        <select class="custom-select" name="kategori_proyek" id="kategori_proyek">
                                            <option selected value=''>--Pilih Kategori Proyek--
                                            </option>
                                            <option value="SWASTA">SWASTA</option>
                                            <option value="BUMN">BUMN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="tgl_pelaksanaan" hidden>
                                    <div class="col mb-3">
                                        <label for="tgl_awal" class="col-form-label fs-6">TANGGAL MULAI
                                            PELAKSANAAN</label>
                                        <div class="input-group date align-items-center">
                                            <input type="text" class="js-datepicker form-control" id="tgl_awal"
                                                name="tgl_awal" autocomplete="off" data-week-start="1"
                                                data-autoclose="true" data-today-highlight="true"
                                                data-date-format="dd-mm-yyyy" value="{{ old('tgl_awal') }}"
                                                placeholder="dd-MM-yyyy">
                                            <div class="input-group-append">
                                                <span class="input-group-text align-self-center" style="cursor:pointer"><i
                                                        class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="tgl_akhir" class="col-form-label fs-6">TANGGAL AKHIR
                                            PELAKSANAAN</label>
                                        <div class="input-group date align-items-center">
                                            <input type="text" class="js-datepicker form-control" id="tgl_akhir"
                                                name="tgl_akhir" autocomplete="off" data-week-start="1"
                                                data-autoclose="true" data-today-highlight="true"
                                                data-date-format="dd-mm-yyyy" value="{{ old('tgl_akhir') }}"
                                                placeholder="dd-MM-yyyy">
                                            <div class="input-group-append">
                                                <span class="input-group-text align-self-center" style="cursor:pointer"><i
                                                        class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="nama_sales" class="col-form-label fs-6">NAMA SALES
                                        </label>
                                        <div class="input-group">
                                            <input class="form-control" list="sales" id="nama_sales"
                                                placeholder="Ketik untuk mencari SALES..." autocomplete="off"
                                                aria-describedby="refresh_sales" name="nama_sales"
                                                value="{{ old('nama_sales') }}"
                                                @if (old('nama_sales')) readonly @endif>
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary fw-bold" title="Refresh Sales"
                                                    type="button" id="refresh_sales"><i class="fa-solid fa-rotate"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <datalist id="sales">
                                            @forelse ($sales as $name)
                                                <option value="{{ $name->nama_sales }}">
                                                    {{ $name->id }}</option>
                                            @empty
                                                <span>Data kosong</span>
                                            @endforelse
                                        </datalist>
                                    </div>
                                    <div class="col mb-3" hidden>
                                        <label for="sales_id" class="col-form-label fs-6">
                                            ID SALES</label>
                                        <input type="text" class="form-control" name="sales_id" id="sales_id"
                                            value="{{ old('sales_id') }}" readonly />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="payment_terms" class="col-form-label fs-6">PAYMENT
                                            TERMS</label>
                                        <div class="input-group">
                                            <input class="form-control" list="top" id="payment_terms"
                                                placeholder="Ketik untuk mencari TOP..." autocomplete="off"
                                                aria-describedby="refresh_top" readonly name="payment_terms"
                                                value="{{ old('payment_terms') ?? '' }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary fw-bold" title="Refresh Payment Terms"
                                                    type="button" id="refresh_top"><i class="fa-solid fa-rotate"></i>
                                                    Refresh
                                                </button>
                                            </div>
                                        </div>
                                        <datalist id="top">
                                            @forelse ($payment_terms as $i)
                                                <option
                                                    value="{{ trim(
                                                        implode(
                                                            ', ',
                                                            array_filter([
                                                                !empty($i->DP) ? 'DP: ' . $i->DP : null,
                                                                !empty($i->APPROVAL) ? 'APPROVAL: ' . $i->APPROVAL : null,
                                                                !empty($i->BMOS) ? 'BMOS: ' . $i->BMOS : null,
                                                                !empty($i->AMOS) ? 'AMOS: ' . $i->AMOS : null,
                                                                !empty($i->TESTCOMM) ? 'TESTCOMM: ' . $i->TESTCOMM : null,
                                                                !empty($i->RETENSI) ? 'RETENSI: ' . $i->RETENSI : null,
                                                            ]),
                                                        ),
                                                    ) }}">
                                                    {{ $i->id }}
                                                </option>
                                            @empty
                                                <span>Data kosong</span>
                                            @endforelse
                                        </datalist>
                                    </div>
                                    <div class="col mb-3" hidden>
                                        <label for="payment_terms_id" class="col-form-label fs-6">
                                            ID PAYMENT TERMS</label>
                                        <input type="text" class="form-control" name="payment_terms_id"
                                            id="payment_terms_id" value="{{ old('payment_terms_id') }}" readonly />
                                    </div>
                                </div>
                                <div class="border">
                                    <div class="row text-monospace">
                                        <div class="col input-group">
                                            <label for="DP" class="col-form-label col-md-4 fs-6">DP</label>
                                            <input type="text" readonly placeholder="0%"
                                                class="form-control-plaintext col-md-3" id="dp" name="DP"
                                                value="{{ old('DP') }}">
                                        </div>
                                        <div class="col input-group">
                                            <span class="align-self-center">Rp.</span>
                                            <input type="text" readonly placeholder="0"
                                                class="form-control-plaintext col-md-5" id="dp_nominal" name="dp_nominal"
                                                value="{{ old('dp_nominal') }}">
                                        </div>
                                    </div>
                                    <div class="row text-monospace">
                                        <div class="col input-group">
                                            <label for="APPROVAL" class="col-form-label col-md-4 fs-6">APPROVAL</label>
                                            <input type="text" readonly placeholder="0%"
                                                class="form-control-plaintext col-md-3" id="approval" name="APPROVAL"
                                                value="{{ old('APPROVAL') }}">
                                        </div>
                                        <div class="col input-group">
                                            <span class="align-self-center">Rp.</span>
                                            <input type="text" readonly placeholder="0"
                                                class="form-control-plaintext col-md-5" id="approval_nominal"
                                                name="approval_nominal" value="{{ old('approval_nominal') }}">
                                        </div>
                                    </div>
                                    <div class="row text-monospace">
                                        <div class="col input-group">
                                            <label for="BMOS" class="col-form-label col-md-4 fs-6">BMOS</label>
                                            <input type="text" readonly placeholder="0%"
                                                class="form-control-plaintext col-md-3" id="bmos" name="BMOS"
                                                value="{{ old('BMOS') }}">
                                        </div>
                                        <div class="col input-group">
                                            <span class="align-self-center">Rp.</span>
                                            <input type="text" readonly placeholder="0"
                                                class="form-control-plaintext col-md-5" id="bmos_nominal"
                                                name="bmos_nominal" value="{{ old('bmos_nominal') }}">
                                        </div>
                                    </div>
                                    <div class="row text-monospace">
                                        <div class="col input-group">
                                            <label for="AMOS" class="col-form-label col-md-4 fs-6">AMOS</label>
                                            <input type="text" readonly placeholder="0%"
                                                class="form-control-plaintext col-md-3" id="amos" name="AMOS"
                                                value="{{ old('AMOS') }}">
                                        </div>
                                        <div class="col input-group">
                                            <span class="align-self-center">Rp.</span>
                                            <input type="text" readonly placeholder="0"
                                                class="form-control-plaintext col-md-5" id="amos_nominal"
                                                name="amos_nominal" value="{{ old('amos_nominal') }}">
                                        </div>
                                    </div>
                                    <div class="row text-monospace">
                                        <div class="col input-group">
                                            <label for="TESTCOMM" class="col-form-label col-md-4 fs-6">TESTCOMM</label>
                                            <input type="text" readonly placeholder="0%"
                                                class="form-control-plaintext col-md-3" id="testcomm" name="TESTCOMM"
                                                value="{{ old('TESTCOMM') }}">
                                        </div>
                                        <div class="col input-group">
                                            <span class="align-self-center">Rp.</span>
                                            <input type="text" readonly placeholder="0"
                                                class="form-control-plaintext col-md-5" id="testcomm_nominal"
                                                name="testcomm_nominal" value="{{ old('testcomm_nominal') }}">
                                        </div>
                                    </div>
                                    <div class="row text-monospace mb-3">
                                        <div class="col input-group">
                                            <label for="RETENSI" class="col-form-label col-md-4 fs-6">RETENSI</label>
                                            <input type="text" readonly placeholder="0%"
                                                class="form-control-plaintext col-md-3" id="retensi" name="RETENSI"
                                                value="{{ old('RETENSI') }}">
                                        </div>
                                        <div class="col input-group">
                                            <span class="align-self-center">Rp.</span>
                                            <input type="text" readonly placeholder="0"
                                                class="form-control-plaintext col-md-5" id="retensi_nominal"
                                                name="retensi_nominal" value="{{ old('retensi_nominal') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="border text-center">
                                    <div class="row text-monospace">
                                        <div class="col input-group">
                                            <label for="ppn" class="col-form-label col-md-4 fs-6">PPN 11%</label>
                                            <input type="text" class="form-control-plaintext col-md-3" id="ppn"
                                                readonly placeholder="0%" name="ppn" value="{{ old('ppn') }}">
                                        </div>
                                        <div class="col input-group">
                                            <span class="align-self-center">Rp.</span>
                                            <input type="text" readonly placeholder="0"
                                                class="form-control-plaintext col-md-5" id="ppn_nominal"
                                                name="ppn_nominal" value="{{ old('ppn_nominal') }}">
                                        </div>
                                    </div>
                                    <div class="row text-monospace">
                                        <div class="col input-group">
                                            <label for="TOTAL" class="col-form-label col-md-4 fs-6">Total</label>
                                            <input type="text" hidden class="form-control-plaintext col-md-3"
                                                id="total" readonly placeholder="0%" name="TOTAL"
                                                value="{{ old('TOTAL') }}">
                                        </div>
                                        <div class="col input-group">
                                            <span class="align-self-center">Rp.</span>
                                            <input type="text" readonly placeholder="0"
                                                class="form-control-plaintext col-md-5" id="total_nominal"
                                                name="total_nominal" value="{{ old('total_nominal') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="keterangan" class="col-form-label fs-6">
                                        KETERANGAN</label>
                                    <textarea class="form-control" placeholder="Ketik keterangan tambahan disini..." id="keterangan" name="keterangan"
                                        rows="3" style="resize: none;">{{ old('keterangan') }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-alt-success" id="submit">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('/') }}resources/views/js/proyek_create.js"></script>

    <script>
        const sales = {!! json_encode($sales) !!};
        const customer = {!! json_encode($customer) !!};
    </script>

@endsection
