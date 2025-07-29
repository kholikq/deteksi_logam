<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-6 text-gray-800"><?= esc($title) ?></h1>

<?php if (session()->getFlashdata('success')): ?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Form Tambah/Edit Varian -->
    <div class="md:col-span-1 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4" id="form-title">Tambah Varian Baru</h2>
        <form action="<?= site_url('varian-roti/save') ?>" method="post" id="varian-form">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="varian-id">
            <div class="mb-4">
                <label for="nama_varian" class="block text-sm font-medium text-gray-700">Nama Varian Roti</label>
                <input type="text" name="nama_varian" id="nama_varian" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div class="flex items-center space-x-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                <button type="button" id="cancel-edit" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded" style="display: none;">Batal</button>
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Varian -->
    <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Daftar Varian Roti</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4">Nama Varian</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php foreach($variants as $variant): ?>
                        <tr class="border-b">
                            <td class="py-3 px-4"><?= esc($variant['nama_varian']) ?></td>
                            <td class="py-3 px-4 flex items-center space-x-2">
                                <button class="text-blue-500 hover:text-blue-700" onclick="editVarian(<?= htmlspecialchars(json_encode($variant), ENT_QUOTES, 'UTF-8') ?>)">Edit</button>
                                <a href="<?= site_url('varian-roti/delete/' . $variant['id']) ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus varian ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('varian-form');
    const formTitle = document.getElementById('form-title');
    const varianId = document.getElementById('varian-id');
    const namaVarian = document.getElementById('nama_varian');
    const cancelBtn = document.getElementById('cancel-edit');

    function editVarian(variant) {
        formTitle.innerText = 'Edit Varian Roti';
        varianId.value = variant.id;
        namaVarian.value = variant.nama_varian;
        cancelBtn.style.display = 'block';
        window.scrollTo(0, 0); // Scroll ke atas untuk melihat form
    }

    cancelBtn.addEventListener('click', () => {
        form.reset();
        formTitle.innerText = 'Tambah Varian Baru';
        varianId.value = '';
        cancelBtn.style.display = 'none';
    });
</script>
<?= $this->endSection() ?>