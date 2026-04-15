<?php
 /* Membuat koneksi ke database */
 $koneksi = mysqli_connect("localhost", "root", "", "todo_lisna");

 /* Mengecek apakah koneksi berhasil */
 if (!$koneksi) {
     die("Koneksi gagal: " . mysqli_connect_error());
 }

 /* Memulai session */
 session_start();

?>
