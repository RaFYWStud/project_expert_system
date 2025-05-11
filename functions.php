<?php
function hitungDiagnosa($gejala_terpilih, $conn)
{
    // 1. Ambil data prior probability
    $penyakit = [];
    $sql = "SELECT id_penyakit, nama_penyakit, prior_prob FROM penyakit";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $penyakit[$row['id_penyakit']] = [
            'nama' => $row['nama_penyakit'],
            'posterior' => $row['prior_prob']
        ];
    }

    // 2. Hitung likelihood untuk setiap gejala
    foreach ($gejala_terpilih as $gejala_id) {
        $sql = "SELECT id_penyakit, nilai_likelihood FROM likelihood WHERE id_gejala = '$gejala_id'";
        $result = $conn->query($sql);

        // Inisialisasi temporary storage
        $temp = [];
        foreach ($penyakit as $id => $data) {
            $temp[$id] = $data['posterior'];
        }

        // Update posterior
        while ($row = $result->fetch_assoc()) {
            $penyakit[$row['id_penyakit']]['posterior'] = $temp[$row['id_penyakit']] * $row['nilai_likelihood'];
        }
    }

    // 3. Normalisasi
    $total = array_sum(array_column($penyakit, 'posterior'));

    // Handle division by zero
    if ($total <= 0) {
        foreach ($penyakit as $id => $data) {
            $penyakit[$id]['posterior'] = 0;
        }
        return $penyakit;
    }

    $results = [];
    foreach ($penyakit as $id => $data) {
        $results[$id] = [
            'nama' => $data['nama'],
            'probabilitas' => round(($data['posterior'] / $total) * 100, 2)
        ];
    }

    // 4. Urutkan hasil
    uasort($results, function ($a, $b) {
        return $b['probabilitas'] <=> $a['probabilitas'];
    });

    return $results;
}
