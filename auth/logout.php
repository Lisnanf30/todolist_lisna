<?php
 session_start();

 /* Menghapus semua data session */
 session_destroy();

 /* Mengarahkan user kembali ke halaman login */
 header("Location: login.php?msg=logout");
 exit;

?>