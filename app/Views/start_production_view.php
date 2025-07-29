<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-6 text-gray-800"><?= esc($title) ?></h1>

<div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
    <form action="<?= site_url('dashboard/start') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-4">
            <label for="id_varian_roti" class="block text-gray-700 text-sm font-bold mb-2">Varian Roti</label>
            <!-- [PERUBAHAN] Ganti input teks menjadi dropdown -->
            <select name="id_varian_roti" id="id_varian_roti" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">-- Pilih Varian --</option>
                <?php foreach($varian_roti_list as $varian): ?>
                    <option value="<?= $varian['id'] ?>"><?= esc($varian['nama_varian']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-6">
            <label for="jumlah_target" class="block text-gray-700 text-sm font-bold mb-2">Jumlah Produksi (Target)</label>
            <input type="number" name="jumlah_target" id="jumlah_target" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Contoh: 500">
        </div>
        <div class="flex items-center justify-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                Mulai Sesi Deteksi
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>