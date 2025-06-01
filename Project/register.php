<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $peran = 'petani';

    $stmt = $conn->prepare("INSERT INTO Akun (username, password, peran, nama, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $password, $peran, $nama, $email);

    if ($stmt->execute()) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Gagal registrasi: " . $stmt->error . "'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - SiTani</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-image: url('Foto/Petani.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
  </style>
</head>
<body class="bg-lime-900 min-h-screen flex items-center justify-center font-sans">
  <div class="bg-white bg-opacity-60 backdrop-blur-lg p-8 rounded-lg shadow-xl w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-lime-700 mb-6">Daftar Akun SiTani</h2>
    <form action="register.php" method="POST" class="space-y-5">
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Nama</label>
        <input type="text" name="nama" required class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
      </div>
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Username</label>
        <input type="text" name="username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
      </div>
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Email</label>
        <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
      </div>
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
      </div>
      <button
        type="submit"
        class="w-full bg-lime-600 hover:bg-lime-700 text-white font-semibold py-2 px-4 rounded-lg transition"
      >
        Daftar
      </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-500">
      Sudah punya akun? <a href="login.php" class="text-lime-600 hover:underline font-medium">Login di sini</a>
    </p>
  </div>

</body>
</html>
