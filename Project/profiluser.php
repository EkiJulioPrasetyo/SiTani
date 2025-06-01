<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_akun']) || $_SESSION['peran'] !== 'petani') {
    header("Location: login.php");
    exit;
}

$id_akun = $_SESSION['id_akun'];

if (isset($_POST['update_user'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE Akun SET nama = ?, email = ? WHERE id_akun = ?");
    $stmt->bind_param("ssi", $nama, $email, $id_akun);
    $stmt->execute();
    $_SESSION['nama'] = $nama;
    header("Location: profiluser.php");
    exit;
}

$stmt = $conn->prepare("SELECT nama, username, email, peran FROM Akun WHERE id_akun = ?");
$stmt->bind_param("i", $id_akun);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $data = $result->fetch_assoc();
} else {
    echo "<script>alert('Data pengguna tidak ditemukan.'); window.location.href='dashboard.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya - SiTani</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen font-sans">
  <div class="max-w-xl mx-auto py-10 px-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
      <h1 class="text-2xl font-bold text-lime-800 mb-4">Profil Anda</h1>
      <form method="POST" class="space-y-4">
        <div>
          <label class="block text-sm font-semibold text-gray-700">Nama</label>
          <input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" class="w-full border px-3 py-2 rounded" required />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700">Email</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" class="w-full border px-3 py-2 rounded" required />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700">Username</label>
          <input type="text" value="<?php echo htmlspecialchars($data['username']); ?>" class="w-full border px-3 py-2 rounded bg-gray-100" readonly />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700">Peran</label>
          <input type="text" value="<?php echo htmlspecialchars($data['peran']); ?>" class="w-full border px-3 py-2 rounded bg-gray-100" readonly />
        </div>
        <button type="submit" name="update_user" class="bg-lime-600 hover:bg-lime-700 text-white px-4 py-2 rounded">Simpan Perubahan</button>
        <a href="dashboard.php" class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded text-center">Kembali</a>
        </form>


    </div>
  </div>
</body>
</html>
