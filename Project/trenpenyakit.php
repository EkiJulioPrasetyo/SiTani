<?php
session_start();
include 'koneksi.php';

require 'mail.php';

if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}
$peran = $_SESSION['peran'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $peran === 'admin') {
    $id      = $_POST['id'] ?? null;
    $nama    = $_POST['nama_penyakit'];
    $jumlah  = $_POST['jumlah_kasus'];
    $periode = $_POST['periode'];
    $tanggal = date('Y-m-d H:i:s');

    if ($id) {
        $stmt = $conn->prepare("
          UPDATE TrenPenyakit 
             SET nama_penyakit=?, jumlah_kasus=?, periode=?, tanggal_diperbarui=?
           WHERE id_tren=?
        ");
        $stmt->bind_param("ssssi", $nama, $jumlah, $periode, $tanggal, $id);
        $aksi = 'update';
    } else {
        $stmt = $conn->prepare("
          INSERT INTO TrenPenyakit (nama_penyakit, jumlah_kasus, periode, tanggal_diperbarui)
          VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("ssss", $nama, $jumlah, $periode, $tanggal);
        $aksi = 'insert';
    }

    if ($stmt->execute()) {
        $pesanNotif = ($aksi==='insert')
            ? "Penambahan tren penyakit <b>$nama</b> ($jumlah kasus, periode $periode)"
            : "Update tren penyakit <b>$nama</b> ($jumlah kasus, periode $periode)";

        $qn = $conn->prepare("
          INSERT INTO Notifikasi (pesan, untuk_peran)
          VALUES (?, 'petani')
        ");
        $qn->bind_param("s", $pesanNotif);
        $qn->execute();


        $subject = ($aksi==='insert')
            ? "Penambahan Data Tren Penyakit"
            : "Update Data Tren Penyakit";

        $body  = "<h2>$subject</h2>"
               . "<p><strong>Penyakit:</strong> $nama</p>"
               . "<p><strong>Jumlah Kasus:</strong> $jumlah</p>"
               . "<p><strong>Periode:</strong> $periode</p>"
               . "<p><strong>Waktu:</strong> $tanggal</p>";

        sendEmailToPetani($subject, $body);
    }

    header("Location: trenpenyakit.php");
    exit;
}


if (isset($_GET['hapus']) && $peran === 'admin') {
    $idH = (int) $_GET['hapus'];
    $sth = $conn->prepare("DELETE FROM TrenPenyakit WHERE id_tren=?");
    $sth->bind_param("i", $idH);
    $sth->execute();
    header("Location: trenpenyakit.php");
    exit;
}

$data = $conn->query("SELECT * FROM TrenPenyakit ORDER BY periode DESC");

$penyakitList = ['Leaf Curl', 'Leaf Spot', 'White Fly', 'Yellowish'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tren Penyakit</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 text-gray-800 p-10">
<div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow">
  <h2 class="text-2xl font-bold mb-6 text-green-800">Tren Penyakit Tanaman</h2>

  <table class="min-w-full text-sm border border-gray-300 mb-6">
    <thead class="bg-green-700 text-white">
      <tr>
        <th class="px-4 py-2 text-left">Penyakit</th>
        <th class="px-4 py-2 text-left">Jumlah Kasus</th>
        <th class="px-4 py-2 text-left">Periode</th>
        <th class="px-4 py-2 text-left">Terakhir Diperbarui</th>
        <?php if ($peran==='admin'): ?>
          <th class="px-4 py-2 text-left">Aksi</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php while($r = $data->fetch_assoc()): ?>
        <tr class="border-b hover:bg-green-50">
          <td class="px-4 py-2"><?= htmlspecialchars($r['nama_penyakit']) ?></td>
          <td class="px-4 py-2"><?= $r['jumlah_kasus'] ?></td>
          <td class="px-4 py-2"><?= $r['periode'] ?></td>
          <td class="px-4 py-2"><?= $r['tanggal_diperbarui'] ?></td>
          <?php if($peran==='admin'): ?>
            <td class="px-4 py-2 space-x-2">
              <a href="?edit=<?= $r['id_tren'] ?>" class="text-blue-600 hover:underline">Edit</a>
              <a href="?hapus=<?= $r['id_tren'] ?>" onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:underline">Hapus</a>
            </td>
          <?php endif; ?>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <?php if($peran==='admin'):
    $editId   = isset($_GET['edit']) ? (int)$_GET['edit'] : null;
    $editData = null;
    if($editId) {
      $sq = $conn->prepare("SELECT * FROM TrenPenyakit WHERE id_tren=?");
      $sq->bind_param("i",$editId);
      $sq->execute();
      $editData = $sq->get_result()->fetch_assoc();
    }
  ?>
    <h3 class="text-xl font-semibold mb-4"><?= $editData ? "Edit Data Tren" : "Tambah Data Tren" ?></h3>
    <form method="POST" class="space-y-4">
      <input type="hidden" name="id" value="<?= $editData['id_tren'] ?? '' ?>">
      <div>
        <label class="block text-sm font-medium">Nama Penyakit</label>
        <select name="nama_penyakit" onchange="fetchData(this.value)" required class="w-full border rounded px-3 py-2">
          <option value="">-- Pilih Penyakit --</option>
          <?php foreach($penyakitList as $p): ?>
            <option value="<?= $p ?>" <?= ($editData['nama_penyakit'] ?? '')===$p ? 'selected':'' ?>>
              <?= $p ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium">Jumlah Kasus</label>
        <input type="number" name="jumlah_kasus" readonly
               value="<?= $editData['jumlah_kasus'] ?? '' ?>"
               class="w-full bg-gray-100 border rounded px-3 py-2 cursor-not-allowed">
      </div>
      <div>
        <label class="block text-sm font-medium">Periode</label>
        <input type="text" name="periode" required placeholder="Misal: Januari 2025"
               value="<?= $editData['periode'] ?? '' ?>"
               class="w-full border rounded px-3 py-2">
      </div>
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        <?= $editData ? "Update" : "Tambah" ?>
      </button>
    </form>
  <?php endif; ?>

  <div class="mt-6 text-center">
    <a href="dashboard.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded shadow">
      Kembali
    </a>
  </div>
</div>

<script>
function fetchData(penyakit) {
  if (!penyakit) return;
  fetch('gettren.php?penyakit='+encodeURIComponent(penyakit))
    .then(res=>res.json())
    .then(data=>{
      if(data) {
        document.querySelector('[name="jumlah_kasus"]').value = data.jumlah_kasus;
        document.querySelector('[name="periode"]').value = data.periode;
      }
    });
}
</script>
</body>
</html>
