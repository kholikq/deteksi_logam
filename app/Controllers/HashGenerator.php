<?php namespace App\Controllers;

class HashGenerator extends BaseController
{
    /**
     * Alat bantu untuk membuat password hash.
     * Cukup akses URL /generate-hash/passwordanda untuk mendapatkan hash.
     * Contoh: http://localhost:8080/generate-hash/admin123
     */
    public function index($password = null)
    {
        if (empty($password)) {
            echo "<h1>Gagal Membuat Hash</h1>";
            echo "<p>Silakan masukkan password di URL.</p>";
            echo "<p>Contoh: <strong>/generate-hash/password_yang_diinginkan</strong></p>";
            return;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        echo "<!DOCTYPE html><html lang='id'><head><title>Password Hash Generator</title>";
        echo "<style>body { font-family: sans-serif; padding: 2em; } textarea { width: 100%; box-sizing: border-box; } code { background-color: #eee; padding: 3px 5px; border-radius: 4px; }</style>";
        echo "</head><body>";
        echo "<h1>Password Hash Generator</h1>";
        echo "<p>Password Plain: <code>" . esc($password) . "</code></p>";
        echo "<p><strong>Password Hash (Salin teks di bawah ini):</strong></p>";
        echo "<textarea rows='4' cols='80' readonly onclick='this.select()'>" . esc($hash) . "</textarea>";
        echo "<hr><p><strong>Langkah Selanjutnya:</strong></p>";
        echo "<ol><li>Salin seluruh teks hash di atas.</li>";
        echo "<li>Buka <strong>phpMyAdmin</strong> dan pilih tabel <code>pengguna</code>.</li>";
        echo "<li>Cari baris data untuk username <code>admin</code>, lalu klik <strong>Edit</strong>.</li>";
        echo "<li>Tempel (paste) hash ini ke dalam kolom <code>password</code>.</li>";
        echo "<li>Klik <strong>Go</strong> atau <strong>Simpan</strong>.</li>";
        echo "<li>Sekarang Anda bisa login dengan username <code>admin</code> dan password <code>" . esc($password) . "</code>.</li></ol>";
        echo "</body></html>";
    }
}