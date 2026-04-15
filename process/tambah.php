<?php
include '../config/koneksi.php';
session_start();

/*
 Mengambil data dari form yang dikirim user
*/
$task        = $_POST['task'];
$description = $_POST['description'];
$deadline    = $_POST['deadline'];

// CEK DEADLINE TIDAK BOLEH KURANG DARI WAKTU SEKARANG
if (strtotime($deadline) < time()) {
    header("Location: ../admin/dashboard.php?msg=error");
    exit;
}

/*
 Menentukan user_id
 Jika admin, bisa pilih user
 Jika bukan admin, otomatis pakai ID user yang login
*/
if ($_SESSION['user']['role'] == 'admin') {
    $user_id = $_POST['user_id']; 
} else {
    $user_id = $_SESSION['user']['id'];
}

/*
 Proses upload file (jika ada file yang diinput)
*/
$file = NULL;

if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {

    $namaFile = $_FILES['file']['name'];
    $tmp      = $_FILES['file']['tmp_name'];

    // Mengambil ekstensi file (contoh: jpg, pdf, dll)
    $ext = pathinfo($namaFile, PATHINFO_EXTENSION);

    // Membuat nama file baru agar tidak bentrok
    $namaBaru = time() . '.' . $ext;

    // Memindahkan file ke folder uploads
    move_uploaded_file($tmp, '../uploads/' . $namaBaru);

    // Menyimpan nama file ke variabel
    $file = $namaBaru;
}

/*
 Menyimpan data tugas ke database
*/
$query = mysqli_query($koneksi, "
    INSERT INTO tasks (task, description, deadline, status, user_id, file) 
    VALUES ('$task','$description','$deadline','open','$user_id','$file')
");

/*sweetalert tambah*/
header("Location: ../admin/dashboard.php?msg=tambah");
exit;

/*
 Mengecek apakah data berhasil disimpan
*/
if (!$query) {
    die("Error: " . mysqli_error($koneksi));
}

/*
 Setelah berhasil, kembali ke dashboard sesuai role user
*/
header("Location: ../".$_SESSION['user']['role']."/dashboard.php");
?>