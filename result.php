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
</head>

<body>
    <div class="container">
        <header>
            <h1>Hasil Diagnosa</h1>
        </header>

        <main>
            <div class="patient-info">
                <h2>Informasi Pasien</h2>
                <p><strong>Nama:</strong> <?= $diagnosa['nama_pasien'] ?></p>
                <p><strong>Usia:</strong> <?= $diagnosa['usia_pasien'] ?> bulan</p>
            </div>

            <div class="symptoms-list">
                <h2>Gejala Terpilih</h2>
                <ul>
                    <?php
                    $gejala_ids = implode("','", $diagnosa['gejala_terpilih']);
                    $sql = "SELECT nama_gejala FROM gejala WHERE id_gejala IN ('$gejala_ids')";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<li>' . $row['nama_gejala'] . '</li>';
                    }
                    ?>
                </ul>
            </div>

            <div class="diagnosis-result">
                <h2>Hasil Analisis</h2>
                <?php
                $diagnosa_utama = array_key_first($diagnosa['hasil']);
                foreach ($diagnosa['hasil'] as $id => $data) {
                    echo '<div class="disease-progress">';
                    echo '<h3>' . $data['nama'] . '</h3>';
                    echo '<div class="progress-bar">';
                    echo '<div class="progress" style="width: ' . $data['probabilitas'] . '%"></div>';
                    echo '<span>' . $data['probabilitas'] . '%</span>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>

            <div class="conclusion">
                <h2>Kesimpulan</h2>
                <p>Berdasarkan analisis gejala, pasien kemungkinan besar menderita:</p>
                <div class="primary-diagnosis">
                    <h3><?= $diagnosa['hasil'][$diagnosa_utama]['nama'] ?></h3>
                    <p>Dengan probabilitas <?= $diagnosa['hasil'][$diagnosa_utama]['probabilitas'] ?>%</p>
                </div>
            </div>

            <a href="index.php" class="btn-back">Kembali</a>
        </main>
    </div>
</body>

</html>
<?php unset($_SESSION['diagnosa']); ?>