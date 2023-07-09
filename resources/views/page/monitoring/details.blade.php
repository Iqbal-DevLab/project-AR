 <div class="content">
     <!-- Single Item -->
     <h2 class="content-heading">Accordion</h2>


     @foreach ($proyek as $i)
         <div class="block-header" role="tab" id="accordion2_h{{ $loop->iteration }}">
             <a class="font-w600 accordion-title" data-toggle="collapse" data-parent="#accordion2_q{{ $loop->iteration }}"
                 href="#accordion2_q{{ $loop->iteration }}" aria-expanded="true"
                 aria-controls="accordion2_q{{ $loop->iteration }}">{{ $i->nama_proyek }}</a>
         </div>
         <div id="accordion2_q{{ $loop->iteration }}" class="collapse show" role="tabpanel"
             aria-labelledby="accordion2_h1">
             <div class="block-content">
                 <h2 class="content-heading">Monitoring Proyek</h2>
                 <div class="row row-deck gutters-tiny">
                     <div class="col-md-6">
                         <div class="block block-rounded shadow bg-white">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">Informasi Proyek</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5"><a class="disabled-link"
                                         href="javascript:void(0)">{{ $i->nama_customer }}</a></div>
                                 <address>
                                     {{ $i->nama_proyek }}<br>
                                     {{ $i->kode_proyek }}<br><br>
                                     <i class="fa-solid fa-hand-holding-dollar"></i> <a class="disabled-link"
                                         href="javascript:void(0)">
                                         @currency($i->nilai_kontrak),-</a><br>
                                     <i class="fa fa-users mr-5"></i>{{ $i->nama_sales }}
                                 </address>
                             </div>
                         </div>
                     </div>
                     <div class="col-md-6">
                         <div class="block block-rounded shadow bg-white">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">Term of Payment</h3>
                             </div>
                             <div class="block-content">
                                 <address>
                                     @if (!empty($i->DP))
                                         DP: {{ $i->DP }}<br>
                                     @endif

                                     @if (!empty($i->APPROVAL))
                                         APPROVAL: {{ $i->APPROVAL }}<br>
                                     @endif

                                     @if (!empty($i->BMOS))
                                         BMOS: {{ $i->BMOS }}<br>
                                     @endif

                                     @if (!empty($i->AMOS))
                                         AMOS: {{ $i->AMOS }}<br>
                                     @endif

                                     @if (!empty($i->TESTCOMM))
                                         TESTCOMM: {{ $i->TESTCOMM }}<br>
                                     @endif

                                     @if (!empty($i->RETENSI))
                                         RETENSI: {{ $i->RETENSI }}<br>
                                     @endif
                                 </address>
                                 <div class="mb-1">
                                     <i class="fa-solid fa-wallet"></i> Pembayaran Sudah Diterima :
                                     @currency($totalDanaMasuk),-
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <h2 class="content-heading">Riwayat Transaksi</h2>
                 <div class="block block-rounded shadow bg-white">
                     <div class="block-content block-content-full">
                         <div class="table-responsive">
                             <table class="table table-striped table-vcenter js-dataTable-full">
                                 <thead>
                                     <tr>
                                         {{-- <th>#</th> --}}
                                         <th class="text-center">Invoice</th>
                                         <th class="text-center">Tagihan</th>
                                         <th class="text-center">Progress</th>
                                         <th class="text-center">Dana Masuk</th>
                                         <th class="text-center">Tanggal Invoice</th>
                                         <th class="text-center">Tanggal Jatuh Tempo</th>
                                         <th class="text-center">Tanggal Transfer</th>
                                         <th class="text-center" style="width: 15%;">Status</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($riwayatTransaksi as $r)
                                         @if ($r->kode_proyek == $i->kode_proyek)
                                             <tr>
                                                 {{-- <td>{{ $loop->iteration }}</td> --}}
                                                 {{-- <td>
                                        <a class="disabled-link" href="javascript:void(0)">{{ $r->no_invoice }}</a>
                                    </td> --}}
                                                 <td class="text-center">
                                                     <button type="button"
                                                         class="btn btn-sm btn-alt-primary rounded-2">
                                                         {{ $r->no_invoice }}
                                                     </button>
                                                 </td>
                                                 </td>
                                                 <td class="text-center">@currency($r->total_tagihan ? $r->total_tagihan : '-'),-</td>
                                                 <td class="text-center">{{ $r->progress }}</td>
                                                 <td>
                                                     <a class="disabled-link" href="javascript:void(0)">
                                                         {{ isset($r->dana_masuk) ? 'Rp. ' . number_format($r->dana_masuk, 0, ',', '.') . ',-' : '-' }}
                                                     </a>
                                                 </td>
                                                 <td class="text-center">
                                                     {{ $r->tgl_invoice ? $r->tgl_invoice : '-' }}
                                                 </td>
                                                 <td class="text-center">
                                                     {{ $r->tgl_jatuh_tempo ? $r->tgl_jatuh_tempo : '-' }}
                                                 </td>
                                                 <td class="text-center">
                                                     {{ $r->tgl_transfer ? $r->tgl_transfer : '-' }}
                                                 </td>
                                                 <td class="text-center">
                                                     <span
                                                         class="badge {{ $r->status == 'BELUM DIBAYAR' ? 'badge-warning' : ($r->status == 'DIBATALKAN' ? 'badge-danger' : 'badge-success') }}">
                                                         {{ $r->status }}
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
         </div>
     @endforeach
     <!-- END Single Item -->

     <!-- Multiple Items -->
     <div class="block">
         <div class="block block-bordered block-rounded mb-2">
             <div class="block-header" role="tab" id="accordion2_h2">
                 <a class="font-w600 accordion-title" data-toggle="collapse" data-parent="#accordion2"
                     href="#accordion2_q2" aria-expanded="true" aria-controls="accordion2_q2">2.1 Accordion
                     Title ABCDEFGHJIKL</a>
             </div>
             <div id="accordion2_q2" class="collapse show" role="tabpanel" aria-labelledby="accordion2_h2">
                 <div class="block-content">
                     <h2 class="content-heading">Monitoring Proyek</h2>
                     <div class="row row-deck gutters-tiny">
                         <div class="col-md-6">
                             <div class="block block-rounded shadow bg-white">
                                 <div class="block-header block-header-default">
                                     <h3 class="block-title">Informasi Proyek</h3>
                                 </div>
                                 <div class="block-content">
                                     <div class="font-size-lg text-black mb-5"><a class="disabled-link"
                                             href="javascript:void(0)">{{ $proyek->nama_customer }}</a></div>
                                     <address>
                                         {{ $proyek->nama_proyek }}<br>
                                         {{ $proyek->kode_proyek }}<br><br>
                                         <i class="fa-solid fa-hand-holding-dollar"></i> <a class="disabled-link"
                                             href="javascript:void(0)">
                                             @currency($proyek->nilai_kontrak),-</a><br>
                                         <i class="fa fa-users mr-5"></i>{{ $proyek->nama_sales }}
                                     </address>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="block block-rounded shadow bg-white">
                                 <div class="block-header block-header-default">
                                     <h3 class="block-title">Term of Payment</h3>
                                 </div>
                                 <div class="block-content">
                                     <address>
                                         @if (!empty($proyek->DP))
                                             DP: {{ $proyek->DP }}<br>
                                         @endif

                                         @if (!empty($proyek->APPROVAL))
                                             APPROVAL: {{ $proyek->APPROVAL }}<br>
                                         @endif

                                         @if (!empty($proyek->BMOS))
                                             BMOS: {{ $proyek->BMOS }}<br>
                                         @endif

                                         @if (!empty($proyek->AMOS))
                                             AMOS: {{ $proyek->AMOS }}<br>
                                         @endif

                                         @if (!empty($proyek->TESTCOMM))
                                             TESTCOMM: {{ $proyek->TESTCOMM }}<br>
                                         @endif

                                         @if (!empty($proyek->RETENSI))
                                             RETENSI: {{ $proyek->RETENSI }}<br>
                                         @endif
                                     </address>
                                     <div class="mb-1">
                                         <i class="fa-solid fa-wallet"></i> Pembayaran Sudah Diterima :
                                         @currency($totalDanaMasuk),-
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <h2 class="content-heading">Riwayat Transaksi</h2>
                     <div class="block block-rounded shadow bg-white">
                         <div class="block-content block-content-full">
                             <div class="table-responsive">
                                 <table class="table table-striped table-vcenter js-dataTable-full">
                                     <thead>
                                         <tr>
                                             {{-- <th>#</th> --}}
                                             <th class="text-center">Invoice</th>
                                             <th class="text-center">Tagihan</th>
                                             <th class="text-center">Progress</th>
                                             <th class="text-center">Dana Masuk</th>
                                             <th class="text-center">Tanggal Invoice</th>
                                             <th class="text-center">Tanggal Jatuh Tempo</th>
                                             <th class="text-center">Tanggal Transfer</th>
                                             <th class="text-center" style="width: 15%;">Status</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @foreach ($riwayatTransaksi as $r)
                                             <tr>
                                                 {{-- <td>{{ $loop->iteration }}</td> --}}
                                                 {{-- <td>
                                            <a class="disabled-link" href="javascript:void(0)">{{ $r->no_invoice }}</a>
                                        </td> --}}
                                                 <td class="text-center">
                                                     <button type="button"
                                                         class="btn btn-sm btn-alt-primary rounded-2">
                                                         {{ $r->no_invoice }}
                                                     </button>
                                                 </td>
                                                 </td>
                                                 <td class="text-center">@currency($r->total_tagihan ? $r->total_tagihan : '-'),-</td>
                                                 <td class="text-center">{{ $r->progress }}</td>
                                                 <td>
                                                     <a class="disabled-link" href="javascript:void(0)">
                                                         {{ isset($r->dana_masuk) ? 'Rp. ' . number_format($r->dana_masuk, 0, ',', '.') . ',-' : '-' }}
                                                     </a>
                                                 </td>
                                                 <td class="text-center">
                                                     {{ $r->tgl_invoice ? $r->tgl_invoice : '-' }}
                                                 </td>
                                                 <td class="text-center">
                                                     {{ $r->tgl_jatuh_tempo ? $r->tgl_jatuh_tempo : '-' }}
                                                 </td>
                                                 <td class="text-center">
                                                     {{ $r->tgl_transfer ? $r->tgl_transfer : '-' }}
                                                 </td>
                                                 <td class="text-center">
                                                     <span
                                                         class="badge {{ $r->status == 'BELUM DIBAYAR' ? 'badge-warning' : ($r->status == 'DIBATALKAN' ? 'badge-danger' : 'badge-success') }}">
                                                         {{ $r->status }}
                                                     </span>
                                                 </td>
                                             </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="block-header block-header-default">
             <h3 class="block-title">Multiple Item</h3>
         </div>
         <div class="block-content">
             <p>
                 An accordion can have multiple active items at a time
             </p>
             <div id="accordion2" role="tablist" aria-multiselectable="true">
                 <div class="block block-bordered block-rounded mb-2">
                     <div class="block-header" role="tab" id="accordion2_h1">
                         <a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q1"
                             aria-expanded="true" aria-controls="accordion2_q1">2.1 Accordion Title</a>
                     </div>
                     <div id="accordion2_q1" class="collapse show" role="tabpanel" aria-labelledby="accordion2_h1">
                         <div class="block-content">
                             <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet
                                 adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut
                                 metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis
                                 purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                         </div>
                     </div>
                 </div>
                 <div class="block block-bordered block-rounded mb-2">
                     <div class="block-header" role="tab" id="accordion2_h2">
                         <a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q2"
                             aria-expanded="true" aria-controls="accordion2_q2">2.2 Accordion Title</a>
                     </div>
                     <div id="accordion2_q2" class="collapse" role="tabpanel" aria-labelledby="accordion2_h2">
                         <div class="block-content">
                             <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet
                                 adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut
                                 metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis
                                 purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                         </div>
                     </div>
                 </div>
                 <div class="block block-bordered block-rounded mb-2">
                     <div class="block-header" role="tab" id="accordion2_h3">
                         <a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q3"
                             aria-expanded="true" aria-controls="accordion2_q3">2.3 Accordion Title</a>
                     </div>
                     <div id="accordion2_q3" class="collapse" role="tabpanel" aria-labelledby="accordion2_h3">
                         <div class="block-content">
                             <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet
                                 adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut
                                 metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis
                                 purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                         </div>
                     </div>
                 </div>
                 <div class="block block-bordered block-rounded mb-2">
                     <div class="block-header" role="tab" id="accordion2_h4">
                         <a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q4"
                             aria-expanded="true" aria-controls="accordion2_q4">2.4 Accordion Title</a>
                     </div>
                     <div id="accordion2_q4" class="collapse" role="tabpanel" aria-labelledby="accordion2_h4">
                         <div class="block-content">
                             <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet
                                 adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut
                                 metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis
                                 purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                         </div>
                     </div>
                 </div>
                 <div class="block block-bordered block-rounded">
                     <div class="block-header" role="tab" id="accordion2_h5">
                         <a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q5"
                             aria-expanded="true" aria-controls="accordion2_q5">2.5 Accordion Title</a>
                     </div>
                     <div id="accordion2_q5" class="collapse" role="tabpanel" aria-labelledby="accordion2_h5">
                         <div class="block-content">
                             <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet
                                 adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut
                                 metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis
                                 purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- END Multiple Items -->
 </div>
 <div id="accordion2" role="tablist" aria-multiselectable="true">
     <div class="block block-bordered block-rounded mb-2">
         <div class="block-header" role="tab" id="accordion2_h1">
             <a class="font-w600 accordion-title" data-toggle="collapse" data-parent="#accordion2"
                 href="#accordion2_q1" aria-expanded="true" aria-controls="accordion2_q1">aaa</a>
         </div>
         <div id="accordion2_q1" class="collapse show" role="tabpanel" aria-labelledby="accordion2_h1">
             <div class="block-content">
                 <h2 class="content-heading">Monitoring Proyek</h2>
                 <div class="row row-deck gutters-tiny">
                     <div class="col-md-6">
                         <div class="block block-rounded shadow bg-white">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">Informasi Proyek</h3>
                             </div>
                             <div class="block-content">
                                 <address>
                                     {{-- {{ $i->kode_proyek }}<br><br>
                                                    <i class="fa-solid fa-hand-holding-dollar"></i> <a class="disabled-link"
                                                        href="javascript:void(0)">
                                                        @currency($i->nilai_kontrak),-</a><br>
                                                    <i class="fa fa-users mr-5"></i>{{ $i->nama_sales }} --}}
                                 </address>
                             </div>
                         </div>
                     </div>
                     <div class="col-md-6">
                         <div class="block block-rounded shadow bg-white">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">Term of Payment</h3>
                             </div>
                             <div class="block-content">
                                 {{-- <address>
                                                        @if (!empty($i->DP))
                                                            DP: {{ $i->DP }}<br>
                                                        @endif

                                                        @if (!empty($i->APPROVAL))
                                                            APPROVAL: {{ $i->APPROVAL }}<br>
                                                        @endif

                                                        @if (!empty($i->BMOS))
                                                            BMOS: {{ $i->BMOS }}<br>
                                                        @endif

                                                        @if (!empty($i->AMOS))
                                                            AMOS: {{ $i->AMOS }}<br>
                                                        @endif

                                                        @if (!empty($i->TESTCOMM))
                                                            TESTCOMM: {{ $i->TESTCOMM }}<br>
                                                        @endif

                                                        @if (!empty($i->RETENSI))
                                                            RETENSI: {{ $i->RETENSI }}<br>
                                                        @endif
                                                    </address> --}}
                                 <div class="mb-1">
                                     <i class="fa-solid fa-wallet"></i> Pembayaran Sudah Diterima :
                                     {{-- @currency($totalDanaMasuk),- --}}
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <h2 class="content-heading">Riwayat Transaksi</h2>
                 <div class="block block-rounded shadow bg-white">
                     <div class="block-content block-content-full">
                         <div class="table-responsive">
                             <table class="table table-striped table-vcenter js-dataTable-full">
                                 <thead>
                                     <tr>
                                         {{-- <th>#</th> --}}
                                         <th class="text-center">Invoice</th>
                                         <th class="text-center">Tagihan</th>
                                         <th class="text-center">Progress</th>
                                         <th class="text-center">Dana Masuk</th>
                                         <th class="text-center">Tanggal Invoice</th>
                                         <th class="text-center">Tanggal Jatuh Tempo</th>
                                         <th class="text-center">Tanggal Transfer</th>
                                         <th class="text-center" style="width: 15%;">Status</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     {{-- @foreach ($riwayatTransaksi as $r)
                                                        <tr>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-alt-primary rounded-2">
                                                                    {{ $r->no_invoice }}
                                                                </button>
                                                            </td>
                                                            </td>
                                                            <td class="text-center">@currency($r->total_tagihan ? $r->total_tagihan : '-'),-</td>
                                                            <td class="text-center">{{ $r->progress }}</td>
                                                            <td>
                                                                <a class="disabled-link" href="javascript:void(0)">
                                                                    {{ isset($r->dana_masuk) ? 'Rp. ' . number_format($r->dana_masuk, 0, ',', '.') . ',-' : '-' }}
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $r->tgl_invoice ? $r->tgl_invoice : '-' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $r->tgl_jatuh_tempo ? $r->tgl_jatuh_tempo : '-' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $r->tgl_transfer ? $r->tgl_transfer : '-' }}
                                                            </td>
                                                            <td class="text-center">
                                                                <span
                                                                    class="badge {{ $r->status == 'BELUM DIBAYAR' ? 'badge-warning' : ($r->status == 'DIBATALKAN' ? 'badge-danger' : 'badge-success') }}">
                                                                    {{ $r->status }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach --}}
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         {{-- @endforeach --}}
     </div>

 </div>
