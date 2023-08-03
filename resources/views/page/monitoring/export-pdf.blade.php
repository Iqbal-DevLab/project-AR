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
            font-size: 4.5px;
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

        /* Mengatur lebar kolom status menjadi 50px */
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
        <div>
            <table class="table table-bordered text-dark">
                <thead>
                    <tr class="table-primary small-row fnt font-weight-bold" style="font-size: 4.5px;">
                        <td>No</td>
                        <td class="text-center">Nama Customer</td>
                        <td class="text-center">Nama Proyek</td>
                        <td class="text-center">Sales</td>
                        <td class="text-center" style="width: 7%;">Harga Kontrak</td>
                        <td class="text-center" style="width: 6%;">Payment Terms</td>
                        <td class="text-center">Kode Proyek</td>
                        <td class="text-center">No Invoice</td>
                        <td class="text-center" style="width: 4%;">Tanggal TTK</td>
                        <td class="text-center">Progress</td>
                        <td class="text-center" style="width: 7%;">AR Invoice</td>
                        <td class="text-center" style="width: 11%;">Keterangan</td>
                        <td class="text-center">Jatuh Tempo</td>
                        <td class="text-center" style="width: 4%;">Tanggal JT</td>
                        <td class="text-center">Telat(Hari)</td>
                        <td class="text-center" style="width: 11%;">Sisa Tagihan</td>
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
                        $no = 1;
                        $totalNilaiKontrak = 0;
                        $totalAR = 0;
                        $totalPembayaranSudahDiterima = 0;
                    @endphp
                    @foreach ($monitoringTable as $data)
                        @foreach ($data['invoice'] as $index => $invoice)
                            @php
                                $prevCustomer = null;
                                $prevProyek = null;
                                $prevKeterangan = null;
                                $totalNilaiKontrak = 0;
                                $totalAR = 0;
                                $totalPembayaranSudahDiterima = 0;
                            @endphp
                            @if ($invoice->ar != 0)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>

                                        {{ $data['proyek']->nama_customer }}
                                    </td>
                                    <td>{{ $data['proyek']->nama_proyek }}</td>
                                    <td>{{ $data['proyek']->nama_sales }}</td>
                                    <td>{{ $data['proyek']->nilai_kontrak }}
                                    </td>
                                    <td>
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
                                        {!! $details !!}</td>
                                    <td>{{ $data['proyek']->kode_proyek }}</td>

                                    <td>{{ $invoice->no_invoice }}</td>
                                    <td>{{ $invoice->tgl_ttk }}</td>
                                    <td>{{ $invoice->progress }}</td>
                                    <td>{{ $invoice->ar }}</td>
                                    <td>{{ $data['proyek']->keterangan }}</td>
                                    <td>{{ $invoice->batas_jatuh_tempo ? $invoice->batas_jatuh_tempo . 'Hari' : '-' }}
                                    </td>
                                    <td>{{ $invoice->tgl_jatuh_tempo }}</td>
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
                                    <td>{{ $data['sisaTagihan'] }}</td>
                                    <td>{{ $data['pembayaranSudahDiterima'] }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
    <script src="{{ asset('/') }}public/js/codebase.app.min.js"></script>
</body>

</html>
