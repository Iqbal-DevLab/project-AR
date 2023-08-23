const totalAkumulasi = document.getElementById("total");
const totalDanaMasuk = document.getElementById("akumulasi_penerimaan");

totalDanaMasuk.value = totalAkumulasi.textContent;
// console.log(totalAkumulasi.textContent);

function confirmDelete(t, id, no_invoice) {
    Swal.fire({
        title: "Konfirmasi",
        text:
            "Apakah Anda yakin ingin membatalkan transaksi dengan no. invoice " +
            no_invoice +
            "?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = t;
        }
    });
}

const switchEl = document.getElementById("switch");
const nonGiro = document.getElementById("nonGiro");
const giro = document.getElementById("giro");

switchEl.addEventListener("change", function () {
    if (this.checked) {
        // Switch is on (GIRO)
        nonGiro.hidden = true;
        giro.hidden = false;
    } else {
        // Switch is off (NON-GIRO)
        nonGiro.hidden = false;
        giro.hidden = true;
    }
});
