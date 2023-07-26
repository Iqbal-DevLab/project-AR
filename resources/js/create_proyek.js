const namaSalesInput = document.getElementById("nama_sales");
const idSalesInput = document.getElementById("sales_id");
const refreshSalesButton = document.getElementById("refresh_sales");
const namaCustomerInput = document.getElementById("nama_customer");
const idCustomerInput = document.getElementById("customer_id");
const refreshCustomerButton = document.getElementById("refresh_customer");
const kategoriProyekSelect = document.getElementById("kategori_proyek");
const tanggalAwalInput = document.getElementById("tgl_awal");
const tanggalAkhirInput = document.getElementById("tgl_akhir");
const tanggalPelaksanaan = document.getElementById("tgl_pelaksanaan");

kategoriProyekSelect.addEventListener("input", function () {
    if (kategoriProyekSelect.value == "BUMN") {
        tanggalPelaksanaan.hidden = false;
        tanggalAwalInput.value = "";
        tanggalAkhirInput.value = "";
    } else {
        tanggalPelaksanaan.hidden = true;
        tanggalAwalInput.value = "";
        tanggalAkhirInput.value = "";
    }
});

namaSalesInput.addEventListener("input", function () {
    const selectedOption = document.querySelector(
        `#sales option[value="${this.value}"]`
    );
    if (selectedOption) {
        idSalesInput.value = selectedOption.textContent.trim();
    } else {
        idSalesInput.value = "";
    }
});

namaSalesInput.addEventListener("change", () => {
    let validasiSales = sales.find(
        (item) => item.nama_sales === namaSalesInput.value
    );
    if (validasiSales) {
        namaSalesInput.readOnly = true;
    } else {
        swal.fire({
            icon: "warning",
            title: "Data Not Found.",
            text: "Nama sales tidak ditemukan!",
        });
        namaSalesInput.value = "";
    }
});

namaSalesInput.addEventListener("click", function () {
    this.readOnly = false;
});

namaSalesInput.addEventListener("input", function () {
    this.readOnly = false;
});

namaSalesInput.addEventListener("blur", function () {
    this.readOnly = true;
});

refreshSalesButton.addEventListener("click", () => {
    namaSalesInput.readOnly = false;
    namaSalesInput.value = "";
    idSalesInput.value = "";
});

namaCustomerInput.addEventListener("input", function () {
    const selectedOption = document.querySelector(
        `#pemesan option[value="${this.value}"]`
    );
    if (selectedOption) {
        idCustomerInput.value = selectedOption.textContent.trim();
    } else {
        idCustomerInput.value = "";
    }
});

namaCustomerInput.addEventListener("change", () => {
    let validasiCustomer = customer.find(
        (item) => item.nama_customer === namaCustomerInput.value
    );
    if (validasiCustomer) {
        namaCustomerInput.readOnly = true;
    } else {
        swal.fire({
            icon: "warning",
            title: "Data Not Found.",
            text: "Nama pemesan tidak ditemukan!",
        });
        namaCustomerInput.value = "";
    }
});

namaCustomerInput.addEventListener("click", function () {
    this.readOnly = false;
});

namaCustomerInput.addEventListener("input", function () {
    this.readOnly = false;
});

namaCustomerInput.addEventListener("blur", function () {
    this.readOnly = true;
});

refreshCustomerButton.addEventListener("click", () => {
    namaCustomerInput.readOnly = false;
    namaCustomerInput.value = "";
    idCustomerInput.value = "";
});

var hargaInput = document.getElementById("harga");
var dpNominalInput = document.getElementById("dp_nominal");
var approvalNominalInput = document.getElementById("approval_nominal");
var bmosNominalInput = document.getElementById("bmos_nominal");
var amosNominalInput = document.getElementById("amos_nominal");
var testcommNominalInput = document.getElementById("testcomm_nominal");
var retensiNominalInput = document.getElementById("retensi_nominal");
var totalNominalInput = document.getElementById("total_nominal");
var ppnNominalInput = document.getElementById("ppn_nominal");

var paymentTermsInput = document.getElementById("payment_terms");
const idPaymentTermsInput = document.getElementById("payment_terms_id");
const dpInput = document.getElementById("dp");
const approvalInput = document.getElementById("approval");
const bmosInput = document.getElementById("bmos");
const amosInput = document.getElementById("amos");
const testcommInput = document.getElementById("testcomm");
const retensiInput = document.getElementById("retensi");
const ppnInput = document.getElementById("ppn");
const totalInput = document.getElementById("total");
const paymentTermsButton = document.getElementById("refresh_top");

var totalharga = "";
document.addEventListener("DOMContentLoaded", function () {
    if (idPaymentTermsInput.value !== "") {
        paymentTermsButton.disabled = false;
    } else {
        paymentTermsButton.disabled = true;
    }
});

hargaInput.addEventListener("keyup", function (event) {
    // Hilangkan semua karakter selain angka
    var harga = this.value.replace(/\D/g, "");
    totalharga = harga;

    // Format harga dengan tanda koma setiap 3 angka
    harga = harga.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    // Set nilai input field
    this.value = harga;

    if (this.value === "") {
        paymentTermsInput.readOnly = true;
    } else paymentTermsInput.readOnly = false;
    paymentTermsButton.disabled = true;
});

paymentTermsInput.addEventListener("input", function () {
    const selectedOption = document.querySelector(
        `#top option[value="${this.value}"]`
    );
    if (selectedOption) {
        idPaymentTermsInput.value = selectedOption.textContent.trim();
    } else {
        idPaymentTermsInput.value = "";
    }
});

paymentTermsInput.addEventListener("input", function () {
    const selectedOption = this.value;
    console.log("Selected option:", selectedOption);

    // Mendapatkan nilai DP, APPROVAL, BMOS, AMOS, TESTCOMM, dan RETENSI dari opsi yang dipilih
    const dpValue = selectedOption.match(/DP:\s?(\d+)/)?.[1];
    console.log("DP:", dpValue);
    const approvalValue = selectedOption.match(/APPROVAL:\s?(\d+)/)?.[1];
    console.log("Approval:", approvalValue);
    const bmosValue = selectedOption.match(/BMOS:\s?(\d+)/)?.[1];
    console.log("BMOS:", bmosValue);
    const amosValue = selectedOption.match(/AMOS:\s?(\d+)/)?.[1];
    console.log("AMOS:", amosValue);
    const testcommValue = selectedOption.match(/TESTCOMM:\s?(\d+)/)?.[1];
    console.log("TESTCOMM:", testcommValue);
    const retensiValue = selectedOption.match(/RETENSI:\s?(\d+)/)?.[1];
    console.log("RETENSI:", retensiValue);

    // Mengisi nilai DP, APPROVAL, BMOS, AMOS, TESTCOMM, dan RETENSI pada input field masing-masing
    dpInput.value = dpValue ? dpValue + "%" : "";
    approvalInput.value = approvalValue ? approvalValue + "%" : "";
    bmosInput.value = bmosValue ? bmosValue + "%" : "";
    amosInput.value = amosValue ? amosValue + "%" : "";
    testcommInput.value = testcommValue ? testcommValue + "%" : "";
    retensiInput.value = retensiValue ? retensiValue + "%" : "";
    ppnInput.value = 11 + "%";

    // Menghitung persentase total
    const total =
        (+dpValue || 0) +
        (+approvalValue || 0) +
        (+bmosValue || 0) +
        (+amosValue || 0) +
        (+testcommValue || 0) +
        (+retensiValue || 0);
    totalInput.value = total + "%";

    // Menghitung Nominal DP, APPROVAL, BMOS, AMOS, TESTCOMM, dan RETENSI pada input field masing-masing
    dpNominalInput.value = dpValue
        ? ((dpValue * totalharga) / 100)
              .toString()
              .replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-"
        : "";
    approvalNominalInput.value = approvalValue
        ? ((approvalValue * totalharga) / 100)
              .toString()
              .replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-"
        : "";
    bmosNominalInput.value = bmosValue
        ? ((bmosValue * totalharga) / 100)
              .toString()
              .replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-"
        : "";
    amosNominalInput.value = amosValue
        ? ((amosValue * totalharga) / 100)
              .toString()
              .replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-"
        : "";
    testcommNominalInput.value = testcommValue
        ? ((testcommValue * totalharga) / 100)
              .toString()
              .replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-"
        : "";
    retensiNominalInput.value = retensiValue
        ? ((retensiValue * totalharga) / 100)
              .toString()
              .replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-"
        : "";

    // Menghitung nilai total nominal
    const totalNominal =
        (+dpNominalInput.value.replace(/[^\d]/g, "") || 0) +
        (+approvalNominalInput.value.replace(/[^\d]/g, "") || 0) +
        (+bmosNominalInput.value.replace(/[^\d]/g, "") || 0) +
        (+amosNominalInput.value.replace(/[^\d]/g, "") || 0) +
        (+testcommNominalInput.value.replace(/[^\d]/g, "") || 0) +
        (+retensiNominalInput.value.replace(/[^\d]/g, "") || 0);

    // Menghitung nilai PPN (Value Added Tax) 11%
    const ppnNominal = totalNominal * 0.11;
    ppnNominalInput.value = ppnNominal
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    totalNominalInput.value = totalNominal + ppnNominal;
    totalNominalInput.value = totalNominalInput.value
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    hargaInput.readOnly = true;
    console.log(totalNominal);
});

paymentTermsInput.addEventListener("change", () => {
    if (idPaymentTermsInput.value !== "") {
        paymentTermsInput.readOnly = true;
        paymentTermsButton.disabled = false;
    } else {
        Swal.fire({
            icon: "error",
            title: "Data Tidak Valid",
            text: "Payment Terms tidak valid. Harap isi dengan benar.",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK",
        });
        paymentTermsInput.value = "";
        paymentTermsButton.disabled = true;
    }
});

paymentTermsButton.addEventListener("click", () => {
    paymentTermsInput.readOnly = false;
    paymentTermsInput.value = "";
    paymentTermsButton.disabled = true;
    idPaymentTermsInput.value = "";
    dpInput.value = "";
    approvalInput.value = "";
    bmosInput.value = "";
    amosInput.value = "";
    testcommInput.value = "";
    retensiInput.value = "";
    totalInput.value = "";
    dpNominalInput.value = "";
    approvalNominalInput.value = "";
    bmosNominalInput.value = "";
    amosNominalInput.value = "";
    testcommNominalInput.value = "";
    retensiNominalInput.value = "";
    totalNominalInput.value = "";
    hargaInput.readOnly = false;
});
