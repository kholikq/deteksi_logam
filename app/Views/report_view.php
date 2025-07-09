<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6 no-print">
    <h1 class="text-3xl font-bold text-gray-800"><?= esc($title) ?></h1>
    <!-- [PERUBAHAN] Tombol cetak diubah menjadi link ke halaman print -->
    <a href="<?= site_url('dashboard/print-report?' . http_build_query(['bulan' => $selectedBulan, 'operator' => $selectedOperator])) ?>" 
       target="_blank" 
       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Cetak Laporan
    </a>
</div>

<div class="no-print bg-white p-4 rounded-lg shadow-md mb-6">
    <h3 class="text-lg font-semibold mb-2">Filter Laporan</h3>
    <form action="<?= site_url('dashboard/full-report') ?>" method="get" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        <div>
            <label for="bulan" class="block text-sm font-medium text-gray-700">Berdasarkan Bulan</label>
            <select name="bulan" id="bulan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="semua" <?= !$selectedBulan || $selectedBulan == 'semua' ? 'selected' : '' ?>>Semua Bulan</option>
                <?php
                for ($i = 0; $i < 12; $i++) {
                    $time = strtotime(sprintf('-%d months', $i));
                    $value = date('Y-m', $time);
                    $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE, null, null, 'MMMM YYYY');
                    $label = $formatter->format($time);
                    $selected = ($selectedBulan == $value) ? 'selected' : '';
                    echo "<option value='{$value}' {$selected}>{$label}</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="operator" class="block text-sm font-medium text-gray-700">Berdasarkan Operator</label>
            <select name="operator" id="operator" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="semua" <?= !$selectedOperator || $selectedOperator == 'semua' ? 'selected' : '' ?>>Semua Operator</option>
                <?php foreach($operators as $op): ?>
                    <option value="<?= $op['id'] ?>" <?= ($selectedOperator == $op['id']) ? 'selected' : '' ?>>
                        <?= esc($op['nama_lengkap']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md shadow-sm">
                Terapkan Filter
            </button>
        </div>
    </form>
</div>


<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">No</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Waktu</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Varian Roti</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Status</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Operator</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php if(!empty($detections)): ?>
                    <?php $no = 1; foreach($detections as $item): ?>
                    <tr class="border-b">
                        <td class="py-3 px-4 text-center"><?= $no++ ?></td>
                        <td class="py-3 px-4"><?= date('d-m-Y H:i:s', strtotime($item['waktu'])) ?></td>
                        <td class="py-3 px-4"><?= esc($item['varian_roti']) ?></td>
                        <td class="py-3 px-4 <?= $item['status'] == 'Logam Terdeteksi' ? 'text-red-500 font-bold' : 'text-green-500' ?>">
                            <?= $item['status'] ?>
                        </td>
                        <td class="py-3 px-4"><?= esc($item['nama_lengkap']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center py-4">Tidak ada data yang cocok dengan filter yang dipilih.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>