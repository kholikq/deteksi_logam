<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-6 text-gray-800"><?= esc($title) ?></h1>

<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <div class="border-b pb-4 mb-4">
        <!-- [PERUBAHAN] Ganti nama field -->
        <h2 class="text-xl font-semibold text-gray-800"><?= esc($production['nama_varian']) ?></h2>
        <p class="text-sm text-gray-500">Oleh: <?= esc($production['nama_lengkap']) ?></p>
    </div>

    <div class="grid grid-cols-2 gap-4 text-gray-700">
        <div>
            <p class="text-sm font-medium text-gray-500">Waktu Mulai</p>
            <p class="font-semibold"><?= date('d M Y, H:i', strtotime($production['waktu_mulai'])) ?></p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Waktu Selesai</p>
            <p class="font-semibold"><?= date('d M Y, H:i', strtotime($production['waktu_selesai'])) ?></p>
        </div>
        <div class="col-span-2 border-t pt-4">
            <p class="text-sm font-medium text-gray-500">Target Produksi</p>
            <p class="font-semibold text-2xl text-blue-600"><?= esc($production['jumlah_target']) ?> Roti</p>
        </div>
        <div class="border-t pt-4">
            <p class="text-sm font-medium text-gray-500">Logam Terdeteksi</p>
            <p class="font-semibold text-2xl text-red-600"><?= esc($production['jumlah_terdeteksi']) ?> Roti</p>
        </div>
        <div class="border-t pt-4">
            <p class="text-sm font-medium text-gray-500">Produk Aman</p>
            <?php $jumlah_aman = $production['jumlah_target'] - $production['jumlah_terdeteksi']; ?>
            <p class="font-semibold text-2xl text-green-600"><?= $jumlah_aman ?> Roti</p>
        </div>
    </div>

    <div class="mt-8 text-center">
        <a href="<?= site_url('dashboard') ?>" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
            Kembali & Mulai Produksi Baru
        </a>
    </div>
</div>
<?= $this->endSection() ?>