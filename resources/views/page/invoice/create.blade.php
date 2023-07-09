@extends('layouts.dashboard')
@section('content')
    <div class="content">
        {{-- <h2 class="content-heading">Halaman Pembuatan Invoice</h2> --}}
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
                                                data-customer-id="{{ $i->customer_id }}">
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
                                            name="tgl_invoice" autocomplete="off" data-week-start="1" data-autoclose="true"
                                            data-today-highlight="true" data-date-format="dd-mm-yyyy"
                                            value="{{ old('tgl_invoice') }}" placeholder="dd-MM-yyyy">
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
                                        <option hidden>--Pilih Progress Pembayaran--</option>
                                        <option id="DP"></option>
                                        <option id="APPROVAL"></option>
                                        <option id="BMOS"></option>
                                        <option id="AMOS"></option>
                                        <option id="TESTCOMM"></option>
                                        <option id="RETENSI"></option>
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

    {{-- <script>
        var tglInvoiceInput = document.getElementById('tgl_invoice');
        var tglJatuhTempoSelect = document.getElementById('batas_jatuh_tempo');
        var tglJatuhTempoInput = document.getElementById('tgl_jatuh_tempo');
        var lainnyaForm = document.getElementById("lainnya");
        var tglJatuhTempoLainnyaInput = document.getElementById("tgl_jatuh_tempo_lainnya");

        tglInvoiceInput.addEventListener('change', function() {
            if (this.value !== "") {
                tglJatuhTempoSelect.disabled = false;
            } else {
                tglJatuhTempoSelect.disabled = true;
            }
        });


        function calculateTanggalJatuhTempo() {
            var tglInvoiceValue = tglInvoiceInput.value;
            var tglInvoiceParts = tglInvoiceValue.split('-');
            var tanggalInvoice = new Date(tglInvoiceParts[2], tglInvoiceParts[1] - 1, tglInvoiceParts[0]);

            if (tglJatuhTempoSelect.value !== "") {
                var selectedOptionValue = parseInt(tglJatuhTempoSelect.value);
                tanggalInvoice.setDate(tanggalInvoice.getDate() + selectedOptionValue);
            } else {
                var customInputValue = tglJatuhTempoLainnyaInput.value;
                var customDays = parseInt(customInputValue);

                if (!isNaN(customDays)) {
                    tanggalInvoice.setDate(tanggalInvoice.getDate() + customDays);
                }
            }

            var dd = String(tanggalInvoice.getDate()).padStart(2, '0');
            var mm = String(tanggalInvoice.getMonth() + 1).padStart(2, '0');
            var yyyy = tanggalInvoice.getFullYear();

            tglJatuhTempoInput.value = dd + '-' + mm + '-' + yyyy;
        }

        tglJatuhTempoSelect.addEventListener('change', function() {
            if (this.value === "") {
                lainnyaForm.style.display = "block";
            } else {
                lainnyaForm.style.display = "none";
            }

            calculateTanggalJatuhTempo();
        });

        tglJatuhTempoLainnyaInput.addEventListener('input', function() {
            calculateTanggalJatuhTempo();
        });
    </script> --}}

    <script>
        const kodeProyekInput = document.getElementById('kode_proyek');
        const namaProyekInput = document.getElementById('nama_proyek');
        const paymentTermsIdInput = document.getElementById('payment_terms_id');
        const customerIdInput = document.getElementById('customer_id');
        const kodeProyekButton = document.getElementById('refresh_kode_proyek');
        const progressSelect = document.getElementById('progress');
        const kodeDP = document.getElementById('DP');
        const kodeAPPROVAL = document.getElementById('APPROVAL');
        const kodeBMOS = document.getElementById('BMOS');
        const kodeAMOS = document.getElementById('AMOS');
        const kodeTESTCOMM = document.getElementById('TESTCOMM');
        const kodeRETENSI = document.getElementById('RETENSI');


        kodeProyekInput.addEventListener('input', function() {
            const selectedOption = document.querySelector(`#kode option[value="${this.value}"]`);
            if (selectedOption) {
                namaProyekInput.value = selectedOption.textContent.trim();
                paymentTermsIdInput.value = selectedOption.dataset.paymentTermsId;
                customerIdInput.value = selectedOption.dataset.customerId;
            } else {
                namaProyekInput.value = '';
                paymentTermsIdInput.value = '';
                customerIdInput.value = '';
            }

            kodeDP.style.display = "none";
            kodeAPPROVAL.style.display = "none";
            kodeBMOS.style.display = "none";
            kodeAMOS.style.display = "none";
            kodeTESTCOMM.style.display = "none";
            kodeRETENSI.style.display = "none";

            console.log(paymentTermsIdInput.value);



            const paymentTermsData = {!! json_encode($payment_terms) !!};
            const invoiceGet = {!! json_encode($invoice) !!};
            var invoiceKodePro = invoiceGet.filter(item => item.kode_proyek === kodeProyekInput.value && item
                .status !== 'DIBATALKAN');
            var result = paymentTermsData.find(item => item.id === parseInt(paymentTermsIdInput.value));

            const data1 = invoiceKodePro.map(obj => obj.progress)
            delete result['id'];
            const data2 = Object.values(result);
            // const newData2 = [data1 + data2[0]];
            // console.log(data2);
            // console.log("new", newData2);
            // const columnNames = Object.keys(result);
            // const data2 = [];
            // columnNames.forEach(columnName => {
            //     const value = result[columnName];
            //     if (value !== null) {
            //         const combinedValue = columnName.toUpperCase() + value;
            //         console.log('combined:', combinedValue);
            //         data2.push(combinedValue);
            //     }
            // });

            const differentData = [...data1, ...data2].filter(value =>
                (value !== null) && (!data1.includes(value) || !data2.includes(value))
            );
            console.log(kodeProyekInput.value);
            console.log(invoiceGet);

            console.log('ini adaa', invoiceKodePro);
            console.log('ini 2', data1);

            console.log('ini rs', result);
            console.log('ini rs2', data2);

            console.log("Different data:");
            console.log(differentData);
            differentData.forEach(value => {
                const key = Object.keys(result).find(key => result[key] === value);

                // const cleanedValue = value.replace(/[0-9%]/g, "");

                if (differentData) {
                    if (key == "DP") {
                        kodeDP.textContent = "DP" + value;
                        kodeDP.value = "DP" + value;
                        kodeDP.style.display = "block";
                    }

                    if (key == "APPROVAL") {
                        kodeAPPROVAL.textContent = "APPROVAL" + value;
                        kodeAPPROVAL.value = "APPROVAL" + value;
                        kodeAPPROVAL.style.display = "block";
                    }

                    if (key == "BMOS") {
                        kodeBMOS.textContent = "BMOS" + value;
                        kodeBMOS.value = "BMOS" + value;
                        kodeBMOS.style.display = "block";
                    }

                    if (key == "AMOS") {
                        kodeAMOS.textContent = "AMOS" + value;
                        kodeAMOS.value = "AMOS" + value;
                        kodeAMOS.style.display = "block";
                    }

                    if (key == "TESTCOMM") {
                        kodeTESTCOMM.textContent = "TESTCOMM" + value;
                        kodeTESTCOMM.value = "TESTCOMM" + value;
                        kodeTESTCOMM.style.display = "block";
                    }

                    if (key == "RETENSI") {
                        kodeRETENSI.textContent = "RETENSI" + value;
                        kodeRETENSI.value = "RETENSI" + value;
                        kodeRETENSI.style.display = "block";
                    }
                }
                console.log(`Key: ${key}, Value: ${value}`);
            });
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
            progressSelect.disabled = true;
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
