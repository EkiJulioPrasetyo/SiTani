<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}

$id_akun = $_SESSION['id_akun'];
$nama = $_SESSION['nama'];
$peran = $_SESSION['peran'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - SiTani</title>
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
<body class="bg-green-700 font-sans pt-24 min-h-screen">
  
  <nav class="fixed top-0 left-0 w-full bg-gray-100 shadow-sm flex justify-between items-center px-6 py-4 z-50">
    <div class="flex items-center gap-2">
      <img src="Foto\Logo.png" alt="Logo" class="h-10">
    </div>
    <div class="flex items-center gap-3">
      <img src="Foto/user.png" alt="User Photo" class="w-10 h-10 rounded-full object-cover">
      <span class="text-black font-medium"><?= htmlspecialchars($nama); ?></span>
    </div>
  </nav>

  <div class="max-w-6xl mx-auto py-10 px-6">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
      <h1 class="text-2xl font-bold text-black mb-2">Halo, <?= htmlspecialchars($nama); ?></h1>
      <p class="text-gray-700">Anda Login sebagai <span class="font-bold"><?= htmlspecialchars($peran); ?></span>.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

      <?php if ($peran !== 'admin'): ?>
        <a href="deteksi.php" class="block bg-lime-700 text-white p-6 rounded-xl shadow-md hover:bg-green-900 transition text-center">
          <h2 class="text-xl font-semibold">Deteksi Penyakit</h2>
          <p class="text-sm mt-2">Unggah gambar tanaman dan dapatkan hasil deteksi serta rekomendasi penanganan.</p>
        </a>
      <?php endif; ?>

      <?php if ($peran === 'admin'): ?>
        <a href="historyadmin.php" class="block bg-lime-700 text-white p-6 rounded-xl shadow-md hover:bg-green-900 transition text-center">
          <h2 class="text-xl font-semibold">Riwayat Deteksi (Admin)</h2>
          <p class="text-sm mt-2">Lihat semua riwayat hasil deteksi yang pernah dilakukan.</p>
        </a>
        <a href="profiladmin.php" class="block bg-lime-700 text-white p-6 rounded-xl shadow-md hover:bg-green-900 transition text-center">
          <h2 class="text-xl font-semibold">Profil Admin</h2>
          <p class="text-sm mt-2">Kelola profil Anda dan akun petani.</p>
        </a>
        <a href="trenpenyakit.php" class="block bg-lime-700 text-white p-6 rounded-xl shadow-md hover:bg-green-900 transition text-center">
          <h2 class="text-xl font-semibold">Tren Penyakit</h2>
          <p class="text-sm mt-2">Lihat tren penyakit periode ini.</p>
        </a>
      <?php else: ?>
        <a href="historyuser.php" class="block bg-lime-700 text-white p-6 rounded-xl shadow-md hover:bg-green-900 transition text-center">
          <h2 class="text-xl font-semibold">Riwayat Saya</h2>
          <p class="text-sm mt-2">Lihat riwayat deteksi milik Anda sendiri.</p>
        </a>
        <a href="profiluser.php" class="block bg-lime-700 text-white p-6 rounded-xl shadow-md hover:bg-green-900 transition text-center">
          <h2 class="text-xl font-semibold">Profil Saya</h2>
          <p class="text-sm mt-2">Lihat informasi akun Anda.</p>
        </a>
        <a href="trenpenyakit.php" class="block bg-lime-700 text-white p-6 rounded-xl shadow-md hover:bg-green-900 transition text-center">
          <h2 class="text-xl font-semibold">Tren Penyakit</h2>
          <p class="text-sm mt-2">Lihat tren penyakit periode ini.</p>
        </a>
      <?php endif; ?>
    </div>
  </div>
  <div class="flex justify-center mt-10">
    <a href="logout.php" class="block bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-8 rounded-xl text-center shadow-lg transition">
      Logout
    </a>
  </div>

</body>
</html>
