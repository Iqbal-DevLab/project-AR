@extends('layouts.dashboard')
@section('content')
    <style>
        .bg-dp {
            background-color: #20B2AA;
        }

        .bg-progress {
            background-color: #FFD700;
        }

        .bg-pelunasan {
            background-color: #1E90FF;
        }
    </style>
    <x-page-title>
        <h4 class="text-capitalize">Halaman Transaksi</h4>
        <x-breadcrumb>
            <li class="breadcrumb-item active"><a href="#">Halaman Transaksi</a></li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <section>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div>
                                <button type="button" class="btn btn-primary px-2 py-2" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="bi bi-plus-circle"></i>
                                    <span class="ms-1 fs-6">Tambahkan Data Transaksi</span>
                                </button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark">
                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">FORM
                                                    TRANSAKSI</h1>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="/finance/transaksi" method="POST" class="fw-semibold">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="row">
                                                        {{-- <div class="col mb-3">
                                                            <label for="nama_proyek" class="col-form-label fs-6">NAMA
                                                                PROYEK</label>
                                                            <select class="form-select" id="nama_proyek" required
                                                                name="kode_proyek">
                                                                <option value="">Pilih Nama Proyek</option>
                                                                @forelse ($proyek as $i)
                                                                    <option value="{{ $i->kode_proyek }}">
                                                                        {{ $i->nama_proyek }}
                                                                    </option>
                                                                @empty
                                                                    <span>Data kosong</span>
                                                                @endforelse
                                                            </select>
                                                        </div> --}}
                                                        <div class="col mb-3">
                                                            <label for="nama_proyek" class="col-form-label fs-6">NAMA
                                                                PROYEK</label>
                                                            <input class="form-control" list="datalistOptions"
                                                                id="nama_proyek"
                                                                placeholder="Ketik untuk mencari Nama Proyek...">
                                                            <datalist id="datalistOptions">
                                                                @forelse ($proyek as $i)
                                                                    <option value="{{ $i->nama_proyek }}">
                                                                        {{ $i->kode_proyek }}</option>
                                                                @empty
                                                                    <span>Data kosong</span>
                                                                @endforelse
                                                            </datalist>
                                                        </div>
                                                        <div class="col mb-3">
                                                            <label for="kode_proyek" class="col-form-label fs-6">KODE
                                                                PROYEK</label>
                                                            <input type="text" class="form-control" name="kode_proyek"
                                                                id="kode_proyek" readonly required />
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="no_invoice" class="col-form-label fs-6">NO.
                                                            INVOICE</label>
                                                        <input type="text" class="form-control" id="no_invoice" required
                                                            name="no_invoice">
                                                    </div>

                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="switch"
                                                            name="switch">
                                                        <label class="col-form-check-label fs-6" for="switch">PEMBAYARAN
                                                            DENGAN GIRO</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col mb-3">
                                                            <label for="nama_bank" class="col-form-label fs-6">NAMA
                                                                BANK</label>
                                                            <select class="form-select" id="bank" required
                                                                name="bank">
                                                                <option value="" hidden>Pilih Nama Bank</option>
                                                                <option value="BANK BRI">BANK BRI</option>
                                                                <option value="BANK BCA">BANK BCA</option>
                                                                <option value="BANK MANDIRI">BANK MANDIRI</option>
                                                                <option value="BANK BNI">BANK BNI</option>
                                                                <option value="BANK OCBC NISP">BANK OCBC NISP</option>
                                                            </select>
                                                        </div>
                                                        <div class="col mb-3" id="nonGiro">
                                                            <label for="tgl_transfer" class="col-form-label fs-6">TANGGAL
                                                                CAIR / TRANSFER</label>
                                                            <input type="date" class="form-control" id="tgl_transfer"
                                                                name="tgl_transfer">
                                                        </div>
                                                    </div>
                                                    <div id="giro" hidden>
                                                        <div class="mb-3">
                                                            <label for="no_giro" class="col-form-label fs-6">NO.
                                                                GIRO</label>
                                                            <input type="text" class="form-control" id="no_giro"
                                                                name="no_giro">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col mb-3">
                                                                <label for="tgl_terima_giro"
                                                                    class="col-form-label fs-6">TANGGAL
                                                                    TERIMA
                                                                    GIRO</label>
                                                                <input type="date" class="form-control"
                                                                    id="tgl_terima_giro" name="tgl_terima_giro">
                                                            </div>
                                                            <div class="col mb-3">
                                                                <label for="tgl_giro_cair"
                                                                    class="col-form-label fs-6">TANGGAL
                                                                    GIRO CAIR</label>
                                                                <input type="date" class="form-control"
                                                                    id="tgl_giro_cair" name="tgl_giro_cair">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="dana_masuk" class="col-form-label fs-6">DANA MASUK
                                                            (Rp)</label>
                                                        <input type="text" class="form-control" id="dana_masuk"
                                                            name="dana_masuk">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="type" class="col-form-label fs-6">TIPE
                                                            PEMBAYARAN</label>
                                                        <select class="form-select" id="type" required
                                                            name="type">
                                                            <option value="" hidden>Pilih Salah Satu</option>
                                                            <option value="DP">DP</option>
                                                            <option value="PROGRESS">PROGRESS</option>
                                                            <option value="PELUNASAN">PELUNASAN</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="status" class="col-form-label fs-6">STATUS</label>
                                                        <select class="form-select" id="status" required
                                                            name="status">
                                                            <option value="" hidden>Pilih Salah Satu</option>
                                                            <option value="BELUM DIBAYAR">BELUM DIBAYAR</option>
                                                            <option value="SUDAH DIBAYAR">SUDAH DIBAYAR</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-dark">SIMPAN</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary px-2 py-2 ms-3" data-bs-toggle="modal"
                                    data-bs-target="#ModalUploadProyek">
                                    <i class="bi bi-file-earmark-plus-fill"></i>
                                    <span class="ms-1 fs-6">Upload Transaksi</span>
                                </button>
                                <div class="modal fade" id="ModalUploadProyek" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Form Transaksi
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('finance-transaksi-upload') }}" method="POST"
                                                enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="formFileSm" class="form-label">Masukkan File
                                                            Transaksi</label>
                                                        <input class="form-control form-control-sm" id="formFileSm"
                                                            type="file" name="file">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-dark">SIMPAN</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class='table styled-table table-striped table-hover' id="table1">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA PROYEK</th>
                                    <th>NO. INVOICE</th>
                                    <th>BANK</th>
                                    <th>TGL CAIR / TRANSFER</th>
                                    <th>NO. GIRO</th>
                                    <th>TANGGAL TERIMA GIRO</th>
                                    <th>TANGGAL GIRO CAIR</th>
                                    <th>DANA MASUK</th>
                                    <th>TYPE</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi as $transaksi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaksi->nama_proyek }} [{{ $transaksi->kode_proyek }}]</td>
                                        {{-- <td>{{ $transaksi->no_invoice }}</td> --}}
                                        <td>{{ $transaksi->bank }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaksi->tgl_transfer)->format('d M Y') }}</td>
                                        <td>{{ $transaksi->no_giro ? $transaksi->no_giro : ' ' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaksi->tgl_terima_giro)->format('d M Y') ? $transaksi->tgl_terima_giro : ' ' }}
                                        <td>{{ \Carbon\Carbon::parse($transaksi->tgl_giro_cair)->format('d M Y') ? $transaksi->tgl_giro_cair : ' ' }}
                                        <td>@currency($transaksi->dana_masuk),- </td>
                                        <td>
                                            <span
                                                class="badge rounded-2 fs-6 {{ $transaksi->type == 'DP' ? 'bg-dp' : ($transaksi->type == 'PELUNASAN' ? 'bg-pelunasan' : 'bg-progress') }}">
                                                {{ $transaksi->type }}
                                            </span>
                                        </td>
                                        <td><span
                                                class="badge rounded-4 fs-6 {{ $transaksi->status == 'BELUM DIBAYAR' ? 'bg-danger' : 'bg-success' }}">
                                                {{ $transaksi->status }}
                                            </span> </td>
                                        <td><a href="#" data-bs-toggle="modal"
                                                data-bs-target="#editTransaksi{{ $transaksi->id }}"
                                                class="badge bg-warning rounded-2"><i data-feather="edit"
                                                    width="20"></a></td>
                                        <div class="modal fade" id="editTransaksi{{ $transaksi->id }}" tabindex="-1"
                                            aria-labelledby="editTransaksiModal" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-dark">
                                                        <h1 class="modal-title fs-5 text-white" id="editTransaksiModal">
                                                            FORM PERUBAHAN TRANSAKSI
                                                        </h1>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('transaksi.update', $transaksi->id) }}"
                                                        class="text-black" method="POST">
                                                        <div class="modal-body">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <label for="nama_proyek"
                                                                        class=" col-form-label fs-6">NAMA
                                                                        PROYEK</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $transaksi->nama_proyek }}" disabled
                                                                        required />
                                                                </div>
                                                                <div class="col mb-3">
                                                                    <label for="kode_proyek"
                                                                        class=" col-form-label fs-6">KODE
                                                                        PROYEK</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $transaksi->kode_proyek }}" disabled
                                                                        required />
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="no_invoice" class="col-form-label fs-6">NO.
                                                                    INVOICE</label>
                                                                <input type="text" class="form-control"
                                                                    id="no_invoice" required name="no_invoice"
                                                                    value="" disabled>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <label for="nama_bank"
                                                                        class="col-form-label fs-6">NAMA BANK</label>
                                                                    <select class="form-select" id="bank" required
                                                                        name="bank">
                                                                        <option value="BANK BRI"
                                                                            @if ($transaksi->bank == 'BANK BRI') selected @endif>
                                                                            BANK BRI</option>
                                                                        <option value="BANK BCA"
                                                                            @if ($transaksi->bank == 'BANK BCA') selected @endif>
                                                                            BANK BCA</option>
                                                                        <option value="BANK MANDIRI"
                                                                            @if ($transaksi->bank == 'BANK MANDIRI') selected @endif>
                                                                            BANK MANDIRI</option>
                                                                        <option value="BANK BNI"
                                                                            @if ($transaksi->bank == 'BANK BNI') selected @endif>
                                                                            BANK BNI</option>
                                                                        <option value="BANK OCBC NISP"
                                                                            @if ($transaksi->bank == 'BANK OCBC NISP') selected @endif>
                                                                            BANK OCBC NISP</option>
                                                                    </select>
                                                                </div>
                                                                @if ($transaksi->tgl_transfer != null)
                                                                    <div class="col mb-3">
                                                                        <label for="tgl_transfer"
                                                                            class="col-form-label fs-6">TANGGAL CAIR /
                                                                            TRANSFER
                                                                        </label>
                                                                        <input type="date" class="form-control"
                                                                            id="tgl_transfer" name="tgl_transfer"
                                                                            value="{{ $transaksi->tgl_transfer }}">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            @if ($transaksi->tgl_giro_cair != null)
                                                                <div>
                                                                    <div class="mb-3">
                                                                        <label for="no_giro"
                                                                            class="col-form-label fs-6">NO.
                                                                            GIRO</label>
                                                                        <input type="text" class="form-control"
                                                                            id="no_giro" name="no_giro"
                                                                            value="{{ $transaksi->no_giro }}">
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col mb-3">
                                                                            <label for="tgl_terima_giro"
                                                                                class="col-form-label fs-6">TANGGAL TERIMA
                                                                                GIRO</label>
                                                                            <input type="date" class="form-control"
                                                                                id="tgl_terima_giro"
                                                                                name="tgl_terima_giro"
                                                                                value="{{ $transaksi->tgl_terima_giro }}">
                                                                        </div>
                                                                        <div class="col mb-3">
                                                                            <label for="tgl_giro_cair"
                                                                                class="col-form-label fs-6">TANGGAL GIRO
                                                                                CAIR</label>
                                                                            <input type="date" class="form-control"
                                                                                id="tgl_giro_cair" name="tgl_giro_cair"
                                                                                value="{{ $transaksi->tgl_giro_cair }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="mb-3">
                                                                <label for="dana_masuk" class="col-form-label fs-6">DANA
                                                                    MASUK (Rp)</label>
                                                                <input type="text" class="form-control"
                                                                    id="dana_masuk" name="dana_masuk"
                                                                    value="{{ $transaksi->dana_masuk }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="type" class="col-form-label fs-6">TIPE
                                                                    PEMBAYARAN</label>
                                                                <select class="form-select" id="type" required
                                                                    name="type">>
                                                                    <option value="DP"
                                                                        @if ($transaksi->type == 'DP') selected @endif>
                                                                        DP</option>
                                                                    <option value="PROGRESS"
                                                                        @if ($transaksi->type == 'PROGRESS') selected @endif>
                                                                        PROGRESS</option>
                                                                    <option value="PELUNASAN"
                                                                        @if ($transaksi->type == 'PELUNASAN') selected @endif>
                                                                        PELUNASAN</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status"
                                                                    class="col-form-label fs-6">STATUS</label>
                                                                <select class="form-select" id="status" required
                                                                    name="status">
                                                                    <option value="BELUM DIBAYAR"
                                                                        @if ($transaksi->status == 'BELUM DIBAYAR') selected @endif>
                                                                        BELUM DIBAYAR</option>
                                                                    <option value="SUDAH DIBAYAR"
                                                                        @if ($transaksi->status == 'SUDAH DIBAYAR') selected @endif>
                                                                        SUDAH DIBAYAR</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-dark">SIMPAN
                                                                PERUBAHAN</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('sweetalert::alert')
        </section>
    </div>

    <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
    <script>
        var hargaInput = document.getElementById('dana_masuk');
        hargaInput.addEventListener('keyup', function(event) {
            // Hilangkan semua karakter selain angka
            var harga = this.value.replace(/\D/g, '');

            // Format harga dengan tanda koma setiap 3 angka
            harga = harga.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Set nilai input field
            this.value = harga;
        });
    </script>
    {{-- <script>
        const namaProyekSelect = document.getElementById('nama_proyek');
        const kodeProyekInput = document.getElementById('kode_proyek');

        // Tambahkan event listener ke select nama proyek
        namaProyekSelect.addEventListener('change', function() {
            // Ambil value dari pilihan yang dipilih
            const selectedOptionValue = this.value;
            // Set nilai input kode proyek sesuai dengan value dari pilihan yang dipilih
            kodeProyekInput.value = selectedOptionValue;
        });
    </script> --}}
    <script>
        const namaProyekInput = document.getElementById('nama_proyek');
        const kodeProyekInput = document.getElementById('kode_proyek');

        // Tambahkan event listener ke input nama proyek
        namaProyekInput.addEventListener('input', function() {
            // Ambil value dari opsi yang dipilih
            const selectedOption = document.querySelector(`#datalistOptions option[value="${this.value}"]`);
            // Jika opsi yang dipilih ditemukan
            if (selectedOption) {
                // Set nilai input kode proyek sesuai dengan value dari opsi yang dipilih
                kodeProyekInput.value = selectedOption.textContent;
            } else {
                // Jika opsi yang dipilih tidak ditemukan, reset nilai input kode proyek
                kodeProyekInput.value = '';
            }
        });
    </script>
    <script>
        const switchEl = document.getElementById('switch');
        const nonGiro = document.getElementById('nonGiro');
        const giro = document.getElementById('giro');

        switchEl.addEventListener('change', function() {
            if (this.checked) {
                // Switch is on (GIRO)
                nonGiro.hidden = true;
                giro.hidden = false
            } else {
                // Switch is off (NON-GIRO)
                nonGiro.hidden = false;
                giro.hidden = true;
            }
        });
    </script>
@endsection
