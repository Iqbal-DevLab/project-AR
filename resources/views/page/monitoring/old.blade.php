@extends('layouts.dashboard')
@section('content')
    <style>
        .width-select {
            width: 350px;
        }

        .width-span {
            .width-span {
                width: 150px;
            }
        }
    </style>
    <x-page-title>
        <h4 class="text-capitalize">Halaman Monitoring</h4>
        <x-breadcrumb>
            <li class="breadcrumb-item active"><a href="#">Halaman Monitoring</a></li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <section>
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <div class="card-title">
                            <form action="{{ route('monitoring.index') }}">
                                {{-- <span class="width-span"><strong>Nama Customer</strong></span> --}}
                                <div class=" mb-3 d-flex gap-3 col-xs-3">
                                    <select class="form-select width-select" aria-label="Default select example"
                                        name="nama_customer">
                                        <option value="">Pilih Nama Customer</option>
                                        @forelse ($customer as $i)
                                            <option value="{{ $i->nama_customer }}">
                                                {{ $i->nama_customer }}</option>
                                        @empty
                                            <span>Data kosong</span>
                                        @endforelse
                                    </select>
                                    <button class="btn btn-primary" type="submit"> SUBMIT</button>
                                </div>

                            </form>
                            <div style="text-align: center">
                                <h1>{{ request('nama_customer') }}</h1>
                            </div>
                        </div>
                        <table class='table table-striped' id="table1">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>KODE PROYEK</th>
                                    <th>NAMA PROYEK</th>
                                    <th>HARGA KONTRAK</th>
                                    <th>TANGGAL JATUH TEMPO</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gettable as $monitoring)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $monitoring->kode_proyek }}</td>
                                        <td>{{ $monitoring->nama_proyek }}</td>
                                        <td>@currency($monitoring->nilai_kontrak),-</td>
                                        <td>{{ \Carbon\Carbon::parse($monitoring->tgl_jatuh_tempo)->format('d F Y') }}
                                        <td>
                                            <a type="button" class="btn btn-primary"
                                                href="{{ route('monitoring.detail', ['id' => $monitoring->id, 'kode_proyek' => $monitoring->kode_proyek]) }} ">
                                                <i data-feather="info" width="20">
                                                </i> DETAIL
                                            </a>
                                        </td>
                                @endforeach
                                </tr>
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
