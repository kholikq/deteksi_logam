<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-6 text-gray-800"><?= esc($title) ?></h1>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">10 Deteksi Terakhir</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Waktu</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Varian Roti</th> <!-- [PERUBAHAN] -->
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Status</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Operator</th>
                </tr>
            </thead>
            <tbody class="text-gray-700" id="realtime-data-body"></tbody>
        </table>
    </div>
</div>

<script>
    function fetchData() {
        fetch('<?= site_url('dashboard/get-realtime-data') ?>')
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('realtime-data-body');
                tbody.innerHTML = ''; 
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.className = 'border-b';
                    const statusClass = item.status === 'Logam Terdeteksi' ? 'text-red-500 font-bold' : 'text-green-500';

                    // [PERUBAHAN] Tambahkan kolom varian roti
                    row.innerHTML = `
                        <td class="py-3 px-4">${new Date(item.waktu).toLocaleString('id-ID')}</td>
                        <td class="py-3 px-4">${item.varian_roti}</td>
                        <td class="py-3 px-4 ${statusClass}">${item.status}</td>
                        <td class="py-3 px-4">${item.nama_lengkap}</td>
                    `;
                    tbody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    }
    document.addEventListener('DOMContentLoaded', fetchData);
    setInterval(fetchData, 5000); 
</script>
<?= $this->endSection() ?>