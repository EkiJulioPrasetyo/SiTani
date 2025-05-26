<?php
session_start();
require_once "koneksi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $peran = $_POST['peran'];

    $stmt = $conn->prepare("SELECT * FROM Akun WHERE username = ? AND peran = ?");
    $stmt->bind_param("ss", $username, $peran);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION["id_akun"] = $row['id_akun'];
            $_SESSION["username"] = $row['username'];
            $_SESSION["nama"] = $row['nama'];
            $_SESSION["peran"] = $row['peran'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Password yang Anda masukkan salah.";
        }
    } else {
        $error = "Username atau peran tidak cocok.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SiTani</title>
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
    <h2 class="text-2xl font-bold text-center text-lime-700 mb-6">Login SiTani</h2>

    <?php if (!empty($error)): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Login Gagal! </strong>
        <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
      </div>
    <?php endif; ?>

    <form action="login.php" method="POST" class="space-y-5">

      <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1">Login Sebagai</label>
        <div class="flex items-center space-x-4">
          <label class="inline-flex items-center cursor-pointer">
            <input type="radio" class="sr-only peer" name="peran" value="admin" required>
            <div class="w-20 bg-gray-200 peer-checked:bg-lime-600 text-center py-2 rounded-lg text-sm font-semibold text-gray-700 peer-checked:text-white">
              Admin
            </div>
          </label>
          <label class="inline-flex items-center cursor-pointer">
            <input type="radio" class="sr-only peer" name="peran" value="petani">
            <div class="w-20 bg-gray-200 peer-checked:bg-lime-600 text-center py-2 rounded-lg text-sm font-semibold text-gray-700 peer-checked:text-white">
              Petani
            </div>
          </label>
        </div>
      </div>

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
        <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
        <input
          type="password"
          name="password"
          id="password"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-600"
        />
      </div>

      <button
        type="submit"
        class="w-full bg-lime-600 hover:bg-lime-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        Login
      </button>
      <div class="mt-6 text-center">
        <a href="index.php" class="w-full block text-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition">Kembali</a>
      </div>
    </form>

    <div class="mt-4 text-sm text-center">
      <p class="text-gray-500">Belum punya akun?
        <a href="register.php" class="text-lime-600 hover:underline font-medium">Daftar di sini</a>
      </p>
      <p class="text-gray-500 mt-2">
        <a href="resetpassword.php" class="text-blue-600 hover:underline font-medium">Lupa Password?</a>
      </p>
    </div>
  </div>

</body>
</html>
