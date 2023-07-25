@extends('layouts.dashboard')
@section('content')
    <style>
        .table td,
        .table th {
            font-size: 0.875rem;
        }
    </style>
    <div class="content">
        @php
            $hargaKontrak = 0;
            
            $dp = 0;
            $approval = 0;
            $bmos = 0;
            $amos = 0;
            $testcomm = 0;
            $retensi = 0;
        @endphp
        <div class="block shadow">
            <div class="block-header block-header-default">
                <h3 class="block-title">Data Invoice <small>Sudah Dibuat</small></h3>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter table-hover js-dataTable-simple">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th class="text-center" style="width: 15%">No Invoice</th>
                                <th class="text-center">Progress</th>
                                <th class="text-center" style="width: 15%">
                                    Tanggal TTK
                                </th>
                                <th class="text-center">Tanggal Jatuh Tempo</th>
                                <th class="text-center">Total Tagihan</th>
                                <th class="text-center">AR</th>
                                <th class="text-center" style="width: 15%">Status</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="block shadow bg-white">
            <div class="block-header block-header-default">
                <h3 class="block-title text-center">BUAT INVOICE</h3>
                <div class="block-options">
                </div>
            </div>
            <div class="block-content">
                <div class="row justify-content-center py-20">
                    <div class="col-xl-10">
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
                        <form id="form_invoice" action="{{ route('invoice.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="kode_proyek" class="col-form-label fs-6">KODE PROYEK
                                    </label>
                                    <div class="input-group">
                                        <input class="form-control" list="kode" id="kode_proyek" name="kode_proyek"
                                            autocomplete="off" placeholder="Ketik untuk mencari KODE PROYEK..."
                                            aria-describedby="refresh_kode_proyek" readonly
                                            onfocus="javascript: this.removeAttribute('readonly')">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary fw-bold" title="Refresh Kode Proyek"
                                                type="button" id="refresh_kode_proyek"><i class="fa-solid fa-rotate"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <datalist id="kode">
                                        @forelse ($proyek as $i)
                                            <option value="{{ $i->kode_proyek }}"
                                                data-payment-terms-id="{{ $i->payment_terms_id }}"
                                                data-customer-id="{{ $i->customer_id }}"
                                                data-keterangan="{{ $i->keterangan }}">
                                                {{ $i->nama_proyek }} </option>
                                        @empty
                                            <span>Data kosong</span>
                                        @endforelse
                                    </datalist>
                                </div>
                                <div class="col mb-3">
                                    <label for="nama_proyek" class=" col-form-label fs-6">NAMA
                                        PROYEK</label>
                                    <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" readonly
                                        placeholder="Nama proyek akan muncul disini ...">
                                </div>
                            </div>
                            <div>
                                <input hidden class="form-control" id="payment_terms_id" name="payment_terms_id" readonly>
                            </div>
                            <div>
                                <input hidden class="form-control" id="customer_id" name="customer_id" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="no_invoice" class="col-form-label fs-6">NO. INVOICE</label>
                                <input type="text" class="form-control" name="no_invoice" autocomplete="off"
                                    placeholder="Masukkan No. Invoice" value="{{ old('no_invoice') }}">
                            </div>
                            <div class="mb-3">
                                <label for="no_faktur_pajak" class="col-form-label fs-6">NO. FAKTUR PAJAK</label>
                                <input type="text" class="form-control" name="no_faktur_pajak" autocomplete="off"
                                    placeholder="Masukkan No. Faktur Pajak" value="{{ old('no_faktur_pajak') }}">
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="tgl_invoice" class="col-form-label fs-6">TANGGAL
                                        INVOICE</label>
                                    <div class="input-group date align-items-center">
                                        <input type="text" class="js-datepicker form-control" id="tgl_invoice"
                                            name="tgl_invoice" autocomplete="off" data-week-start="1"
                                            data-autoclose="true" data-today-highlight="true"
                                            data-date-format="dd-mm-yyyy" value="{{ old('tgl_invoice') }}"
                                            placeholder="dd-MM-yyyy">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary fw-bold" type="button"><i
                                                    class="fa fa-calendar"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col mb-3">
                                    <label for="progress" class="col-form-label fs-6">PROGRESS PEMBAYARAN</label>
                                    <select class="custom-select" disabled name="progress" id="progress">
                                        <option hidden value=''>--Pilih Progress Pembayaran--</option>
                                        <option id="DP" style="display: none;"></option>
                                        <option id="APPROVAL" style="display: none;"></option>
                                        <option id="BMOS" style="display: none;"></option>
                                        <option id="AMOS" style="display: none;"></option>
                                        <option id="TESTCOMM" style="display: none;"></option>
                                        <option id="RETENSI" style="display: none;"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tagihan" class="col-form-label fs-6">Sub Total
                                </label>
                                <span class="align-self-center">(Rp)</span>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="tagihan" name="tagihan"
                                        placeholder="">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary fw-bold" title="Refresh Nilai Tagihan"
                                            type="button" id="refresh_tagihan"><i class="fa-solid fa-rotate"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="border text-center">
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <div class="mt-2 px-2 mx-2">
                                            <label>
                                                Koreksi DP</label>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" name="koreksi_dp" class="form-control col-md-5"
                                            id="koreksi_dp" placeholder=0>
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <div class="mt-2 px-2 mx-2">
                                            <label>
                                                Nilai Tagihan</label>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0"
                                            class="form-control-plaintext col-md-5" id="nilai_tagihan"
                                            name="nilai_tagihan">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <div class="mt-2 px-2 mx-2">
                                            <label>
                                                PPN 11%</label>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0"
                                            class="form-control-plaintext col-md-5" id="ppn_nominal" name="ppn_nominal">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <label for="pph" class="fs-6"></label>
                                        <select class="custom-select" name="pph" id="pph">
                                            <option selected hidden value="0">--Pilih PPh--</option>
                                            <option value="0">Tidak Ada</option>
                                            <option value="1,5%">PPh 1,5%</option>
                                            <option value="2%">PPh 2%</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary fw-bold" hidden title="Refresh Pilihan PPh"
                                                type="button" id="refresh_pph"><i class="fa-solid fa-rotate"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0"
                                            class="form-control-plaintext col-md-5" name="pph_nominal" id="pph_nominal">
                                    </div>
                                </div>
                                <div class="row text-monospace">
                                    <div class="col input-group">
                                        <div class="mt-2 px-2 mx-2">
                                            <label>
                                                Lain-lain</label>
                                        </div>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" name="lain_lain" class="form-control col-md-5"
                                            id="biayalain" placeholder=0>
                                    </div>
                                </div>
                            </div>
                            <div class="border text-center text-monospace">
                                {{-- <div class="row">
                                    <div class="col input-group">
                                        <label for="TOTAL" class="col-form-label col-md-9 fs-6">Total Tagihan
                                            Sebelumnya +
                                            PPN(11%)</label>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0" class="form-control col-md-5"
                                            id="total_nominal" name="total_tagihan">
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col input-group">
                                        <label for="TOTAL" class="col-form-label col-md-9 fs-6">Total Tagihan +
                                            PPN(11%)</label>
                                    </div>
                                    <div class="col input-group">
                                        <span class="align-self-center">Rp.</span>
                                        <input type="text" readonly placeholder="0" class="form-control col-md-5"
                                            id="total_nominal" name="total_tagihan">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary fw-bold" title="Hitung Total" type="button"
                                                id="hitung"><i class="fa-solid fa-divide"></i> Hitung
                                            </button>
                                            <button class="btn btn-secondary fw-bold" title="Hitung Ulang Total"
                                                type="button" id="update"><i class="fa-solid fa-divide"></i> Hitung
                                            </button>
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary fw-bold" title="Refresh Semua"
                                                    type="button" id="refresh_all"><i class="fa-solid fa-rotate"></i>
                                                    Refresh
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="keterangan" class="col-form-label fs-6">
                                    KETERANGAN</label>
                                <textarea class="form-control" placeholder="Ketik keterangan tambahan disini..." id="keterangan" name="keterangan"
                                    rows="3" style="resize: none;"></textarea>
                            </div>
                            <div class="footer text-right">
                                <button type="submit" id="submit" class="btn btn-alt-primary">
                                    <i class="fa fa-check"></i> BUAT INVOICE
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('sweetalert::alert')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const kodeProyekInput = document.getElementById('kode_proyek');
        const namaProyekInput = document.getElementById('nama_proyek');
        const paymentTermsIdInput = document.getElementById('payment_terms_id');
        const customerIdInput = document.getElementById('customer_id');
        const keteranganInput = document.getElementById('keterangan');
        const kodeProyekButton = document.getElementById('refresh_kode_proyek');
        const progressSelect = document.getElementById('progress');
        const kodeDP = document.getElementById('DP');
        const kodeAPPROVAL = document.getElementById('APPROVAL');
        const kodeBMOS = document.getElementById('BMOS');
        const kodeAMOS = document.getElementById('AMOS');
        const kodeTESTCOMM = document.getElementById('TESTCOMM');
        const kodeRETENSI = document.getElementById('RETENSI');

        const invoiceData = {!! json_encode($dataInvoice) !!};
        // Mendapatkan referensi ke elemen tbody di dalam tabel
        var tableBody = document.getElementById('invoiceTableBody');

        //Fungsi Status invoice pada table invoice
        function getStatusBadgeClass(status) {
            if (status === 'MENUNGGU PEMBAYARAN') {
                return 'badge-warning';
            } else if (status === 'DIBATALKAN') {
                return 'badge-danger';
            } else if (status === 'TAGIHAN MENUNGGU PELUNASAN') {
                return 'badge-info';
            } else if (status === 'KWITANSI BELUM DITERIMA') {
                return 'badge-secondary';
            } else {
                return 'badge-primary';
            }
        }

        // Fungsi untuk memformat nilai sebagai mata uang dalam format Rupiah tanpa angka desimal yang bernilai nol di belakangnya
        function formatCurrency(amount) {
            const formattedAmount = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amount);
            return formattedAmount.replace(/\,00$/, '');
        }

        kodeProyekInput.addEventListener('input', function() {
            const selectedOption = document.querySelector(`#kode option[value="${this.value}"]`);
            if (selectedOption) {
                namaProyekInput.value = selectedOption.textContent.trim();
                paymentTermsIdInput.value = selectedOption.dataset.paymentTermsId;
                customerIdInput.value = selectedOption.dataset.customerId;
                keteranganInput.value = selectedOption.dataset.keterangan;

                const kodeProyek = selectedOption.value;
                const filteredInvoices = invoiceData.filter(dataInvoice => dataInvoice.kode_proyek === kodeProyek);

                // Membuat variabel untuk menyimpan markup HTML tabel
                let tableHTML = '';
                //Deklarasi variable TOP
                var dp = 0;
                var approval = 0;
                var bmos = 0;
                var amos = 0;
                var testcomm = 0;
                var retensi = 0;

                // Melooping setiap invoice dalam filteredInvoices
                for (let i = 0; i < filteredInvoices.length; i++) {
                    const invoice = filteredInvoices[i];
                    console.log(invoice);

                    // Membuat baris HTML untuk setiap invoice
                    tableHTML += '<tr>';
                    tableHTML += '<td>' + invoice.nama_customer + '</td>';
                    tableHTML += '<td class="text-center">' + invoice.no_invoice + '</td>';
                    tableHTML += '<td class="text-center">' + invoice.progress + '</td>';
                    tableHTML += '<td class="text-center font-italic">' + (invoice.tgl_ttk ? invoice.tgl_ttk :
                        '-') + '</td>';

                    tableHTML += '<td class="text-center font-italic">' + (invoice.tgl_jatuh_tempo ? invoice
                        .tgl_jatuh_tempo : '-') + '</td>';

                    tableHTML += '<td class="text-center">' + formatCurrency(invoice.total_tagihan) + '</td>';
                    tableHTML += '<td class="text-center">' + formatCurrency(invoice.ar) + '</td>';
                    tableHTML += '<td class="text-center">';
                    tableHTML += '<span class="badge ' + getStatusBadgeClass(invoice.status) + '">';
                    tableHTML += invoice.status;
                    tableHTML += '</span>';
                    tableHTML += '</td>';

                    tableHTML += '</tr>';

                    //Perhitungan TOP
                    let dp_percentage = invoice.DP ? parseFloat(invoice.DP.replace('%', '')) : 0;
                    let approval_percentage = invoice.APPROVAL ? parseFloat(invoice.APPROVAL.replace('%', '')) : 0;
                    let bmos_percentage = invoice.BMOS ? parseFloat(invoice.BMOS.replace('%', '')) : 0;
                    let amos_percentage = invoice.AMOS ? parseFloat(invoice.AMOS.replace('%', '')) : 0;
                    let testcomm_percentage = invoice.TESTCOMM ? parseFloat(invoice.TESTCOMM.replace('%', '')) : 0;
                    let retensi_percentage = invoice.RETENSI ? parseFloat(invoice.RETENSI.replace('%', '')) : 0;

                    let nilai_kontrak = invoice.nilai_kontrak;

                    var dp = (dp_percentage * nilai_kontrak) / 100;
                    var approval = (approval_percentage * nilai_kontrak) / 100;
                    var bmos = (bmos_percentage * nilai_kontrak) / 100;
                    var amos = (amos_percentage * nilai_kontrak) / 100;
                    var testcomm = (testcomm_percentage * nilai_kontrak) / 100;
                    var retensi = (retensi_percentage * nilai_kontrak) / 100;

                    var ar = invoice.ar ? invoice.ar : 0;
                    console.log('ini ar', ar);

                }
                // Menambahkan markup HTML ke dalam tbody
                tableBody.innerHTML = tableHTML;
                console.log('ini dp', dp);

                // console.log("datainvoice", filteredInvoices);

            } else {
                namaProyekInput.value = '';
                paymentTermsIdInput.value = '';
                customerIdInput.value = '';
                keteranganInput.value = '';

                // Jika tidak ada kode proyek yang cocok, hapus isi tabel
                tableBody.innerHTML = '';
            }

            const paymentTermsData = {!! json_encode($payment_terms) !!};
            var result = paymentTermsData.find(item => item.id === parseInt(paymentTermsIdInput.value));
            console.log('result:', result);

            // Function to show the selected option and set its value
            function showOption(id, value, text) {
                var option = document.getElementById(id);
                option.style.display = 'block';
                option.value = value;
                option.text = text;
            }

            // Check if the result is not null and show the corresponding option
            if (result) {
                if (result.DP !== null) {
                    showOption('DP', result.DP, 'DP' + result.DP);
                }
                if (result.APPROVAL !== null) {
                    showOption('APPROVAL', result.APPROVAL, 'APPROVAL' + result.APPROVAL);
                }
                if (result.BMOS !== null) {
                    showOption('BMOS', result.BMOS, 'BMOS' + result.BMOS);
                }
                if (result.AMOS !== null) {
                    showOption('AMOS', result.AMOS, 'AMOS' + result.AMOS);
                }
                if (result.TESTCOMM !== null) {
                    showOption('TESTCOMM', result.TESTCOMM, 'TESTCOMM' + result.TESTCOMM);
                }
                if (result.RETENSI !== null) {
                    showOption('RETENSI', result.RETENSI, 'RETENSI' + result.RETENSI);
                }
            }

            // const invoiceGet = {!! json_encode($invoice) !!};
            // var invoiceKodePro = invoiceGet.filter(item => item.kode_proyek === kodeProyekInput.value && item
            //     .status !== 'DIBATALKAN');

            // const data1 = invoiceKodePro.map(obj => obj.progress)
            // delete result['id'];
            // const data2 = Object.values(result);

            // const differentData = [...data1, ...data2].filter(value =>
            //     (value !== null) && (!data1.includes(value) || !data2.includes(value))
            // );
            // console.log(kodeProyekInput.value);
            // console.log(invoiceGet);

            // console.log('ini adaa', invoiceKodePro);
            // console.log('ini 2', data1);

            // console.log('ini rs', result);
            // console.log('ini rs2', data2);

            // console.log("Different data:");
            // console.log(differentData);
            // differentData.forEach(value => {
            //     const key = Object.keys(result).find(key => result[key] === value);



            // console.log(`Key: ${key}, Value: ${value}`);
            // });
        });

        kodeProyekInput.addEventListener('change', () => {
            const kodeProyek = {!! json_encode($proyek) !!};
            let validasiKodeProyek = kodeProyek.find(item => item.kode_proyek === kodeProyekInput.value);
            if (validasiKodeProyek) {
                kodeProyekInput.readOnly = true;
                progressSelect.disabled = false;
            } else {
                swal.fire({
                    icon: 'warning',
                    title: 'Data Not Found.',
                    text: 'Kode proyek tidak ditemukan!'
                });
                kodeProyekInput.value = '';
            }
        });

        kodeProyekButton.addEventListener('click', () => {
            kodeProyekInput.readOnly = false;
            kodeProyekInput.value = '';
            namaProyekInput.value = '';
            paymentTermsIdInput.value = '';
            keteranganInput.value = '';
            progressSelect.disabled = true;
            tableBody.innerHTML =
                '<tr class="odd"><td valign="top" colspan="9" class="dataTables_empty">No data available in table</td></tr>';
        });
    </script>

    <script>
        var tagihanInput;
        var koreksidDpInput;
        var biayaLainInput;
        document.addEventListener('DOMContentLoaded', function() {
            tagihanInput = document.getElementById('tagihan');
            koreksidDpInput = document.getElementById('koreksi_dp');
            biayaLainInput = document.getElementById('biayalain');

            if (tagihanInput) {
                tagihanInput.addEventListener('input', function(event) {
                    var tagihan = this.value.replace(/\D/g, '');

                    tagihan = tagihan.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                    this.value = tagihan;
                });
            }

            if (koreksidDpInput) {
                koreksidDpInput.addEventListener('input', function(event) {
                    var koreksiDp = this.value.replace(/\D/g, '');

                    koreksiDp = koreksiDp.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                    this.value = koreksiDp;
                });
            }

            if (biayaLainInput) {
                biayaLainInput.addEventListener('input', function(event) {
                    var biayaLain = this.value.replace(/\D/g, '');

                    biayaLain = biayaLain.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                    this.value = biayaLain;
                });
            }
        });

        var tagihanInput = document.getElementById('tagihan');
        var koreksidDpInput = document.getElementById('koreksi_dp');
        var refreshTagihanButton = document.getElementById('refresh_tagihan');
        var pphSelect = document.getElementById('pph');
        var refreshPphButton = document.getElementById('refresh_pph');
        var biayaLainnyaInput = document.getElementById('biayalain');
        var divideButton = document.getElementById('hitung');
        var updateButton = document.getElementById('update');
        var refreshAllButton = document.getElementById('refresh_all');
        var ppnNominalInput = document.getElementById('ppn_nominal');
        var pphNominalInput = document.getElementById('pph_nominal');
        var totalNominalInput = document.getElementById('total_nominal');
        var buatInvoiceButton = document.getElementById('submit');
        var tglJatuhTempoInput = document.getElementById('tgl_jatuh_tempo');
        var nilaiTagihanInput = document.getElementById('nilai_tagihan');

        refreshAllButton.style.display = 'none';
        updateButton.style.display = 'none';
        buatInvoiceButton.disabled = true;
        divideButton.style.display = 'none';

        tagihanInput.addEventListener('change', () => {
            tagihanInput.readOnly = true;
            divideButton.style.display = 'inline-block';
        });

        let selectedPphValue = '';

        pphSelect.addEventListener('change', () => {
            selectedPphValue = pphSelect.value; // Simpan nilai yang dipilih
            pphSelect.disabled = true;
            divideButton.style.display = 'inline-block';
            buatInvoiceButton.disabled = false;
        });

        function kosongkanNilai() {
            ppnNominalInput.value = '';
            pphNominalInput.value = '';
            biayaLainnyaInput.value = '';
            biayaLainnyaInput.readOnly = true;
            totalNominalInput.value = '';
            tagihanInput.readOnly = false;
            pphSelect.disabled = false;
            divideButton.style.display = 'none';
            refreshAllButton.style.display = 'none';
            nilaiTagihanInput.value = '';
            koreksidDpInput.value = '';
            koreksidDpInput.readOnly = false;
        }

        refreshTagihanButton.addEventListener('click', function() {
            tagihanInput.value = '';
            kosongkanNilai();
        });

        refreshPphButton.addEventListener('click', function() {
            pphSelect.value = '0';
            kosongkanNilai();
            divideButton.style.display = 'inline-block';
        });

        biayaLainnyaInput.addEventListener('input', function() {
            var biayaLainnyaValue = parseFloat(biayaLainnyaInput.value);

            if (biayaLainnyaValue === 0) {
                refreshAllButton.style.display = 'inline-block';

            } else {
                updateButton.style.display = 'inline-block';
                buatInvoiceButton.disabled = true;
                refreshAllButton.style.display = 'none';
            }
        });

        biayaLainnyaInput.value = '';
        biayaLainnyaInput.readOnly = true;

        divideButton.addEventListener('click', function() {
            var tagihan = parseFloat(tagihanInput.value.replace(/[^\d]/g, '')) || 0;
            var koreksi = parseFloat(koreksidDpInput.value.replace(/[^\d]/g, '')) || 0;
            var nilaiTagihan = parseFloat(nilaiTagihanInput.value.replace(/[^\d]/g, '')) || 0;
            var nilaiTagihan = tagihan - koreksi;
            var ppn = 0.11 * nilaiTagihan;
            var pph = 0;

            if (pphSelect.value === '1,5%') {
                pph = 0.015 * nilaiTagihan;
            } else if (pphSelect.value === '2%') {
                pph = 0.02 * nilaiTagihan;
            }

            document.getElementById('ppn_nominal').value = ppn.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') +
                ',-';

            document.getElementById('pph_nominal').value = pph.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') +
                ',-';

            var biayaLainnya = parseFloat(biayaLainnyaInput.value.replace(/\D/g, '')) || 0;

            if (biayaLainnya === 0) {
                document.getElementById('biayalain').value = ''
            } else {
                document.getElementById('biayalain').value = biayaLainnya.toString().replace(
                    /\B(?=(\d{3})+(?!\d))/g, '.') + ',-';
            }

            var total = nilaiTagihan + ppn + biayaLainnya - pph;
            document.getElementById('total_nominal').value = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                '.') + ',-';


            document.getElementById('nilai_tagihan').value = nilaiTagihan.toString().replace(
                /\B(?=(\d{3})+(?!\d))/g,
                '.') + ',-';


            divideButton.style.display = 'none';
            updateButton.style.display = 'none';
            refreshAllButton.style.display = 'inline-block';
            biayaLainnyaInput.readOnly = false;
            buatInvoiceButton.disabled = false;
            pphSelect.disabled = true;
            tagihanInput.readOnly = true;
            koreksidDpInput.readOnly = true;
        });

        updateButton.addEventListener('click', function() {
            var tagihan = parseFloat(tagihanInput.value.replace(/[^\d]/g, '')) || 0;
            var koreksi = parseFloat(koreksidDpInput.value.replace(/[^\d]/g, '')) || 0;
            var nilaiTagihan = parseFloat(nilaiTagihanInput.value.replace(/[^\d]/g, '')) || 0;
            var nilaiTagihan = tagihan - koreksi;
            var ppn = 0.11 * nilaiTagihan;
            var pph = 0;

            if (pphSelect.value === '1,5%') {
                pph = 0.015 * nilaiTagihan;
            } else if (pphSelect.value === '2%') {
                pph = 0.02 * nilaiTagihan;
            }

            document.getElementById('ppn_nominal').value = ppn.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') +
                ',-';

            document.getElementById('pph_nominal').value = pph.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') +
                ',-';

            var biayaLainnya = parseFloat(biayaLainnyaInput.value.replace(/\D/g, '')) || 0;

            if (biayaLainnya === 0) {
                document.getElementById('biayalain').value = ''
            } else {
                document.getElementById('biayalain').value = biayaLainnya.toString().replace(
                    /\B(?=(\d{3})+(?!\d))/g, '.') + ',-';
            }

            var total = nilaiTagihan + ppn + biayaLainnya - pph;
            document.getElementById('total_nominal').value = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                '.') + ',-';


            document.getElementById('nilai_tagihan').value = nilaiTagihan.toString().replace(
                /\B(?=(\d{3})+(?!\d))/g,
                '.') + ',-';

            updateButton.style.display = 'none';
            refreshAllButton.style.display = 'inline-block';
            biayaLainnyaInput
                .readOnly = true;
            buatInvoiceButton.disabled = false;
            pphSelect.disabled = true;
            tagihanInput.readOnly =
                true;

        });

        refreshAllButton.addEventListener('click', function() {
            tagihanInput.value = '';
            pphSelect.value = '0';
            biayaLainnyaInput.value = '';
            buatInvoiceButton.disabled = true;
            koreksidDpInput.readOnly = true;
            kosongkanNilai();
        });

        buatInvoiceButton.addEventListener('click', function() {
            pphSelect.disabled = false;
        });
    </script>
@endsection
