CREATE DATABASE IF NOT EXISTS sitani;

USE sitani;

CREATE TABLE IF NOT EXISTS Akun (
    id_akun INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    peran ENUM('admin', 'petani') NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS DeteksiPenyakit (
    id_deteksi INT AUTO_INCREMENT PRIMARY KEY,
    id_akun INT NOT NULL,
    gambar_url VARCHAR(255),
    hasil_deteksi TEXT,
    rekomendasi TEXT,
    tanggal DATETIME,
    FOREIGN KEY (id_akun) REFERENCES Akun(id_akun) ON DELETE CASCADE
);

CREATE TABLE if NOT EXISTS TrenPenyakit (
    id_tren INT AUTO_INCREMENT PRIMARY KEY,
    nama_penyakit VARCHAR(100) NOT NULL,
    jumlah_kasus INT NOT NULL,
    periode VARCHAR(50) NOT NULL,
    tanggal_diperbarui DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
