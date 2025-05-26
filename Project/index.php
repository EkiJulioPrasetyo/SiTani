<?php
include('koneksi.php');
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SiTani</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans overflow-x-hidden">

  <nav class="fixed top-0 left-0 w-full bg-white shadow-md z-50 px-10 py-4 flex justify-between items-center">
    <img src="foto/Logo.png" alt="Logo SiTani" class="h-12">
    <ul class="flex gap-6 font-medium">
      <li class="cursor-pointer">Beranda</li>
      <li class="cursor-pointer">Layanan</li>
      <li class="cursor-pointer">Kategori</li>
      <li class="cursor-pointer">Tentang</li>
    </ul>
    <div class="flex gap-4 items-center">
      <a href="login.php" class="text-lime-700 font-medium">Masuk</a>
      <a href="register.php" class="bg-lime-700 text-white px-4 py-2 rounded-md font-semibold hover:bg-green-900">Daftar</a>
    </div>
  </nav>

  <section class="bg-cover bg-center text-white pt-40 pb-20 px-10" style="background-image: url('foto/petani.png')">
    <div class="bg-black bg-opacity-10 p-10 rounded-lg max-w-xl">
      <h1 class="text-4xl font-bold mb-4">Selamat datang di <span class="text-red-500">SiTani!</span></h1>
      <p class="mb-6 leading-relaxed">Platform web yang memudahkan petani dan pengguna dalam jual beli hasil pertanian, khususnya tanaman cabe jamu.</p>
      <a href="register.php" class="bg-lime-700 px-4 py-2 rounded-md font-semibold hover:bg-green-900">Daftar</a>
    </div>
  </section>

  <section class="bg-green-900 text-white text-center py-12 px-6">
    <h2 class="text-2xl font-semibold mb-4">Dari Ladang ke Layar, Tanpa Ribet</h2>
    <p class="max-w-xl mx-auto">Semua yang dibutuhkan petani dan pembeli cabe jamu ada di satu platform.</p>
  </section>

  <section class="bg-green-900 text-white py-16 px-6">
    <div class="grid gap-8 max-w-6xl mx-auto grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
      <div class="bg-white bg-opacity-5 p-6 rounded-lg hover:bg-opacity-10">
        <img src="foto/panen.png" class="w-12 mb-4">
        <h3 class="font-bold mb-2">Panen Lebih Terencana</h3>
        <p>Dapatkan prediksi panen berbasis data untuk bantu kamu merencanakan hasil lebih optimal.</p>
      </div>
      <div class="bg-white bg-opacity-5 p-6 rounded-lg hover:bg-opacity-10">
        <img src="foto/deteksi.png" class="w-12 mb-4">
        <h3 class="font-bold mb-2">Deteksi Cepat & Akurat</h3>
        <p>Unggah gambar tanaman, SiTani bantu identifikasi penyakit dan beri solusi perawatan instan.</p>
      </div>
      <div class="bg-white bg-opacity-5 p-6 rounded-lg hover:bg-opacity-10">
        <img src="foto/belanja.png" class="w-12 mb-4">
        <h3 class="font-bold mb-2">Langsung dari Petani ke Pembeli</h3>
        <p>Pembeli bisa beli langsung ke petani tanpa perantara dengan harga adil.</p>
      </div>
      <div class="bg-white bg-opacity-5 p-6 rounded-lg hover:bg-opacity-10">
        <img src="foto/catatan.png" class="w-12 mb-4">
        <h3 class="font-bold mb-2">Pencatatan Hasil Panen</h3>
        <p>Catat hasil panen tiap bulan dan punya riwayat panen yang rapi.</p>
      </div>
      <div class="bg-white bg-opacity-5 p-6 rounded-lg hover:bg-opacity-10">
        <img src="foto/edukasi.png" class="w-12 mb-4">
        <h3 class="font-bold mb-2">Edukasi & Informasi</h3>
        <p>Pelajari lebih banyak tentang cabe jamu, manfaat, dan cara budidayanya.</p>
      </div>
    </div>
  </section>

  <section class="py-16 px-6 text-center bg-white">
    <h2 class="text-2xl font-semibold text-green-900 mb-4">Belajar Sambil Bertani, Bisa di SiTani</h2>
    <p class="text-green-800 max-w-xl mx-auto mb-10">Kenali lebih dalam soal cabe jamu: cara tanam, rawat, sampai jadi produk bernilai tinggi.</p>
    <div class="flex flex-wrap justify-center gap-6">
      <div class="max-w-xs bg-white shadow-md rounded-lg overflow-hidden text-left">
        <img src="foto/18.png" alt="Cabe Jamu">
        <div class="p-4">
          <h3 class="font-semibold text-green-900 mb-2">Apa Itu Cabe Jamu?</h3>
          <p class="text-green-800 text-sm">Cabe jamu (Piper retrofractum Vahl.) adalah tanaman obat dari suku Piperaceae...</p>
          <a href="#" class="text-lime-700 font-bold inline-block mt-3">Baca selengkapnya →</a>
        </div>
      </div>
      <div class="max-w-xs bg-white shadow-md rounded-lg overflow-hidden text-left">
        <img src="foto/19.png" alt="Budidaya">
        <div class="p-4">
          <h3 class="font-semibold text-green-900 mb-2">Tanam Sendiri, Gak Susah Kok!</h3>
          <p class="text-green-800 text-sm">Mau coba budidaya cabe jamu? Tenang, SiTani pandu langkah demi langkah.</p>
          <a href="#" class="text-lime-700 font-bold inline-block mt-3">Baca selengkapnya →</a>
        </div>
      </div>
      <div class="max-w-xs bg-white shadow-md rounded-lg overflow-hidden text-left">
        <img src="foto/20.png" alt="Hama Penyakit">
        <div class="p-4">
          <h3 class="font-semibold text-green-900 mb-2">Kenali Hama & Penyakitnya</h3>
          <p class="text-green-800 text-sm">Kami bantu kamu mengenali ciri-ciri penyakit tanaman dan solusinya.</p>
          <a href="#" class="text-lime-700 font-bold inline-block mt-3">Baca selengkapnya →</a>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-green-900 text-green-100 py-16 px-5">
    <div class="max-w-5xl mx-auto flex flex-wrap gap-10 items-center justify-center">
      <div class="w-full sm:w-auto">
        <img src="foto/Tani.png" alt="Petani" class="w-72 rounded-xl shadow-lg" />
      </div>
      <div class="max-w-xl">
        <h2 class="text-2xl font-semibold text-green-200 mb-4">Tentang Kami</h2>
        <p class="text-green-50 leading-relaxed">
          Platform web yang memudahkan petani dan pengguna dalam jual beli hasil pertanian, khususnya tanaman cabe jamu. Temukan informasi, manfaat, dan cara budidaya cabe jamu di sini, sekaligus dukung petani lokal dengan bertransaksi langsung.
        </p>
      </div>
    </div>
  </section>

  <footer class="bg-white py-16 px-10 text-sm text-gray-700">
    <div class="max-w-6xl mx-auto flex flex-wrap justify-between gap-10">
      <div class="max-w-xs">
        <img src="foto/Logo.png" alt="Logo SiTani" class="h-12 mb-4" />
        <p class="mb-4">Copyright © 2020 Landify UI Kit.<br>All rights reserved</p>
        <div class="flex gap-3">
          <a href="#"><img src="foto/instagram.png" alt="Instagram" class="w-5 grayscale hover:grayscale-0 transition" /></a>
          <a href="#"><img src="foto/twitter.png" alt="Twitter" class="w-5 grayscale hover:grayscale-0 transition" /></a>
          <a href="#"><img src="foto/youtube.png" alt="YouTube" class="w-5 grayscale hover:grayscale-0 transition" /></a>
        </div>
      </div>
      <div class="flex flex-wrap gap-16 flex-1 justify-between">
        <div>
          <h4 class="text-green-900 font-semibold mb-3">Company</h4>
          <ul class="space-y-2">
            <li><a href="#" class="hover:underline">About us</a></li>
            <li><a href="#" class="hover:underline">Blog</a></li>
            <li><a href="#" class="hover:underline">Contact us</a></li>
            <li><a href="#" class="hover:underline">Pricing</a></li>
            <li><a href="#" class="hover:underline">Testimonials</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-green-900 font-semibold mb-3">Support</h4>
          <ul class="space-y-2">
            <li><a href="#" class="hover:underline">Help center</a></li>
            <li><a href="#" class="hover:underline">Terms of service</a></li>
            <li><a href="#" class="hover:underline">Legal</a></li>
            <li><a href="#" class="hover:underline">Privacy policy</a></li>
            <li><a href="#" class="hover:underline">Status</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-green-900 font-semibold mb-3">Stay up to date</h4>
          <input type="email" placeholder="Your email address" class="px-3 py-2 border border-gray-300 rounded-md w-full max-w-xs" />
        </div>
      </div>
    </div>
  </footer>

</body>
</html>
