@extends('layouts.dashboard')
@section('content')
    <style>
        .width-select {
            width: 350px;
        }

        .width-span {
            width: 150px;
        }
    </style>
    <x-page-title>
        <h4 class="text-capitalize">monitoring.detail</h4>
        <x-breadcrumb>
            <li class="breadcrumb-item active"><a href="#">Halaman Detail</a></li>
        </x-breadcrumb>
    </x-page-title>
    <div class="row">
        <section>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title mb-5 mt-3">
                            <h4>Informasi Proyek</h4>
                        </div>
                        <div class="row fs-6">
                            @php
                                $nilai = 0;
                                
                            @endphp
                            @foreach ($riwayatTransaksi as $riwayat)
                                @php
                                    $tgl_jatuh_tempo = Carbon\Carbon::parse($riwayat->tgl_jatuh_tempo);
                                    $tgl_transfer = Carbon\Carbon::parse($riwayat->tgl_transfer);
                                    
                                    if ($tgl_jatuh_tempo->lessThan($tgl_transfer)) {
                                        $telat_hari = $tgl_jatuh_tempo->diffInDays($tgl_transfer, false);
                                    } else {
                                        $telat_hari = 0;
                                    }
                                    
                                    $nilai += $telat_hari;
                                    
                                    if ($telat_hari == 0) {
                                        $grade = 'A';
                                    } elseif ($telat_hari <= 60) {
                                        $grade = 'B';
                                    } elseif ($telat_hari <= 180) {
                                        $grade = 'C';
                                    } else {
                                        $grade = 'D';
                                    }
                                @endphp

                                <!-- tampilkan data di sini -->
                            @endforeach
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <p><strong>Kode Proyek</strong></p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p>{{ $proyek->kode_proyek }}</p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p><strong>Nilai Proyek</strong></p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p>@currency($proyek->nilai_kontrak),-</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <p><strong>Nama Proyek</strong></p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p>{{ $proyek->nama_proyek }}</p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p><strong>Tgl Jth Tempo</strong></p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p>{{ \Carbon\Carbon::parse($proyek->tgl_jatuh_tempo)->format('d F Y') }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <p><strong>Nama Customer</strong></p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p>{{ $proyek->nama_customer }}</p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p><strong>TOP</strong></p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p>{{ $proyek->term_of_payment }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <p><strong>Nama Sales</strong></p>
                                </div>
                                <div class="col-sm-6 col-md-3 mb-3">
                                    <p>{{ $proyek->nama_sales }}</p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p><strong>Grade Proyek</strong></p>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <p> <span class="">
                                            @if ($nilai == 0)
                                                <span class="badge bg-success">A</span>
                                            @elseif ($nilai <= 60)
                                                <span class="badge bg-primary">B</span>
                                            @elseif ($nilai <= 180)
                                                <span class="badge bg-orange fs-6">C</span>
                                            @else
                                                <span class="badge bg-danger">D</span>
                                            @endif
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card fs-5">
                    <div class="card-body">
                        <div class="card-title mt-4">
                            <h4>Riwayat Transaksi</h4>
                        </div>
                        <table class="table table-striped table-hover mb-5 fs-6">
                            <thead>

                                <tr>
                                    <th>NO</th>
                                    <th>TANGGAL TRANSAKSI</th>
                                    <th>NO. INVOICE</th>
                                    <th>TAGIHAN</th>
                                    <th>TELAT (HARI)</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- {{ dd($riwayatTransaksi) }} --}}
                                @foreach ($riwayatTransaksi as $riwayat)
                                    @php
                                        $tgl_jatuh_tempo = Carbon\Carbon::parse($riwayat->tgl_jatuh_tempo);
                                        $tgl_transfer = Carbon\Carbon::parse($riwayat->tgl_transfer);
                                        
                                        if ($tgl_jatuh_tempo->lessThan($tgl_transfer)) {
                                            $telat_hari = $tgl_jatuh_tempo->diffInDays($tgl_transfer, false);
                                        } else {
                                            $telat_hari = 0;
                                        }
                                        
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @if ($riwayat->tgl_giro_cair)
                                            <td>{{ \Carbon\Carbon::parse($riwayat->tgl_giro_cair)->format('d M Y') }}
                                            @elseif($riwayat->tgl_transfer)
                                            <td>{{ \Carbon\Carbon::parse($riwayat->tgl_transfer)->format('d M Y') }}
                                            @else
                                            <td>Belum ada transaksi</td>
                                        @endif
                                        {{-- <td>{{ $riwayat->no_invoice ? $riwayat->no_invoice : 'Belum ada transaksi' }} --}}
                                        </td>

                                        </td>
                                        <td>@currency($riwayat->dana_masuk ? $riwayat->dana_masuk : 'Belum ada transaksi'),-
                                        </td>
                                        <td>
                                            @if ($telat_hari > 0)
                                                <p>{{ $telat_hari }} HARI</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </td>
                                        <td><span
                                                class="badge fs-5 {{ $riwayat->status == 'DP' ? 'bg-yellow' : 'bg-success' }}">
                                                {{ $riwayat->status }}
                                            </span> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('sweetalert::alert')
        </section>
    </div>
    <script src="/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/js/vendors.js"></script>
    <script src="/assets/vendors/choices.js/choices.min.js"></script>
    <script src="/assets/js/superadmin/edituser.js"></script>
@endsection
