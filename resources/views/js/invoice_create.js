const kodeProyekInput = document.getElementById("kode_proyek");
const namaProyekInput = document.getElementById("nama_proyek");
const paymentTermsIdInput = document.getElementById("payment_terms_id");
const customerIdInput = document.getElementById("customer_id");
const keteranganInput = document.getElementById("keterangan");
const kodeProyekButton = document.getElementById("refresh_kode_proyek");
const progressSelect = document.getElementById("progress");
const kodeDP = document.getElementById("DP");
const kodeAPPROVAL = document.getElementById("APPROVAL");
const kodeBMOS = document.getElementById("BMOS");
const kodeAMOS = document.getElementById("AMOS");
const kodeTESTCOMM = document.getElementById("TESTCOMM");
const kodeRETENSI = document.getElementById("RETENSI");

var tableBody = document.getElementById("invoiceTableBody");

function getStatusBadgeClass(status) {
    if (status === "Menunggu Pembayaran") {
        return "badge-warning";
    } else if (status === "Dibatalkan") {
        return "badge-danger";
    } else if (status === "Tagihan Menunggu Pelunasan") {
        return "badge-info";
    } else if (status === "Kwitansi Belum Diterima") {
        return "badge-secondary";
    } else {
        return "badge-primary";
    }
}

// Fungsi untuk memformat nilai sebagai mata uang dalam format Rupiah
function formatCurrency(amount) {
    const formattedAmount = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(amount);
    return formattedAmount.replace(/\,00$/, "");
}

kodeProyekInput.addEventListener("input", function () {
    const selectedOption = document.querySelector(
        `#kode option[value="${this.value}"]`
    );
    if (selectedOption) {
        namaProyekInput.value = selectedOption.textContent.trim();
        paymentTermsIdInput.value = selectedOption.dataset.paymentTermsId;
        customerIdInput.value = selectedOption.dataset.customerId;
        keteranganInput.value = selectedOption.dataset.keterangan;

        const kodeProyek = selectedOption.value;
        const filteredInvoices = invoiceData.filter(
            (dataInvoice) => dataInvoice.kode_proyek === kodeProyek
        );

        // Membuat variabel untuk menyimpan markup HTML tabel
        let tableHTML = "";
        // variable TOP
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
            tableHTML += "<tr>";
            tableHTML += "<td>" + invoice.nama_customer + "</td>";
            tableHTML +=
                '<td class="text-center">' +
                (invoice.no_invoice_before
                    ? invoice.no_invoice_before
                    : invoice.no_invoice) +
                "</td>";
            tableHTML +=
                '<td class="text-center">' + invoice.progress + "</td>";
            tableHTML +=
                '<td class="text-center font-italic">' +
                (invoice.tgl_ttk ? invoice.tgl_ttk : "-") +
                "</td>";

            tableHTML +=
                '<td class="text-center font-italic">' +
                (invoice.tgl_jatuh_tempo ? invoice.tgl_jatuh_tempo : "-") +
                "</td>";

            tableHTML +=
                '<td class="text-center">' +
                formatCurrency(invoice.total_tagihan) +
                "</td>";
            tableHTML +=
                '<td class="text-center">' +
                formatCurrency(invoice.ar) +
                "</td>";
            tableHTML += '<td class="text-center">';
            tableHTML +=
                '<span class="badge ' +
                getStatusBadgeClass(invoice.status) +
                '">';
            tableHTML += invoice.status;
            tableHTML += "</span>";
            tableHTML += "</td>";

            tableHTML += "</tr>";

            //Perhitungan TOP
            let dp_percentage = invoice.DP
                ? parseFloat(invoice.DP.replace("%", ""))
                : 0;
            let approval_percentage = invoice.APPROVAL
                ? parseFloat(invoice.APPROVAL.replace("%", ""))
                : 0;
            let bmos_percentage = invoice.BMOS
                ? parseFloat(invoice.BMOS.replace("%", ""))
                : 0;
            let amos_percentage = invoice.AMOS
                ? parseFloat(invoice.AMOS.replace("%", ""))
                : 0;
            let testcomm_percentage = invoice.TESTCOMM
                ? parseFloat(invoice.TESTCOMM.replace("%", ""))
                : 0;
            let retensi_percentage = invoice.RETENSI
                ? parseFloat(invoice.RETENSI.replace("%", ""))
                : 0;

            let nilai_kontrak = invoice.nilai_kontrak;

            var dp = (dp_percentage * nilai_kontrak) / 100;
            var approval = (approval_percentage * nilai_kontrak) / 100;
            var bmos = (bmos_percentage * nilai_kontrak) / 100;
            var amos = (amos_percentage * nilai_kontrak) / 100;
            var testcomm = (testcomm_percentage * nilai_kontrak) / 100;
            var retensi = (retensi_percentage * nilai_kontrak) / 100;

            var ar = invoice.ar ? invoice.ar : 0;
            console.log("ini ar", ar);
        }
        // Menambahkan markup HTML ke dalam tbody
        tableBody.innerHTML = tableHTML;
        console.log("ini dp", dp);
    } else {
        namaProyekInput.value = "";
        paymentTermsIdInput.value = "";
        customerIdInput.value = "";
        keteranganInput.value = "";

        tableBody.innerHTML = "";
    }

    let result = paymentTermsData.find(
        (item) => item.id === parseInt(paymentTermsIdInput.value)
    );
    console.log("result:", result);

    // Function to show the selected option and set its value
    function showOption(id, value, text) {
        var option = document.getElementById(id);
        option.style.display = "block";
        option.value = value;
        option.text = text;
    }

    // Check if the result is not null and show the corresponding option
    if (result) {
        if (result.DP !== null) {
            showOption("DP", "DP" + result.DP, "DP: " + result.DP);
        }
        if (result.APPROVAL !== null) {
            showOption(
                "APPROVAL",
                "APPROVAL" + result.APPROVAL,
                "APPROVAL: " + result.APPROVAL
            );
        }
        if (result.BMOS !== null) {
            showOption("BMOS", "BMOS" + result.BMOS, "BMOS: " + result.BMOS);
        }
        if (result.AMOS !== null) {
            showOption("AMOS", "AMOS" + result.AMOS, "AMOS: " + result.AMOS);
        }
        if (result.TESTCOMM !== null) {
            showOption(
                "TESTCOMM",
                "TESTCOMM" + result.TESTCOMM,
                "TESTCOMM: " + result.TESTCOMM
            );
        }
        if (result.RETENSI !== null) {
            showOption(
                "RETENSI",
                "RETENSI" + result.RETENSI,
                "RETENSI: " + result.RETENSI
            );
        }
    }
    // const invoiceGet = {!! json_encode($invoice) !!};
    // var invoiceKodePro = invoiceGet.filter(item => item.kode_proyek === kodeProyekInput.value && item
    //     .status !== 'Dibatalkan');

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

kodeProyekInput.addEventListener("change", () => {
    let validasiKodeProyek = kodeProyek.find(
        (item) => item.kode_proyek === kodeProyekInput.value
    );
    if (validasiKodeProyek) {
        kodeProyekInput.readOnly = true;
        progressSelect.disabled = false;
    } else {
        swal.fire({
            icon: "warning",
            title: "Data Not Found.",
            text: "Kode proyek tidak ditemukan!",
        });
        kodeProyekInput.value = "";
    }
});

kodeProyekButton.addEventListener("click", () => {
    kodeProyekInput.readOnly = false;
    kodeProyekInput.value = "";
    namaProyekInput.value = "";
    paymentTermsIdInput.value = "";
    keteranganInput.value = "";
    // progressSelect.disabled = true;
    // Reset the selected index of the <select> element
    progressSelect.selectedIndex = 0;

    // Hide all options and set their style to "display: none"
    var options = progressSelect.getElementsByTagName("option");
    for (var i = 0; i < options.length; i++) {
        options[i].style.display = "none";
    }
    tableBody.innerHTML =
        '<tr class="odd"><td valign="top" colspan="9" class="dataTables_empty">No data available in table</td></tr>';
});

var tagihanInput;
var koreksidDpInput;
var biayaLainInput;

document.addEventListener("DOMContentLoaded", function () {
    tagihanInput = document.getElementById("tagihan");
    koreksidDpInput = document.getElementById("koreksi_dp");
    biayaLainInput = document.getElementById("biayalain");

    if (tagihanInput) {
        tagihanInput.addEventListener("input", function (event) {
            var tagihan = this.value.replace(/\D/g, "");

            tagihan = tagihan.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            this.value = tagihan;
        });
    }

    if (koreksidDpInput) {
        koreksidDpInput.addEventListener("input", function (event) {
            var koreksiDp = this.value.replace(/\D/g, "");

            koreksiDp = koreksiDp.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            this.value = koreksiDp;
        });
    }

    // if (biayaLainInput) {
    //     biayaLainInput.addEventListener("input", function (event) {
    //         var biayaLain = this.value.replace(/\D/g, "");

    //         biayaLain = biayaLain.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    //         this.value = biayaLain;
    //     });
    // }
});

// function formatCurrency(value) {
//     return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
// }

// function formatCurrencyInput(inputElement) {
//     var inputValue = inputElement.value;
//     inputElement.value = formatCurrency(inputValue);
// }

var tagihanInput = document.getElementById("tagihan");
var koreksidDpInput = document.getElementById("koreksi_dp");
var refreshTagihanButton = document.getElementById("refresh_tagihan");
var pphSelect = document.getElementById("pph");
var refreshPphButton = document.getElementById("refresh_pph");
var biayaLainnyaInput = document.getElementById("biayalain");
var divideButton = document.getElementById("hitung");
var updateButton = document.getElementById("update");
var refreshAllButton = document.getElementById("refresh_all");
var ppnNominalInput = document.getElementById("ppn_nominal");
var pphNominalInput = document.getElementById("pph_nominal");
var totalNominalInput = document.getElementById("total_nominal");
var buatInvoiceButton = document.getElementById("submit");
var tglJatuhTempoInput = document.getElementById("tgl_jatuh_tempo");
var nilaiTagihanInput = document.getElementById("nilai_tagihan");

refreshAllButton.style.display = "none";
updateButton.style.display = "none";
buatInvoiceButton.disabled = true;
divideButton.style.display = "none";

tagihanInput.addEventListener("change", () => {
    tagihanInput.readOnly = true;
    divideButton.style.display = "inline-block";
});

let selectedPphValue = "";

pphSelect.addEventListener("change", () => {
    selectedPphValue = pphSelect.value;
    pphSelect.disabled = true;
    divideButton.style.display = "inline-block";
    buatInvoiceButton.disabled = false;
});

function kosongkanNilai() {
    ppnNominalInput.value = "";
    pphNominalInput.value = "";
    biayaLainnyaInput.value = "";
    biayaLainnyaInput.readOnly = true;
    totalNominalInput.value = "";
    tagihanInput.readOnly = false;
    pphSelect.disabled = false;
    divideButton.style.display = "none";
    refreshAllButton.style.display = "none";
    nilaiTagihanInput.value = "";
    koreksidDpInput.value = "";
    koreksidDpInput.readOnly = false;
}

refreshTagihanButton.addEventListener("click", function () {
    tagihanInput.value = "";
    kosongkanNilai();
});

refreshPphButton.addEventListener("click", function () {
    pphSelect.value = "0";
    kosongkanNilai();
    divideButton.style.display = "inline-block";
});

biayaLainnyaInput.addEventListener("input", function () {
    var biayaLainnyaValue = parseFloat(biayaLainnyaInput.value);

    if (biayaLainnyaValue === 0) {
        refreshAllButton.style.display = "inline-block";
    } else {
        updateButton.style.display = "inline-block";
        buatInvoiceButton.disabled = true;
        refreshAllButton.style.display = "none";
    }
});

biayaLainnyaInput.value = "";
biayaLainnyaInput.readOnly = true;

divideButton.addEventListener("click", function () {
    var tagihan = parseFloat(tagihanInput.value.replace(/[^\d]/g, "")) || 0;
    var koreksi = parseFloat(koreksidDpInput.value.replace(/[^\d]/g, "")) || 0;
    var nilaiTagihan =
        parseFloat(nilaiTagihanInput.value.replace(/[^\d]/g, "")) || 0;
    var nilaiTagihan = tagihan - koreksi;
    var ppn = 0.11 * nilaiTagihan;
    var pph = 0;

    if (pphSelect.value === "1,5%") {
        pph = 0.015 * nilaiTagihan;
    } else if (pphSelect.value === "2%") {
        pph = 0.02 * nilaiTagihan;
    }

    document.getElementById("ppn_nominal").value = formatCurrency(ppn);

    document.getElementById("pph_nominal").value = formatCurrency(pph);

    var biayaLainnya =
        parseFloat(biayaLainnyaInput.value.replace(/[^\d.,]/g, "")) || 0;

    if (biayaLainnya === 0) {
        document.getElementById("biayalain").value = "";
    } else {
        document.getElementById("biayalain").value =
            formatCurrency(biayaLainnya);
    }

    var total = nilaiTagihan + ppn + biayaLainnya - pph;
    document.getElementById("total_nominal").value = formatCurrency(total);

    document.getElementById("nilai_tagihan").value =
        formatCurrency(nilaiTagihan);

    function formatCurrency(value) {
        return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") + ",-";
    }

    // document.getElementById("ppn_nominal").value =
    //     ppn.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-";

    // document.getElementById("pph_nominal").value =
    //     pph.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-";

    // var biayaLainnya =
    //     parseFloat(biayaLainnyaInput.value.replace(/\D/g, "")) || 0;

    // if (biayaLainnya === 0) {
    //     document.getElementById("biayalain").value = "";
    // } else {
    //     document.getElementById("biayalain").value =
    //         biayaLainnya.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") +
    //         ",-";
    // }

    // var total = nilaiTagihan + ppn + biayaLainnya - pph;
    // document.getElementById("total_nominal").value =
    //     total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-";

    // document.getElementById("nilai_tagihan").value =
    //     nilaiTagihan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-";

    divideButton.style.display = "none";
    updateButton.style.display = "none";
    refreshAllButton.style.display = "inline-block";
    biayaLainnyaInput.readOnly = false;
    buatInvoiceButton.disabled = false;
    pphSelect.disabled = true;
    tagihanInput.readOnly = true;
    koreksidDpInput.readOnly = true;
});

updateButton.addEventListener("click", function () {
    var tagihan = parseFloat(tagihanInput.value.replace(/[^\d]/g, "")) || 0;
    var koreksi = parseFloat(koreksidDpInput.value.replace(/[^\d]/g, "")) || 0;
    var nilaiTagihan =
        parseFloat(nilaiTagihanInput.value.replace(/[^\d]/g, "")) || 0;
    var nilaiTagihan = tagihan - koreksi;
    var ppn = 0.11 * nilaiTagihan;
    var pph = 0;

    if (pphSelect.value === "1,5%") {
        pph = 0.015 * nilaiTagihan;
    } else if (pphSelect.value === "2%") {
        pph = 0.02 * nilaiTagihan;
    }

    document.getElementById("ppn_nominal").value = formatCurrency(ppn);

    document.getElementById("pph_nominal").value = formatCurrency(pph);

    var biayaLainnya =
        parseFloat(biayaLainnyaInput.value.replace(/[^\d.,-]/g, "")) || 0;

    if (biayaLainnya === 0) {
        document.getElementById("biayalain").value = "";
    } else {
        document.getElementById("biayalain").value =
            formatCurrency(biayaLainnya);
    }

    var total = nilaiTagihan + ppn + biayaLainnya - pph;
    document.getElementById("total_nominal").value = formatCurrency(total);

    document.getElementById("nilai_tagihan").value =
        formatCurrency(nilaiTagihan);

    function formatCurrency(value) {
        return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") + ",-";
    }

    // document.getElementById("ppn_nominal").value =
    //     ppn.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-";

    // document.getElementById("pph_nominal").value =
    //     pph.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-";

    // var biayaLainnya =
    //     parseFloat(biayaLainnyaInput.value.replace(/\D/g, "")) || 0;

    // if (biayaLainnya === 0) {
    //     document.getElementById("biayalain").value = "";
    // } else {
    //     document.getElementById("biayalain").value =
    //         biayaLainnya.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") +
    //         ",-";
    // }

    // var total = nilaiTagihan + ppn + biayaLainnya - pph;
    // document.getElementById("total_nominal").value =
    //     total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-";

    // document.getElementById("nilai_tagihan").value =
    //     nilaiTagihan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-";
    updateButton.style.display = "none";
    refreshAllButton.style.display = "inline-block";
    biayaLainnyaInput.readOnly = true;
    buatInvoiceButton.disabled = false;
    pphSelect.disabled = true;
    tagihanInput.readOnly = true;
});

refreshAllButton.addEventListener("click", function () {
    tagihanInput.value = "";
    pphSelect.value = "0";
    biayaLainnyaInput.value = "";
    buatInvoiceButton.disabled = true;
    koreksidDpInput.readOnly = true;
    kosongkanNilai();
});

buatInvoiceButton.addEventListener("click", function () {
    pphSelect.disabled = false;
});
