// $("body").on("click", "#edituser", function (e) {
//     e.preventDefault();
//     let id = $(this).data("id");
//     $.get("/superadmin/user/" + id, function (data) {
//         $("#id").val(data.user.id).prop("hidden", true);
//         $("#nik_karyawan").val(data.user.nik_karyawan).prop("readonly", true);
//         $("#nama_karyawan").val(data.user.nama_karyawan).prop("readonly", true);
//         $("#password").val(data.user.password);
//         $("#status_user").val(data.user.status_user);
//         $("#role_user").val(data.user.role_user);
//     });
// });
