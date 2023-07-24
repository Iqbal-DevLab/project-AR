<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" id="css-main" href="{{ asset('/') }}public/css/codebase.min.css">

    {{-- <title>Invoice {{ $tglAwal }} - {{ $tglAkhir }}</title> --}}
    <style>
        body {
            font-size: 7px;
            margin: auto;
            background-color: white;
            /* font-family: Arial, Helvetica, sans-serif !important; */
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
            <h6>Rekap AR Monitoring</h6>
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
                    <tr class="table-primary small-row">
                        <th>No</th>
                        <th class="text-center">Nama Customer</th>
                        <th class="text-center">Nama Proyek</th>
                        <th class="text-center">Sales</th>
                        <th class="text-center" style="width: 9%;">Harga Kontrak</th>
                        <th class="text-center" style="width: 7%;">Payment Terms</th>
                        <th class="text-center">Kode Proyek</th>
                        <th class="text-center">No Invoice</th>
                        <th class="text-center" style="width: 6%;">Tanggal TTK</th>
                        <th class="text-center">Progress</th>
                        <th class="text-center" style="width: 9%;">AR</th>
                        <th class="text-center" style="width: 11%;">Keterangan</th>
                        <th class="text-center">Jatuh Tempo</th>
                        <th class="text-center" style="width: 6%;">Tanggal JT</th>
                        <th class="text-center">Telat (Hari)</th>
                        <th class="text-center" style="width: 11%;">Pembayaran Sudah Diterima</th>
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
                                    echo '<td class="text-right"><strong>Total</strong></td>';
                                    echo '<td class="text-right" colspan="3"><strong>Rp. ' . number_format($totalNilaiKontrak) . ',-</strong></td>';
                                    echo '<td class="text-right" colspan="6"><strong>Rp. ' . number_format($totalAR) . ',-</strong></td>';
                                    echo '<td class="text-right" colspan="5"><strong>Rp. ' . number_format($totalPembayaranSudahDiterima) . ',-</strong></td>';
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
                            <td class="text-right">
                                <strong>Total</strong>
                            </td>
                            <td class="text-right" colspan="3"><strong>Rp.
                                    {{ number_format($totalNilaiKontrak) }},-</strong></td>
                            <td class="text-right" colspan="6"><strong>Rp. {{ number_format($totalAR) }},-</strong>
                            </td>
                            <td class="text-right" colspan="5"><strong>Rp.
                                    {{ number_format($totalPembayaranSudahDiterima) }},-</strong></td>
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
                        <td class="text-right">
                            <strong>Total Keseluruhan</strong>
                        </td>
                        <td class="text-right" colspan="3"><strong>Rp.
                                {{ number_format($totalHargaKontrakKeseluruhan) }},-</strong></td>
                        <td class="text-right" colspan="6"><strong>Rp.
                                {{ number_format($totalARKeseluruhan) }},-</strong></td>
                        <td class="text-right" colspan="5"><strong>Rp.
                                {{ number_format($totalPembayaranSudahDiterimaKeseluruhan) }},-</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset('/') }}public/js/codebase.app.min.js"></script>
</body>

</html>
