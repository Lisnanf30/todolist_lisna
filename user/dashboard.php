<?php
// Menghubungkan ke database agar bisa ambil data
include '../config/koneksi.php';

//Mengecek apakah user sudah login dan memiliki role user
// Jika tidak sesuai, diarahkan ke halaman login

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'user') {
    header("Location: ../auth/login.php"); // mengalihkan ke login
    exit; // menghentikan proses
}

/*
 Mengambil ID user yang sedang login dari session
 Digunakan untuk filter data tugas milik user tersebut
*/
$user_id = $_SESSION['user']['id'];

/*
 Mengambil data tugas dengan status open milik user
*/
$open = mysqli_query($koneksi, "
    SELECT * FROM tasks 
    WHERE user_id='$user_id' AND status='open'
");

/*
 Mengambil data tugas dengan status in progress
*/
$progress = mysqli_query($koneksi, "
    SELECT * FROM tasks 
    WHERE user_id='$user_id' AND status='in_progress'
");

/*
 Mengambil data tugas dengan status done
*/
$done = mysqli_query($koneksi, "
    SELECT * FROM tasks 
    WHERE user_id='$user_id' AND status='done'
");

/*
 Mengambil semua data tugas milik user
 Digunakan untuk pilihan saat upload file
*/
$data = mysqli_query($koneksi, "
    SELECT * FROM tasks 
    WHERE user_id='$user_id'
");
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Judul halaman -->
    <title>Dashboard Siswa</title>

    <!-- Menghubungkan file CSS -->
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div class="container">

    <!-- Bagian header -->
    <div class="header">

        <!-- Judul dashboard -->
        <h2>Dashboard Siswa</h2>

        <!-- Tombol logout -->
        <a href="../auth/logout.php" class="logout">Logout</a>
    </div>

    <!-- Form upload file tugas -->
    <form action="../process/update.php" method="POST" enctype="multipart/form-data" class="form-upload">

        <!-- Judul form -->
        <h3>Kirim Tugas</h3>

        <!-- Dropdown memilih tugas -->
        <select name="task_id" required>

            <!-- Pilihan default -->
            <option value="">Pilih Tugas</option>

            <?php while($row = mysqli_fetch_assoc($data)) { ?>

                <!-- Menampilkan daftar tugas milik user -->
                <option value="<?= $row['id']; ?>">
                    <?= $row['task']; ?>
                </option>

            <?php } ?>

        </select>

        <!-- Input upload file -->
        <input type="file" name="file" required>

        <!-- Tombol kirim file -->
        <button type="submit">Upload File</button>

    </form>

    <!-- Tampilan kanban board -->
    <div class="board">

        <!-- Kolom tugas open -->
        <div class="column">

            <!-- Menampilkan jumlah tugas open -->
            <h3>Open (<?= mysqli_num_rows($open); ?>)</h3>

            <?php while($row = mysqli_fetch_assoc($open)) { ?>

                <div class="card">

                    <!-- Judul tugas -->
                    <b><?= $row['task']; ?></b>

                    <!-- Deskripsi tugas -->
                    <p><?= $row['description']; ?></p>

                    <!-- Deadline tugas -->
                    <small>📅 <?= date('d-m-Y H:i', strtotime($row['deadline'])); ?></small>

                    <!-- Mengecek apakah ada file -->
                    <?php if($row['file'] != NULL) { ?>

                        <div class="file">

                            <!-- Link melihat file -->
                            <a href="../uploads/<?= $row['file']; ?>" target="_blank">
                                👀 Lihat File
                            </a>

                            <!-- Link download file -->
                            <a href="../uploads/<?= $row['file']; ?>" download>
                                ⬇️ Download
                            </a>

                        </div>

                    <?php } ?>

                    <!-- Tombol ubah status -->
                    <div class="aksi">

                        <!-- Mengubah status ke in progress -->
                        <a href="../process/update.php?id=<?= $row['id']; ?>&status=in_progress" 
                           class="btn-progress">
                           ➡️ Mulai
                        </a>

                    </div>

                </div>

            <?php } ?>

        </div>

        <!-- Kolom tugas sedang dikerjakan -->
        <div class="column">

            <h3>In Progress (<?= mysqli_num_rows($progress); ?>)</h3>

            <?php while($row = mysqli_fetch_assoc($progress)) { ?>

                <div class="card">

                    <b><?= $row['task']; ?></b>
                    <p><?= $row['description']; ?></p>
                    <small>📅<?= date('d-m-Y H:i', strtotime($row['deadline'])); ?></small>

                    <!-- Mengecek file -->
                    <?php if($row['file'] != NULL) { ?>

                        <div class="file">

                            <a href="../uploads/<?= $row['file']; ?>" target="_blank" class="lihat">
                                👀 Lihat File
                            </a>

                            <a href="../uploads/<?= $row['file']; ?>" download>
                                ⬇️ Download
                            </a>

                        </div>

                    <?php } ?>

                    <!-- Tombol ubah status ke selesai -->
                    <div class="aksi">

                        <a href="../process/update.php?id=<?= $row['id']; ?>&status=done"
                           class="btn-done">
                           ➡️ Selesai
                        </a>

                    </div>

                </div>

            <?php } ?>

        </div>

        <!-- Kolom tugas selesai -->
        <div class="column">

            <h3>Done (<?= mysqli_num_rows($done); ?>)</h3>

            <?php while($row = mysqli_fetch_assoc($done)) { ?>

                <div class="card">

                    <b><?= $row['task']; ?></b>
                    <p><?= $row['description']; ?></p>
                    <small>📅 <?= date('d-m-Y H:i', strtotime($row['deadline'])); ?></small>

                    <!-- Mengecek file -->
                    <?php if($row['file'] != NULL) { ?>

                        <div class="file">

                            <a href="../uploads/<?= $row['file']; ?>" target="_blank">
                                👀 Lihat File
                            </a>

                            <a href="../uploads/<?= $row['file']; ?>" download>
                                ⬇️ Download
                            </a>

                        </div>

                    <?php } ?>

                </div>

            <?php } ?>

        </div>

    </div>

</div>

<!-- Menampilkan notifikasi alert -->
<?php include '../config/alert.php'; ?>

</body>
</html>
