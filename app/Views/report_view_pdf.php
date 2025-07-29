<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .text-red { color: #dc3545; font-weight: bold; }
        .text-green { color: #28a745; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Laporan Produksi</h1>
    <table>
        <thead>
            <tr>
                <th>Waktu Mulai</th>
                <th>Operator</th>
                <th>Varian Roti</th>
                <th class="text-center">Target</th>
                <th class="text-center">Terdeteksi</th>
                <th class="text-center">Aman</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($productions)): ?>
                <?php foreach($productions as $prod): ?>
                    <tr>
                        <td><?= date('d-m-Y H:i', strtotime($prod['waktu_mulai'])) ?></td>
                        <td><?= esc($prod['nama_lengkap']) ?></td>
                        <td><?= esc($prod['nama_varian']) ?></td>
                        <td class="text-center"><?= esc($prod['jumlah_target']) ?></td>
                        <td class="text-center text-red"><?= esc($prod['jumlah_terdeteksi']) ?></td>
                        <td class="text-center text-green"><?= $prod['jumlah_target'] - $prod['jumlah_terdeteksi'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>