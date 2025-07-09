<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-6 text-gray-800"><?= esc($title) ?></h1>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Form Tambah/Edit Pengguna -->
    <div class="md:col-span-1 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4" id="form-title">Tambah Pengguna Baru</h2>
        <form action="<?= site_url('users/save') ?>" method="post" id="user-form">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="user-id">
            <div class="mb-4">
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Kosongkan jika tidak diubah">
            </div>
            <div class="mb-4">
                <label for="peran" class="block text-sm font-medium text-gray-700">Peran</label>
                <select name="peran" id="peran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="operator">Operator</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                <button type="button" id="cancel-edit" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded" style="display: none;">Batal</button>
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Pengguna -->
    <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Daftar Pengguna</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4">Nama Lengkap</th>
                        <th class="py-3 px-4">Username</th>
                        <th class="py-3 px-4">Peran</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php foreach($users as $user): ?>
                    <tr class="border-b">
                        <td class="py-3 px-4"><?= esc($user['nama_lengkap']) ?></td>
                        <td class="py-3 px-4"><?= esc($user['username']) ?></td>
                        <td class="py-3 px-4"><?= ucfirst($user['peran']) ?></td>
                        <td class="py-3 px-4 flex items-center space-x-2">
                            <button class="text-blue-500 hover:text-blue-700" onclick="editUser(<?= htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8') ?>)">Edit</button>
                            <a href="<?= site_url('users/delete/' . $user['id']) ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('user-form');
    const formTitle = document.getElementById('form-title');
    const userId = document.getElementById('user-id');
    const namaLengkap = document.getElementById('nama_lengkap');
    const username = document.getElementById('username');
    const peran = document.getElementById('peran');
    const password = document.getElementById('password');
    const cancelBtn = document.getElementById('cancel-edit');

    function editUser(user) {
        formTitle.innerText = 'Edit Pengguna';
        userId.value = user.id;
        namaLengkap.value = user.nama_lengkap;
        username.value = user.username;
        peran.value = user.peran;
        password.placeholder = 'Kosongkan jika tidak diubah';
        cancelBtn.style.display = 'block';
    }

    cancelBtn.addEventListener('click', () => {
        form.reset();
        formTitle.innerText = 'Tambah Pengguna Baru';
        userId.value = '';
        password.placeholder = '';
        cancelBtn.style.display = 'none';
    });
</script>
<?= $this->endSection() ?>