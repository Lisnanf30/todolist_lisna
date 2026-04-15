<?php
// CEK PARAMETER MSG
if (isset($_GET['msg'])) {

    $msg = $_GET['msg'];

    // default text notifikasi
    $text = "";
    $icon = "success";

    // cek kondisi msg
    if ($msg == 'tambah') {
        $text = "Tugas berhasil ditambahkan";
    } elseif ($msg == 'edit') {
        $text = "Tugas berhasil diupdate";
    } elseif ($msg == 'hapus') {
        $text = "Tugas berhasil dihapus";
    } elseif ($msg == 'login') {
        $text = "Login berhasil!";
    } elseif ($msg == 'logout') {
        $text = "Berhasil logout!";
    } elseif ($msg == 'gagal') {
        $text = "Username atau password salah!";
        $icon = "error";
    }
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: '<?= $icon ?>',
    title: '<?= $text ?>',
}).then(() => {
    window.history.replaceState(null, null, window.location.pathname);
});
</script>
<?php } ?><?php
// Mengecek apakah ada parameter msg di URL
if (isset($_GET['msg'])) {

    // Mengambil nilai msg dari URL
    $msg = $_GET['msg'];

    // Menyimpan teks notifikasi default kosong
    $text = "";

    // Menentukan icon default success
    $icon = "success";

    // Mengecek kondisi berdasarkan isi msg

    // Jika msg tambah menampilkan notifikasi berhasil tambah tugas
    if ($msg == 'tambah') {
        $text = "Tugas berhasil ditambahkan";

    // Jika msg edit menampilkan notifikasi update berhasil
    } elseif ($msg == 'edit') {
        $text = "Tugas berhasil diupdate";

    // Jika msg hapus menampilkan notifikasi data terhapus
    } elseif ($msg == 'hapus') {
        $text = "Tugas berhasil dihapus";

    // Jika msg login menampilkan notifikasi login berhasil
    } elseif ($msg == 'login') {
        $text = "Login berhasil!";

    // Jika msg logout menampilkan notifikasi logout berhasil
    } elseif ($msg == 'logout') {
        $text = "Berhasil logout!";

    // Jika msg gagal menampilkan error login
    } elseif ($msg == 'gagal') {
        $text = "Username atau password salah!";

        // Mengubah icon menjadi error
        $icon = "error";
    }
?>

<!-- Mengambil library SweetAlert2 dari CDN untuk menampilkan popup -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Menampilkan popup notifikasi menggunakan SweetAlert
Swal.fire({

    // Menentukan jenis icon sesuai kondisi
    icon: '<?= $icon ?>',

    // Menampilkan pesan notifikasi
    title: '<?= $text ?>',

// Setelah popup ditutup
}).then(() => {

    // Menghapus parameter msg dari URL tanpa reload halaman
    window.history.replaceState(null, null, window.location.pathname);

});
</script>

<?php } ?>
