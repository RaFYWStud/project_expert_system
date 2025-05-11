<?php
include '../config/database.php';
include '../functions.php';

// Ambil data input
$nama_pasien = $_POST['nama_pasien'];
$usia_pasien = $_POST['usia_pasien'];
$gejala_terpilih = $_POST['gejala'];

// Proses diagnosa
$hasil_diagnosa = hitungDiagnosa($gejala_terpilih, $conn);

// Simpan ke session untuk ditampilkan
session_start();
$_SESSION['diagnosa'] = [
    'nama_pasien' => $nama_pasien,
    'usia_pasien' => $usia_pasien,
    'gejala_terpilih' => $gejala_terpilih,
    'hasil' => $hasil_diagnosa
];

header("Location: ../result.php");
exit();
