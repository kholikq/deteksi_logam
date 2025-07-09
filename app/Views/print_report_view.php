<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-size: 13px;
        }
        .text-center {
            text-align: center;
        }
        .text-danger {
            color: #dc3545;
            font-weight: bold;
        }
        .text-success {
            color: #28a745;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="header">
            <h1>Laporan Keseluruhan Hasil Deteksi Logam</h1>
            <?php
                $periode = "Semua Periode";
                if (isset($filterBulan) && $filterBulan !== 'semua') {
                    $time = strtotime($filterBulan . '-01');
                    $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE, null, null, 'MMMM yyyy');
                    $periode = "Periode: " . $formatter->format($time);
                }
                $operator = "Semua Operator";
                if (isset($namaOperator)) {
                    $operator = "Operator: " . esc($namaOperator);
                }
            ?>
            <p><?= $periode ?> | <?= $operator ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Waktu</th>
                    <th>Varian Roti</th>
                    <th>Status</th>
                    <th>Operator</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($detections)): ?>
                    <?php $no = 1; foreach($detections as $item): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= date('d-m-Y H:i:s', strtotime($item['waktu'])) ?></td>
                        <td><?= esc($item['varian_roti']) ?></td>
                        <td class="<?= $item['status'] == 'Logam Terdeteksi' ? 'text-danger' : 'text-success' ?>">
                            <?= $item['status'] ?>
                        </td>
                        <td><?= esc($item['nama_lengkap']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>