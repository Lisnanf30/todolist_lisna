<?php
 include '../config/koneksi.php'; // menghubungkan file koneksi ke database MySQL

 // cek apakah user sudah login sebagai admin
 // jika tidak login atau bukan admin maka diarahkan ke halaman login
 if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../auth/login.php"); // pindah ke halaman login
    exit; // menghentikan eksekusi kode
 }

 // mengambil semua data tugas dan username user
 // JOIN digunakan untuk menggabungkan tabel tasks dan roles
 $data = mysqli_query($koneksi, "
    SELECT tasks.*, roles.username 
    FROM tasks 
    JOIN roles ON tasks.user_id = roles.id
 ");

 // mengambil data tugas berdasarkan status
 // digunakan untuk tampilan kanban
 $open     = mysqli_query($koneksi, "SELECT * FROM tasks WHERE status='open'"); // tugas belum dikerjakan
 $progress = mysqli_query($koneksi, "SELECT * FROM tasks WHERE status='in_progress'"); // tugas sedang dikerjakan
 $done     = mysqli_query($koneksi, "SELECT * FROM tasks WHERE status='done'"); // tugas selesai
 ?>

 <!DOCTYPE html>
 <html>
 <head>
    <title>Dashboard Guru</title>
    <!-- menghubungkan file CSS untuk tampilan -->
    <link rel="stylesheet" href="../assets/style.css">
 </head>

 <body>

 <div class="container"> <!-- wadah utama semua isi dashboard -->

    <!-- HEADER -->
    <!-- menampilkan judul halaman dan tombol logout -->
    <div class="header">
        <h2>Dashboard Guru</h2> <!-- judul dashboard -->
        <a class="logout" href="../auth/logout.php">Logout</a> <!-- tombol keluar -->
    </div>

    <!-- FORM TAMBAH -->
    <!-- form ini digunakan admin/guru untuk menambahkan tugas -->
    <form action="../process/tambah.php" method="POST">

        <!-- input judul tugas -->
        <input type="text" name="task" placeholder="Judul tugas..." required>

        <!-- input deskripsi tugas -->
        <textarea name="description" placeholder="Deskripsi tugas..." required></textarea>

        <!-- input deadline dengan tanggal + jam -->
        <!-- min digunakan untuk membatasi agar tidak bisa pilih waktu sebelum sekarang -->
        <input type="datetime-local" name="deadline" min="<?= date('Y-m-d\TH:i'); ?>" required>

        <!-- dropdown memilih user yang menerima tugas -->
        <select name="user_id" required>
            <option value="">Pilih User</option>

            <?php
            // mengambil semua user dari tabel roles
            $roles = mysqli_query($koneksi, "SELECT * FROM roles WHERE role='user'");
            while($u = mysqli_fetch_assoc($roles)) {
            ?>
                <!-- menampilkan username dalam dropdown -->
                <option value="<?= $u['id']; ?>">
                    <?= $u['username']; ?>
                </option>
            <?php } ?>
        </select>

        <!-- tombol submit untuk menyimpan tugas -->
        <button type="submit">Tambah</button>

    </form>

    <!-- TABEL DATA -->
    <!-- menampilkan semua tugas dalam bentuk tabel lengkap -->
    <table>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Tugas</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>File</th>
            <th>Aksi</th>
            <th>Deadline</th>
        </tr>

        <?php 
        $no = 1; // nomor urut
        while($row = mysqli_fetch_assoc($data)) { 
        ?>
        <tr>

            <!-- nomor urut -->
            <td><?= $no++; ?></td>

            <!-- nama user -->
            <td><?= $row['username']; ?></td>

            <!-- judul tugas -->
            <td><?= $row['task']; ?></td>

            <!-- deskripsi -->
            <td><?= $row['description']; ?></td>

            <!-- status dengan class warna -->
            <td class="<?=
                ($row['status']=='open') ? 'status-open' : 
                (($row['status']=='in_progress') ? 'status-progress' : 'status-done');
            ?>">
                <?= $row['status']; ?>
            </td>

            <!-- file -->
            <td>
                <?php if($row['file']) { ?>
                    <a href="../uploads/<?= $row['file']; ?>">👀 Lihat</a>
                <?php } else { ?>
                    Tidak ada file
                <?php } ?>
            </td>

            <!-- aksi edit dan hapus -->
            <td>
                <a href="../process/edit.php?id=<?= $row['id']; ?>" class="edit" 
                onclick="return confirmEdit(event, this)">Edit
                </a>
                <a href="../process/hapus.php?id=<?= $row['id']; ?>" class="hapus"
                 onclick="return confirmDelete(event, this)">Hapus
                </a>
            </td>

            <!-- deadline + pengecekan apakah sudah lewat -->
            <td class="<?= (strtotime($row['deadline']) < time()) ? 'deadline-lewat' : '' ?>">
                <?= date('d-m-Y H:i', strtotime($row['deadline'])); ?>
            </td>

        </tr>
        <?php } ?>

    </table>

 </div>

 <!-- memanggil file alert untuk notifikasi -->
 <?php include '../config/alert.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// fungsi untuk konfirmasi sebelum hapus data
function confirmDelete(event, el) {

    // mencegah link langsung dijalankan
    event.preventDefault();

    // menampilkan popup konfirmasi
    Swal.fire({
        title: 'Yakin mau hapus?',
        text: 'Data akan hilang permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {

        // jika user klik tombol hapus
        if (result.isConfirmed) {
            // lanjut ke proses hapus
            window.location.href = el.href;
        }

    });

    return false;
}
</script>

<script>
// fungsi konfirmasi sebelum edit
function confirmEdit(event, el) {

    // mencegah langsung pindah halaman
    event.preventDefault();

    Swal.fire({
        title: 'Edit data?',
        text: 'Pastikan data yang akan diubah sudah benar',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Edit',
        cancelButtonText: 'Batal'
    }).then((result) => {

        // kalau user klik edit
        if (result.isConfirmed) {
            window.location.href = el.href;
        }

    });

    return false;
}
</script>

 </body>
 </html>
