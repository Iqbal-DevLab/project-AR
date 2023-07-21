<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> --}}
    <link rel="stylesheet" id="css-main" href="{{ asset('/') }}public/css/codebase.min.css">

    @php
        $tglAwal = request('tgl_awal');
        $tglAkhir = request('tgl_akhir');
        $status = request('status');
    @endphp
    <title>Invoice {{ $tglAwal }} - {{ $tglAkhir }}</title>
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
            <h6>Invoice List</h6>
        </div>
        <div class="mb-3 text-left">
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
        </div>
        <div>
            <table class="table table-bordered text-dark">
                <thead>
                    <tr class="table-primary small-row">
                        <th class="text-center" style="width: 11%;">Invoice</th>
                        <th class="text-center" style="width: 9%;">Proyek</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Sales</th>
                        <th class="text-center">Progress</th>
                        <th class="text-center" style="width: 11%;">Nilai Tagihan</th>
                        <th class="text-center" style="width: 11%;">AR</th>
                        <th class="text-center" style="width: 8%;">Tanggal Invoice</th>
                        <th class="text-center" style="width: 8%;">Tanggal TTK</th>
                        <th class="text-center" style="width: 8%;">Tanggal JT</th>
                        <th class="text-center" style="width: 11%;">Status</th>
                        <th class="text-center" style="width: 11%;">Ket</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalTagihan = 0;
                        $totalAR = 0;
                    @endphp
                    @foreach ($result as $i)
                        <tr class="small-row">
                            {{-- <td class="text-center">{{ $loop->iteration }}</td> --}}
                            <td class="text-center">{{ $i->no_invoice }}</td>
                            <td class="text-center">{{ $i->nama_proyek }}</td>
                            <td class="text-center">{{ $i->kode_proyek }}</td>
                            <td class="text-center">{{ $i->nama_sales }}</td>
                            <td class="text-center">{{ $i->progress }}</td>
                            <td class="text-right">@currency($i->total_tagihan),-</td>
                            <td class="text-right">@currency($i->ar),-</td>
                            <td class="text-center font-italic">{{ $i->tgl_invoice }}</td>
                            <td class="text-center font-italic">{{ $i->tgl_ttk }}</td>
                            <td class="text-center font-italic">{{ $i->tgl_jatuh_tempo }}</td>
                            <td class="text-center">
                                <span class="badge badge-transparent">
                                    {{ $i->status }}
                                </span>
                            </td>
                            <td>{{ $i->keterangan }}</td>
                        </tr>
                        @php
                            $totalTagihan += $i->total_tagihan;
                            $totalAR += $i->ar;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="small-row">
                        <td colspan="5" class="text-center text-align-center" style="font-weight: bold;">Total</td>
                        <td class="text-right">@currency($totalTagihan),-</td>
                        <td class="text-right">@currency($totalAR),-</td>
                        <td colspan="5"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script src="{{ asset('/') }}public/js/codebase.app.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script> --}}
</body>

</html>
