<?php
session_start();
include '../config/koneksi.php';

/*
 Mengecek apakah user sudah login
 Jika belum login, akan diarahkan ke halaman login
*/
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

/*
 Proses upload file untuk tugas
*/
if (isset($_POST['task_id'])) {

    $task_id = $_POST['task_id'];
    $user_id = $_SESSION['user']['id'];

    $file = $_FILES['file']['name'];
    $tmp  = $_FILES['file']['tmp_name'];

    // Mengambil jenis file (contoh: pdf, jpg)
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    // Daftar file yang boleh diupload
    $allowed = ['pdf','doc','docx','xls','xlsx','jpg','jpeg','png'];

    // Mengecek apakah file termasuk yang diperbolehkan
    if (in_array($ext, $allowed)) {

        // Membuat nama file baru supaya tidak bentrok
        $new_name = time().'.'.$ext;

        // Memindahkan file ke folder uploads
        if (move_uploaded_file($tmp, "../uploads/".$new_name)) {

            // Menyimpan nama file ke database sesuai tugas milik user
            mysqli_query($koneksi, "
                UPDATE tasks 
                SET file='$new_name'
                WHERE id='$task_id' 
                AND user_id='$user_id'
            ");

            // Kembali ke dashboard user
            header("Location: ../user/dashboard.php");
            exit;

        } else {
            echo "Gagal upload file!";
        }

    } else {
        echo "Format file tidak didukung!";
    }
}

/*
 Proses mengubah status tugas
*/
if (isset($_GET['id']) && isset($_GET['status'])) {

    $id = $_GET['id'];
    $status = $_GET['status'];

    // Jika yang mengubah adalah user biasa
    if ($_SESSION['user']['role'] == 'user') {

        $user_id = $_SESSION['user']['id'];

        // User hanya bisa mengubah tugas miliknya sendiri
        mysqli_query($koneksi, "
            UPDATE tasks 
            SET status='$status' 
            WHERE id='$id' 
            AND user_id='$user_id'
        ");

    } else {

        // Admin bisa mengubah semua tugas
        mysqli_query($koneksi, "
            UPDATE tasks 
            SET status='$status' 
            WHERE id='$id'
        ");
    }

    // Setelah update, kembali ke dashboard sesuai role
    header("Location: ../".$_SESSION['user']['role']."/dashboard.php");
    exit;
}
?>