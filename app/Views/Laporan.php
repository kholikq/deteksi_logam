<!DOCTYPE html>
<html>
<head>
    <title>Laporan Deteksi Logam</title>
</head>
<body>
    <h2>Laporan Keseluruhan</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Sumber</th>
        </tr>
        <?php foreach($semua as $item): ?>
        <tr>
            <td><?= $item['id'] ?></td>
            <td><?= $item['waktu'] ?></td>
            <td><?= $item['status'] == 1 ? 'Terdeteksi' : 'Aman' ?></td>
            <td><?= $item['sumber'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <button onclick="window.print()">Cetak</button>
</body>
</html>
