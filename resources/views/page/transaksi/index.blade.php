@extends('layouts.dashboard')
@section('content')
    <style>
        .table td,
        .table th {
            font-size: 0.875rem;
        }
    </style>
    <div class="content extraTableLarge">
        <div class="text-right">
            <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-notifications"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-bell"></i>
                <span class="badge badge-primary badge-pill">{{ count($notifications) }}</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right min-width-300" aria-labelledby="page-header-notifications">
                <h5 class="h6 text-center py-10 mb-0 border-b text-uppercase">Notifications</h5>
                <ul class="list-unstyled my-20">
                    @foreach ($notifications as $item)
                        <li>
                            <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                                <div class="ml-5 mr-15">
                                    <span>{!! $item['icon'] !!}</span>
                                </div>
                                <div class="media-body pr-10">
                                    <p class="mb-0">{{ $item['nama_proyek'] }} -
                                        {{ $item['nama_customer'] }}
                                    </p>
                                    <div class="text-muted font-size-sm font-italic">{{ $item['keterangan'] }}</div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                    @if (empty($notifications))
                        <li>
                            <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                                <div class="ml-5 mr-15">
                                    <i class="fa fa-fw fa-info-circle text-info"></i>
                                </div>
                                <div class="media-body pr-10">
                                    <p class="mb-0">Tidak ada notifikasi baru.</p>
                                </div>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        {{-- <h2 class="content-heading">Halaman Rekap Penerimaan</h2> --}}
        <div class="row row-deck gutters-tiny mb-3">
            <div class="col-md-6">
                <div class="block shadow bg-white">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Berdasarkan Tanggal</h3>
                    </div>
                    <div class="block-content">
                        <form action="{{ route('transaksi.index') }}">
                            <div class="form-group row">
                                <label for="tgl_awal" class="col-lg-1 col-form-label"
                                    style="font-size: 0.875rem; max-width: 59px;">DARI</label>
                                <div class="col-md-4 input-group date align-items-center">
                                    <input type="text" required class="js-datepicker form-control form-control-sm"
                                        id="tgl_awal" name="tgl_awal" autocomplete="off" data-week-start="1"
                                        data-autoclose="true" data-today-highlight="true" data-date-format="dd-mm-yyyy"
                                        value="{{ request('tgl_awal') }}" placeholder="dd-MM-yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text align-self-center"
                                            style="cursor:pointer; height:28px;"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_akhir" class="col-lg-1 col-form-label"
                                    style="font-size: 0.875rem; max-width: 59px; ">SAMPAI</label>
                                <div class="col-md-4 input-group date align-items-center">
                                    <input type="text" required class="js-datepicker form-control form-control-sm"
                                        id="tgl_akhir" name="tgl_akhir" autocomplete="off" data-week-start="1"
                                        data-autoclose="true" data-today-highlight="true" data-date-format="dd-mm-yyyy"
                                        value="{{ request('tgl_akhir') }}" placeholder="dd-MM-yyyy">
                                    <div class="input-group-append">
                                        <span class="input-group-text align-self-center"
                                            style="cursor:pointer; height:28px;"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="align-self-center">
                                    <select class="form-control form-control-sm" name="filter_select"
                                        style="font-size: 0.875rem; height: 28px; width: 9rem;">
                                        <option value="">--Pilih Filter--</option>
                                        <option value="TANGGAL_TRANSFER"
                                            {{ request('filter_select') == 'TANGGAL_TRANSFER' ? 'selected' : '' }}>TANGGAL
                                            TRANSFER</option>
                                        <option value="TANGGAL_TERIMA_GIRO"
                                            {{ request('filter_select') == 'TANGGAL_TERIMA_GIRO' ? 'selected' : '' }}>
                                            TANGGAL TERIMA GIRO</option>
                                        <option value="TANGGAL_GIRO_CAIR"
                                            {{ request('filter_select') == 'TANGGAL_GIRO_CAIR' ? 'selected' : '' }}>TANGGAL
                                            GIRO CAIR</option>
                                    </select>
                                </div>
                                <div class="align-self-center">
                                    <button type="submit" class="btn btn-sm btn-alt-primary align-self-center"><i
                                            class="fa fa-search"></i>
                                        Cari</button>
                                </div>
                                <div class="align-self-center">
                                    <a href="{{ route('transaksi.index') }}"
                                        class="btn btn-sm btn-secondary fw-bold align-self-center"
                                        title="Refresh filter tanggal" type="button" id="refresh-filter-tanggal"><i
                                            class="fa-solid fa-rotate"></i> Refresh
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block shadow bg-white">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Informasi Rekap Penerimaan</h3>
                    </div>
                    <div class="block-content text-monospace">
                        <div class="row">
                            <label class="col-sm-4 col-md-4 col-form-label">
                                Akumulasi Penerimaan
                            </label>
                            <div class="col-sm-4 col-md-4">
                                <input type="text" readonly placeholder=0 class="form-control-plaintext"
                                    id="akumulasi_penerimaan">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block shadow bg-white">
            <div class="block-header block-header-default">
                <h3 class="block-title">Rekap Penerimaan <small>Transaksi</small></h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-responsive table-vcenter table-hover js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center" style="width: 15%;">NAMA PEMESAN</th>
                            <th class="text-center">INVOICE</th>
                            <th class="text-center" style="width: 10%;">BANK</th>
                            <th class="text-center" style="width: 15%;">TGL CAIR / TRANSFER</th>
                            <th class="text-center" style="width: 15%;">NO. GIRO</th>
                            <th class="text-center" style="width: 18%;">NILAI GIRO</th>
                            <th class="text-center" style="width: 18%;">TANGGAL TERIMA GIRO</th>
                            <th class="text-center" style="width: 18%;">TANGGAL GIRO
                                CAIR</th>
                            <th class="text-center" style="width: 15%;">DANA MASUK</th>
                            <th class="text-center" style="width: 15%;">AKUMULASI PENERIMAAN</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                            $akumulasiAll = 0;
                        @endphp
                        @foreach ($transaksi as $t)
                            @php
                                $total += $t->total_dana_masuk;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center font-w600">{{ $t->nama_customer }}<br>[{{ $t->nama_proyek }}]</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-alt-primary w-100"
                                        style="cursor: default">
                                        {{ $t->no_invoice_before ? $t->no_invoice_before : $t->no_invoice }}
                                    </button>
                                </td>
                                <td class="text-center">{{ $t->bank }}
                                </td>
                                <td class="text-center" style="font-style:italic;">
                                    {{ $t->tgl_transfer ? $t->tgl_transfer : '-' }}
                                <td class="text-center">{{ $t->no_giro ? $t->no_giro : '-' }}</td>
                                <td class="text-center">
                                    <?php if ($t->nilai_giro): ?>
                                    <span class="badge text-white bg-secondary">@currency($t->nilai_giro),-</span>
                                    <?php else: ?>
                                    -
                                    <?php endif; ?>
                                </td>
                                <td class="text-center font-italic">
                                    {{ $t->tgl_terima_giro ? $t->tgl_terima_giro : '-' }}
                                <td class="text-center font-italic">
                                    {{ $t->tgl_giro_cair ? $t->tgl_giro_cair : '-' }}
                                <td class="text-center">
                                    @if ($t->total_dana_masuk)
                                        <span class="badge badge-primary">@currency($t->total_dana_masuk),-</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td><span class="badge badge-info">@currency($total),-</span></td>
                                <td class="text-center">
                                    <span
                                        class="badge
                                        {{ $t->status == 'BELUM DIBAYAR' ? 'badge-warning' : ($t->status == 'DIBATALKAN' ? 'badge-danger' : 'badge-success') }}">
                                        {{ $t->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('transaksi.edit', $t->id) }}" type="button"
                                            class="btn btn-sm btn-alt-secondary {{ $t->status === 'SUDAH DIBAYAR' || $t->status === 'DIBATALKAN' ? 'disabled' : '' }}"
                                            title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="confirmDelete('{{ route('transaksi.cancel', ['id' => $t->id, 'no_invoice' => $t->no_invoice]) }}', {{ $t->id }}, '{{ $t->no_invoice }}')"
                                            type="button" class="btn btn-sm btn-alt-danger" title="Batalkan">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $akumulasiAll += $t->total_dana_masuk;
                            @endphp
                        @endforeach
                    </tbody>
                    <span hidden id="total">@currency($akumulasiAll),-</span>
                </table>
            </div>
        </div>
        <div class="block shadow bg-white">
            <div class="block-header block-header-default">
                <h3 class="block-title">Transaksi <small>Dibatalkan</small></h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-responsive table-vcenter table-hover js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center" style="width: 15%;">NAMA PEMESAN</th>
                            <th class="text-center">INVOICE</th>
                            <th class="text-center" style="width: 10%;">BANK</th>
                            <th class="text-center" style="width: 15%;">TGL CAIR / TRANSFER</th>
                            <th class="text-center" style="width: 15%;">NO. GIRO</th>
                            <th class="text-center" style="width: 18%;">NILAI GIRO</th>
                            <th class="text-center" style="width: 18%;">TANGGAL TERIMA GIRO</th>
                            <th class="text-center" style="width: 18%;">TANGGAL GIRO
                                CAIR</th>
                            <th class="text-center" style="width: 15%;">DANA MASUK</th>
                            {{-- <th class="text-center" style="width: 15%;">AKUMULASI PENERIMAAN</th> --}}
                            <th class="text-center">STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @php
                            $total = 0;
                            $akumulasiAll = 0;
                        @endphp --}}

                        @foreach ($getDibatalkan as $t)
                            {{-- @php
                                $total += $t->total_dana_masuk;
                            @endphp --}}
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center font-w600">{{ $t->nama_customer }}<br>[{{ $t->nama_proyek }}]</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-alt-primary w-100"
                                        style="cursor: default">
                                        {{ $t->no_invoice_before ? $t->no_invoice_before : $t->no_invoice }}
                                    </button>
                                </td>
                                <td class="text-center">{{ $t->bank }}
                                </td>
                                <td class="text-center" style="font-style:italic;">
                                    {{ $t->tgl_transfer ? $t->tgl_transfer : '-' }}
                                <td class="text-center">{{ $t->no_giro ? $t->no_giro : '-' }}</td>
                                <td class="text-center">
                                    <?php if ($t->nilai_giro): ?>
                                    <span class="badge text-white bg-secondary">@currency($t->nilai_giro),-</span>
                                    <?php else: ?>
                                    -
                                    <?php endif; ?>
                                </td>
                                <td class="text-center font-italic">
                                    {{ $t->tgl_terima_giro ? $t->tgl_terima_giro : '-' }}
                                <td class="text-center font-italic">
                                    {{ $t->tgl_giro_cair ? $t->tgl_giro_cair : '-' }}
                                <td class="text-center">
                                    @if ($t->total_dana_masuk)
                                        <span class="badge badge-primary">@currency($t->total_dana_masuk),-</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                {{-- <td><span class="badge badge-info">@currency($total),-</span></td> --}}
                                <td class="text-center">
                                    <span
                                        class="badge
                                        {{ $t->status == 'BELUM DIBAYAR' ? 'badge-warning' : ($t->status == 'DIBATALKAN' ? 'badge-danger' : 'badge-success') }}">
                                        {{ $t->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('transaksi.edit', $t->id) }}" type="button"
                                            class="btn btn-sm btn-alt-secondary {{ $t->status === 'SUDAH DIBAYAR' || $t->status === 'DIBATALKAN' ? 'disabled' : '' }}"
                                            title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="confirmDelete('{{ route('transaksi.cancel', ['id' => $t->id, 'no_invoice' => $t->no_invoice]) }}', {{ $t->id }}, '{{ $t->no_invoice }}')"
                                            type="button" class="btn btn-sm btn-alt-danger" title="Batalkan">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            {{-- @php
                                $akumulasiAll += $t->total_dana_masuk;
                            @endphp --}}
                        @endforeach
                    </tbody>
                    {{-- <span hidden id="total">@currency($akumulasiAll),-</span> --}}
                </table>
            </div>
        </div>
    </div>

    @include('sweetalert::alert')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const totalAkumulasi = document.getElementById('total');
        const totalDanaMasuk = document.getElementById('akumulasi_penerimaan');

        totalDanaMasuk.value = totalAkumulasi.textContent;
        console.log(totalAkumulasi.textContent);
    </script>

    <script>
        function confirmDelete(t, id, no_invoice) {

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin membatalkan transaksi dengan no. invoice ' + no_invoice + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = t;
                }
            });
        }
    </script>

    <script>
        const switchEl = document.getElementById('switch');
        const nonGiro = document.getElementById('nonGiro');
        const giro = document.getElementById('giro');

        switchEl.addEventListener('change', function() {
            if (this.checked) {
                // Switch is on (GIRO)
                nonGiro.hidden = true;
                giro.hidden = false
            } else {
                // Switch is off (NON-GIRO)
                nonGiro.hidden = false;
                giro.hidden = true;
            }
        });
    </script>
@endsection
