<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    @php
        $tglAwal = request('tgl_awal');
        $tglAkhir = request('tgl_akhir');
    @endphp
    <title>Sales Volume {{ $tglAwal }} - {{ $tglAkhir }}</title>
    <style>
        body {
            font-size: 7px;
            margin: auto;
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
    </style>
</head>

<body>
    <div class="">
        <div class="header mb-2">
            <img src="{{ public_path('assets/images/simetri-logo.png') }}" style="height: 30px; width: 110px;"
                alt="logo-simetri">
        </div>
        <div class="mb-3 text-center">
            <h6>Sales Volume </h6>
            <p>{{ $tglAwal }} - {{ $tglAkhir }}</p>
        </div>
        <div>
            <table class="table table-bordered">
                <thead>
                    <tr class="table-primary small-row">
                        <th class="text-center">No</th>
                        <th class="text-center">Proyek</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Progress</th>
                        <th class="text-center" style="width: 9%;">Tanggal Invoice</th>
                        <th class="text-center" style="width: 11%;">No. Invoice</th>
                        <th class="text-center" style="width: 11%;">Rp.(+PPN)</th>
                        <th class="text-center" style="width: 11%;">DPP</th>
                        <th class="text-center" style="width: 11%;">Koreksi DP</th>
                        <th class="text-center">Sales</th>
                        <th class="text-center">Kode Proyek</th>
                        <th class="text-center" style="width: 11%;">Sales Volume</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($result as $sv)
                        @if (strpos($sv->progress, 'DP') === false)
                            <tr class="small-row">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $sv->nama_proyek }}</td>
                                <td class="text-center">{{ $sv->nama_customer }}</td>
                                <td class="text-center">{{ $sv->progress }}</td>
                                <td class="text-center font-italic">{{ $sv->tgl_invoice }}</td>
                                <td class="text-center">{{ $sv->no_invoice }}</td>
                                <td>@currency($sv->total_tagihan),-</td>
                                <td>@currency($sv->nilai_tagihan),-</td>
                                <td>@currency($sv->koreksi_dp),-</td>
                                <td class="text-center">{{ $sv->nama_sales }}</td>
                                <td class="text-center">{{ $sv->kode_proyek }}</td>
                                <td>@currency($sv->nilai_tagihan + $sv->koreksi_dp),-</td>
                            </tr>
                            @php
                                $total += $sv->koreksi_dp + $sv->nilai_tagihan;
                            @endphp
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="11" class="text-right" style="font-weight: bold;">Total</td>
                        <td>@currency($total),-</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
</body>

</html>
