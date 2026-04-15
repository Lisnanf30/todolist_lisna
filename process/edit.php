<?php
include '../config/koneksi.php';

/*
 Proses saat tombol update diklik
 Mengambil data dari form lalu mengupdate data di database
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $task = $_POST['task'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];

    mysqli_query($koneksi, "UPDATE tasks 
        SET task='$task', description='$description', deadline='$deadline' 
        WHERE id=$id"
    );

    /*sweetalert edit */
   header("Location: ../admin/dashboard.php?msg=edit");
exit;

    // Pindah ke halaman dashboard sesuai role user
    header("Location: ../".$_SESSION['user']['role']."/dashboard.php");
    exit;
}

/*
 Mengambil data tugas berdasarkan ID saat halaman dibuka
*/
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM tasks WHERE id=$id");

/*
 Mengecek apakah query berhasil dijalankan
*/
if (!$data) {
    die("Query error: " . mysqli_error($koneksi));
}

$row = mysqli_fetch_assoc($data);

/*
 Mengecek apakah data dengan ID tersebut ada
*/
if (!$row) {
    die("Data tidak ditemukan");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
    <h2>Edit Tugas</h2>

    <!-- Form untuk mengubah data tugas -->
    <form action="" method="POST">

        <!-- Menyimpan ID tugas (tidak terlihat oleh user) -->
        <input type="hidden" name="id" value="<?= $row['id']; ?>">

        <!-- Input nama tugas -->
        <input type="text" name="task" value="<?= $row['task']; ?>" required>

        <!-- Input deskripsi tugas -->
        <textarea name="description"><?= $row['description']; ?></textarea>

        <!-- Input tanggal deadline -->
        <input type="datetime-local" name="deadline" value="<?= $row['deadline']; ?>" required>

        <!-- Tombol untuk menyimpan perubahan -->
        <button type="submit">Update</button>
    </form>
</div>

</body>
</html>
