@extends('layouts.dashboard')
@section('content')
    <div class="content">
        {{-- <h2 class="content-heading">Halaman Sales</h2> --}}
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
            <div>
                <div class="modal fade" id="modal-sales" tabindex="-1" role="dialog" aria-labelledby="modal-sales"
                    aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="block block-themed block-transparent mb-0">
                                <div class="block-header bg-primary-dark">
                                    <h3 class="block-title">FORM SALES</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-dismiss="modal"
                                            aria-label="Close">
                                            <i class="si si-close"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <form action="{{ route('sales.store') }}" method="POST">
                                        <div class="modal-body">
                                            @csrf
                                            {{-- <!-- Progress Wizard 2 -->
                                                <div class="js-wizard-simple block">
                                                    <!-- Wizard Progress Bar -->
                                                    <div class="progress rounded-0" data-wizard="progress"
                                                        style="height: 8px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                            role="progressbar" style="width: 30%;" aria-valuenow="30"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <!-- END Wizard Progress Bar -->

                                                    <!-- Step Tabs -->
                                                    <ul class="nav nav-tabs nav-tabs-alt nav-fill" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" href="#wizard-progress2-step1"
                                                                data-toggle="tab">1. Personal</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#wizard-progress2-step2"
                                                                data-toggle="tab">2. Details</a>
                                                        </li>
                                                    </ul>
                                                    <!-- END Step Tabs -->

                                                    <!-- Form -->
                                                    <form action="be_forms_wizard.html" method="post">
                                                        <!-- Steps Content -->
                                                        <div class="block-content block-content-full tab-content"
                                                            style="min-height: 274px;">
                                                            <!-- Step 1 -->
                                                            <div class="tab-pane active" id="wizard-progress2-step1"
                                                                role="tabpanel">
                                                                <div class="form-group">
                                                                    <div class="form-material floating">
                                                                        <input class="form-control" type="text"
                                                                            id="wizard-progress2-firstname"
                                                                            name="wizard-progress2-firstname">
                                                                        <label for="wizard-progress2-firstname">First
                                                                            Name</label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-material floating">
                                                                        <input class="form-control" type="text"
                                                                            id="wizard-progress2-lastname"
                                                                            name="wizard-progress2-lastname">
                                                                        <label for="wizard-progress2-lastname">Last
                                                                            Name</label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-material floating">
                                                                        <input class="form-control" type="email"
                                                                            id="wizard-progress2-email"
                                                                            name="wizard-progress2-email">
                                                                        <label for="wizard-progress2-email">Email</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END Step 1 -->

                                                            <!-- Step 3 -->
                                                            <div class="tab-pane" id="wizard-progress2-step2"
                                                                role="tabpanel">
                                                                <div class="form-group">
                                                                    <div class="form-material floating">
                                                                        <input class="form-control" type="text"
                                                                            id="wizard-progress2-location"
                                                                            name="wizard-simple2-location">
                                                                        <label
                                                                            for="wizard-simple2-location">Location</label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="form-material floating">
                                                                        <select class="form-control"
                                                                            id="wizard-progress2-skills"
                                                                            name="wizard-progress2-skills" size="1">
                                                                            <option></option>
                                                                            <!-- Empty value for demostrating material select box -->
                                                                            <option value="1">Photoshop</option>
                                                                            <option value="2">HTML</option>
                                                                            <option value="3">CSS</option>
                                                                            <option value="4">JavaScript</option>
                                                                        </select>
                                                                        <label for="wizard-progress2-skills">Skills</label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label
                                                                        class="css-control css-control-primary css-switch"
                                                                        for="wizard-progress2-terms">
                                                                        <input type="checkbox" class="css-control-input"
                                                                            id="wizard-progress2-terms"
                                                                            name="wizard-progress2-terms">
                                                                        <span class="css-control-indicator"></span> Agree
                                                                        with the terms
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <!-- END Step 3 -->
                                                        </div>
                                                        <!-- END Steps Content -->

                                                        <!-- Steps Navigation -->
                                                        <div
                                                            class="block-content block-content-sm block-content-full bg-body-light">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <button type="button" class="btn btn-alt-secondary"
                                                                        data-wizard="prev">
                                                                        <i class="fa fa-angle-left mr-5"></i> Previous
                                                                    </button>
                                                                </div>
                                                                <div class="col-6 text-right">
                                                                    <button type="button" class="btn btn-alt-secondary"
                                                                        data-wizard="next">
                                                                        Next <i class="fa fa-angle-right ml-5"></i>
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="btn btn-alt-primary d-none"
                                                                        data-wizard="finish">
                                                                        <i class="fa fa-check mr-5"></i> Submit
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- END Steps Navigation -->
                                                    </form>
                                                    <!-- END Form -->
                                                </div>
                                                <!-- END Progress Wizard 2 --> --}}
                                            <div class="mb-3">
                                                <label for="nama_sales" class="col-form-label fs-6">NAMA</label>
                                                <input type="text" class="form-control" id="nama_sales" name="nama_sales"
                                                    placeholder="Masukkan Nama Sales" style="text-transform:uppercase"
                                                    oninput="this.value = this.value.toUpperCase()">
                                            </div>
                                            <div class="mb-3">
                                                <label for="type" class="col-form-label fs-6">TIPE</label>
                                                <select class="form-control" id="type" name="type">
                                                    <option value="" hidden>--Pilih Tipe--</option>
                                                    <option value="SWASTA">SWASTA</option>
                                                    <option value="BUMN">BUMN</option>
                                                    <option value="SBY">SBY</option>
                                                    <option value="PRESALES">PRESALES</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="contact_sales" class="col-form-label fs-6">CONTACT</label>
                                                <input type="number" class="form-control" id="contact_sales"
                                                    name="contact_sales" placeholder="Masukkan Contact Sales">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-square btn-dark min-width-125 mb-10">
                                                    <span class="ms-1 fs-6">SIMPAN</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="modal fade" id="modal-target" tabindex="-1" role="dialog" aria-labelledby="modal-target"
                    aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="block block-themed block-transparent mb-0">
                                <div class="block-header bg-primary-dark">
                                    <h3 class="block-title">FORM SALES</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-dismiss="modal"
                                            aria-label="Close">
                                            <i class="si si-close"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <form action="{{ route('sales-target.store') }}" method="POST">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Nama Sales</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <select class="form-control" aria-label="Default select example"
                                                        name="sales_id">
                                                        <option value="" hidden>--Pilih Nama Sales--</option>
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
                                                    <input type="string" class="form-control" id="target" name="target"
                                                        placeholder="Masukkan Target Sales">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Tahun</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <select class="form-control" aria-label="Default select example"
                                                        name="tahun">
                                                        <option value="" hidden>--Pilih Tahun--</option>
                                                        <option value="2023">2023</option>
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        class="btn btn-square btn-dark min-width-125 mb-10">
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

        </div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Data Table <small>Sales</small></h3>
                <div class="text-right">
                    <button type="button" class="btn btn-alt-primary min-width-125 mb-10" data-toggle="modal"
                        data-target="#modal-sales">
                        <i class="fa-solid fa-plus"></i>
                        <span class="ms-1 fs-6">Tambahkan Sales</span>
                    </button>
                    <button type="button" class="btn btn-alt-primary min-width-125 mb-10" data-toggle="modal"
                        data-target="#modal-target">
                        <i class="fa-solid fa-plus"></i>
                        <span class="ms-1 fs-6">Tambahkan Target</span>
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-hover table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Target</th>
                            <th class="text-center">Tahun</th>
                            <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Tipe</th>
                            <th class="text-center" style="width: 100px;">Contact</th>
                            <th class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $s)
                            <tr>
                                <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                <td class="text-center">{{ $s->nama_sales }}</td>
                                <td class="text-center">
                                    {{ isset($s->target) ? 'Rp. ' . number_format($s->target, 0, ',', '.') . ',-' : '-' }}
                                </td>
                                <td class="text-center">{{ $s->tahun ? $s->tahun : '-' }}</td>
                                <td class="text-center">{{ $s->type }}</td>
                                <td class="text-center">{{ $s->contact_sales }}</td>
                                <td class="text-center"><button data-toggle="modal"
                                        data-target="#editSales{{ $s->id }}" title="Edit"
                                        class="btn btn-sm btn-alt-primary"><i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                </td>
                                <div class="modal fade" id="editSales{{ $s->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="editSalesModal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-popout" role="document">
                                        <div class="modal-content">
                                            <div class="block block-themed block-transparent mb-0">
                                                <div class="block-header bg-primary-dark">
                                                    <h3 class="block-title">Edit Sales</h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <i class="si si-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="block-content">
                                                    <form action="{{ route('sales.update', $s->id) }}" class="text-black"
                                                        method="POST">
                                                        <div class="modal-body">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="nama_sales"
                                                                    class="col-form-label fs-6">NAMA</label>
                                                                <input type="text" class="form-control"
                                                                    id="nama_sales" name="nama_sales"
                                                                    placeholder="Masukkan Nama Sales"
                                                                    style="text-transform:uppercase"
                                                                    oninput="this.value = this.value.toUpperCase()"
                                                                    value="{{ $s->nama_sales }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="type"
                                                                    class="col-form-label fs-6">TIPE</label>
                                                                <select class="form-control" id="type"
                                                                    name="type">
                                                                    <option value="" hidden>--Pilih Tipe--</option>
                                                                    <option value="BUMN"
                                                                        @if ($s->type == 'BUMN') selected @endif>
                                                                        BUMN</option>
                                                                    <option value="SWASTA"
                                                                        @if ($s->type == 'SWASTA') selected @endif>
                                                                        SWASTA</option>
                                                                    <option value="SBY"
                                                                        @if ($s->type == 'SBY') selected @endif>
                                                                        SBY</option>
                                                                    <option value="PRESALES"
                                                                        @if ($s->type == 'PRESALES') selected @endif>
                                                                        PRESALES</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="contact_sales"
                                                                    class="col-form-label fs-6">CONTACT</label>
                                                                <input type="number" class="form-control"
                                                                    id="contact_sales" name="contact_sales"
                                                                    placeholder="Masukkan Contact Sales"
                                                                    value="{{ $s->contact_sales }}">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-alt-success">
                                                                    <i class="fa fa-check"></i> Simpan
                                                                </button>
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
        @include('sweetalert::alert')
    @endsection
