<?php
include 'config/database.php';
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosa Penyakit Anak</title>
    <script src="assets/js/script.js" defer></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <nav class="hamburger-navbar">
        <h1>Sistem Pakar Penyakit Pernafasan Anak</h1>
        <button class="hamburger-button" onclick="toggleMenu()">☰</button>
        <div class="hamburger-menu">
            <a href="index.php">Diagnosa</a>
            <a href="knowledge_base.php">Basis Pengetahuan</a>
            <a href="about.php">Tentang Sistem</a>
        </div>
    </nav>

    <div class="container">
        <header class="page-header">
            <h2>Selamat Datang di Sistem Pakar</h2>
            <p>Silakan isi data pasien dan pilih gejala untuk memulai diagnosa.</p>
        </header>

        <main>
            <form action="processes/diagnosis.php" method="post">
                <div class="form-group">
                    <label for="nama">Nama Pasien:</label>
                    <input type="text" id="nama" name="nama_pasien" placeholder="Masukkan nama pasien..." required>
                </div>

                <div class="form-group">
                    <label for="usia">Usia (bulan):</label>
                    <input type="number" id="usia" name="usia_pasien" placeholder="Masukkan usia pasien dalam bulan..." min="0" max="60" required>
                </div>

                <fieldset>
                    <legend>Pilih Gejala:</legend>
                    <div class="progress-container">
                        <label for="progress">Gejala yang Dipilih:</label>
                        <progress id="progress" value="0" max="100"></progress>
                    </div>
                    <?php
                    $sql = "SELECT * FROM gejala";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="checkbox-group">';
                        echo '<input type="checkbox" id="' . $row['id_gejala'] . '" name="gejala[]" value="' . $row['id_gejala'] . '">';
                        echo '<label for="' . $row['id_gejala'] . '">' . $row['nama_gejala'] . '</label>';
                        echo '</div>';
                    }
                    ?>
                </fieldset>

                <button type="submit" class="btn-diagnose">Proses Diagnosa</button>
            </form>
        </main>
    </div>
</body>

</html>