<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_akun']) || $_SESSION['peran'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $stmt = $conn->prepare("SELECT gambar_url FROM DeteksiPenyakit WHERE id_deteksi = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nama_file);
    $stmt->fetch();
    $stmt->close();

    if ($nama_file && file_exists("uploads/$nama_file")) {
        unlink("uploads/$nama_file");
    }

    $stmt = $conn->prepare("DELETE FROM DeteksiPenyakit WHERE id_deteksi = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: historyadmin.php");
    exit;
}

$result = $conn->query("SELECT dp.*, a.nama AS nama_pengguna FROM DeteksiPenyakit dp JOIN Akun a ON dp.id_akun = a.id_akun ORDER BY dp.tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Deteksi Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 py-10 px-6 font-sans">

  <div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6 text-lime-800">Riwayat Semua Deteksi Gambar</h1>

    <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden text-sm">
      <thead class="bg-lime-700 text-white">
        <tr>
          <th class="py-2 px-4 text-left">Waktu</th>
          <th class="py-2 px-4 text-left">Pengguna</th>
          <th class="py-2 px-4 text-left">Gambar</th>
          <th class="py-2 px-4 text-left">Label</th>
          <th class="py-2 px-4 text-left">Rekomendasi</th>
          <th class="py-2 px-4 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr class="border-b hover:bg-lime-50">
          <td class="py-2 px-4"><?php echo $row['tanggal']; ?></td>
          <td class="py-2 px-4"><?php echo htmlspecialchars($row['nama_pengguna']); ?></td>
          <td class="py-2 px-4">
            <img src="uploads/<?php echo htmlspecialchars($row['gambar_url']); ?>" alt="Gambar" class="h-16 rounded shadow">
          </td>
          <td class="py-2 px-4 font-semibold text-green-700"><?php echo htmlspecialchars($row['hasil_deteksi']); ?></td>
          <td class="py-2 px-4"><?php echo htmlspecialchars($row['rekomendasi']); ?></td>
          <td class="py-2 px-4">
            <a
              href="historyadmin.php?hapus=<?php echo $row['id_deteksi']; ?>"
              onclick="return confirm('Yakin ingin menghapus data ini?')"
              class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition"
            >Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <div class="mt-6 text-center">
    <a href="dashboard.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded shadow inline-block">Kembali</a>
  </div>
  
</body>
</html>
