const total = document.getElementById("total");
const totalAR = document.getElementById("total_AR");

totalAR.value = total.textContent;
console.log(total.textContent);

function ttkFunction(id) {
    // var tglTtkInput = document.getElementById(`tgl_ttk${id}`);
    var tglJatuhTempoSelect = document.getElementById(`batas_jatuh_tempo${id}`);
    // console.log(tglTtkInput.value);
    tglJatuhTempoSelect.disabled = false;
}

function jatuhTempo(jatuhTempo, id, i) {
    var tglTtkInput = document.getElementById(`tgl_ttk${id}`);
    var tglJatuhTempoInput = document.getElementById(`tgl_jatuh_tempo${id}`);
    var lainnyaForm = document.getElementById(`lainnya${id}`);
    var simpanButton = document.getElementById(`submit${id}`);

    var tglttk = tglTtkInput.value;
    var tglTtkParts = tglttk.split("-");
    var tanggalTtk = new Date(
        tglTtkParts[2],
        tglTtkParts[1] - 1,
        tglTtkParts[0]
    );
    var selectedOptionValue = parseInt(jatuhTempo);
    tanggalTtk.setDate(tanggalTtk.getDate() + selectedOptionValue);

    if (jatuhTempo !== "" && i == false) {
        lainnyaForm.style.display = "none";
    } else {
        lainnyaForm.style.display = "block";
    }

    var dd = String(tanggalTtk.getDate()).padStart(2, "0");
    var mm = String(tanggalTtk.getMonth() + 1).padStart(2, "0");
    var yyyy = tanggalTtk.getFullYear();

    tglJatuhTempoInput.value = dd + "-" + mm + "-" + yyyy;
}

function submitFunction(event, id) {
    var tglTtkInput = document.getElementById(`tgl_ttk${id}`);
    var tglJatuhTempoInput = document.getElementById(`tgl_jatuh_tempo${id}`);
    var tglJatuhTempoSelect = document.getElementById(`batas_jatuh_tempo${id}`);

    // Periksa apakah ada input yang kosong
    if (tglTtkInput.value == "" || tglJatuhTempoInput.value == "") {
        // Tampilkan pesan kesalahan menggunakan Swal
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Mohon lengkapi semua input sebelum submit!",
        });

        // Mencegah pengiriman form ke server
        event.preventDefault();
    } else {
        event.target.submit();
    }
}

function confirmDelete(i, id, no_invoice) {
    Swal.fire({
        title: "Konfirmasi",
        text:
            "Apakah Anda yakin ingin membatalkan Invoice dengan Nomor " +
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
            window.location.href = i;
        }
    });
}
