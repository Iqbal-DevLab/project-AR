@extends('layouts.dashboard')
@section('content')
    <style>
        .width-span {
            width: 150px;
        }

        .width-select {
            width: 100px;
        }

        .width-select-tahun {
            width: 75px;
        }
    </style>
    <x-page-title>
        <h4 class="text-capitalize"></h4>
        <x-breadcrumb>
            <li class="breadcrumb-item active"><a href="#"></a></li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <section>
            <div class="row">
                <div class="card fs-5">
                    <div class="card-body">
                        <div class="card-title mb-5 mt-3">
                            <h4>Informasi Sales</h4>
                        </div>
                        <form class="d-flex mb-4" action="{{ route('getsalestarget') }}">

                            <span class="mx-1">Nama Sales</span>
                            <div class="mb-3 d-flex gap-3">
                                <select class="form-select width-select" aria-label="Default select example"
                                    name="sales_id">
                                    <option value="">Pilih</option>
                                    @forelse ($salesname as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama_sales }}</option>
                                    @empty
                                        <span>Data kosong</span>
                                    @endforelse
                                </select>
                                <span class="mx-1">Tahun</span>
                            </div>
                            <div class=" mb-3 d-flex gap-3">
                                <select class="form-select width-select-tahun" aria-label="Default select example"
                                    name="tahun">
                                    <option value="">Pilih</option>
                                    @forelse ($salest as $item)
                                        <option value="{{ $item->tahun }}">
                                            {{ $item->tahun }}</option>
                                    @empty
                                        <span>Data kosong</span>
                                    @endforelse
                                </select>
                                <button class="btn
                                            btn-primary"
                                    type="submit">Submit</button>
                            </div>
                        </form>
                        <div class="overflow-hidden">
                            @if ($sales != '')
                                @foreach ($sales as $item)
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <div class="p-1"><strong>Nama Sales</strong></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="p-1">{{ $item->nama_sales }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <div class="p-1"><strong>Target Sales</strong></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="p-1">

                                                @currency($item->target),-
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <div class="p-1"><strong>Target Tercapai</strong></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="p-1">

                                                @currency($item->target_tercapai),-
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-6 col-md-4">
                                            <div class="p-1"><strong>Tahun</strong></div>
                                        </div>
                                        <div class="col-sm-6 col-md-5">
                                            <div class="p-1">

                                                {{ $item->tahun }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card fs-5">
                    <div class="card-body">
                        <div class="card-title mt-3">
                            <h4>Data Setiap Bulan</h4>
                        </div>
                        <table class='table table-striped table-hover' id="table1">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Total Nilai Proyek</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($proyek != null)
                                    @foreach ($proyek as $p)
                                        <tr>
                                            <td>
                                                {{ \Carbon\Carbon::createFromDate(null, $p->bulan, null, 'UTC')->format('F') }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::createFromDate(null, $p->bulan, null, 'UTC')->format('Y') }}
                                            </td>
                                            <td>@currency($p->total),- </td>
                                        </tr>
                                    @endforeach
                                @endif
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
@endsection
