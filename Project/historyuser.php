<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_akun']) || $_SESSION['peran'] !== 'petani') {
    header("Location: login.php");
    exit;
}

$id_akun = $_SESSION['id_akun'];

if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];

    $cek = $conn->prepare("SELECT gambar_url FROM DeteksiPenyakit WHERE id_deteksi = ? AND id_akun = ?");
    $cek->bind_param("ii", $id_hapus, $id_akun);
    $cek->execute();
    $cek->bind_result($gambar);
    if ($cek->fetch()) {
        $cek->close();
        if (file_exists("uploads/$gambar")) {
            unlink("uploads/$gambar");
        }
        $del = $conn->prepare("DELETE FROM DeteksiPenyakit WHERE id_deteksi = ? AND id_akun = ?");
        $del->bind_param("ii", $id_hapus, $id_akun);
        $del->execute();
        header("Location: historyuser.php");
        exit;
    } else {
        $cek->close();
    }
}

$stmt = $conn->prepare("SELECT * FROM DeteksiPenyakit WHERE id_akun = ? ORDER BY tanggal DESC");
$stmt->bind_param("i", $id_akun);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Deteksi Saya</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 py-10 px-6 font-sans">
  <div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6 text-lime-800">Riwayat Deteksi Gambar Saya</h1>

    <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden text-sm">
      <thead class="bg-lime-700 text-white">
        <tr>
          <th class="py-2 px-4 text-left">Waktu</th>
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
          <td class="py-2 px-4">
            <img src="uploads/<?php echo htmlspecialchars($row['gambar_url']); ?>" alt="Gambar" class="h-16 rounded shadow">
          </td>
          <td class="py-2 px-4 font-semibold text-green-700"><?php echo htmlspecialchars($row['hasil_deteksi']); ?></td>
          <td class="py-2 px-4"><?php echo htmlspecialchars($row['rekomendasi']); ?></td>
          <td class="py-2 px-4">
            <a href="?hapus=<?php echo $row['id_deteksi']; ?>"
               onclick="return confirm('Yakin ingin menghapus riwayat ini?')"
               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
              Hapus
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <div class="mt-6 text-center">
     <a href="dashboard.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded shadow">Kembali</a>
  </div>

</body>
</html>
