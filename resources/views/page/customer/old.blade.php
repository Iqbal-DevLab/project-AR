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
        <h3 class="text-capitalize">Halaman Customer</h3>
        <x-breadcrumb>
            <li class="breadcrumb-item active"><a href="#">Halaman Customer</a></li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <section>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div>
                                <button type="button" class="btn btn-primary px-2 py-2 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="bi bi-plus-circle"></i>
                                    <span class="ms-1 fs-6">Tambahkan Customer</span>
                                </button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Form Customer</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="/customer" method="POST">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Company Name</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" id="nama_customer" class="form-control"
                                                                name="nama_customer" pattern="[a-zA-Z ]+"
                                                                style="text-transform:uppercase"
                                                                oninput="this.value = this.value.toUpperCase()"
                                                                placeholder="PT Sinar Metrindo Perkasa">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Contact Name</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" id="nama_contact" class="form-control"
                                                                name="nama_contact" placeholder="Nama Pelanggan"
                                                                oninput="this.value = this.value.toUpperCase()">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <table class='table table-striped table-hover' id="table1">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>COMPANY NAME</th>
                                <th>CONTACT NAME</th>
                                {{-- <th>GRADE</th> --}}
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @php
                                $tgl_jatuh_tempo = Carbon\Carbon::parse($get->tgl_jatuh_tempo);
                                $tgl_transfer = Carbon\Carbon::parse($get->tgl_transfer);
                                
                                if ($tgl_jatuh_tempo->lessThan($tgl_transfer)) {
                                    $telat_hari = $tgl_jatuh_tempo->diffInDays($tgl_transfer, false);
                                } else {
                                    $telat_hari = 0;
                                }
                                $grade = '';
                                if ($telat_hari == 0) {
                                    $grade = 'A';
                                } elseif ($telat_hari <= 60) {
                                    $grade = 'B';
                                } elseif ($telat_hari <= 180) {
                                    $grade = 'C';
                                } else {
                                    $grade = 'D';
                                }
                            @endphp --}}
                            @foreach ($customer as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->nama_customer }}</td>
                                    <td>{{ $customer->nama_contact }}</td>
                                    {{-- <td><span class="badge rounded-2 bg-success">{{ $customer->nama_contact }}</span></td> --}}
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
        $(document).ready(function() {
            $('#detail').on('click', function() {
                let id = $(this).data('id');
                // let url = '/supervisor/detail-data/' + id;
                // $.ajax({
                //     url: url,
                //     type: 'GET',
                //     dataType: 'json',
                //     success: function(data) {
                //         $('#showData').modal('show');
                //         $('#id_proyek').val(data.detail[0].id);
                //     }
                // });
            });
        });
    </script>
@endsection
