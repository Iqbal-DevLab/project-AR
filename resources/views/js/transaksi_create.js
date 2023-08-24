document.addEventListener("DOMContentLoaded", function () {
    // var danaMasukInput = document.getElementById("dana_masuk");
    // var nilaiGiroInput = document.getElementById("nilai_giro");
    // var bankChargeInput = document.getElementById("bank_charge");
    // var totalDanaMasukInput = document.getElementById("total_dana_masuk_i");

    // function updateTotalDanaMasuk(Transfer) {
    //     // Mendapatkan nilai dana masuk
    //     const danaMasuk =
    //         parseFloat(danaMasukInput.value.replace(/\D/g, "")) || 0; // Menghapus karakter selain digit

    //     // Mendapatkan nilai bank charge
    //     const bankCharge =
    //         parseFloat(bankChargeInput.value.replace(/\D/g, "")) || 0; // Menghapus karakter selain digit

    //     // Menghitung total dana masuk setelah dikurangi bank charge atau sama dengan dana masuk jika bank charge belum diisi
    //     const totalDanaMasuk = danaMasuk ? danaMasuk + bankCharge : danaMasuk;

    //     totalDanaMasukInput.value =
    //         totalDanaMasuk >= 0
    //             ? (totalDanaMasuk = formatCurrency(totalDanaMasukInput))
    //             : 0;

    //     function formatCurrency(value) {
    //         return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") + ",-";
    //     }
    // }

    var danaMasukInput = document.getElementById("dana_masuk");
    var nilaiGiroInput = document.getElementById("nilai_giro");
    var bankChargeInput = document.getElementById("bank_charge");
    var totalDanaMasukInput = document.getElementById("total_dana_masuk_i");

    function updateTotalDanaMasuk() {
        // Mendapatkan nilai dana masuk
        const danaMasuk =
            parseFloat(danaMasukInput.value.replace(/\D/g, "")) || 0; // Menghapus karakter selain digit

        // Mendapatkan nilai bank charge
        const bankCharge =
            parseFloat(bankChargeInput.value.replace(/\D/g, "")) || 0; // Menghapus karakter selain digit

        // Menghitung total dana masuk setelah dikurangi bank charge atau sama dengan dana masuk jika bank charge belum diisi
        const totalDanaMasuk = danaMasuk + bankCharge;

        totalDanaMasukInput.value = formatCurrency(totalDanaMasuk);
    }

    function formatCurrency(value) {
        return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") + ",-";
    }

    // Panggil fungsi updateTotalDanaMasuk saat input dana masuk atau bank charge berubah
    danaMasukInput.addEventListener("input", updateTotalDanaMasuk);
    bankChargeInput.addEventListener("input", updateTotalDanaMasuk);

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
        // if (selectedOption) {
        //     namaProyekInput.value = selectedOption.textContent.trim();
        //     invoiceIdInput.value = selectedOption.dataset.invoiceId;
        //     customerIdInput.value = selectedOption.dataset.customerId;
        //     kodeProyekInput.value = selectedOption.dataset.kodeProyek;
        //     progressInput.value = selectedOption.dataset.progress;
        //     tglTtkInput.value = selectedOption.dataset.tglTtk;
        //     batasJatuhTempoInput.value = selectedOption.dataset.batasJatuhTempo;
        //     tglJatuhTempoInput.value = selectedOption.dataset.tglJatuhTempo;
        //     batasJatuhTempoInput.value = selectedOption.dataset.batasJatuhTempo;
        //     tagihanInput.value =
        //         selectedOption.dataset.tagihan.replace(
        //             /\B(?=(\d{3})+(?!\d))/g,
        //             "."
        //         ) + ",-";
        //     pphSelect.value = selectedOption.dataset.pph;
        //     pphNominalInput.value =
        //         selectedOption.dataset.pphNominal.replace(
        //             /\B(?=(\d{3})+(?!\d))/g,
        //             "."
        //         ) + ",-";
        //     pphSelect.disabled = true;
        //     ppnNominalInput.value =
        //         selectedOption.dataset.ppnNominal.replace(
        //             /\B(?=(\d{3})+(?!\d))/g,
        //             "."
        //         ) + ",-";
        //     biayaLainnyaInput.value =
        //         selectedOption.dataset.lainLain.replace(
        //             /\B(?=(\d{3})+(?!\d))/g,
        //             "."
        //         ) + ",-";
        //     totalNominalInput.value =
        //         selectedOption.dataset.totalTagihan.replace(
        //             /\B(?=(\d{3})+(?!\d))/g,
        //             "."
        //         ) + ",-";
        //     koreksiDpInput.value =
        //         selectedOption.dataset.koreksiDp.replace(
        //             /\B(?=(\d{3})+(?!\d))/g,
        //             "."
        //         ) + ",-";
        //     nilaiTagihanInput.value =
        //         selectedOption.dataset.nilaiTagihan.replace(
        //             /\B(?=(\d{3})+(?!\d))/g,
        //             "."
        //         ) + ",-";
        //     arInput.value =
        //         selectedOption.dataset.ar.replace(
        //             /\B(?=(\d{3})+(?!\d))/g,
        //             "."
        //         ) + ",-";

        //}
        function formatCurrency(value) {
            return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") + ",-";
        }
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

            // Pastikan selectedOption.dataset.tagihan adalah angka sebelum memformat
            const tagihanValue = parseFloat(selectedOption.dataset.tagihan);
            tagihanInput.value = formatCurrency(tagihanValue);
            pphSelect.value = selectedOption.dataset.pph;
            // Pastikan selectedOption.dataset.pphNominal adalah angka sebelum memformat
            const pphNominalValue = parseFloat(
                selectedOption.dataset.pphNominal
            );
            pphNominalInput.value = formatCurrency(pphNominalValue);
            pphSelect.disabled = true;
            // Pastikan selectedOption.dataset.ppnNominal adalah angka sebelum memformat
            const ppnNominalValue = parseFloat(
                selectedOption.dataset.ppnNominal
            );
            ppnNominalInput.value = formatCurrency(ppnNominalValue);

            // Pastikan selectedOption.dataset.lainLain adalah angka sebelum memformat
            const biayaLainnyaValue = parseFloat(
                selectedOption.dataset.lainLain
            );

            if (!isNaN(biayaLainnyaValue)) {
                biayaLainnyaInput.value = formatCurrency(biayaLainnyaValue);
            } else {
                biayaLainnyaInput.value = "0.00,-";
            }

            // Pastikan selectedOption.dataset.totalTagihan adalah angka sebelum memformat
            const totalTagihanValue = parseFloat(
                selectedOption.dataset.totalTagihan
            );
            totalNominalInput.value = formatCurrency(totalTagihanValue);

            // Pastikan selectedOption.dataset.koreksiDp adalah angka sebelum memformat
            const koreksiDpValue = parseFloat(selectedOption.dataset.koreksiDp);
            koreksiDpInput.value = koreksiDpInput.value
                ? formatCurrency(koreksiDpValue)
                : "0.00,-";

            // Pastikan selectedOption.dataset.nilaiTagihan adalah angka sebelum memformat
            const nilaiTagihanValue = parseFloat(
                selectedOption.dataset.nilaiTagihan
            );
            nilaiTagihanInput.value = formatCurrency(nilaiTagihanValue);

            // Pastikan selectedOption.dataset.ar adalah angka sebelum memformat
            const arValue = parseFloat(selectedOption.dataset.ar);
            arInput.value = formatCurrency(arValue);
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
const giroSwitch = document.getElementById("giro_switch");
const transferSwitch = document.getElementById("transfer_switch");
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
        statusSelect.value = "Belum Dibayar";
        statusSelect.disabled = true;
        totalDanaMasukInput.value = "";
        giroSwitch.style.fontWeight = "bold";
        giroSwitch.classList.add("text-primary");
        transferSwitch.classList.remove("text-primary");
        transferSwitch.style.fontWeight = "normal";
    } else {
        // Switch is off (NON-GIRO)
        nonGiro.hidden = false;
        giro.hidden = true;
        statusPembayaranSelect.value = "";
        statusSelect.value = "Sudah Dibayar";
        noGiroInput.value = "";
        tglTerimaGiroInput.value = "";
        tglGiroCairInput.value = "";
        nilaiGiroInput.value = "";
        totalDanaMasukInput.value = "";
        transferSwitch.style.fontWeight = "bold";
        transferSwitch.classList.add("text-primary");
        giroSwitch.classList.remove("text-primary");
        giroSwitch.style.fontWeight = "normal";
    }
});

submitBtn.addEventListener("click", function () {
    statusSelect.disabled = false;
});
