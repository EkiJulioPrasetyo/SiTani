<?php
session_start();
include "koneksi.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_baru = $_POST['password_baru'] ?? '';
    $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';    

    if ($password_baru !== $konfirmasi_password) {
        $error = "Konfirmasi password tidak cocok.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM Akun WHERE username = ? AND email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE Akun SET password = ? WHERE username = ? AND email = ?");
            $update->bind_param("sss", $password_hash, $username, $email);
            $update->execute();

            $success = "Password berhasil diperbarui. Silakan login.";
        } else {
            $error = "Username atau email tidak cocok.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - SiTani</title>
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
    <h2 class="text-2xl font-bold text-center text-lime-700 mb-6">Reset Password</h2>
    <?php if (!empty($success)): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <?php echo $success; ?>
      </div>
    <?php elseif (!empty($error)): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form action="resetpassword.php" method="POST" class="space-y-5">
      <div>
        <label for="username" class="block text-gray-700 font-semibold mb-1">Username</label>
        <input
          type="text"
          name="username"
          id="username"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-600"
        />
      </div>

      <div>
        <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
        <input
          type="email"
          name="email"
          id="email"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-600"
        />
      </div>

      <div>
        <label for="password_baru" class="block text-gray-700 font-semibold mb-1">Password Baru</label>
        <input
          type="password"
          name="password_baru"
          id="password_baru"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-600"
        />
      </div>

      <div>
        <label for="konfirmasi_password" class="block text-gray-700 font-semibold mb-1">Konfirmasi Password</label>
        <input
          type="password"
          name="konfirmasi_password"
          id="konfirmasi_password"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-600"
        />
      </div>

      <button
        type="submit"
        class="w-full bg-lime-600 hover:bg-lime-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        Reset Password
      </button>
    </form>

    <div class="mt-6 text-center">
      <a href="login.php" class="w-full block text-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition">Kembali</a>
    </div>
  </div>

</body>
</html>
