<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-4">
    <h1 class="text-3xl font-bold text-gray-800"><?= esc($title) ?></h1>
    <a href="<?= site_url('dashboard/finish/' . $production['id']) ?>" 
     onclick="return confirm('Apakah Anda yakin ingin menyelesaikan sesi produksi ini?')"
     class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
     Selesai Produksi
 </a>
</div>

<!-- Info Produksi -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-sm font-medium text-gray-500">Varian Roti</h3>
        <!-- [PERUBAHAN] Ganti nama field -->
        <p class="mt-1 text-2xl font-semibold text-gray-900" id="info-varian"><?= esc($production['nama_varian']) ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-sm font-medium text-gray-500">Target Produksi</h3>
        <p class="mt-1 text-2xl font-semibold text-gray-900" id="info-target"><?= esc($production['jumlah_target']) ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-sm font-medium text-gray-500">Logam Terdeteksi</h3>
        <p class="mt-1 text-2xl font-semibold text-red-600" id="info-terdeteksi"><?= esc($production['jumlah_terdeteksi']) ?></p>
    </div>
</div>

<!-- Tabel Real-time -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Log Deteksi (Real-time)</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Waktu Deteksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700" id="realtime-data-body"></tbody>
        </table>
    </div>
</div>

<script>
    function fetchData() {
        fetch('<?= site_url('dashboard/get-realtime-data') ?>')
        .then(response => {
            if (!response.ok) { window.location.href = '<?= site_url('dashboard') ?>'; }
            return response.json();
        })
        .then(data => {
            if (data.error) { window.location.href = '<?= site_url('dashboard') ?>'; return; }
            document.getElementById('info-terdeteksi').textContent = data.production.jumlah_terdeteksi;
            const tbody = document.getElementById('realtime-data-body');
            tbody.innerHTML = ''; 
            data.detections.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'border-b';
                row.innerHTML = `<td class="py-3 px-4">${new Date(item.waktu).toLocaleString('id-ID')}</td>`;
                tbody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
    }
    document.addEventListener('DOMContentLoaded', fetchData);
    setInterval(fetchData, 3000);
</script>
<?= $this->endSection() ?>