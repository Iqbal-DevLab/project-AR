@extends('layouts.dashboard')
@section('content')
    <style>
        .width-span {
            width: 150px;
        }

        .width-select {
            width: 350px;
        }
    </style>
    <x-page-title>
        <h4 class="text-capitalize">Halaman Sales</h4>
        <x-breadcrumb>
            <li class="breadcrumb-item active"><a href="#">Halaman Sales</a></li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <section>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div>
                                <button type="button" class="btn btn-primary px-2 me-3 py-2" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="bi bi-plus-circle"></i>
                                    <span class="ms-1 fs-6">Tambahkan Sales</span>
                                </button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark">
                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">FORM SALES
                                                </h1>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="/sales" method="POST">
                                                <div class="modal-body">
                                                    @csrf

                                                    <div class="mb-3">
                                                        <label for="nama_sales" class="col-form-label fs-6">NAMA</label>
                                                        <input type="text" class="form-control" id="nama_sales"
                                                            name="nama_sales" placeholder="Masukkan Nama Sales"
                                                            style="text-transform:uppercase"
                                                            oninput="this.value = this.value.toUpperCase()">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="type" class="col-form-label fs-6">TIPE</label>
                                                        <select class="form-select" id="type" required name="type">
                                                            <option value="" hidden>Pilih Salah Satu</option>
                                                            <option value="BUMN">BUMN</option>
                                                            <option value="SWASTA">SWASTA</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="contact_sales"
                                                            class="col-form-label fs-6">CONTACT</label>
                                                        <input type="number" class="form-control" id="contact_sales"
                                                            name="contact_sales" placeholder="Masukkan Contact Sales">
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-dark">SIMPAN</button>
                                                    </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <button type="button" class="btn btn-primary px-2 py-2" data-bs-toggle="modal"
                                data-bs-target="#modalTarget">
                                <i class="bi bi-plus-circle"></i>
                                <span class="ms-1 fs-6">Tambahkan Target</span>
                            </button>
                            <div class="modal fade" id="modalTarget" tabindex="-1" aria-labelledby="modalTargetLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark">
                                            <h1 class="modal-title fs-5 text-white" id="modalTargetLabel">FORM TARGET</h1>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="/salestarget" method="POST">
                                            <div class="modal-body">
                                                @csrf
                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <label>Nama Sales</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" aria-label="Default select example"
                                                            name="sales_id">
                                                            <option value="">Pilih</option>
                                                            @forelse ($sales as $i)
                                                                <option value="{{ $i->id }}">
                                                                    {{ $i->nama_sales }}</option>
                                                            @empty
                                                                <span>Data kosong</span>
                                                            @endforelse
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Target(Rp)</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="string" class="form-control" id="target"
                                                            name="target" placeholder="Masukkan Target Sales">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Tahun</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" aria-label="Default select example"
                                                            name="tahun">
                                                            <option value="">Pilih</option>
                                                            <option value="2023">2023</option>
                                                            {{-- <option value="2024">2024</option> --}}
                                                            <span>Data kosong</span>

                                                        </select>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-dark">SIMPAN</button>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class='table table-striped table-hover' id="table1">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA</th>
                                <th>TIPE</th>
                                <th>CONTACT</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sales)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sales->nama_sales }}</td>
                                    <td>{{ $sales->type }}</td>
                                    <td>{{ $sales->contact_sales }}</td>
                                    <td>

                                        <button type="submit" class="btn btn-success"><i data-feather="edit"
                                                width="20">
                                            </i> </button>
                                        <button type="submit" class="btn btn-danger"><i data-feather="trash-2"
                                                width="20">
                                            </i> </button>
                                    </td>
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
        var hargaInput = document.getElementById('target');
        hargaInput.addEventListener('keyup', function(event) {
            // Hilangkan semua karakter selain angka
            var harga = this.value.replace(/\D/g, '');

            // Format harga dengan tanda koma setiap 3 angka
            harga = harga.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Set nilai input field
            this.value = harga;
        });
    </script>
@endsection
