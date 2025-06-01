<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_akun']) || $_SESSION['peran'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id_akun = $_SESSION['id_akun'];

if (isset($_POST['update_admin'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE Akun SET nama = ?, email = ? WHERE id_akun = ?");
    $stmt->bind_param("ssi", $nama, $email, $id_akun);
    $stmt->execute();
    $_SESSION['nama'] = $nama;
    header("Location: profiladmin.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $hapus_id = $_GET['hapus'];
    $conn->query("DELETE FROM Akun WHERE id_akun = $hapus_id AND peran = 'petani'");
    header("Location: profiladmin.php");
    exit;
}

$admin = $conn->query("SELECT nama, username, email FROM Akun WHERE id_akun = $id_akun")->fetch_assoc();

$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';
if ($keyword) {
    $stmt = $conn->prepare("SELECT * FROM Akun WHERE peran = 'petani' AND (nama LIKE ? OR username LIKE ?)");
    $like = "%" . $keyword . "%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $petani = $stmt->get_result();
} else {
    $petani = $conn->query("SELECT * FROM Akun WHERE peran = 'petani'");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Admin - SiTani</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 font-sans py-10 px-6">
  <div class="max-w-5xl mx-auto space-y-10">

    <div class="bg-white p-6 rounded-xl shadow">
      <h2 class="text-xl font-bold text-lime-700 mb-4">Profil Admin</h2>
      <form method="POST" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Nama</label>
          <input name="nama" value="<?php echo htmlspecialchars($admin['nama']); ?>" class="w-full border px-3 py-2 rounded" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" class="w-full border px-3 py-2 rounded" required />
        </div>
        <button type="submit" name="update_admin" class="bg-lime-600 text-white px-4 py-2 rounded hover:bg-lime-700">Simpan Perubahan</button>
      </form>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-lime-700">Daftar Akun Petani</h2>
        <form method="GET" class="flex gap-2">
          <input type="text" name="cari" placeholder="Cari nama/username..." value="<?php echo htmlspecialchars($keyword); ?>" class="border px-3 py-2 rounded-md" />
          <button type="submit" class="bg-lime-600 hover:bg-lime-700 text-white px-4 py-2 rounded">Cari</button>
        </form>
      </div>

      <table class="w-full text-sm border border-gray-200">
        <thead class="bg-lime-600 text-white">
          <tr>
            <th class="px-4 py-2 text-left">Nama</th>
            <th class="px-4 py-2 text-left">Username</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($petani->num_rows > 0): ?>
            <?php while ($row = $petani->fetch_assoc()): ?>
              <tr class="border-t">
                <td class="px-4 py-2"><?php echo htmlspecialchars($row['nama']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($row['username']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($row['email']); ?></td>
                <td class="px-4 py-2">
                  <a href="?hapus=<?php echo $row['id_akun']; ?>" onclick="return confirm('Yakin ingin menghapus akun ini?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data ditemukan.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="mt-6 text-center">
      <a href="dashboard.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded shadow inline-block">Kembali</a>
    </div>


  </div>
</body>
</html>