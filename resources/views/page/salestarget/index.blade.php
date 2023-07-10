@extends('layouts.dashboard')
@section('content')
    <style>
        .table td,
        .table th {
            font-size: 0.875rem;
        }
    </style>
    <div class="content tableExtraLarge">
        {{-- <h2 class="content-heading">Halaman Sales Volume</h2> --}}
        {{-- <div class="row row-deck gutters-tiny mb-3">
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
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="block shadow bg-white mt-3">
            <div class="block-header block-header-default">
                <h3 class="block-title">Data Table <small>Sales Target</small></h3>
                <a href="{{ route('sales-volume.pdf', ['tgl_awal' => request('tgl_awal'), 'tgl_akhir' => request('tgl_akhir')]) }}"
                    class="btn btn-sm btn-alt-primary"><i class="fa-solid fa-file-arrow-down"></i> Export pdf</a>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-bordered table-vcenter table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Sales</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Target</th>
                                <th class="text-center">Januari</th>
                                <th class="text-center">Februari</th>
                                <th class="text-center">Maret</th>
                                <th class="text-center">April</th>
                                <th class="text-center">Mei</th>
                                <th class="text-center">Juni</th>
                                <th class="text-center">Juli</th>
                                <th class="text-center">Agustus</th>
                                <th class="text-center">September</th>
                                <th class="text-center">Oktober</th>
                                <th class="text-center">November</th>
                                <th class="text-center">Desember</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Variance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalperSales = 0;
                            @endphp
                            @foreach ($dataTarget as $data)
                                @php
                                    $jan = isset($data['bulan_1']) ? $data['bulan_1'] : 0;
                                    $feb = isset($data['bulan_2']) ? $data['bulan_2'] : 0;
                                    $mar = isset($data['bulan_3']) ? $data['bulan_3'] : 0;
                                    $apr = isset($data['bulan_4']) ? $data['bulan_4'] : 0;
                                    $mei = isset($data['bulan_5']) ? $data['bulan_5'] : 0;
                                    $jun = isset($data['bulan_6']) ? $data['bulan_6'] : 0;
                                    $jul = isset($data['bulan_7']) ? $data['bulan_7'] : 0;
                                    $ags = isset($data['bulan_8']) ? $data['bulan_8'] : 0;
                                    $sep = isset($data['bulan_9']) ? $data['bulan_9'] : 0;
                                    $okt = isset($data['bulan_10']) ? $data['bulan_10'] : 0;
                                    $nov = isset($data['bulan_11']) ? $data['bulan_11'] : 0;
                                    $des = isset($data['bulan_12']) ? $data['bulan_12'] : 0;
                                    $totalperSales = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $ags + $sep + $okt + $nov + $des;
                                @endphp
                                <tr>
                                    <td>{{ $data['nama_sales'] }}</td>
                                    <td>{{ $data['type'] }}</td>
                                    <td>@currency($data['target']),-</td>
                                    <td>@currency($jan),-</td>
                                    <td>@currency($feb),-</td>
                                    <td>@currency($mar),-</td>
                                    <td>@currency($apr),-</td>
                                    <td>@currency($mei),-</td>
                                    <td>@currency($jun),-</td>
                                    <td>@currency($jul),-</td>
                                    <td>@currency($ags),-</td>
                                    <td>@currency($sep),-</td>
                                    <td>@currency($okt),-</td>
                                    <td>@currency($nov),-</td>
                                    <td>@currency($des),-</td>
                                    <td>@currency($totalperSales),-</td>
                                </tr>
                            @endforeach
                        </tbody>

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
