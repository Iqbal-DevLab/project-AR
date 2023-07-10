@extends('layouts.dashboard')
@section('content')
    <style>
        .table td,
        .table th {
            font-size: 0.875rem;
        }
    </style>
    <div class="content tableExtraLarge">
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
                                    $variance = $data['target'] - $totalperSales;
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
                                    <td>@currency($variance),-</td>
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
