<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" id="css-main" href="{{ asset('/') }}public/css/codebase.min.css">
    @php
        $timezone = 'Asia/Jakarta';
        $timeNow = \Carbon\Carbon::now();
        $tglSekarang = \Carbon\Carbon::now($timezone)->format('d-m-Y');
    @endphp
    <title>AR Monitoring {{ $timeNow }}</title>
    <style>
        body {
            font-size: 5.0px;
            margin: auto;
            background-color: white;
        }

        .fnt {
            font-family: Arial, sans-serif !important;
        }

        /* lebar td */
        .small-row td,
        {
        padding: 2px;
        height: 20px;
        }

        .table th {
            text-align: center;
            height: 20px;
            padding: 2px;
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="text-dark">
        <div class="header mb-2">
            <img src="{{ public_path('assets/images/simetri-logo.png') }}" style="height: 30px; width: 100px;"
                alt="logo-simetri">
        </div>
        <div class="mb-3 text-center">
            <p class="fnt font-weight-bold" style="font-size: 9px;">Rekap AR Monitoring<br>{{ $tglSekarang }}</p>
        </div>
        <div>
            <table class="table table-bordered text-dark">
                <thead>
                    <tr class="table-primary small-row fnt font-weight-bold" style="font-size: 5.0px;">
                        <td>No</td>
                        <td class="text-center">Nama Customer</td>
                        <td class="text-center">Nama Proyek</td>
                        <td class="text-center">Sales</td>
                        <td class="text-center" style="width: 8%;">Harga Kontrak</td>
                        <td class="text-center" style="width: 6%;">Payment Terms</td>
                        <td class="text-center">Kode Proyek</td>
                        <td class="text-center">No Invoice</td>
                        <td class="text-center" style="width: 4%;">Tanggal TTK</td>
                        <td class="text-center">Progress</td>
                        <td class="text-center" style="width: 8%;">AR Invoice</td>
                        <td class="text-center" style="width: 10%;">Keterangan</td>
                        <td class="text-center">Jatuh Tempo</td>
                        <td class="text-center" style="width: 4%;">Tanggal JT</td>
                        <td class="text-center">Telat(Hari)</td>
                        <td class="text-center" style="width: 11%;">Sisa Tagihan</td>
                        <td class="text-center" style="width: 11%;">Pembayaran Sudah Diterima</td>
                    </tr>
                </thead>
                {{-- @php
                    $totalHargaKontrakKeseluruhan = 0;
                    $totalARKeseluruhan = 0;
                    $totalSisaTagihanKeseluruhan = 0;
                    $totalPembayaranSudahDiterimaKeseluruhan = 0;
                @endphp --}}
                <tbody>
                    @php
                        $no = 1;
                        $totalNilaiKontrak = 0;
                        $totalAR = 0;
                        $totalSisaTagihan = 0;
                        $totalPembayaranSudahDiterima = 0;
                        $prevCustomer = null;
                        $prevProyek = null;
                    @endphp
                    @foreach ($monitoringTable as $data)
                        @foreach ($data['invoice'] as $index => $invoice)
                            @if ($invoice->ar != 0)
                                @php
                                    $sameCustomer = $prevCustomer === $data['proyek']->nama_customer;
                                    $prevCustomer = $data['proyek']->nama_customer;
                                    $sameProyek = $prevProyek === $data['proyek']->nama_proyek;
                                    $prevProyek = $data['proyek']->nama_proyek;
                                    $details = '';
                                    if (!$sameCustomer) {
                                        if ($prevCustomer !== null && $totalNilaiKontrak > 0 && $totalAR > 0) {
                                            echo '<tr class="small-row">';
                                            echo '<td class="text-right font-weight-bold" colspan="2">Total</td>';
                                            echo '<td class="text-right font-weight-bold" colspan="3">Rp. ' . number_format($totalNilaiKontrak, 0, '.', '.') . ',-</td>';
                                            echo '<td class="text-right font-weight-bold" colspan="6">Rp. ' . number_format($totalAR, 0, '.', '.') . ',-</td>';
                                            echo '<td class="text-right font-weight-bold" colspan="5">Rp. ' . number_format($totalSisaTagihan, 0, '.', '.') . ',-</td>';
                                            echo '<td class="text-right font-weight-bold" colspan="1">Rp. ' . number_format($totalPembayaranSudahDiterima, 0, '.', '.') . ',-</td>';
                                            echo '</tr>';
                                        }
                                    
                                        $totalNilaiKontrak = 0;
                                        $totalAR = 0;
                                        $totalSisaTagihan = 0;
                                        $totalPembayaranSudahDiterima = 0;
                                    }
                                    // if (!$sameProyek) {
                                    $totalNilaiKontrak += $data['proyek']->nilai_kontrak;
                                    // }
                                    $totalSisaTagihan += $data['sisaTagihan'];
                                    $totalAR += $invoice->ar;
                                    
                                    if (!$sameProyek) {
                                        $totalPembayaranSudahDiterima += $data['pembayaranSudahDiterima'];
                                    }
                                @endphp
                                <tr class="small-row">
                                    <td>{{ $no++ }}</td>
                                    <td class="border-0">
                                        @if (!$sameCustomer)
                                            {{ $data['proyek']->nama_customer }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$sameProyek)
                                            {{ $data['proyek']->nama_proyek }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$sameProyek)
                                            {{ $data['proyek']->nama_sales }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if (!$sameProyek)
                                            @currency($data['proyek']->nilai_kontrak),-
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$sameProyek)
                                            @php
                                                $details = 'DP: ' . $data['proyek']->DP;
                                                if ($data['proyek']->APPROVAL) {
                                                    $details .= '<br>APPROVAL: ' . $data['proyek']->APPROVAL;
                                                }
                                                if ($data['proyek']->BMOS) {
                                                    $details .= '<br>BMOS: ' . $data['proyek']->BMOS;
                                                }
                                                if ($data['proyek']->AMOS) {
                                                    $details .= '<br>AMOS: ' . $data['proyek']->AMOS;
                                                }
                                                if ($data['proyek']->TESTCOMM) {
                                                    $details .= '<br>TESTCOMM: ' . $data['proyek']->TESTCOMM;
                                                }
                                                if ($data['proyek']->RETENSI) {
                                                    $details .= '<br>RETENSI: ' . $data['proyek']->RETENSI;
                                                }
                                            @endphp
                                            {!! $details !!}
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$sameProyek)
                                            {{ $data['proyek']->kode_proyek }}
                                        @endif
                                    </td>
                                    <td>{{ $invoice->no_invoice }}</td>
                                    <td>{{ $invoice->tgl_ttk ? $invoice->tgl_ttk : '-' }}</td>
                                    <td>{{ $invoice->progress }}</td>
                                    <td class="text-right">@currency($invoice->ar),-</td>
                                    <td>
                                        @if (!$sameProyek)
                                            {{ $data['proyek']->keterangan }}
                                        @endif
                                    </td>
                                    <td>{{ $invoice->batas_jatuh_tempo ? $invoice->batas_jatuh_tempo . 'Hari' : '-' }}
                                    </td>
                                    <td>{{ $invoice->tgl_jatuh_tempo ? $invoice->tgl_jatuh_tempo : '-' }}</td>
                                    <td>
                                        @if (isset($invoice->tgl_jatuh_tempo))
                                            @php
                                                $tglJatuhTempo = \Carbon\Carbon::createFromFormat('d-m-Y', $invoice->tgl_jatuh_tempo);
                                                $tglSekarang = \Carbon\Carbon::now();
                                                $tglLunas = isset($invoice->tgl_lunas) ? \Carbon\Carbon::createFromFormat('d-m-Y', $invoice->tgl_lunas) : null;
                                                
                                                if ($tglLunas) {
                                                    $telatHari = max(0, $tglJatuhTempo->diffInDays($tglLunas, false));
                                                    echo $telatHari . ' Hari';
                                                } else {
                                                    $telatHari = max(0, $tglJatuhTempo->diffInDays($tglSekarang, false));
                                                    echo $telatHari . ' Hari';
                                                }
                                            @endphp
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if (!$sameProyek)
                                            @currency($data['sisaTagihan']),-
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if (!$sameProyek)
                                            @currency($data['pembayaranSudahDiterima']),-
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                    @if ($prevCustomer !== null && $totalNilaiKontrak > 0 && $totalAR > 0)
                        <tr class="small-row">
                            <td class="text-right font-weight-bold" colspan="2">
                                Total
                            </td>
                            <td class="text-right font-weight-bold" colspan="3">
                                Rp.
                                {{ number_format($totalNilaiKontrak, 0, '.', '.') }},-
                            </td>
                            <td class="text-right font-weight-bold" colspan="6">Rp.
                                {{ number_format($totalAR, 0, '.', '.') }},-
                            </td>
                            <td class="text-right font-weight-bold" colspan="5">
                                Rp.
                                {{ number_format($totalSisaTagihan, 0, '.', '.') }},-
                            </td>
                            <td class="text-right font-weight-bold" colspan="1">
                                Rp.
                                {{ number_format($totalPembayaranSudahDiterima, 0, '.', '.') }},-
                            </td>
                        </tr>
                    @endif
                    @php
                        $totalHargaKontrakKeseluruhan = 0;
                        $totalARKeseluruhan = 0;
                        $totalSisaTagihanKeseluruhan = 0;
                        $totalPembayaranSudahDiterimaKeseluruhan = 0;
                    @endphp

                    @foreach ($monitoringTable as $data)
                        @php
                            $totalNilaiKontrak = 0;
                            $totalAR = 0;
                            $totalSisaTagihan = 0;
                            $totalPembayaranSudahDiterima = 0;
                            $prevProyek = null;
                        @endphp

                        @foreach ($data['invoice'] as $index => $invoice)
                            @if ($invoice->ar != 0)
                                @php
                                    $sameProyek = $prevProyek === $data['proyek']->nama_proyek;
                                    $prevProyek = $data['proyek']->nama_proyek;
                                    // if (!$sameProyek) {
                                    $totalNilaiKontrak += $data['proyek']->nilai_kontrak;
                                    // }
                                    $totalAR += $invoice->ar;
                                    $totalSisaTagihan += $data['sisaTagihan'];
                                    if (!$sameProyek) {
                                        $totalPembayaranSudahDiterima += $data['pembayaranSudahDiterima'];
                                    }
                                @endphp
                            @endif
                        @endforeach

                        @php
                            $totalHargaKontrakKeseluruhan += $totalNilaiKontrak;
                            $totalARKeseluruhan += $totalAR;
                            $totalSisaTagihanKeseluruhan += $totalSisaTagihan;
                            $totalPembayaranSudahDiterimaKeseluruhan += $totalPembayaranSudahDiterima;
                        @endphp
                    @endforeach

                    {{-- Tampilkan total keseluruhan di luar loop --}}
                    <tr class="small-row">
                        <td class="text-right font-weight-bold" colspan="2">
                            Total Keseluruhan
                        </td>
                        <td class="text-right font-weight-bold" colspan="3">Rp.
                            {{ number_format($totalHargaKontrakKeseluruhan, 0, '.', '.') }},-
                        </td>
                        <td class="text-right font-weight-bold" colspan="6">Rp.
                            {{ number_format($totalARKeseluruhan, 0, '.', '.') }},-
                        </td>
                        <td class="text-right font-weight-bold" colspan="5">Rp.
                            {{ number_format($totalSisaTagihanKeseluruhan, 0, '.', '.') }},-
                        </td>
                        <td class="text-right font-weight-bold" colspan="1">Rp.
                            {{ number_format($totalPembayaranSudahDiterimaKeseluruhan, 0, '.', '.') }},-
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    <script src="{{ asset('/') }}public/js/codebase.app.min.js"></script>
</body>

</html>
