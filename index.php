<?php
include 'config/database.php';
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosa Penyakit Bayi</title>
    <script src="assets/js/script.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <nav class="hamburger-navbar">
        <h1>Sistem Pakar Penyakit Pernafasan Bayi</h1>
        <button class="hamburger-button" onclick="toggleMenu()">☰</button>
        <div class="hamburger-menu">
            <a href="index.php">Diagnosa</a>
            <a href="knowledge_base.php">Basis Pengetahuan</a>
            <a href="about.php">Tentang Sistem</a>
        </div>
    </nav>

    <div class="container">

        <main>
            <form action="processes/diagnosis.php" method="post">
                <div class="form-group">
                    <label for="nama">Nama Pasien:</label>
                    <input type="text" id="nama" name="nama_pasien" required>
                </div>

                <div class="form-group">
                    <label for="usia">Usia (bulan):</label>
                    <input type="number" id="usia" name="usia_pasien" min="0" max="60" required>
                </div>

                <fieldset>
                    <legend>Pilih Gejala:</legend>
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