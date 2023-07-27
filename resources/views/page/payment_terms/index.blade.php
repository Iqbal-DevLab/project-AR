@extends('layouts.dashboard')
@section('content')
    <div class="content">
        {{-- <h2 class="content-heading">Halaman Terms of Payment</h2> --}}
        <div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="modal fade" id="modal-proyek" tabindex="-1" role="dialog" aria-labelledby="modal-proyek"
                aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">FORM TERM OF PAYMENT</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="si si-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content">
                                <form action="{{ route('payment-terms.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="input-group">
                                            <label for="DP" class="col-form-label col-md-6 fs-6">DP</label>
                                            <input type="text" class="form-control" autocomplete="off" id="DP"
                                                pattern="[0-9%]+" name="DP">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <label for="APPROVAL" class="col-form-label col-md-6 fs-6">APPROVAL</label>
                                            <input type="text" class="form-control" autocomplete="off" id="APPROVAL"
                                                pattern="[0-9%]+" name="APPROVAL">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <span class="percentage-value"></span>%
                                                </span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <label for="BMOS" class="col-form-label col-md-6 fs-6">BMOS</label>
                                            <input type="text" class="form-control" autocomplete="off" id="BMOS"
                                                pattern="[0-9%]+" name="BMOS">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <label for="AMOS" class="col-form-label col-md-6 fs-6">AMOS</label>
                                            <input type="text" class="form-control" autocomplete="off" id="AMOS"
                                                pattern="[0-9%]+" name="AMOS">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <label for="TESTCOMM" class="col-form-label col-md-6 fs-6">TESTCOMM</label>
                                            <input type="text" class="form-control" autocomplete="off" id="TESTCOMM"
                                                pattern="[0-9%]+" name="TESTCOMM">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <label for="RETENSI" class="col-form-label col-md-6 fs-6">RETENSI</label>
                                            <input type="text" class="form-control" autocomplete="off" id="RETENSI"
                                                pattern="[0-9%]+" name="RETENSI">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <label for="TOTAL" class="col-form-label col-md-6 fs-6"></label>
                                            <input type="text" class="form-control" id="TOTAL" readonly
                                                name="TOTAL">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-alt-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-alt-success">
                                            <i class="fa fa-check"></i> SIMPAN
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Table <small>Terms of Payment</small></h3>
                <div class="text-right">
                    <button type="button" class="btn btn-alt-primary min-width-125 mb-10" data-toggle="modal"
                        data-target="#modal-proyek">
                        <i class="fa-solid fa-plus"></i>
                        <span class="ms-1 fs-6">Tambahkan Terms of Payment</span>
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">DP</th>
                                <th class="text-center">Approval</th>
                                <th class="text-center">BMOS</th>
                                <th class="text-center">AMOS</th>
                                <th class="text-center">TESTCOMM</th>
                                <th class="text-center">Retensi</th>
                                {{-- <th class="text-center">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment_terms as $payment_terms)
                                <tr>
                                    <td>{{ $loop->iteration }}
                                    </td>
                                    <td class="text-center font-w600">{{ $payment_terms->DP ? $payment_terms->DP : '-' }}
                                    </td>
                                    <td class="text-center font-w600">
                                        {{ $payment_terms->APPROVAL ? $payment_terms->APPROVAL : '-' }}
                                    </td>
                                    <td class="text-center font-w600">
                                        {{ $payment_terms->BMOS ? $payment_terms->BMOS : '-' }}</td>
                                    <td class="text-center font-w600">
                                        {{ $payment_terms->AMOS ? $payment_terms->AMOS : '-' }}</td>
                                    <td class="text-center font-w600">
                                        {{ $payment_terms->TESTCOMM ? $payment_terms->TESTCOMM : '-' }}
                                    </td>
                                    <td class="text-center font-w600">
                                        {{ $payment_terms->RETENSI ? $payment_terms->RETENSI : '-' }}
                                    </td>
                                    {{-- <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                                title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                                title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')

    <script src="{{ asset('/') }}resources/views/js/payment_terms_index.js"></script>
@endsection
