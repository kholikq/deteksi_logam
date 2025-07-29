<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800"><?= esc($title) ?></h1>
    <!-- [PERUBAHAN] Grup tombol untuk cetak dan export -->
    <div class="flex space-x-2">
        <a href="<?= site_url('dashboard/export-pdf?' . http_build_query(['bulan' => $selectedBulan, 'operator' => $selectedOperator])) ?>" 
         target="_blank" 
         class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
         Export PDF
     </a>
     <a href="<?= site_url('dashboard/export-excel?' . http_build_query(['bulan' => $selectedBulan, 'operator' => $selectedOperator])) ?>" 
         class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
         Export Excel
     </a>
 </div>
</div>

<!-- Form Filter -->
<div class="bg-white p-4 rounded-lg shadow-md mb-6">
    <h3 class="text-lg font-semibold mb-2">Filter Laporan</h3>
    <form action="<?= site_url('dashboard/full-report') ?>" method="get" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        <div>
            <label for="bulan" class="block text-sm font-medium text-gray-700">Berdasarkan Bulan</label>
            <select name="bulan" id="bulan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="semua" <?= !isset($selectedBulan) || $selectedBulan == 'semua' ? 'selected' : '' ?>>Semua Bulan</option>
                <?php
                for ($i = 0; $i < 12; $i++) {
                    $time = strtotime(sprintf('-%d months', $i));
                    $value = date('Y-m', $time);
                    $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE, null, null, 'MMMM YYYY');
                    $label = $formatter->format($time);
                    $selected = (isset($selectedBulan) && $selectedBulan == $value) ? 'selected' : '';
                    echo "<option value='{$value}' {$selected}>{$label}</option>";
                }
                ?>
            </select>
        </div>
        
        <?php if(session()->get('user_role') == 'admin'): ?>
        <div>
            <label for="operator" class="block text-sm font-medium text-gray-700">Berdasarkan Operator</label>
            <select name="operator" id="operator" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="semua" <?= !isset($selectedOperator) || $selectedOperator == 'semua' ? 'selected' : '' ?>>Semua Operator</option>
                <?php foreach($operators as $op): ?>
                    <option value="<?= $op['id'] ?>" <?= (isset($selectedOperator) && $selectedOperator == $op['id']) ? 'selected' : '' ?>>
                        <?= esc($op['nama_lengkap']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>

    <div class="<?= session()->get('user_role') == 'admin' ? '' : 'md:col-start-3' ?>">
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">
            Terapkan Filter
        </button>
    </div>
</form>
</div>

<!-- Tabel Laporan Produksi -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4">Waktu Mulai</th>
                    <th class="py-3 px-4">Operator</th>
                    <th class="py-3 px-4">Varian Roti</th>
                    <th class="py-3 px-4">Target</th>
                    <th class="py-3 px-4">Terdeteksi</th>
                    <th class="py-3 px-4">Aman</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php if(!empty($productions)): ?>
                    <?php foreach($productions as $prod): ?>
                        <tr class="border-b">
                            <td class="py-3 px-4"><?= date('d-m-Y H:i', strtotime($prod['waktu_mulai'])) ?></td>
                            <td class="py-3 px-4"><?= esc($prod['nama_lengkap']) ?></td>
                            <td class="py-3 px-4"><?= esc($prod['nama_varian']) ?></td>
                            <td class="py-3 px-4 text-center"><?= esc($prod['jumlah_target']) ?></td>
                            <td class="py-3 px-4 text-center text-red-600 font-semibold"><?= esc($prod['jumlah_terdeteksi']) ?></td>
                            <td class="py-3 px-4 text-center text-green-600 font-semibold"><?= $prod['jumlah_target'] - $prod['jumlah_terdeteksi'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center py-4">Tidak ada data produksi yang cocok.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>