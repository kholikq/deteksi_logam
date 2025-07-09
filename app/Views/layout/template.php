<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - Sistem Deteksi Logam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print { .no-print { display: none; } main { margin: 0 !important; padding: 0 !important; } }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen bg-gray-200">
        <!-- Sidebar Menu -->
        <div class="no-print w-64 bg-gray-800 text-white flex flex-col">
            <div class="px-6 py-4 border-b border-gray-700">
                <h2 class="text-xl font-semibold">Deteksi Logam</h2>
                <span class="text-sm text-gray-400">Halo, <?= session()->get('user_name') ?></span>
            </div>
            <nav class="flex-1 px-4 py-4">
                <a href="<?= site_url('dashboard') ?>" class="flex items-center px-4 py-2 rounded hover:bg-gray-700">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                <a href="<?= site_url('dashboard/full-report') ?>" class="mt-2 flex items-center px-4 py-2 rounded hover:bg-gray-700">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan Keseluruhan
                </a>
                <?php if(session()->get('user_role') == 'admin'): ?>
                <a href="<?= site_url('users') ?>" class="mt-2 flex items-center px-4 py-2 rounded hover:bg-gray-700"> <!-- Disesuaikan -->
                     <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m0 0A5.975 5.975 0 0112 13a5.975 5.975 0 013-1.197M15 21a9 9 0 00-6-6.303"></path></svg>
                    Manajemen Pengguna
                </a>
                <?php endif; ?>
                <a href="<?= site_url('login/logout') ?>" class="mt-auto mb-4 flex items-center px-4 py-2 rounded hover:bg-red-700 bg-red-600">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </a>
            </nav>
        </div>

        <main class="flex-1 p-6 overflow-y-auto">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</body>
</html>