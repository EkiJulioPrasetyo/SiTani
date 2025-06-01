<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    
    if (mysqli_num_rows($cek) > 0) {
        $update = mysqli_query($conn, "UPDATE users SET password='$new_password' WHERE username='$username'");
        if ($update) {
            echo "Password berhasil direset. Silakan <a href='login.html'>login kembali</a>.";
        } else {
            echo "Gagal mengupdate password.";
        }
    } else {
        echo "Username tidak ditemukan.";
    }
}
?>
