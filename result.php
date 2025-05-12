<?php
session_start();
include 'config/database.php';
include 'functions.php';

if (!isset($_SESSION['diagnosa'])) {
    header("Location: index.php");
    exit();
}

$diagnosa = $_SESSION['diagnosa'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <header class="page-header">
            <h1>Hasil Diagnosa</h1>
        </header>

        <main>
            <div class="patient-info">
                <h2>Informasi Pasien</h2>
                <p><strong>Nama:</strong> <?= $diagnosa['nama_pasien'] ?></p>
                <p><strong>Usia:</strong> <?= $diagnosa['usia_pasien'] ?> bulan</p>
            </div>

            <div class="diagnosis-chart">
                <h2>Hasil Analisis</h2>
                <div class="chart-container">
                    <canvas id="diagnosisChart"></canvas>
                </div>
            </div>

            <div class="conclusion">
                <h2>Kesimpulan</h2>
                <p>Berdasarkan analisis gejala, pasien kemungkinan besar menderita:</p>
                <div class="primary-diagnosis">
                    <h3><?= $diagnosa['hasil'][array_key_first($diagnosa['hasil'])]['nama'] ?></h3>
                    <p>Dengan probabilitas <?= $diagnosa['hasil'][array_key_first($diagnosa['hasil'])]['probabilitas'] ?>%</p>
                </div>
            </div>

            <div class="solution">
                <h2>Solusi & Penanganan</h2>
                <?php
                $penyakit_terdeteksi = array_key_first($diagnosa['hasil']);
                $usia_pasien = $diagnosa['usia_pasien'];

                $sql_solusi = "SELECT solusi FROM solusi 
                  WHERE id_penyakit = '$penyakit_terdeteksi' 
                  AND $usia_pasien BETWEEN usia_min AND usia_max";
                $result_solusi = $conn->query($sql_solusi);

                if ($result_solusi && $result_solusi->num_rows > 0) {
                    $row_solusi = $result_solusi->fetch_assoc();
                    echo '<div class="solution-content">';
                    echo $row_solusi['solusi'];
                    echo '</div>';

                    echo '<div class="solution-note">';
                    echo '<p><strong>Catatan Penting:</strong> Solusi di atas adalah saran umum. Jika gejala berlanjut atau memburuk, segera konsultasikan dengan dokter anak.</p>';
                    echo '</div>';
                } else {
                    echo '<div class="solution-content">';
                    echo 'Belum ada solusi spesifik untuk kombinasi penyakit dan usia ini. Silakan konsultasikan dengan dokter anak untuk penanganan lebih lanjut.';
                    echo '</div>';
                }

                echo '<div class="selected-symptoms">';
                echo '<h3>Gejala yang Dipilih:</h3>';
                echo '<ul>';

                foreach ($diagnosa['gejala_terpilih'] as $gejala_id) {
                    $sql_gejala = "SELECT nama_gejala FROM gejala WHERE id_gejala = '$gejala_id'";
                    $result_gejala = $conn->query($sql_gejala);
                    if ($result_gejala && $row_gejala = $result_gejala->fetch_assoc()) {
                        echo '<li>' . $row_gejala['nama_gejala'] . '</li>';
                    }
                }

                echo '</ul>';
                echo '</div>';
                ?>
            </div>


            <a href="index.php" class="btn-back">Kembali</a>

        </main>
    </div>

    <script>
        // Data untuk Pie Chart
        const data = {
            labels: [
                <?php
                foreach ($diagnosa['hasil'] as $id => $data) {
                    echo "'" . $data['nama'] . "',";
                }
                ?>
            ],
            datasets: [{
                data: [
                    <?php
                    foreach ($diagnosa['hasil'] as $id => $data) {
                        echo $data['probabilitas'] . ",";
                    }
                    ?>
                ],
                backgroundColor: [
                    '#4CAF50',
                    '#FF9800',
                    '#2196F3',
                    '#F44336',
                    '#9C27B0'
                ],
                hoverOffset: 4
            }]
        };

        // Konfigurasi Pie Chart
        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                }
            }
        };

        // Render Pie Chart
        const ctx = document.getElementById('diagnosisChart').getContext('2d');
        new Chart(ctx, config);
    </script>
</body>

</html>
<?php unset($_SESSION['diagnosa']); ?>