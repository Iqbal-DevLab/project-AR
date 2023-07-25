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
            font-size: 7px;
            margin: auto;
            background-color: white;
        }

        .fnt {
            font-family: Arial, sans-serif !important;
        }

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

        .periode-td {
            width: 50px;
        }

        /* Mengatur lebar kolom status menjadi 150px */
        .status-td {
            width: 50px;
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
        {{-- <div class="mb-3 text-left">
            <table>
                <tr>
                    <td class="periode-td">Periode</td>
                    <td>:</td>
                    <td>
                        @if (request('tgl_awal'))
                            {{ $tglAwal }} - {{ $tglAkhir }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="status-td">Status</td>
                    <td>:</td>
                    <td>
                        {{ request('status') }}
                </tr>
        </div> --}}
        <div>
            <table class="table table-bordered text-dark">
                <thead>
                    <tr class="table-primary small-row fnt font-weight-bold" style="font-size: 8px;">
                        <td>No</td>
                        <td class="text-center">Nama Customer</td>
                        <td class="text-center">Nama Proyek</td>
                        <td class="text-center">Sales</td>
                        <td class="text-center" style="width: 9%;">Harga Kontrak</td>
                        <td class="text-center" style="width: 8%;">Payment Terms</td>
                        <td class="text-center">Kode Proyek</td>
                        <td class="text-center">No Invoice</td>
                        <td class="text-center" style="width: 6%;">Tanggal TTK</td>
                        <td class="text-center">Progress</td>
                        <td class="text-center" style="width: 9%;">AR</td>
                        <td class="text-center" style="width: 11%;">Keterangan</td>
                        <td class="text-center">Jatuh Tempo</td>
                        <td class="text-center" style="width: 6%;">Tanggal JT</td>
                        <td class="text-center">Telat (Hari)</td>
                        <td class="text-center" style="width: 11%;">Pembayaran Sudah Diterima</td>
                    </tr>
                </thead>
                @php
                    $totalHargaKontrakKeseluruhan = 0;
                    $totalARKeseluruhan = 0;
                    $totalPembayaranSudahDiterimaKeseluruhan = 0;
                @endphp
                <tbody>
                    @php
                        $prevCustomer = null;
                        $prevProyek = null;
                        $totalNilaiKontrak = 0;
                        $totalAR = 0;
                        $totalPembayaranSudahDiterima = 0;
                    @endphp
                    @foreach ($results as $i)
                        @php
                            $sameCustomer = $prevCustomer === $i->nama_customer;
                            $prevCustomer = $i->nama_customer;
                            $sameProyek = $prevProyek === $i->nama_proyek;
                            $prevProyek = $i->nama_proyek;
                            $details = '';
                            if (!$sameCustomer) {
                                if ($prevCustomer !== null && $totalNilaiKontrak > 0 && $totalAR > 0) {
                                    echo '<tr class="small-row">';
                                    echo '<td></td>';
                                    echo '<td class="text-right font-weight-bold">Total</td>';
                                    echo '<td class="text-right font-weight-bold" colspan="3">Rp. ' . number_format($totalNilaiKontrak, 0, '.', '.') . ',-</td>';
                                    echo '<td class="text-right font-weight-bold" colspan="6">Rp. ' . number_format($totalAR, 0, '.', '.') . ',-</td>';
                                    echo '<td class="text-right font-weight-bold" colspan="5">Rp. ' . number_format($totalPembayaranSudahDiterima, 0, '.', '.') . ',-</td>';
                                    echo '</tr>';
                                }
                            
                                $totalNilaiKontrak = 0;
                                $totalAR = 0;
                                $totalPembayaranSudahDiterima = 0;
                            }
                            $totalNilaiKontrak += $i->nilai_kontrak;
                            $totalAR += $i->ar;
                            $totalPembayaranSudahDiterima += $i->pembayaranSudahDiterima;
                        @endphp
                        <tr class="small-row">
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">
                                @if (!$sameCustomer)
                                    {{ $i->nama_customer }}
                                @endif
                            </td>
                            <td class="text-center">{{ $i->nama_proyek }}</td>
                            <td class="text-center">{{ $i->nama_sales }}</td>
                            <td class="text-right">@currency($i->nilai_kontrak),-</td>
                            <td class="">
                                @if (!$sameProyek)
                                    @php
                                        $details = 'DP: ' . $i->DP;
                                        if ($i->APPROVAL) {
                                            $details .= '<br>APPROVAL: ' . $i->APPROVAL;
                                        }
                                        if ($i->BMOS) {
                                            $details .= '<br>BMOS: ' . $i->BMOS;
                                        }
                                        if ($i->AMOS) {
                                            $details .= '<br>AMOS: ' . $i->AMOS;
                                        }
                                        if ($i->TESTCOMM) {
                                            $details .= '<br>TESTCOMM: ' . $i->TESTCOMM;
                                        }
                                        if ($i->RETENSI) {
                                            $details .= '<br>RETENSI: ' . $i->RETENSI;
                                        }
                                    @endphp
                                @endif
                                {!! $details !!}
                            </td>
                            <td>{{ $i->kode_proyek }}</td>
                            <td class="text-center">{{ $i->no_invoice }}</td>
                            <td class="text-center font-italic">{{ $i->tgl_ttk }}</td>
                            <td class="text-center">{{ $i->progress }}</td>
                            <td class="text-right">@currency($i->ar),-</td>
                            <td class="text-center">{{ $i->keterangan }}</td>
                            <td class="text-center">{{ $i->batas_jatuh_tempo }}</td>
                            <td class="text-center font-italic">{{ $i->tgl_jatuh_tempo }}</td>
                            <td class="text-center">
                                @if (isset($i->tgl_jatuh_tempo))
                                    @php
                                        $tglJatuhTempo = \Carbon\Carbon::createFromFormat('d-m-Y', $i->tgl_jatuh_tempo);
                                        $tglSekarang = \Carbon\Carbon::now();
                                        $tglLunas = isset($i->tgl_lunas) ? \Carbon\Carbon::createFromFormat('d-m-Y', $i->tgl_lunas) : null;
                                        
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
                            <td class="text-right">@currency($i->pembayaranSudahDiterima),-</td>
                        </tr>
                    @endforeach
                    @if ($prevCustomer !== null)
                        <tr class="small-row">
                            <td></td>
                            <td class="text-right font-weight-bold">
                                Total
                            </td>
                            <td class="text-right font-weight-bold" colspan="3">Rp.
                                {{ number_format($totalNilaiKontrak, 0, '.', '.') }},-</td>
                            <td class="text-right font-weight-bold" colspan="6">Rp.
                                {{ number_format($totalAR, 0, '.', '.') }},-
                            </td>
                            <td class="text-right font-weight-bold" colspan="5">Rp.
                                {{ number_format($totalPembayaranSudahDiterima, 0, '.', '.') }},-</td>
                        </tr>
                    @endif
                    @foreach ($results as $i)
                        @php
                            $totalHargaKontrakKeseluruhan += $i->nilai_kontrak;
                            $totalARKeseluruhan += $i->ar;
                            $totalPembayaranSudahDiterimaKeseluruhan += $i->pembayaranSudahDiterima;
                        @endphp
                    @endforeach

                    {{-- Tampilkan total keseluruhan --}}
                    <tr class="small-row">
                        <td></td>
                        <td class="text-right font-weight-bold">
                            Total Keseluruhan
                        </td>
                        <td class="text-right font-weight-bold" colspan="3">Rp.
                            {{ number_format($totalHargaKontrakKeseluruhan, 0, '.', '.') }},-</td>
                        <td class="text-right font-weight-bold" colspan="6">Rp.
                            {{ number_format($totalARKeseluruhan, 0, '.', '.') }},-</td>
                        <td class="text-right font-weight-bold" colspan="5">Rp.
                            {{ number_format($totalPembayaranSudahDiterimaKeseluruhan, 0, '.', '.') }},-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset('/') }}public/js/codebase.app.min.js"></script>
</body>

</html>
