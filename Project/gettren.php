<?php
include 'koneksi.php';

$penyakit = $_GET['penyakit'] ?? '';

if ($penyakit) {
    // 1) Hitung dari DeteksiPenyakit
    $stmt = $conn->prepare("
      SELECT COUNT(*) as jumlah 
      FROM DeteksiPenyakit 
      WHERE hasil_deteksi = ?
    ");
    $stmt->bind_param("s", $penyakit);
    $stmt->execute();
    $jumlah = $stmt->get_result()->fetch_assoc()['jumlah'];

    // 2) (Opsional) ambil periode terakhir dari TrenPenyakit
    $stmt2 = $conn->prepare("
      SELECT periode 
      FROM TrenPenyakit 
      WHERE nama_penyakit = ? 
      ORDER BY tanggal_diperbarui DESC 
      LIMIT 1
    ");
    $stmt2->bind_param("s", $penyakit);
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    $periode = $res2->num_rows 
        ? $res2->fetch_assoc()['periode'] 
        : date('F Y'); 

    echo json_encode([
        'jumlah_kasus' => $jumlah,
        'periode'      => $periode
    ]);
}
