@extends('layouts.dashboard')
@section('content')
    <style>
        .table td,
        .table th {
            font-size: 0.875rem;
        }
    </style>
    <div class="content tableLarge">
        {{-- <h2 class="content-heading">Halaman Sales Volume</h2> --}}
        <div class="row row-deck gutters-tiny mb-3">
            <div class="col-md-6">
                <div class="block shadow bg-white">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Berdasarkan Tanggal</h3>
                    </div>
                    <div class="block-content">
                        <form action="{{ route('sales-volume.index') }}">
                            <div class="form-group row">
                                <label for="tgl_awal" class="col-lg-1 col-form-label"
                                    style="font-size: 0.875rem; max-width: 59px;">DARI</label>
                                <div class="col-md-4 input-group date align-items-center">
                                    <input type="text" class="js-datepicker form-control form-control-sm" id="tgl_awal"
                                        name="tgl_awal" autocomplete="off" data-week-start="1" data-autoclose="true"
                                        data-today-highlight="true" data-date-format="dd-mm-yyyy"
                                        value="{{ request('tgl_awal') }}" placeholder="dd-MM-yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text align-self-center"
                                            style="cursor:pointer; height:28px;"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_akhir" class="col-lg-1 col-form-label"
                                    style="font-size: 0.875rem; max-width: 59px; ">SAMPAI</label>
                                <div class="col-md-4 input-group date align-items-center">
                                    <input type="text" class="js-datepicker form-control form-control-sm" id="tgl_akhir"
                                        name="tgl_akhir" autocomplete="off" data-week-start="1" data-autoclose="true"
                                        data-today-highlight="true" data-date-format="dd-mm-yyyy"
                                        value="{{ request('tgl_akhir') }}" placeholder="dd-MM-yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text align-self-center"
                                            style="cursor:pointer; height:28px;"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-alt-primary align-self-center"><i
                                        class="fa fa-search"></i>
                                    Cari</button>
                                <a href="{{ route('sales-volume.index') }}"
                                    class="btn btn-sm btn-secondary fw-bold align-self-center"
                                    title="Refresh filter tanggal" type="button" id="refresh-filter-tanggal"><i
                                        class="fa-solid fa-rotate"></i> Refresh
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block shadow bg-white">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Informasi Sales Volume</h3>
                    </div>
                    <div class="block-content text-monospace" style="margin-bottom: 5%;">
                        <div class="col-lg-5">
                            <label for="total_sales_volume" class="form-label fs-6">Total Sales Volume</label>
                            <input type="text" readonly required placeholder=0
                                class="col-sm-12 col-md-6 col-xl-10 form-control" id="total_sales_volume"
                                name="total_sales_volume">
                        </div>
                        {{-- <div class="col-lg-5">
                            <label for="uang_muka" class="form-label fs-6">Uang Muka</label>
                            <input type="text" readonly required placeholder=0
                                class="col-sm-12 col-md-6 col-xl-10 form-control" id="uang_muka" name="uang_muka">
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="block shadow bg-white mt-3">
            <div class="block-header block-header-default">
                <h3 class="block-title">Data Table <small>Sales Volume</small></h3>
                <a href="{{ route('sales-volume.pdf', ['tgl_awal' => request('tgl_awal'), 'tgl_akhir' => request('tgl_akhir')]) }}"
                    class="btn btn-sm btn-alt-primary"><i class="fa-solid fa-file-arrow-down"></i> Download PDF</a>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter table-hover js-dataTable-full">
                        <thead>
                            <tr>
                                <th class="text-center">Proyek</th>
                                <th class="text-center">Customer</th>
                                <th class="text-center">Progress</th>
                                <th class="text-center" style="width: 15%;">Tanggal Invoice</th>
                                <th class="text-center">No. Invoice</th>
                                <th class="text-center" style="width: 15%;">Rp.(+PPN)</th>
                                <th class="text-center" style="width: 15%;">DPP</th>
                                <th class="text-center" style="width: 15%;">KOREKSI DP</th>
                                <th class="text-center" style="width: 15%;">Sales</th>
                                <th class="text-center" style="width: 15%;">Kode Proyek</th>
                                <th class="text-center" style="width: 15%;">Sales Volume</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($result as $sv)
                                @if (strpos($sv->progress, 'DP') === false)
                                    <tr>
                                        <td class="text-center">{{ $sv->nama_proyek }}</td>
                                        <td class="text-center">{{ $sv->nama_customer }}</td>
                                        <td class="text-center">{{ $sv->progress }}</td>
                                        <td class="text-center font-italic">{{ $sv->tgl_invoice }}</td>
                                        <td class="text-center">{{ $sv->no_invoice }}</td>
                                        <td class="text-center">@currency($sv->total_tagihan),-</td>
                                        <td class="text-center">@currency($sv->nilai_tagihan),-</td>
                                        <td class="text-center">@currency($sv->koreksi_dp),-</td>
                                        <td class="text-center">{{ $sv->nama_sales }}</td>
                                        <td class="text-center"> {{ $sv->kode_proyek }}
                                        </td>
                                        <td class="text-center"> @currency($sv->nilai_tagihan + $sv->koreksi_dp),-
                                        </td>
                                    </tr>
                                    @php
                                        $total += $sv->koreksi_dp + $sv->nilai_tagihan;
                                    @endphp
                                @endif
                            @endforeach
                        </tbody>
                        <span hidden id="total">@currency($total),-</span>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')

    <script>
        const total = document.getElementById('total');
        const totalSalesVolume = document.getElementById('total_sales_volume');

        totalSalesVolume.value = total.textContent;
        console.log(total.textContent);
    </script>
@endsection
