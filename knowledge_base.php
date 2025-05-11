<?php
include 'config/database.php';

// Query untuk mendapatkan semua data basis pengetahuan
$sql = "SELECT 
          p.id_penyakit, 
          p.nama_penyakit, 
          p.deskripsi,
          p.prior_prob,
          g.id_gejala,
          g.nama_gejala,
          l.nilai_likelihood
        FROM penyakit p
        JOIN likelihood l ON p.id_penyakit = l.id_penyakit
        JOIN gejala g ON l.id_gejala = g.id_gejala
        ORDER BY p.id_penyakit, g.id_gejala";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basis Pengetahuan Sistem Pakar</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .knowledge-container {
            margin: 20px auto;
            max-width: 1200px;
        }

        .disease-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .disease-header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
        }

        .disease-body {
            padding: 20px;
        }

        .symptoms-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .symptoms-table th,
        .symptoms-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .symptoms-table th {
            background-color: #f2f2f2;
        }

        .prior-badge {
            background-color: #2196F3;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9em;
        }

        .likelihood-badge {
            background-color: #ff9800;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.85em;
        }
    </style>
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php">Diagnosa</a></li>
            <li><a href="knowledge_base.php">Basis Pengetahuan</a></li>
            <li><a href="about.php">Tentang Sistem</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="knowledge-container">
            <h1>Basis Pengetahuan Sistem Pakar</h1>
            <p>Berikut adalah aturan dan pengetahuan yang digunakan sistem untuk mendiagnosa penyakit bayi:</p>

            <?php
            $current_disease = null;
            while ($row = $result->fetch_assoc()) {
                // Jika penyakit baru, buat card baru
                if ($current_disease != $row['id_penyakit']) {
                    if ($current_disease != null) {
                        echo "</table></div></div>";
                    }

                    echo '<div class="disease-card">';
                    echo '<div class="disease-header">';
                    echo '<h2>' . $row['nama_penyakit'] . '</h2>';
                    echo '<p>' . $row['deskripsi'] . '</p>';
                    echo '<div>Prior Probability: <span class="prior-badge">' . $row['prior_prob'] . '</span></div>';
                    echo '</div>';
                    echo '<div class="disease-body">';
                    echo '<h3>Gejala Terkait</h3>';
                    echo '<table class="symptoms-table">';
                    echo '<tr><th>Kode Gejala</th><th>Nama Gejala</th><th>Likelihood</th></tr>';

                    $current_disease = $row['id_penyakit'];
                }

                // Tampilkan gejala
                echo '<tr>';
                echo '<td>' . $row['id_gejala'] . '</td>';
                echo '<td>' . $row['nama_gejala'] . '</td>';
                echo '<td><span class="likelihood-badge">' . $row['nilai_likelihood'] . '</span></td>';
                echo '</tr>';
            }

            // Tutup card terakhir
            if ($current_disease != null) {
                echo '</table></div></div>';
            }
            ?>

            <div class="knowledge-summary">
                <h2>Total Basis Pengetahuan</h2>
                <div class="summary-cards">
                    <?php
                    // Hitung total pengetahuan
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

                    <div class="summary-card">
                        <h3>Penyakit</h3>
                        <p><?= $count_data['total_penyakit'] ?></p>
                    </div>

                    <div class="summary-card">
                        <h3>Gejala</h3>
                        <p><?= $count_data['total_gejala'] ?></p>
                    </div>

                    <div class="summary-card">
                        <h3>Aturan</h3>
                        <p><?= $count_data['total_aturan'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>