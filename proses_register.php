<?php

/* Menghubungkan ke database */
include '../config/koneksi.php';


/* Mengambil data dari form register */
$username = $_POST['username'];
$password = $_POST['password'];
$role     = $_POST['role'];

/* CEK USERNAME DULU */
$cek = mysqli_query($koneksi, "SELECT * FROM roles WHERE username='$username'");

if (mysqli_num_rows($cek) > 0) {
    // kalau sudah ada
    echo "<script>alert('Username sudah terdaftar!'); window.history.back();</script>";
    exit;
}


/* Menyimpan data user ke database */
mysqli_query($koneksi, "
    INSERT INTO roles (username, password, role) 
    VALUES ('$username','$password','$role')
");


/* Mengarahkan ke halaman login setelah register */
header("Location: login.php");

?>