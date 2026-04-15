<!DOCTYPE html>
 <html>

 <head>
    <!-- Menentukan judul halaman yang tampil di tab browser -->
    <title>Login</title>

    <!-- Menghubungkan file CSS untuk mengatur tampilan -->
    <link rel="stylesheet" href="../assets/style.css">
 </head>

 <body>

    <!-- Container sebagai pembungkus form login agar rapi di tengah -->
    <div class="login-container">

        <!-- Judul halaman login -->
        <h2>Login</h2>

        <!-- Form untuk mengirim data login ke server -->
        <form action="proses_login.php" method="POST">

            <!-- Input untuk memasukkan username -->
            <input type="text" name="username" placeholder="Username" required>

            <!-- Input untuk memasukkan password dan disembunyikan -->
            <input type="password" name="password" placeholder="Password" required>

            <!-- Tombol untuk mengirim data login -->
            <button type="submit">Login</button>

        </form>

        <!-- Teks dan link menuju halaman register -->
        <p class="register-link">
            <!-- Informasi jika belum punya akun -->
            Belum punya akun?

            <!-- Link ke halaman register -->
            <a href="register.php">Register</a>
        </p>

    </div>

    <!-- Memanggil file alert untuk menampilkan notifikasi popup -->
    <?php include '../config/alert.php'; ?>
    
 </body>

 </html>
