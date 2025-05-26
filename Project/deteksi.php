<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit;
}

$output = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_deteksi'])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $original_name = pathinfo($_FILES["gambar"]["name"], PATHINFO_FILENAME);
    $original_name = preg_replace("/[^a-zA-Z0-9_-]/", "", $original_name);
    $ext = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
    $filename = $original_name . "_" . time() . "." . $ext;
    $relative_path = $target_dir . $filename;

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $relative_path)) {
        $absolute_path = realpath($relative_path);

        $command = "python predict.py " . escapeshellarg($absolute_path) . " 2>&1";
        $output = shell_exec($command);

        file_put_contents("debug_log.txt", "CMD: $command\nOutput:\n$output\n\n", FILE_APPEND);

        $output = trim($output);

        $rekomendasi_penanganan = [
            "Healthy" => "Tanaman dalam kondisi sehat. Lanjutkan perawatan rutin seperti penyiraman dan pemupukan.",
            "Leaf Curl" => "Gunakan insektisida sistemik untuk mengatasi serangan kutu daun atau thrips. Pangkas daun yang terinfeksi.",
            "Leaf Spot" => "Gunakan fungisida berbasis tembaga. Jaga kelembaban daun tetap rendah dengan penyiraman di pangkal.",
            "White Fly" => "Semprot dengan sabun insektisida atau neem oil. Gunakan perangkap kuning lengket.",
            "Yellowish" => "Periksa pH tanah dan tingkat nutrisi. Tambahkan pupuk NPK seimbang dan perbaiki drainase."
        ];

        if ($output === "") {
            $output = "Gagal mendeteksi. Cek kembali model atau format gambar.";
        } else {
            $rekomendasi = $rekomendasi_penanganan[$output] ?? "Rekomendasi belum tersedia.";
            $label_saja = $output;
            $output = "$output\nRekomendasi: $rekomendasi";

            $id_akun = $_SESSION['id_akun'];
            $gambar_url = basename($relative_path);
            $waktu = date('Y-m-d H:i:s');

            $stmt = $conn->prepare("INSERT INTO DeteksiPenyakit (id_akun, gambar_url, hasil_deteksi, rekomendasi, tanggal) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $id_akun, $gambar_url, $label_saja, $rekomendasi, $waktu);
            $stmt->execute();
        }
    } else {
        $output = "Gagal mengupload gambar.";
        file_put_contents("upload_error_log.txt", print_r($_FILES, true), FILE_APPEND);
    }

    echo $output;
    exit;
}
?>

<?php if ($_SERVER["REQUEST_METHOD"] !== "POST") : ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Deteksi Penyakit - SiTani</title>
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
<body class="bg-lime-900 font-sans text-white min-h-screen flex items-center justify-center px-4">
  <nav class="fixed top-0 left-0 w-full bg-gray-100 shadow-sm flex justify-between items-center px-6 py-4 z-50">
    <div class="flex items-center gap-2">
      <img src="Foto/Logo.png" alt="Logo" class="h-10">
    </div>
  </nav>

  <div class="mt-20 w-full max-w-6xl bg-white/10 backdrop-blur-md rounded-lg shadow-xl p-8 flex flex-col md:flex-row gap-8">
    <div class="md:w-1/2 w-full text-center space-y-6">
      <div id="preview" class=""></div>

      <form id="formUpload" action="" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input
          type="file"
          name="gambar"
          accept="image/*"
          required
          class="hidden"
          id="uploadInput"
          onchange="handleFile(this)"
        />

        <div class="flex justify-center gap-4">
          <button
            type="button"
            onclick="document.getElementById('uploadInput').click()"
            class="bg-lime-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-lime-800 transition">
            Pilih Gambar
          </button>
          <button
            type="submit"
            name="upload_deteksi"
            id="extraBtn"
            class="bg-lime-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-lime-800 hidden transition">
            Upload & Deteksi
          </button>
        </div>
        <div class="mt-10">
          <button
            onclick="history.back()"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded shadow">
            Kembali
          </button>
        </div>
      </form>
    </div>
    <div class="md:w-1/2 w-full space-y-6 text-left">
      <div id="loading" class="hidden text-green-100 text-sm flex items-center gap-2">
        <svg class="animate-spin h-5 w-5 text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4z"></path>
        </svg>
        <span>Memproses gambar...</span>
      </div>
      <div id="hasil" class="text-xl font-bold text-white whitespace-pre-line"></div>
    </div>
  </div>

  <script>
    function handleFile(input) {
      const file = input.files[0];
      const preview = document.getElementById("preview");
      const extraBtn = document.getElementById("extraBtn");

      if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.innerHTML = `
            <img src="${e.target.result}" alt="Preview"
              class="mx-auto max-w-xs rounded-xl shadow-lg border border-white/20" />
          `;

          extraBtn.classList.remove("hidden");
        };
        reader.readAsDataURL(file);
      } else {
        preview.innerHTML = "<p class='text-red-200 font-semibold'>File bukan gambar!</p>";
        extraBtn.classList.add("hidden");
      }
    }

    const form = document.getElementById('formUpload');
    const hasilDiv = document.getElementById('hasil');
    const loadingDiv = document.getElementById('loading');

    form.onsubmit = async function (e) {
      e.preventDefault(); 
      loadingDiv.classList.remove("hidden");
      hasilDiv.innerText = "";

      const formData = new FormData(form);
      formData.append("upload_deteksi", "1");

      try {
        const response = await fetch(window.location.href, {
          method: 'POST',
          body: formData
        });

        if (!response.ok) throw new Error("Gagal menghubungi server!");

        const hasil = await response.text();
        loadingDiv.classList.add("hidden");
        hasilDiv.innerText = "Hasil Deteksi:\n" + hasil;
      } catch (error) {
        console.error("Upload gagal:", error);
        alert("Upload gagal. Coba lagi!");
        form.submit();
      }
    };
  </script>

</body>
</html>
<?php endif; ?>
