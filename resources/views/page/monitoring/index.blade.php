@extends('layouts.dashboard')
@section('content')
    <style>
        .table td,
        .table th {
            font-size: 0.875rem;
        }
    </style>
    <div class="tableExtraLarge content">
        {{-- <h2 class="content-heading">Halaman Monitoring</h2> --}}
        <div class="block shadow bg-white">
            <div class="block-header block-header-default">
                <h3 class="block-title">Rekap AR <small>Monitoring</small></h3>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter table-hover js-dataTable-full">
                        <thead>
                            @php
                                $totalAR = 0;
                            @endphp
                            <tr>
                                <th colspan="8" class="text-center ">
                                    <div class=" d-flex justify-content-center">
                                        <div class="input-group" style="width: 15%;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"
                                                    style="height: 28px; text-transform: none; background: none !important; border: none;">Total
                                                    AR:</span>
                                            </div><input readonly class="form-control-plaintext form-control-sm "
                                                id="total_AR">
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Nama Pemesan</th>
                                <th class="text-center">Harga Kontrak</th>
                                <th class="text-center">Nilai Tagihan Yang Dibuat</th>
                                <th class="text-center">AR</th>
                                <th class="text-center">Sisa Tagihan Yang Belum Dibuat</th>
                                <th class="text-center">Pembayaran Sudah Diterima</th>
                                <th class="text-center" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($combinedCustomers as $customer)
                                @php
                                    $totalAR += $customer->AR;
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="font-w600">{{ $customer->nama_customer }}</td>
                                    <td class="text-center">
                                        {{ isset($customer->totalHargaKontrak) ? 'Rp ' . number_format(($customer->totalHargaKontrak * 111) / 100, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ isset($customer->totalNilaiTagihan) ? 'Rp ' . number_format($customer->totalNilaiTagihan, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ isset($customer->AR) ? 'Rp ' . number_format($customer->AR, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ isset($customer->sisaTagihan) ? 'Rp ' . number_format($customer->sisaTagihan, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ isset($customer->pembayaranSudahDiterima) ? 'Rp ' . number_format($customer->pembayaranSudahDiterima, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        <a type="button" class="btn btn-sm btn-alt-primary"
                                            title="Klik untuk melihat detail"
                                            href="{{ route('monitoring.detail', ['id' => $customer->id]) }}"><i
                                                class="fa-solid fa-circle-info"></i> Detail</a>
                                    </td>
                            @endforeach
                        </tbody>
                        <span hidden id="total">@currency($totalAR),-</span>
                    </table>
                </div>
            </div>
        </div>
        <div class="row row-deck gutters-tiny">
            <div class="col-md-6">

                <div class="block shadow">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Rekap Data DP <small>Belum Dibayar</small></h3>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="table-responsive">
                            <table class="table table-striped table-vcenter js-dataTable-simple">
                                <thead>
                                    <tr>
                                        {{-- <th class="text-center"></th> --}}
                                        <th>Proyek</th>
                                        <th>Customer</th>
                                        <th class="text-center" style="width: 15%">No Invoice</th>
                                        <th>DP</th>
                                        <th class="text-center" style="width: 15%">
                                            Tanggal TTK
                                        </th>
                                        <th class="text-center">DPP</th>
                                        <th class="text-center" style="width: 15%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tableDP as $item)
                                        @if (strpos($item->progress, 'DP') !== false)
                                            <tr>
                                                {{-- <td class="text-center">{{ $key + 1 }}</td> --}}
                                                <td class="font-w600">{{ $item->nama_proyek }}</td>
                                                <td class="font-w600">{{ $item->nama_customer }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-alt-primary w-100"
                                                        style="cursor: default">
                                                        {{ $item->no_invoice }}
                                                    </button>
                                                </td>
                                                <td class="font-w600">{{ $item->progress }}</td>
                                                <td class="text-center font-italic">
                                                    {{ $item->tgl_ttk ? $item->tgl_ttk : '-' }}
                                                </td>
                                                <td class="text-center">@currency($item->nilai_tagihan),-</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge {{ $item->status == 'MENUNGGU PEMBAYARAN' ? 'badge-warning' : ($item->status == 'DIBATALKAN' ? 'badge-danger' : ($item->status == 'TAGIHAN MENUNGGU PELUNASAN' ? 'badge-info' : ($item->status == 'KWITANSI BELUM DITERIMA' ? 'badge-secondary' : 'badge-primary'))) }}">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block shadow">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Rekap Data BMOS <small>Belum Dibayar</small></h3>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="table-responsive">
                            <table class="table table-striped table-vcenter js-dataTable-simple">
                                <thead>
                                    <tr>
                                        {{-- <th class="text-center"></th> --}}
                                        <th>Proyek</th>
                                        <th>Customer</th>
                                        <th class="text-center" style="width: 15%">No Invoice</th>
                                        <th>BMOS</th>
                                        <th class="text-center" style="width: 15%">
                                            Tanggal TTK
                                        </th>
                                        <th class="text-center">DPP</th>
                                        <th class="text-center" style="width: 15%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tableBMOS as $item)
                                        @if (strpos($item->progress, 'BMOS') !== false)
                                            <tr>
                                                {{-- <td class="text-center">{{ $loop->iteration }}</td> --}}
                                                <td class="font-w600">{{ $item->nama_proyek }}</td>
                                                <td class="font-w600">{{ $item->nama_customer }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-alt-primary w-100"
                                                        style="cursor: default">
                                                        {{ $item->no_invoice }}
                                                    </button>
                                                </td>
                                                <td class="font-w600">{{ $item->progress }}</td>
                                                <td class="text-center font-italic">
                                                    {{ $item->tgl_ttk ? $item->tgl_ttk : '-' }}
                                                </td>
                                                <td class="text-center">@currency($item->nilai_tagihan),-</td>
                                                @if ($item->nilai_giro != null && $item->transaksiStatus == 'BELUM DIBAYAR')
                                                    <td class="text-center">
                                                        <span class="badge badge-pill badge-info">
                                                            GIRO MUNDUR SUDAH DITERIMA
                                                        </span>
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <span
                                                            class="badge {{ $item->invoiceStatus == 'MENUNGGU PEMBAYARAN' ? 'badge-warning' : ($item->invoiceStatus == 'DIBATALKAN' ? 'badge-danger' : ($item->invoiceStatus == 'TAGIHAN MENUNGGU PELUNASAN' ? 'badge-info' : ($item->invoiceStatus == 'KWITANSI BELUM DITERIMA' ? 'badge-secondary' : 'badge-primary'))) }}">
                                                            {{ $item->invoiceStatus }}
                                                        </span>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
    <script>
        const total = document.getElementById('total');
        const totalAR = document.getElementById('total_AR');

        totalAR.value = total.textContent;
        console.log(total.textContent);
    </script>
@endsection
