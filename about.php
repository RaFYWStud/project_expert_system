<?php
include 'config/database.php';

// Query untuk mendapatkan jumlah data
$sql_count = "SELECT 
    COUNT(DISTINCT p.id_penyakit) as total_penyakit,
    COUNT(DISTINCT g.id_gejala) as total_gejala,
    COUNT(*) as total_aturan
FROM penyakit p
JOIN likelihood l ON p.id_penyakit = l.id_penyakit
JOIN gejala g ON l.id_gejala = g.id_gejala";

$count_result = $conn->query($sql_count);
$count_data = $count_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Sistem</title>
    <script src="assets/js/script.js" defer></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <nav class="hamburger-navbar">
        <h1>Tentang Sistem</h1>
        <button class="hamburger-button" onclick="toggleMenu()">☰</button>
        <div class="hamburger-menu">
            <a href="index.php">Diagnosa</a>
            <a href="knowledge_base.php">Basis Pengetahuan</a>
            <a href="about.php">Tentang Sistem</a>
        </div>
    </nav>

    <div class="container">
        <header class="page-header">
            <h2>Sistem Pakar Penyakit Pernapasan Bayi</h2>
            <p>Project Akhir Mata Kuliah Kecerdasan Buatan</p>
        </header>

        <div class="about-section">
            <h3>Tentang Sistem</h3>
            <p>Sistem pakar ini dikembangkan sebagai project akhir mata kuliah Kecerdasan Buatan. Tujuan sistem ini adalah untuk membantu diagnosis awal penyakit pernapasan pada bayi berdasarkan gejala-gejala yang terlihat. Sistem ini bukan pengganti diagnosis medis profesional, tetapi dapat membantu orang tua untuk mendapatkan informasi awal tentang kondisi kesehatan anak mereka.</p>

            <h3>Metode yang Digunakan</h3>
            <p>Sistem ini dibangun menggunakan algoritma <strong>Teorema Bayes</strong>, sebuah metode probabilistik yang digunakan dalam sistem pakar untuk menghitung kemungkinan suatu penyakit berdasarkan gejala-gejala yang diamati. Teorema Bayes menggunakan konsep probabilitas kondisional untuk memperbarui keyakinan tentang sebuah hipotesis berdasarkan bukti baru.</p>

            <p>Rumus dasar Teorema Bayes yang digunakan adalah:</p>
            <div class="formula">
                P(H|E) = [P(E|H) × P(H)] / P(E)
            </div>
            <p>Dimana:</p>
            <ul>
                <li>P(H|E) adalah probabilitas posterior penyakit H terjadi jika gejala E muncul</li>
                <li>P(E|H) adalah likelihood atau probabilitas gejala E muncul jika penyakit H terjadi</li>
                <li>P(H) adalah probabilitas prior penyakit H</li>
                <li>P(E) adalah probabilitas total gejala E terjadi</li>z
            </ul>

            <h3>Basis Pengetahuan</h3>
            <p>Sistem pakar ini menggunakan basis pengetahuan yang terdiri dari:</p>
            <ul>
                <li><strong><?= $count_data['total_penyakit'] ?> Jenis Penyakit</strong> pernapasan yang umum terjadi pada bayi</li>
                <li><strong><?= $count_data['total_gejala'] ?> Gejala</strong> yang dapat diamati oleh orang tua</li>
                <li><strong><?= $count_data['total_aturan'] ?> Aturan</strong> yang menghubungkan gejala dengan penyakit</li>
            </ul>

            <p>Setiap penyakit memiliki nilai probabilitas prior dan setiap hubungan antara penyakit dan gejala memiliki nilai likelihood yang telah ditentukan berdasarkan literatur medis dan konsultasi dengan pakar.</p>

            <h3>Fitur Sistem</h3>
            <ol>
                <li><strong>Diagnosis Interaktif</strong> - Pengguna dapat memilih gejala yang terlihat pada bayi</li>
                <li><strong>Visualisasi Hasil</strong> - Hasil diagnosis ditampilkan dalam bentuk grafik pie untuk memudahkan pemahaman</li>
                <li><strong>Solusi Penanganan</strong> - Sistem memberikan saran penanganan awal berdasarkan diagnosis dan usia bayi</li>
                <li><strong>Basis Pengetahuan Transparan</strong> - Pengguna dapat melihat seluruh basis pengetahuan yang digunakan</li>
            </ol>

            <h3>Batasan Sistem</h3>
            <p>Perlu dicatat bahwa sistem pakar ini memiliki beberapa batasan:</p>
            <ul>
                <li>Sistem hanya mendiagnosa penyakit pernapasan yang umum terjadi pada bayi</li>
                <li>Hasil diagnosis bukan pengganti konsultasi medis dengan dokter anak</li>
                <li>Sistem mengandalkan input gejala yang akurat dari pengguna</li>
                <li>Solusi yang diberikan bersifat umum dan perlu disesuaikan dengan kondisi spesifik anak</li>
            </ul>

            <h3>Pengembangan Sistem</h3>
            <p>Sistem ini dikembangkan dengan teknologi berikut:</p>
            <ul>
                <li>PHP dan MySQL untuk backend dan basis data</li>
                <li>HTML, CSS, dan JavaScript untuk frontend</li>
                <li>Chart.js untuk visualisasi data</li>
                <li>Algoritma Naive Bayes untuk inferensi probabilistik</li>
            </ul>

            <h3>Referensi</h3>
            <ul>
                <li>Herman, Sunardi, & Muslimah, V. (2024). <em>Implementing Bayes' Theorem method in expert system to determine infant disease</em>. Khazanah Informatika: Jurnal Ilmu Komputer dan Informatika, 10(1), 1-13.</li>

                <li>World Health Organization. (2019). <em>Integrated Management of Childhood Illness</em>.</li>
            </ul>

            <div class="disclaimer">
                <h3>Disclaimer!</h3>
                <p>Sistem pakar ini dikembangkan untuk tujuan pendidikan dan informasi. Hasil diagnosis dan solusi yang diberikan tidak menggantikan konsultasi medis dengan profesional kesehatan. Jika anak Anda mengalami gejala penyakit, selalu konsultasikan dengan dokter anak.</p>
            </div>
        </div>
    </div>

    <footer class="about-footer">
        <p>© 2025 Sistem Pakar Penyakit Pernapasan Bayi - Project Akhir Mata Kuliah Kecerdasan Buatan</p>
    </footer>
</body>

</html>