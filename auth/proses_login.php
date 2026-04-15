<?php

 /* Menghubungkan ke database */
 include '../config/koneksi.php';


 /* Mengambil data dari form login */
 $username = $_POST['username'];
 $password = $_POST['password'];

 
 /* Mengecek data user di database */
 $data = mysqli_query($koneksi, "
     SELECT * 
     FROM roles 
     WHERE username='$username' 
     AND password='$password'
 ");

 $user = mysqli_fetch_assoc($data);


 /* Jika user ditemukan */
 if ($user) {

    /* Menyimpan data user ke session */
    $_SESSION['user'] = $user;

    /* Mengarahkan berdasarkan role */
    if ($user['role'] == 'admin') {

        header("Location: ../admin/dashboard.php?msg=login");

    } else {

        header("Location: ../user/dashboard.php?msg=login");

    }

 } else {

    /* Jika login gagal */
    header("Location: login.php?msg=gagal");

 }
 exit;
?>