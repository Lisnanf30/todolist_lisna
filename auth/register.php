<!DOCTYPE html>
<html>

<head>
    <!-- Judul halaman register -->
    <title>Register</title>

    <!-- Menghubungkan file CSS -->
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

    <!-- Container utama untuk form register -->
    <div class="register-container">

        <h2>Register</h2>

        <!-- Form untuk proses registrasi user -->
        <form action="proses_register.php" method="POST">

            <input type="text" name="username" placeholder="Username" required>

            <input type="password" name="password" placeholder="Password" required>

            <!-- Pilihan role user -->
            <select name="role">

                <option value="user">User</option>
                <option value="admin">Admin</option>

            </select>

            <button type="submit">Register</button>

        </form>

        <!-- Link menuju halaman login -->
        <p>
            Sudah punya akun?
            <a href="login.php">Login</a>
        </p>

    </div>
</body>

</html>