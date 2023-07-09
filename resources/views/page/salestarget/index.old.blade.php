@extends('layouts.dashboard')
@section('content')
    <div class="content">
        <h2 class="content-heading">Halaman Sales Target</h2>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Data Table <small>Sales Target</small></h3>
            </div>
            <div class="block-content block-content-full">
                <form class="d-flex mb-4" action="{{ route('sales-target.index') }}">

                    <span class="mx-1">Nama Sales</span>
                    <div class="mb-3 d-flex gap-3">
                        <select class="form-control width-select" aria-label="Default select example" name="sales_id">
                            <option value="">Pilih</option>
                            {{-- @forelse ($salesname as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama_sales }}</option>
                            @empty
                                <span>Data kosong</span>
                            @endforelse --}}
                        </select>
                        <span class="mx-1">Tahun</span>
                    </div>
                    <div class=" mb-3 d-flex gap-3">
                        <select class="form-control width-select-tahun" aria-label="Default select example" name="tahun">
                            <option value="">Pilih</option>
                            {{-- @forelse ($salest as $item)
                                <option value="{{ $item->tahun }}">
                                    {{ $item->tahun }}</option>
                            @empty
                                <span>Data kosong</span>
                            @endforelse --}}
                        </select>
                        <button class="btn
                                            btn-primary" type="submit">
                            <i class="fa fa-search me-1"></i>
                            <span class="ms-1 fs-6"></span>
                        </button>
                    </div>
                </form>
                <div class="overflow-hidden">
                    {{-- @if ($sales != '')
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
                    @endif --}}
                </div>
                <table class="table table-bordered table-hover table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Bulan</th>
                            <th style="width: 15%;">Tahun</th>
                            <th>Total Nilai Proyek</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @if ($proyek != null)
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
                        @endif --}}
                    </tbody>
                </table>
            </div>
        </div>
        @include('sweetalert::alert')
    @endsection
