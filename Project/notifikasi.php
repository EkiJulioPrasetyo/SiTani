<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}

$peran = $_SESSION['peran'];

if ($peran !== 'petani') {
    echo "Akses ditolak.";
    exit;
}

$data = $conn->query("SELECT * FROM Notifikasi WHERE untuk_peran = 'petani' ORDER BY tanggal_dibuat DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 text-gray-800 p-10">
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-6 text-green-800">Notifikasi untuk Anda</h2>

    <?php if ($data->num_rows > 0): ?>
        <ul class="space-y-4">
            <?php while ($row = $data->fetch_assoc()): ?>
                <li class="border border-gray-300 rounded-lg p-4 bg-green-100 hover:bg-green-200 transition">
                    <div class="text-sm text-gray-600"><?php echo date('d M Y, H:i', strtotime($row['tanggal_dibuat'])); ?></div>
                    <div class="mt-1 text-gray-900"><?php echo $row['pesan']; ?></div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p class="text-gray-600">Belum ada notifikasi.</p>
    <?php endif; ?>

    <div class="mt-6 text-center">
        <a href="dashboard.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded shadow">
            Kembali ke Dashboard
        </a>
    </div>
</div>
</body>
</html>
