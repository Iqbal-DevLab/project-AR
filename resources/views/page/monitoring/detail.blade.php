@extends('layouts.dashboard')
@section('content')
    <style>
        .table td,
        .table th {
            font-size: 0.875rem;
        }

        .custom-div {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
    <div class="tableExtraLarge content">

        <div class="block" style="padding-bottom: 15px;">
            <div class="block-header block-header-default">
                <h3 class="block-title text-center">{{ $customer->nama_customer }}</h3>
            </div>
            <div class="block-content">
                {{-- <p>{{ $customer->nama_customer }}</p> --}}
                <div id="accordion2" role="tablist" aria-multiselectable="true">
                    @php
                        $hargaKontrak = 0;
                        
                        $dp = 0;
                        $approval = 0;
                        $bmos = 0;
                        $amos = 0;
                        $testcomm = 0;
                        $retensi = 0;
                    @endphp
                    @foreach ($proyek as $item)
                        <div class="block block-bordered shadow" style="background-color:#f0f2f5; margin-bottom:30px;">
                            <div class="block-header row custom-div" role="tab" id="accordion2_h{{ $item->id }}">
                                <div class="col" style="height:140px !important;">
                                    <button class="font-w600 btn btn-sm btn-square btn-alt-primary" data-toggle="collapse"
                                        data-parent="#accordion2" href="#accordion2_q{{ $item->id }}"
                                        aria-expanded="true"
                                        aria-controls="accordion2_q{{ $item->id }}">{{ $item->nama_proyek }}</button>
                                </div>

                                <div class="d-flex align-items-end" style="margin-right: 15px;">
                                    <div style="margin-right: 10px;">
                                        <div class="col mb-1 text-center shadow bg-white">
                                            <p class="font-w600 rounded " style="height: 48px;">
                                                Harga
                                                Kontrak<br>
                                                {{ isset($item->nilai_kontrak) ? 'Rp. ' . number_format(($item->nilai_kontrak * 111) / 100, 0, ',', '.') . ',-' : '-' }}
                                            </p>
                                        </div>
                                        <div class="col mb-1 text-center shadow bg-white">
                                            <p class="font-w600 rounded " style="height: 48px;">
                                                Pembayaran
                                                Sudah Diterima<br>
                                                @if (isset($monitoringTable[$item->id]['pembayaranSudahDiterima']))
                                                    @currency($monitoringTable[$item->id]['pembayaranSudahDiterima']),-
                                                @else
                                                    0,-
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="col mb-1 text-center shadow bg-white">
                                            <p class="font-w600 rounded " style="height: 48px;">Total
                                                Nilai
                                                Tagihan yang Dibuat<br>
                                                @if (isset($monitoringTable[$item->id]['totalNilaiTagihan']))
                                                    @currency($monitoringTable[$item->id]['totalNilaiTagihan']),-
                                                @else
                                                    0,-
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col mb-1 text-center shadow bg-white">
                                            <p class="font-w600 rounded " style="height: 48px;">
                                                Sisa Tagihan Belum Dibuat<br>
                                                @if (isset($monitoringTable[$item->id]['sisaTagihan']))
                                                    @currency($monitoringTable[$item->id]['sisaTagihan']),-
                                                @else
                                                    0,-
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="accordion2_q{{ $item->id }}" class="collapse" role="tabpanel"
                                aria-labelledby="accordion2_h{{ $item->id }}">
                                <div class="block-content">
                                    <div class="row row-deck gutters-tiny">
                                        <div class="col-md-6">
                                            <div class="block shadow bg-white">
                                                <div class="block-header block-header-default">
                                                    <h3 class="block-title">Informasi Proyek</h3>
                                                </div>
                                                <div class="block-content">
                                                    <address>
                                                        <span class="font-w600">{{ $item->nama_proyek }}</span><br>
                                                        {{ $item->kode_proyek }}<br>
                                                        {{ $item->kategori_proyek }}<br>
                                                        <a>
                                                            @if ($item->status_po == 'BELUM DITERIMA')
                                                                PO {{ $item->status_po }}
                                                            @endif
                                                        </a><br><br>
                                                        <i class="fa-solid fa-hand-holding-dollar mr-1"></i>
                                                        <a>
                                                            {{ isset($item->nilai_kontrak) ? 'Rp. ' . number_format(($item->nilai_kontrak * 111) / 100, 0, ',', '.') . ',-' : '-' }}
                                                        </a><br>
                                                        <i class="fa fa-users mr-5"></i>{{ $item->nama_sales }}<br>
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#editKeterangan{{ $item->id }}"
                                                            class="fa-solid
                                                            fa-message mr-5 btn btn-sm btn-alt-primary"
                                                            style="cursor: pointer;"></a>{{ $item->keterangan }}
                                                        <div class="modal fade" id="editKeterangan{{ $item->id }}"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="editKeteranganModal" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-popout" role="document">
                                                                <div class="modal-content">
                                                                    <div class="block block-themed block-transparent mb-0">
                                                                        <div class="block-header bg-primary-dark">
                                                                            <h3 class="block-title">Update Keterangan</h3>
                                                                            <div class="block-options">
                                                                                <button type="button"
                                                                                    class="btn-block-option"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <i class="si si-close"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="block-content">
                                                                            <form
                                                                                action="{{ route('proyek.update', $item->id) }}"
                                                                                class="text-black" method="POST">
                                                                                <div class="modal-body">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <div class="row">
                                                                                        <div hidden class="col mb-3">
                                                                                            <label for="status_po"
                                                                                                class=" col-form-label fs-6">STATUS
                                                                                                PO <span
                                                                                                    class="text-danger">*</span></label>
                                                                                            <select type="text"
                                                                                                class="form-control"
                                                                                                name="status_po" required>
                                                                                                <option
                                                                                                    value="BELUM DITERIMA"
                                                                                                    @if ($item->status_po == 'BELUM DITERIMA') selected @endif>
                                                                                                    BELUM DITERIMA</option>
                                                                                                <option
                                                                                                    value="SUDAH DITERIMA"
                                                                                                    @if ($item->status_po == 'SUDAH DITERIMA') selected @endif>
                                                                                                    SUDAH DITERIMA</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label for="keterangan"
                                                                                            class="col-form-label fs-6">
                                                                                            KETERANGAN <span
                                                                                                class="text-danger">*</span></label>
                                                                                        <textarea class="form-control" id="keterangan" placeholder="Ketik keterangan tambahan disini..." name="keterangan"
                                                                                            rows="3" style="resize: none;">{{ $item->keterangan }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="submit"
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
                                                    </address>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="block shadow bg-white">
                                                <div class="block-header block-header-default">
                                                    <h3 class="block-title">Term of Payment</h3>
                                                </div>
                                                <div class="block-content">
                                                    <address>
                                                        @php
                                                            // $dp_percentage = floatval(str_replace('%', '', $item->DP));
                                                            // $approval_percentage = floatval(str_replace('%', '', $item->APPROVAL));
                                                            // $bmos_percentage = floatval(str_replace('%', '', $item->BMOS));
                                                            // $amos_percentage = floatval(str_replace('%', '', $item->AMOS));
                                                            // $testcomm_percentage = floatval(str_replace('%', '', $item->TESTCOMM));
                                                            // $retensi_percentage = floatval(str_replace('%', '', $item->RETENSI));
                                                            
                                                            // $dp = ($dp_percentage * $item->nilai_kontrak) / 100;
                                                            // $approval = ($approval_percentage * $item->nilai_kontrak) / 100;
                                                            // $bmos = ($bmos_percentage * $item->nilai_kontrak) / 100;
                                                            // $amos = ($amos_percentage * $item->nilai_kontrak) / 100;
                                                            // $testcomm = ($testcomm_percentage * $item->nilai_kontrak) / 100;
                                                            // $retensi = ($retensi_percentage * $item->nilai_kontrak) / 100;
                                                            
                                                            // $dpPPN = ($dp * 111) / 100;
                                                            // $approvalPPN = ($approval * 111) / 100;
                                                            // $bmosPPN = ($bmos * 111) / 100;
                                                            // $amosPPN = ($amos * 111) / 100;
                                                            // $testcommPPN = ($testcomm * 111) / 100;
                                                            // $retensiPPN = ($retensi * 111) / 100;
                                                            
                                                            // if ($monitoringTable[$item->id]['tagihanDP'] == $monitoringTable[$item->id]['arDP']) {
                                                            //     $dpNominal = $dpPPN;
                                                            // } else {
                                                            //     $diff = $monitoringTable[$item->id]['tagihanDP'] - $monitoringTable[$item->id]['arDP'];
                                                            //     $dpAR = $dpPPN - $diff;
                                                            //     $dpNominal = $dpAR;
                                                            // }
                                                            
                                                            // if ($monitoringTable[$item->id]['tagihanAPPROVAL'] == $monitoringTable[$item->id]['arAPPROVAL']) {
                                                            //     $approvalNominal = $approvalPPN;
                                                            // } else {
                                                            //     $diff = $monitoringTable[$item->id]['tagihanAPPROVAL'] - $monitoringTable[$item->id]['arAPPROVAL'];
                                                            //     $approvalAR = $approvalPPN - $diff;
                                                            //     $approvalNominal = $approvalAR;
                                                            // }
                                                            
                                                            // if ($monitoringTable[$item->id]['tagihanBMOS'] == $monitoringTable[$item->id]['arBMOS']) {
                                                            //     $bmosNominal = $bmosPPN;
                                                            // } else {
                                                            //     $diff = $monitoringTable[$item->id]['tagihanBMOS'] - $monitoringTable[$item->id]['arBMOS'];
                                                            //     $bmosAR = $bmosPPN - $diff;
                                                            //     $bmosNominal = $bmosAR;
                                                            // }
                                                            
                                                            // if ($monitoringTable[$item->id]['tagihanAMOS'] == $monitoringTable[$item->id]['arAMOS']) {
                                                            //     $amosNominal = $amosPPN;
                                                            // } else {
                                                            //     $diff = $monitoringTable[$item->id]['tagihanAMOS'] - $monitoringTable[$item->id]['arAMOS'];
                                                            //     $amosAR = $amosPPN - $diff;
                                                            //     $amosNominal = $amosAR;
                                                            // }
                                                            
                                                            // if ($monitoringTable[$item->id]['tagihanTESTCOMM'] == $monitoringTable[$item->id]['arTESTCOMM']) {
                                                            //     $testcommNominal = $testcommPPN;
                                                            // } else {
                                                            //     $diff = $monitoringTable[$item->id]['tagihanTESTCOMM'] - $monitoringTable[$item->id]['arTESTCOMM'];
                                                            //     $testcommAR = $testcommPPN - $diff;
                                                            //     $testcommNominal = $testcommAR;
                                                            // }
                                                            
                                                            // if ($monitoringTable[$item->id]['tagihanRETENSI'] == $monitoringTable[$item->id]['arRETENSI']) {
                                                            //     $retensiNominal = $retensiPPN;
                                                            // } else {
                                                            //     $diff = $monitoringTable[$item->id]['tagihanRETENSI'] - $monitoringTable[$item->id]['arRETENSI'];
                                                            //     $retensiAR = $retensiPPN - $diff;
                                                            //     $retensiNominal = $retensiAR;
                                                            // }
                                                            
                                                            $dp_percentage = floatval(str_replace('%', '', $item->DP));
                                                            $approval_percentage = floatval(str_replace('%', '', $item->APPROVAL));
                                                            $bmos_percentage = floatval(str_replace('%', '', $item->BMOS));
                                                            $amos_percentage = floatval(str_replace('%', '', $item->AMOS));
                                                            $testcomm_percentage = floatval(str_replace('%', '', $item->TESTCOMM));
                                                            $retensi_percentage = floatval(str_replace('%', '', $item->RETENSI));
                                                            
                                                            $nilai_kontrak = $item->nilai_kontrak;
                                                            $ppn = 111 / 100;
                                                            
                                                            $dp = ($dp_percentage * $nilai_kontrak) / 100;
                                                            $approval = ($approval_percentage * $nilai_kontrak) / 100;
                                                            $bmos = ($bmos_percentage * $nilai_kontrak) / 100;
                                                            $amos = ($amos_percentage * $nilai_kontrak) / 100;
                                                            $testcomm = ($testcomm_percentage * $nilai_kontrak) / 100;
                                                            $retensi = ($retensi_percentage * $nilai_kontrak) / 100;
                                                            
                                                            $dpPPN = $dp * $ppn;
                                                            $approvalPPN = $approval * $ppn;
                                                            $bmosPPN = $bmos * $ppn;
                                                            $amosPPN = $amos * $ppn;
                                                            $testcommPPN = $testcomm * $ppn;
                                                            $retensiPPN = $retensi * $ppn;
                                                            
                                                            $tagihanDP = $monitoringTable[$item->id]['tagihanDP'];
                                                            $arDP = $monitoringTable[$item->id]['arDP'];
                                                            
                                                            $tagihanAPPROVAL = $monitoringTable[$item->id]['tagihanAPPROVAL'];
                                                            $arAPPROVAL = $monitoringTable[$item->id]['arAPPROVAL'];
                                                            
                                                            $tagihanBMOS = $monitoringTable[$item->id]['tagihanBMOS'];
                                                            $arBMOS = $monitoringTable[$item->id]['arBMOS'];
                                                            
                                                            $tagihanAMOS = $monitoringTable[$item->id]['tagihanAMOS'];
                                                            $arAMOS = $monitoringTable[$item->id]['arAMOS'];
                                                            
                                                            $tagihanTESTCOMM = $monitoringTable[$item->id]['tagihanTESTCOMM'];
                                                            $arTESTCOMM = $monitoringTable[$item->id]['arTESTCOMM'];
                                                            
                                                            $tagihanRETENSI = $monitoringTable[$item->id]['tagihanRETENSI'];
                                                            $arRETENSI = $monitoringTable[$item->id]['arRETENSI'];
                                                            
                                                            $dpNominal = $tagihanDP == $arDP ? $dpPPN : $dpPPN - ($tagihanDP - $arDP);
                                                            $approvalNominal = $tagihanAPPROVAL == $arAPPROVAL ? $approvalPPN : $approvalPPN - ($tagihanAPPROVAL - $arAPPROVAL);
                                                            $bmosNominal = $tagihanBMOS == $arBMOS ? $bmosPPN : $bmosPPN - ($tagihanBMOS - $arBMOS);
                                                            $amosNominal = $tagihanAMOS == $arAMOS ? $amosPPN : $amosPPN - ($tagihanAMOS - $arAMOS);
                                                            $testcommNominal = $tagihanTESTCOMM == $arTESTCOMM ? $testcommPPN : $testcommPPN - ($tagihanTESTCOMM - $arTESTCOMM);
                                                            $retensiNominal = $tagihanRETENSI == $arRETENSI ? $retensiPPN : $retensiPPN - ($tagihanRETENSI - $arRETENSI);
                                                            
                                                        @endphp
                                                        <div class="row">
                                                            @if (!empty($item->DP))
                                                                <span class="col"> DP {{ $item->DP }}
                                                                    @currency($dpPPN),-</span>
                                                                <span class="col">Sisa @currency($dpNominal),-</span><br>
                                                            @endif
                                                        </div>
                                                        <div class="row">
                                                            @if (!empty($item->APPROVAL))
                                                                <span class="col"> APPROVAL {{ $item->APPROVAL }}
                                                                    @currency($approvalPPN),-</span>
                                                                <span class="col">Sisa @currency($approvalNominal),-</span><br>
                                                            @endif
                                                        </div>
                                                        <div class="row">
                                                            @if (!empty($item->BMOS))
                                                                <span class="col"> BMOS {{ $item->BMOS }}
                                                                    @currency($bmosPPN),-</span>
                                                                <span class="col">Sisa @currency($bmosNominal),-</span><br>
                                                            @endif
                                                        </div>
                                                        <div class="row">
                                                            @if (!empty($item->AMOS))
                                                                <span class="col"> AMOS {{ $item->AMOS }}
                                                                    @currency($amosPPN),-</span>
                                                                <span class="col">Sisa @currency($amosNominal),-</span><br>
                                                            @endif
                                                        </div>
                                                        <div class="row">

                                                            @if (!empty($item->TESTCOMM))
                                                                <span class="col"> TESTCOMM {{ $item->TESTCOMM }}
                                                                    @currency($testcommPPN),-</span>
                                                                <span class="col">Sisa @currency($testcommNominal),-</span><br>
                                                            @endif
                                                        </div>
                                                        <div class="row">

                                                            @if (!empty($item->RETENSI))
                                                                <p class="col"> RETENSI {{ $item->RETENSI }}
                                                                    @currency($retensiPPN),-</p>
                                                                <p class="col">Sisa @currency($retensiNominal),-</p><br>
                                                            @endif
                                                        </div>


                                                    </address>
                                                    <div class="mb-1">
                                                        <i class="fa-solid fa-wallet"></i> Sudah Diterima +
                                                        PPN(11%) :
                                                        @if (isset($monitoringTable[$item->id]['pembayaranSudahDiterima']))
                                                            @currency($monitoringTable[$item->id]['pembayaranSudahDiterima']),-
                                                        @else
                                                            0,-
                                                        @endif
                                                    </div>
                                                    <div class="mb-1">
                                                        <i class="fa-solid fa-wallet"></i> Belum Diterima +
                                                        PPN(11%) :
                                                        @if (isset($monitoringTable[$item->id]['pembayaranBelumDiterima']))
                                                            @currency($monitoringTable[$item->id]['pembayaranBelumDiterima']),-
                                                        @else
                                                            0,-
                                                        @endif
                                                    </div>
                                                    <div class="mb-1">
                                                        <i class="fa-solid fa-wallet"></i> Sisa Tagihan Belum
                                                        Dibuat +
                                                        PPN(11%) :
                                                        @if (isset($monitoringTable[$item->id]['sisaTagihan']))
                                                            @currency($monitoringTable[$item->id]['sisaTagihan']),-
                                                        @else
                                                            0,-
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block shadow bg-white mt-3">
                                        <div class="block-header block-header-default">
                                            <h3 class="block-title">Riwayat Invoice</h3>
                                        </div>
                                        <div class="block-content block-content-full">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-vcenter js-dataTable-full">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Invoice</th>
                                                            <th class="text-center">Progress</th>
                                                            <th class="text-center">Nilai Tagihan</th>
                                                            <th class="text-center">AR</th>
                                                            <th class="text-center">Tanggal Invoice</th>
                                                            <th class="text-center">Tanggal TTK</th>
                                                            <th class="text-center">Jatuh Tempo</th>
                                                            <th class="text-center">Tanggal Jatuh Tempo</th>
                                                            <th class="text-center">Telat (Hari)</th>
                                                            <th class="text-center">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (isset($monitoringTable[$item->id]['invoice']) && is_iterable($monitoringTable[$item->id]['invoice']))
                                                            @foreach ($monitoringTable[$item->id]['invoice'] as $invoice)
                                                                @if (isset($invoice->tgl_invoice))
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-alt-primary rounded-2 w-100"
                                                                                style="cursor: default">
                                                                                {{ $invoice->no_invoice }}
                                                                            </button>
                                                                        </td>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $invoice->progress }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ isset($invoice->total_tagihan) ? 'Rp. ' . number_format($invoice->total_tagihan, 0, ',', '.') . ',-' : '-' }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ isset($invoice->sisa_pembayaran) ? 'Rp. ' . number_format($invoice->sisa_pembayaran, 0, ',', '.') . ',-' : '-' }}
                                                                        </td>
                                                                        <td class="text-center font-italic">
                                                                            {{ $invoice->tgl_invoice ? $invoice->tgl_invoice : '-' }}
                                                                        </td>
                                                                        <td class="text-center font-italic">
                                                                            {{ $invoice->tgl_ttk ? $invoice->tgl_ttk : '-' }}
                                                                        </td>
                                                                        <td class="text-center font-italic">
                                                                            {{ $invoice->batas_jatuh_tempo }} Hari</td>
                                                                        <td class="text-center font-italic">
                                                                            {{ $invoice->tgl_jatuh_tempo ? $invoice->tgl_jatuh_tempo : '-' }}
                                                                        </td>
                                                                        <td class="text-center">
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
                                                                        <td class="text-center">
                                                                            <span
                                                                                class="badge {{ $invoice->status == 'MENUNGGU PEMBAYARAN' ? 'badge-warning' : ($invoice->status == 'DIBATALKAN' ? 'badge-danger' : ($invoice->status == 'TAGIHAN MENUNGGU PELUNASAN' ? 'badge-info' : ($invoice->status == 'KWITANSI BELUM DITERIMA' ? 'badge-secondary' : 'badge-primary'))) }}">
                                                                                {{ $invoice->status }}
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="block shadow">
                                        <div class="block-header block-header-default">
                                            <h3 class="block-title">Riwayat Transaksi</h3>
                                        </div>
                                        <div class="block-content block-content-full">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-vcenter js-dataTable-full">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Invoice</th>
                                                            <th class="text-center">Progress</th>
                                                            <th class="text-center">Tagihan</th>
                                                            <th class="text-center">Nilai Giro</th>
                                                            <th class="text-center">Nama Bank</th>
                                                            <th class="text-center">Tanggal Transfer</th>
                                                            <th class="text-center">Dana Masuk</th>
                                                            <th class="text-center" style="width: 15%;">Status
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (isset($monitoringTable[$item->id]['transaksi']) && is_iterable($monitoringTable[$item->id]['transaksi']))
                                                            @foreach ($monitoringTable[$item->id]['transaksi'] as $transaksi)
                                                                @if (isset($transaksi->tgl_ttk) && isset($transaksi->tgl_jatuh_tempo))
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-alt-primary rounded-2 w-100"
                                                                                style="cursor: default">
                                                                                {{ $transaksi->no_invoice }}
                                                                            </button>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $transaksi->progress }}
                                                                        </td>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ isset($transaksi->sisa_pembayaran) ? 'Rp. ' . number_format($transaksi->sisa_pembayaran, 0, ',', '.') . ',-' : '-' }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ isset($transaksi->nilai_giro) ? 'Rp. ' . number_format($transaksi->nilai_giro, 0, ',', '.') . ',-' : '-' }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $transaksi->bank ? $transaksi->bank : '-' }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $transaksi->tgl_transfer ? $transaksi->tgl_transfer : '-' }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <a class="text-primary">
                                                                                {{ isset($transaksi->total_dana_masuk) ? 'Rp. ' . number_format($transaksi->total_dana_masuk, 0, ',', '.') . ',-' : '-' }}
                                                                            </a>
                                                                        </td>
                                                                        @if ($transaksi->nilai_giro != null && $transaksi->status == 'BELUM DIBAYAR')
                                                                            <td class="text-center">
                                                                                <span
                                                                                    class="badge badge-pill bg-secondary text-white">
                                                                                    GIRO MUNDUR SUDAH DITERIMA
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td class="text-center">
                                                                                <span
                                                                                    class="badge {{ $transaksi->status == 'BELUM DIBAYAR' ? 'badge-warning' : ($transaksi->status == 'DIBATALKAN' ? 'badge-danger' : 'badge-success') }}">
                                                                                    {{ $transaksi->status }}
                                                                                </span>
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
