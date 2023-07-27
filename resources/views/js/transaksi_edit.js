document.addEventListener("DOMContentLoaded", function () {
    var danaMasukInput = document.getElementById("dana_masuk_giro");
    var nilaiGiroInput = document.getElementById("nilai_giro");
    var bankChargeInput = document.getElementById("bank_charge");
    var totalDanaMasukInput = document.getElementById("total_dana_masuk_i");

    function updateTotalDanaMasuk(Transfer) {
        // Mendapatkan nilai dana masuk
        const danaMasuk =
            parseFloat(danaMasukInput.value.replace(/\D/g, "")) || 0; // Menghapus karakter selain digit

        // Menghitung total dana masuk setelah dikurangi bank charge atau sama dengan dana masuk jika bank charge belum diisi
        const totalDanaMasuk = danaMasuk;

        // Memperbarui nilai total dana masuk
        totalDanaMasukInput.value =
            totalDanaMasuk >= 0
                ? "Rp. " + totalDanaMasuk.toLocaleString("id-ID")
                : 0; // Menampilkan format angka dengan tanda titik sebagai pemisah ribuan dan mengatur nilai default menjadi 0 jika negatif
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
});

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

document.addEventListener("DOMContentLoaded", function () {
    var checkbox = document.getElementById("switch");
    var label = document.querySelector(".col-form-check-label");

    checkbox.disabled = true;
    // label.style.color = "gray";
});
