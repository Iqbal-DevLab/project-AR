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
                {{-- <a href="{{ route('sales-volume.pdf', ['tgl_awal' => request('tgl_awal'), 'tgl_akhir' => request('tgl_akhir')]) }}"
                    class="btn btn-sm btn-alt-primary"><i class="fa-solid fa-file-arrow-down"></i> Export to Pdf</a> --}}
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    @php
                        $categories = ['BUMN', 'SWASTA', 'PRESALES', 'SBY'];
                        $totalSemuaTarget = 0;
                        
                        $totalSemuaJan = 0;
                        $totalSemuaFeb = 0;
                        $totalSemuaMar = 0;
                        $totalSemuaApr = 0;
                        $totalSemuaMei = 0;
                        $totalSemuaJun = 0;
                        $totalSemuaJul = 0;
                        $totalSemuaAgs = 0;
                        $totalSemuaSep = 0;
                        $totalSemuaOkt = 0;
                        $totalSemuaNov = 0;
                        $totalSemuaDes = 0;
                        
                        $totalSemuaTotal = 0;
                        $totalSemuaVariance = 0;
                    @endphp
                    @foreach ($categories as $category)
                        <table class="table table-striped table-vcenter table-hover">
                            <h4>SALES {{ $category }}</h4>
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th class="text-center" style="width: 15%;">Sales</th>
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
                                    $totalJan = 0;
                                    $totalFeb = 0;
                                    $totalMar = 0;
                                    $totalApr = 0;
                                    $totalMei = 0;
                                    $totalJun = 0;
                                    $totalJul = 0;
                                    $totalAgs = 0;
                                    $totalSep = 0;
                                    $totalOkt = 0;
                                    $totalNov = 0;
                                    $totalDes = 0;
                                    
                                    $totalTarget = 0;
                                    $totalSemuaSales = 0;
                                    $totalVariance = 0;
                                @endphp
                                @foreach ($dataTarget as $data)
                                    @if ($data['type'] == $category)
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
                                            
                                            $totalJan += $jan;
                                            $totalFeb += $feb;
                                            $totalMar += $mar;
                                            $totalApr += $apr;
                                            $totalMei += $mei;
                                            $totalJun += $jun;
                                            $totalJul += $jul;
                                            $totalAgs += $ags;
                                            $totalSep += $sep;
                                            $totalOkt += $okt;
                                            $totalNov += $nov;
                                            $totalDes += $des;
                                            
                                            $totalTarget += $data['target'];
                                            $totalSemuaSales += $totalperSales;
                                            $totalVariance += $variance;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $data['nama_sales'] }}</td>
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
                                    @endif
                                @endforeach
                                @php
                                    $totalSemuaTarget += $totalTarget;
                                    $totalSemuaJan += $totalJan;
                                    $totalSemuaFeb += $totalFeb;
                                    $totalSemuaMar += $totalMar;
                                    $totalSemuaApr += $totalApr;
                                    $totalSemuaMei += $totalMei;
                                    $totalSemuaJun += $totalJun;
                                    $totalSemuaJul += $totalJul;
                                    $totalSemuaAgs += $totalAgs;
                                    $totalSemuaSep += $totalSep;
                                    $totalSemuaOkt += $totalOkt;
                                    $totalSemuaNov += $totalNov;
                                    $totalSemuaDes += $totalDes;
                                    $totalSemuaTotal += $totalSemuaSales;
                                    $totalSemuaVariance += $totalVariance;
                                @endphp
                            </tbody>

                            <tr>
                                <td class="text-center" style="font-weight: bold; width: 15%;">TOTAL
                                    SALES {{ $category }}</td>
                                <td class="font-w600">@currency($totalTarget),-</td>
                                <td class="font-w600">@currency($totalJan),-</td>
                                <td class="font-w600">@currency($totalFeb),-</td>
                                <td class="font-w600">@currency($totalMar),-</td>
                                <td class="font-w600">@currency($totalApr),-</td>
                                <td class="font-w600">@currency($totalMei),-</td>
                                <td class="font-w600">@currency($totalJun),-</td>
                                <td class="font-w600">@currency($totalJul),-</td>
                                <td class="font-w600">@currency($totalAgs),-</td>
                                <td class="font-w600">@currency($totalSep),-</td>
                                <td class="font-w600">@currency($totalOkt),-</td>
                                <td class="font-w600">@currency($totalNov),-</td>
                                <td class="font-w600">@currency($totalDes),-</td>
                                <td class="font-w600">@currency($totalSemuaSales),-</td>
                                <td class="font-w600">@currency($totalVariance),-</td>
                            </tr>
                    @endforeach


                    <tr class="">
                        <td class="text-center" style="font-weight: bold; width: 15%;">KUMULATIF SALES</td>
                        <td class="font-w600">@currency($totalSemuaTarget),-</td>
                        <td class="font-w600">@currency($totalSemuaJan),-</td>
                        <td class="font-w600">@currency($totalSemuaFeb),-</td>
                        <td class="font-w600">@currency($totalSemuaMar),-</td>
                        <td class="font-w600">@currency($totalSemuaApr),-</td>
                        <td class="font-w600">@currency($totalSemuaMei),-</td>
                        <td class="font-w600">@currency($totalSemuaJun),-</td>
                        <td class="font-w600">@currency($totalSemuaJul),-</td>
                        <td class="font-w600">@currency($totalSemuaAgs),-</td>
                        <td class="font-w600">@currency($totalSemuaSep),-</td>
                        <td class="font-w600">@currency($totalSemuaOkt),-</td>
                        <td class="font-w600">@currency($totalSemuaNov),-</td>
                        <td class="font-w600">@currency($totalSemuaDes),-</td>
                        <td class="font-w600">@currency($totalSemuaTotal),-</td>
                        <td class="font-w600">@currency($totalSemuaVariance),-</td>
                    </tr>

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
