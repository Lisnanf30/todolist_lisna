<?php
include '../config/koneksi.php';

/*
 Mengecek apakah user adalah admin
 Jika bukan admin, maka tidak boleh menghapus data
*/
if ($_SESSION['user']['role'] != 'admin') {
    echo "Akses ditolak!";
    exit;
}

/*
 Mengambil ID tugas dari URL
*/
$id = $_GET['id'];

/*
 Menghapus data tugas berdasarkan ID di database
*/
mysqli_query($koneksi, "DELETE FROM tasks WHERE id=$id");

/* sweetalert hapus */
header("Location: ../admin/dashboard.php?msg=hapus");
exit;

/*
 Setelah data dihapus, kembali ke halaman dashboard admin
*/
header("Location: ../admin/dashboard.php");
?>