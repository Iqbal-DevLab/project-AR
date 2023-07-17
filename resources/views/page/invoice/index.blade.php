@extends('layouts.dashboard')
@section('content')
    <style>
        .table td,
        .table th {
            font-size: 0.875rem;
        }
    </style>
    <div class="content tableExtraLarge">
        {{-- <h2 class="content-heading">Halaman Invoice</h2> --}}
        <div class="text-left">
            <a type="button" class="btn btn-alt-primary min-width-125 mb-10" href="{{ route('invoice.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span class="ms-1 fs-6">Invoice Baru</span>
            </a>
        </div>
        <div class="block shadow bg-white">
            <div class="block-header block-header-default">
                <h3 class="block-title">Berdasarkan Tanggal</h3>
            </div>
            <div class="block-content block-content-full">
                <form action="{{ route('invoice.index') }}" class="row">
                    <select class="custom-select font-weight-bold"
                        style="font-size: 0.775rem; max-width: 150px; height:28px;" id="bulan" name="bulan">
                        <option value="01" {{ request('bulan') == '01' ? 'selected' : '' }}>Januari</option>
                        <option value="02" {{ request('bulan') == '02' ? 'selected' : '' }}>Februari</option>
                        <option value="03" {{ request('bulan') == '03' ? 'selected' : '' }}>Maret</option>
                        <option value="04" {{ request('bulan') == '04' ? 'selected' : '' }}>April</option>
                        <option value="05" {{ request('bulan') == '05' ? 'selected' : '' }}>Mei</option>
                        <option value="06" {{ request('bulan') == '06' ? 'selected' : '' }}>Juni</option>
                        <option value="07" {{ request('bulan') == '07' ? 'selected' : '' }}>Juli</option>
                        <option value="08" {{ request('bulan') == '08' ? 'selected' : '' }}>Agustus</option>
                        <option value="09" {{ request('bulan') == '09' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                    </select>
                    <select class="custom-select font-weight-bold"
                        style="font-size: 0.775rem; max-width: 150px; height:28px;" id="tahun" name="tahun">
                        <option value="2022" {{ request('tahun') == '2022' ? 'selected' : '' }}>2022</option>
                        <option value="2023" {{ request('tahun') == '2023' ? 'selected' : '' }}>2023</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-alt-primary align-self-center"><i class="fa fa-search"></i>
                        Cari</button>
                    <a href="{{ route('invoice.index') }}" class="btn btn-sm btn-secondary fw-bold align-self-center"
                        title="Refresh filter tanggal" type="button" id="refresh-filter-tanggal"><i
                            class="fa-solid fa-rotate"></i> Refresh
                    </a>


                    {{-- <div class="form-group row">
                        <label for="tgl_awal" class="col-md-1 col-form-label"
                            style="font-size: 0.875rem; max-width: 59px;">DARI</label>
                        <div class="col-md-2 input-group date align-items-center">
                            <input type="text" class="js-datepicker form-control form-control-sm" id="tgl_awal"
                                name="tgl_awal" autocomplete="off" data-week-start="1" data-autoclose="true"
                                data-today-highlight="true" data-date-format="dd-mm-yyyy" value="{{ request('tgl_awal') }}"
                                placeholder="dd-MM-yyyy">
                            <div class="input-group-append">
                                <span class="input-group-text align-self-center" style="cursor:pointer; height:28px;"><i
                                        class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_akhir" class="col-md-1 col-form-label"
                            style="font-size: 0.875rem; max-width: 59px;">SAMPAI</label>
                        <div class="col-md-2 input-group date align-items-center">
                            <input type="text" class="js-datepicker form-control form-control-sm" id="tgl_akhir"
                                name="tgl_akhir" autocomplete="off" data-week-start="1" data-autoclose="true"
                                data-today-highlight="true" data-date-format="dd-mm-yyyy" value="{{ request('tgl_akhir') }}"
                                placeholder="dd-MM-yyyy">
                            <div class="input-group-append">
                                <span class="input-group-text align-self-center" style="cursor:pointer; height:28px;"><i
                                        class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-alt-primary align-self-center"><i
                                class="fa fa-search"></i>
                            Cari</button>
                        <a href="{{ route('invoice.index') }}" class="btn btn-sm btn-secondary fw-bold align-self-center"
                            title="Refresh filter tanggal" type="button" id="refresh-filter-tanggal"><i
                                class="fa-solid fa-rotate"></i> Refresh
                        </a>
                    </div> --}}
                </form>
            </div>
        </div>
        <div class="block shadow bg-white">
            <div class="block-header block-header-default">
                <h3 class="block-title">List <small>Invoice</small></h3>
            </div>
            <div class="block-content block-content-full">
                <table
                    class="table table-responsive table-hover table-striped table-vcenter js-dataTable-full-pagination no-pagination">
                    <thead>
                        <tr>
                            @if (request('tgl_awal'))
                                <p class="text-center font-weight-bold">Periode<br>{{ request('tgl_awal') }} -
                                    {{ request('tgl_akhir') }}</p>
                            @endif
                            <th class="text-center">Invoice</th>
                            <th class="text-center">Nama Proyek</th>
                            <th class="text-center">Kode Proyek</th>
                            <th class="text-center">Sales</th>
                            <th class="text-center">Progress</th>
                            <th class="text-center" style="width: 15%;">Nilai Tagihan</th>
                            <th class="text-center" style="width: 15%;">AR</th>
                            <th class="text-center" style="width: 8%;">Tanggal Invoice</th>
                            <th class="text-center" style="width: 8%;">Tanggal TTK</th>
                            <th class="text-center" style="width: 8%;">Tanggal Jatuh Tempo</th>
                            <th class="text-center" style="width: 8%;">Status</th>
                            <th>Ket</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $i)
                            <a hidden>{{ $i->created_at }}</a>
                            <tr>
                                {{-- <td class="text-center">{{ $loop->iteration }}</td> --}}
                                <td class="text-center">
                                    <a class="btn btn-sm btn-alt-primary rounded-2 w-100 copy-button"
                                        style="cursor: default ;">
                                        {{ $i->no_invoice_before ? $i->no_invoice_before : $i->no_invoice }}
                                    </a>
                                </td>
                                <td class="text-center font-w600">{{ $i->nama_proyek }}</td>
                                <td class="text-center">{{ $i->kode_proyek }}</td>
                                <td class="text-center">{{ $i->nama_sales }}</td>
                                <td class="text-center">{{ $i->progress }}</td>
                                <td class="text-center">@currency($i->total_tagihan),-</td>
                                <td class="text-center">@currency($i->ar),-</td>
                                <td class="text-center font-italic">{{ $i->tgl_invoice }}</td>
                                @if (!$i->tgl_ttk)
                                    <td class="text-center">
                                        <a href="#" data-toggle="modal" data-target="#editInvoice{{ $i->id }}"
                                            class="btn btn-sm btn-alt-success" style="white-space: nowrap;">
                                            Input Tanggal TTK
                                        </a>
                                    </td>
                                @else
                                    <td class="text-center font-italic">
                                        {{ $i->tgl_ttk ? \Carbon\Carbon::parse($i->tgl_ttk)->format('d-m-Y') : '-' }}
                                    </td>
                                @endif
                                <td class="text-center font-italic">
                                    {{ $i->tgl_jatuh_tempo ? \Carbon\Carbon::parse($i->tgl_jatuh_tempo)->format('d-m-Y') : '-' }}
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge {{ $i->status == 'MENUNGGU PEMBAYARAN' ? 'badge-warning' : ($i->status == 'DIBATALKAN' ? 'badge-danger' : ($i->status == 'TAGIHAN MENUNGGU PELUNASAN' ? 'badge-info' : ($i->status == 'KWITANSI BELUM DITERIMA' ? 'badge-secondary' : 'badge-primary'))) }}">
                                        {{ $i->status }}
                                    </span>
                                </td>
                                <td>{{ $i->keterangan ? $i->keterangan : '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="javascript:void(0)"
                                            onclick="confirmDelete('{{ route('invoice.cancel', ['id' => $i->id, 'no_invoice' => $i->no_invoice]) }}', {{ $i->id }}, '{{ $i->no_invoice }}')"
                                            type="button"
                                            class="btn btn-square btn-alt-danger rounded-2 {{ $i->status == 'TAGIHAN TELAH DILUNASI' || $i->status == 'TAGIHAN MENUNGGU PELUNASAN' ? 'disabled' : '' }}"
                                            title="Batalkan Invoice"><i class="fa fa-close"></i>
                                        </a>
                                    </div>
                                </td>
                                <div class="modal fade" id="editInvoice{{ $i->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="editInvoiceModal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-popout" role="document">
                                        <div class="modal-content">
                                            <div class="block block-themed block-transparent mb-0">
                                                <div class="block-header bg-primary-dark">
                                                    <h3 class="block-title">Update Tanggal TTK &amp;
                                                        Tanggal Jatuh Tempo
                                                    </h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <i class="si si-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="block-content">
                                                    <form action="{{ route('invoice.update', $i->id) }}"
                                                        class="text-black" method="POST">
                                                        <div class="modal-body">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="tgl_ttk" class="col-form-label fs-6">TANGGAL
                                                                    TTK</label>
                                                                <div class="input-group date align-items-center">
                                                                    <input type="text"
                                                                        class="js-datepicker form-control"
                                                                        onchange="ttkFunction({{ $i->id }})"
                                                                        id="tgl_ttk{{ $i->id }}" name="tgl_ttk"
                                                                        autocomplete="off" data-week-start="1"
                                                                        data-autoclose="true" data-today-highlight="true"
                                                                        data-date-format="dd-mm-yyyy"
                                                                        placeholder="dd-MM-yyyy">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-secondary fw-bold"
                                                                            type="button"><i class="fa fa-calendar"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <label for="batas_jatuh_tempo"
                                                                        class="col-form-label fs-6">BATAS JATUH
                                                                        TEMPO</label>
                                                                    <select class="custom-select"
                                                                        oninput="jatuhTempo(this.value, '{{ $i->id }}',false)"
                                                                        name="batas_jatuh_tempo" disabled
                                                                        id="batas_jatuh_tempo{{ $i->id }}">
                                                                        <option value="Tidak Diisi">--Pilih Batas Jatuh
                                                                            Tempo--</option>
                                                                        <option value="1">1 Hari</option>
                                                                        <option value="7">7 Hari</option>
                                                                        <option value="14">14 Hari</option>
                                                                        <option value="30">30 Hari</option>
                                                                        <option value="45">45 Hari</option>
                                                                        <option value="60">60 Hari</option>
                                                                        <option value="90">90 Hari</option>
                                                                        <option value="">Lainnya</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col mb-3" id="lainnya{{ $i->id }}"
                                                                    style="display: none;">
                                                                    <label for="batas_jatuh_tempo_lainnya"
                                                                        class="col-form-label fs-6">LAINNYA
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            oninput="jatuhTempo(this.value, '{{ $i->id }}',true)"
                                                                            name="batas_jatuh_tempo_lainnya"
                                                                            id="batas_jatuh_tempo_lainnya{{ $i->id }}"
                                                                            class="form-control">
                                                                        <div class="input-group-append w-25">
                                                                            <span class="input-group-text">Hari</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tgl_jatuh_tempo"
                                                                    class="col-form-label fs-6">TANGGAL
                                                                    JATUH TEMPO</label>
                                                                <div class="input-group date align-items-center">
                                                                    <input type="text" disabled
                                                                        class="js-datepicker form-control"
                                                                        id="tgl_jatuh_tempo{{ $i->id }}"
                                                                        name="tgl_jatuh_tempo" autocomplete="off"
                                                                        data-week-start="1" data-autoclose="true"
                                                                        data-today-highlight="true"
                                                                        data-date-format="dd-mm-yyyy"
                                                                        placeholder="dd-MM-yyyy">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-secondary fw-bold"
                                                                            type="button"><i class="fa fa-calendar"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="keterangan" class="col-form-label fs-6">
                                                                    KETERANGAN <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" id="keterangan" placeholder="Ketik keterangan tambahan disini..." name="keterangan"
                                                                    rows="3" style="resize: none;">{{ $i->keterangan }}</textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    onclick="submitFunction({{ $i->id }})"
                                                                    class="btn btn-alt-success">
                                                                    <i class="fa fa-check"></i> Simpan
                                                                </button>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function ttkFunction(id) {
            var tglTtkInput = document.getElementById(`tgl_ttk${id}`);
            var tglJatuhTempoSelect = document.getElementById(`batas_jatuh_tempo${id}`);
            console.log(tglTtkInput.value);
            tglJatuhTempoSelect.disabled = false;
        }


        function submitFunction(id) {
            var tglTtkInput = document.getElementById(`tgl_ttk${id}`);
            var tglJatuhTempoInput = document.getElementById(`tgl_jatuh_tempo${id}`);
            var tglJatuhTempoSelect = document.getElementById(`batas_jatuh_tempo${id}`);

            // Periksa apakah ada input yang kosong
            if (tglTtkInput.value.trim() === '' || tglJatuhTempoInput.value.trim() === '' || tglJatuhTempoSelect.value
                .trim() === '' || tglJatuhTempoSelect.value
                .trim() === 'Tidak Diisi') {
                // Tampilkan pesan kesalahan menggunakan Swal
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Mohon lengkapi semua input sebelum submit!',
                });

                // Mencegah pengiriman form ke server
                event.preventDefault();
            } else {
                // Input valid, form dapat di-submit ke server (jika Anda ingin mengirimkan formulir setelah validasi)
                // event.target.submit();
            }
        }


        function jatuhTempo(jatuhTempo, id, i) {
            var tglTtkInput = document.getElementById(`tgl_ttk${id}`);
            var tglJatuhTempoInput = document.getElementById(`tgl_jatuh_tempo${id}`);
            var lainnyaForm = document.getElementById(`lainnya${id}`);
            var simpanButton = document.getElementById(`submit${id}`);

            var tglttk = tglTtkInput.value
            var tglTtkParts = tglttk.split('-');
            var tanggalTtk = new Date(tglTtkParts[2], tglTtkParts[1] - 1, tglTtkParts[0]);
            if (jatuhTempo !== '' && i == false) {
                var selectedOptionValue = parseInt(jatuhTempo);
                tanggalTtk.setDate(tanggalTtk.getDate() + selectedOptionValue);
                lainnyaForm.style.display = "none";
            } else {
                var selectedOptionValue = parseInt(jatuhTempo);
                tanggalTtk.setDate(tanggalTtk.getDate() + selectedOptionValue);
                lainnyaForm.style.display = "block";
            }

            var dd = String(tanggalTtk.getDate()).padStart(2, '0');
            var mm = String(tanggalTtk.getMonth() + 1).padStart(2, '0');
            var yyyy = tanggalTtk.getFullYear();

            tglJatuhTempoInput.value = dd + '-' + mm + '-' + yyyy;
        }
    </script>

    <script>
        function confirmDelete(i, id, no_invoice) {

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin membatalkan Invoice dengan Nomor ' + no_invoice + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = i;
                }
            });
        }
    </script>
@endsection
