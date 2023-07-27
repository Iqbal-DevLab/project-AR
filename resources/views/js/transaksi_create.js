document.addEventListener("DOMContentLoaded", function () {
    var danaMasukInput = document.getElementById("dana_masuk");
    var nilaiGiroInput = document.getElementById("nilai_giro");
    var bankChargeInput = document.getElementById("bank_charge");
    var totalDanaMasukInput = document.getElementById("total_dana_masuk_i");

    function updateTotalDanaMasuk(Transfer) {
        // Mendapatkan nilai dana masuk
        const danaMasuk =
            parseFloat(danaMasukInput.value.replace(/\D/g, "")) || 0; // Menghapus karakter selain digit

        // Mendapatkan nilai bank charge
        const bankCharge =
            parseFloat(bankChargeInput.value.replace(/\D/g, "")) || 0; // Menghapus karakter selain digit

        // Menghitung total dana masuk setelah dikurangi bank charge atau sama dengan dana masuk jika bank charge belum diisi
        const totalDanaMasuk = danaMasuk ? danaMasuk + bankCharge : danaMasuk;

        // if (nilaiGiro) {
        //     totalDanaMasukInput.value = nilaiGiro;

        // } else {
        // Memperbarui nilai total dana masuk
        totalDanaMasukInput.value =
            totalDanaMasuk >= 0 ? totalDanaMasuk.toLocaleString("id-ID") : 0; // Menampilkan format angka dengan tanda titik sebagai pemisah ribuan dan mengatur nilai default menjadi 0 jika negatif
        // }
    }

    if (danaMasukInput) {
        danaMasukInput.addEventListener("input", function (event) {
            // Hilangkan semua karakter selain angka
            var danaMasuk = this.value.replace(/\D/g, "");

            // Format danaMasuk dengan tanda koma setiap 3 angka
            danaMasuk = danaMasuk.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            // Set nilai input field
            this.value = danaMasuk;
            updateTotalDanaMasuk(danaMasuk);
        });
    }

    if (nilaiGiroInput) {
        nilaiGiroInput.addEventListener("input", function (event) {
            // Hilangkan semua karakter selain angka
            var nilaiGiro = this.value.replace(/\D/g, "");

            // Format nilaiGiro dengan tanda koma setiap 3 angka
            nilaiGiro = nilaiGiro.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            // Set nilai input field
            this.value = nilaiGiro;
            console.log(nilaiGiro);
            // updateTotalDanaMasuk(nilaiGiro);
        });
    }

    if (bankChargeInput) {
        bankChargeInput.addEventListener("input", function (event) {
            // Hilangkan semua karakter selain angka
            var bankCharge = this.value.replace(/\D/g, "");

            // Format bankCharge dengan tanda koma setiap 3 angka
            bankCharge = bankCharge.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            // Set nilai input field
            this.value = bankCharge;
            updateTotalDanaMasuk();
        });
    }
});

const noInvoiceInput = document.getElementById("no_invoice_i");
const invoiceIdInput = document.getElementById("invoice_id_i");
const customerIdInput = document.getElementById("customer_id_i");
const namaProyekInput = document.getElementById("nama_proyek_i");
const kodeProyekInput = document.getElementById("kode_proyek_i");
const progressInput = document.getElementById("progress_i");
const tagihanInput = document.getElementById("tagihan_i");
const ppnNominalInput = document.getElementById("ppn_nominal_i");
const pphSelect = document.getElementById("pph_i");
const pphNominalInput = document.getElementById("pph_nominal_i");
const biayaLainnyaInput = document.getElementById("biayalain_i");
const totalNominalInput = document.getElementById("total_nominal_i");
const nilaiTagihanInput = document.getElementById("nilai_tagihan_i");
const arInput = document.getElementById("ar_i");
const tglTtkInput = document.getElementById("tgl_ttk_i");
const batasJatuhTempoInput = document.getElementById("batas_jatuh_tempo_i");
const tglJatuhTempoInput = document.getElementById("tgl_jatuh_tempo_i");
const koreksiDpInput = document.getElementById("koreksi_dp_i");
const cariDataButton = document.getElementById("cari_data_i");
const loadingButton = document.getElementById("loading");
const loadingSubmitButton = document.getElementById("loadingSubmit");
const submitBtn = document.getElementById("submit");

const pphOption = document.createElement("option");
pphOption.value = "--Pilih PPh--";
pphOption.text = "--Pilih PPh--";
pphSelect.add(pphOption);
hideLoadingIndicator();
loadingSubmitButton.style.display = "none";
cariDataButton.addEventListener("click", function () {
    showLoadingIndicator();
    // Ambil opsi yang dipilih pada datalist #no
    const selectedOption = document.querySelector(
        `#no option[value="${noInvoiceInput.value}"]`
    );

    setTimeout(function () {
        hideLoadingIndicator();
        // Sembunyikan indikator loading
        // Jika opsi yang dipilih ditemukan
        if (selectedOption) {
            namaProyekInput.value = selectedOption.textContent.trim();
            invoiceIdInput.value = selectedOption.dataset.invoiceId;
            customerIdInput.value = selectedOption.dataset.customerId;
            kodeProyekInput.value = selectedOption.dataset.kodeProyek;
            progressInput.value = selectedOption.dataset.progress;
            tglTtkInput.value = selectedOption.dataset.tglTtk;
            batasJatuhTempoInput.value = selectedOption.dataset.batasJatuhTempo;
            tglJatuhTempoInput.value = selectedOption.dataset.tglJatuhTempo;
            batasJatuhTempoInput.value = selectedOption.dataset.batasJatuhTempo;
            tagihanInput.value =
                selectedOption.dataset.tagihan.replace(
                    /\B(?=(\d{3})+(?!\d))/g,
                    "."
                ) + ",-";
            pphSelect.value = selectedOption.dataset.pph;
            pphNominalInput.value =
                selectedOption.dataset.pphNominal.replace(
                    /\B(?=(\d{3})+(?!\d))/g,
                    "."
                ) + ",-";
            pphSelect.disabled = true;
            ppnNominalInput.value =
                selectedOption.dataset.ppnNominal.replace(
                    /\B(?=(\d{3})+(?!\d))/g,
                    "."
                ) + ",-";
            biayaLainnyaInput.value =
                selectedOption.dataset.lainLain.replace(
                    /\B(?=(\d{3})+(?!\d))/g,
                    "."
                ) + ",-";
            totalNominalInput.value =
                selectedOption.dataset.totalTagihan.replace(
                    /\B(?=(\d{3})+(?!\d))/g,
                    "."
                ) + ",-";
            koreksiDpInput.value =
                selectedOption.dataset.koreksiDp.replace(
                    /\B(?=(\d{3})+(?!\d))/g,
                    "."
                ) + ",-";
            nilaiTagihanInput.value =
                selectedOption.dataset.nilaiTagihan.replace(
                    /\B(?=(\d{3})+(?!\d))/g,
                    "."
                ) + ",-";
            arInput.value =
                selectedOption.dataset.ar.replace(
                    /\B(?=(\d{3})+(?!\d))/g,
                    "."
                ) + ",-";
        } else {
            let validasiNoInvoice = noInvoice.find(
                (item) => item.no_invoice === noInvoiceInput.value
            );
            if (validasiNoInvoice) {
            } else {
                swal.fire({
                    icon: "warning",
                    title: "Data Not Found.",
                    text: "No Invoice tidak ditemukan!",
                });

                namaProyekInput.value = "";
                noInvoiceInput.value = "";
                kodeProyekInput.value = "";
                progressInput.value = "";
                tagihanInput.value = "";
                pphSelect.value = "--Pilih PPh--";
                pphNominalInput.value = "";
                ppnNominalInput.value = "";
                biayaLainnyaInput.value = "";
                totalNominalInput.value = "";
            }
        }
    }, 500); // Simulasikan waktu delay 1 detik
});

function showLoadingIndicator() {
    // Sembunyikan tombol cari_data_i
    cariDataButton.style.display = "none";

    // Tampilkan tombol loading
    loadingButton.style.display = "block";
}

function hideLoadingIndicator() {
    // Tampilkan tombol cari_data_i
    cariDataButton.style.display = "block";

    // Sembunyikan tombol loading
    loadingButton.style.display = "none";
}

submitBtn.addEventListener("click", function () {
    submitBtn.style.display = "none";
    loadingSubmitButton.style.display = "inline-block";
});

const switchEl = document.getElementById("switch");
const nonGiro = document.getElementById("nonGiro");
const tglTransferInput = document.getElementById("tgl_transfer");
const danaMasukInput = document.getElementById("dana_masuk");
const statusPembayaranSelect = document.getElementById("status");
const noGiroInput = document.getElementById("no_giro");
const tglTerimaGiroInput = document.getElementById("tgl_terima_giro");
const tglGiroCairInput = document.getElementById("tgl_giro_cair");
const nilaiGiroInput = document.getElementById("nilai_giro");
const statusSelect = document.getElementById("status");
const submitBtn2 = document.getElementById("submit");
var totalDanaMasukInput = document.getElementById("total_dana_masuk_i");

switchEl.addEventListener("change", function () {
    if (this.checked) {
        // Switch is on (GIRO)
        nonGiro.hidden = true;
        giro.hidden = false;
        tglTransferInput.value = "";
        danaMasukInput.value = "";
        statusPembayaranSelect.value = "";
        statusSelect.value = "BELUM DIBAYAR";
        statusSelect.disabled = true;
        totalDanaMasukInput.value = "";
    } else {
        // Switch is off (NON-GIRO)
        nonGiro.hidden = false;
        giro.hidden = true;
        statusPembayaranSelect.value = "";
        statusSelect.value = "SUDAH DIBAYAR";
        noGiroInput.value = "";
        tglTerimaGiroInput.value = "";
        tglGiroCairInput.value = "";
        nilaiGiroInput.value = "";
        totalDanaMasukInput.value = "";
    }
});

submitBtn.addEventListener("click", function () {
    // Set disabled menjadi false untuk elemen select sebelum mengirim data ke database
    statusSelect.disabled = false;
});
