@extends('layouts.dashboard')
@section('content')
    <style>
        .table td,
        .table th {
            font-size: 0.875rem;
        }
    </style>
    <div class="content tableLarge">
        {{-- <h2 class="content-heading">Halaman Proyek</h2> --}}
        <div class="text-left">
            <a type="button" class="btn btn-alt-primary min-width-125 mb-10" href="{{ route('proyek.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span class="ms-1 fs-6">Proyek Baru</span>
            </a>
        </div>
        <div class="block shadow bg-white">
            <div class="block-header block-header-default">
                <h3 class="block-title">Table <small>Proyek</small></h3>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nama Proyek</th>
                                <th class="text-center" style="width: 10%">Kode Proyek</th>
                                <th class="text-center">Nama Pemesan</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Sales</th>
                                <th class="text-center">Harga Kontrak (DPP)</th>
                                <th class="text-center">Status PO</th>
                                <th class="text-center">Ket</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proyek as $p)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="font-w600 text-center">{{ $p->nama_proyek }}</td>
                                    <td class="text-center">{{ $p->kode_proyek }}</td>
                                    <td class="font-w600 text-center">{{ $p->nama_customer }}</td>
                                    <td class="text-center">{{ $p->kategori_proyek }}</td>
                                    <td class="text-center">{{ $p->nama_sales }}</td>
                                    <td class="text-center">@currency($p->nilai_kontrak),-</td>
                                    <td class="text-center"><span
                                            class="badge {{ $p->status_po == 'BELUM DITERIMA' ? 'badge-warning' : 'badge-success' }}">{{ $p->status_po }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $p->keterangan ? $p->keterangan : '-' }}</td>
                                    <td class="text-center">
                                        <a href="#" data-toggle="modal" data-target="#editProyek{{ $p->id }}"
                                            class="btn btn-sm btn-alt-primary rounded-2"><i
                                                class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                    <div class="modal fade" id="editProyek{{ $p->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editProyekModal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-popout" role="document">
                                            <div class="modal-content">
                                                <div class="block block-themed block-transparent mb-0">
                                                    <div class="block-header bg-primary-dark">
                                                        <h3 class="block-title">Update Status PO &amp; Keterangan</h3>
                                                        <div class="block-options">
                                                            <button type="button" class="btn-block-option"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <i class="si si-close"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="block-content">
                                                        <form action="{{ route('proyek.update', $p->id) }}"
                                                            class="text-black" method="POST">
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="harga" class="col-form-label fs-6">HARGA
                                                                        KONTRAK</label>
                                                                    <input type="text" class="form-control"
                                                                        id="harga" name="nilai_kontrak"
                                                                        placeholder="Masukkan Harga Kontrak">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col mb-3">
                                                                        <label for="status_po"
                                                                            class=" col-form-label fs-6">STATUS
                                                                            PO <span class="text-danger">*</span></label>
                                                                        <select type="text" class="form-control"
                                                                            name="status_po" required>
                                                                            <option value="BELUM DITERIMA"
                                                                                @if ($p->status_po == 'BELUM DITERIMA') selected @endif>
                                                                                BELUM DITERIMA</option>
                                                                            <option value="SUDAH DITERIMA"
                                                                                @if ($p->status_po == 'SUDAH DITERIMA') selected @endif>
                                                                                SUDAH DITERIMA</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="keterangan" class="col-form-label fs-6">
                                                                        KETERANGAN <span
                                                                            class="text-danger">*</span></label>
                                                                    <textarea class="form-control" id="keterangan" placeholder="Ketik keterangan tambahan disini..." name="keterangan"
                                                                        rows="3" style="resize: none;">{{ $p->keterangan }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-alt-success">
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
    @endsection
