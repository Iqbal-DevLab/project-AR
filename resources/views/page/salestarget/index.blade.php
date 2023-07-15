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
                                    <th class="text-center" style="width: 8%;">Target</th>
                                    <th class="text-center" style="width: 50px;">Januari</th>
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
                                            <td><span class="badge badge-transparent">@currency($data['target']),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($jan),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($feb),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($mar),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($apr),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($mei),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($jun),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($jul),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($ags),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($sep),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($okt),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($nov),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($des),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($totalperSales),-</span></td>
                                            <td><span class="badge badge-transparent">@currency($variance),-</span></td>
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
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalTarget),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalJan),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalFeb),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalMar),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalApr),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalMei),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalJun),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalJul),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalAgs),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalSep),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalOkt),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalNov),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalDes),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaSales),-</span></td>
                                <td class="font-w600"><span class="badge badge-transparent">@currency($totalVariance),-</span></td>
                            </tr>
                    @endforeach


                    <tr class="bg-warning">
                        <td class="text-center" style="font-weight: bold; width: 15%;">KUMULATIF SALES</td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaTarget),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaJan),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaFeb),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaMar),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaApr),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaMei),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaJun),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaJul),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaAgs),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaSep),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaOkt),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaNov),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaDes),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaTotal),-</span></td>
                        <td class="font-w600"><span class="badge badge-transparent">@currency($totalSemuaVariance),-</span></td>
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
