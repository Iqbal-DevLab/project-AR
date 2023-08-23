@extends('layouts.dashboard')
@section('content')
    <div class="content">
        {{-- <h2 class="content-heading">Halaman Customer</h2> --}}
        <div>

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
            <div class="modal fade" id="modal-customer" tabindex="-1" role="dialog" aria-labelledby="modal-customer"
                aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">FORM CUSTOMER</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="si si-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content">
                                <form action="{{ route('customer.store') }}" method="POST">
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
                                                <button type="submit" class="btn btn-square btn-dark min-width-125 mb-10">
                                                    <span class="ms-1 fs-6">SIMPAN</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="block shadow">
            <div class="block-header block-header-default">
                <h3 class="block-title">Data Table <small>Customer</small></h3>
                <div class="text-right">
                    <button type="button" class="btn btn-alt-primary min-width-125 mb-10" data-toggle="modal"
                        data-target="#modal-customer">
                        <i class="fa-solid fa-plus"></i>
                        <span class="ms-1 fs-6">Tambahkan Customer Baru</span>
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Customer</th>
                                <th>Nama Contact</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customer as $c)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $c->nama_customer }}</td>
                                    <td>{{ $c->nama_contact }}</td>
                                    <td class="text-center">
                                        <button type="button" data-toggle="modal"
                                            data-target="#edit-customer{{ $c->id }}"
                                            class="btn btn-sm btn-alt-primary" data-toggle="tooltip" title="Edit">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                    </td>
                                    <div class="modal fade" id="edit-customer{{ $c->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="edit-customer{{ $c->id }}-label"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="block block-themed block-transparent mb-0">
                                                    <div class="block-header bg-primary-dark">
                                                        <h3 class="block-title">EDIT CUSTOMER</h3>
                                                        <div class="block-options">
                                                            <button type="button" class="btn-block-option"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <i class="si si-close"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="block-content">
                                                        <form action="{{ route('customer.update', $c->id) }}"
                                                            method="POST">
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label>Company Name</label>
                                                                    </div>
                                                                    <div class="col-md-8 form-group">
                                                                        <input type="text" id="nama_customer"
                                                                            class="form-control" name="nama_customer"
                                                                            pattern="[a-zA-Z ]+" disabled
                                                                            style="text-transform:uppercase"
                                                                            oninput="this.value = this.value.toUpperCase()"
                                                                            placeholder="PT Sinar Metrindo Perkasa"
                                                                            value="{{ $c->nama_customer }}">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>Contact Name</label>
                                                                    </div>
                                                                    <div class="col-md-8 form-group">
                                                                        <input type="text" id="nama_contact"
                                                                            class="form-control" name="nama_contact"
                                                                            placeholder="Nama Pelanggan"
                                                                            oninput="this.value = this.value.toUpperCase()"
                                                                            value="{{ $c->nama_contact }}">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-alt-success">
                                                                            <i class="fa fa-check"></i> Simpan
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
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
    </div>
    @include('sweetalert::alert')
@endsection
