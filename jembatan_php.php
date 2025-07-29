<?php
// =====================================================================
//  Script PHP CLI sebagai Jembatan Arduino ke Web
// =====================================================================

// --- PENGATURAN YANG PERLU ANDA UBAH ---

// 1. Sesuaikan dengan port COM Arduino Anda.
//    PASTIKAN port ini benar dan TIDAK sedang dibuka oleh Serial Monitor di Arduino IDE.
$serialPort = 'COM3';

// 2. Ganti dengan URL API CodeIgniter Anda
//    Jika menggunakan 'php spark serve', URL ini sudah benar.
$apiUrl = 'http://localhost:8080/api/record';

// --- AKHIR PENGATURAN ---


// --- Fungsi untuk mengirim data ke server ---
function kirimKeServer($statusDeteksi) {
    global $apiUrl; // Mengambil variabel global

    echo "Mempersiapkan data untuk dikirim ke server...\n";

    // Data yang akan dikirim
    $postData = [
        'status' => $statusDeteksi,
    ];

    // Inisialisasi cURL
    $ch = curl_init($apiUrl);

    // Konfigurasi cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

    // Eksekusi cURL dan dapatkan respons
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Tutup koneksi cURL
    curl_close($ch);

    // Tampilkan hasil
    if ($httpCode == 201) {
        echo "SUKSES: Data terkirim. Respons Server: $response\n";
    } else {
        echo "GAGAL: Server merespons dengan kode $httpCode. Respons: $response\n";
    }
}


// --- Fungsi utama untuk membaca port serial ---
function main() {
    global $serialPort, $apiUrl;

    echo "===============================================\n";
    echo "   Script Jembatan PHP Arduino ke Web Dijalankan   \n";
    echo "===============================================\n";
    echo "Target API: $apiUrl\n";
    echo "Tekan Ctrl+C untuk menghentikan script.\n\n";

    $configCmd = "mode $serialPort: BAUD=9600 PARITY=n DATA=8 STOP=1";
    shell_exec($configCmd);

    try {
        $portPath = '\\\\.\\' . $serialPort;
        $fp = fopen($portPath, 'r+');

        if (!$fp) {
            throw new Exception("Gagal membuka port $serialPort. Pastikan port benar dan tidak digunakan program lain (seperti Serial Monitor).");
        }

        echo "Berhasil terhubung ke port $serialPort.\n";
        
        echo "Menunggu Arduino siap (2 detik)...\n";
        sleep(2);
        echo "Mulai mendengarkan data...\n";

        $buffer = ''; // Buat buffer untuk menampung data yang masuk

        // Loop tak terbatas untuk membaca data
        while (true) {
            // Baca data yang tersedia dari port (hingga 1024 byte)
            $read = fread($fp, 1024);
            
            // Jika ada data yang berhasil dibaca, tambahkan ke buffer
            if ($read !== false && strlen($read) > 0) {
                $buffer .= $read;
            }

            // Proses buffer jika mengandung karakter baris baru (\n)
            while (($pos = strpos($buffer, "\n")) !== false) {
                // Ambil satu baris lengkap dari buffer
                $line = substr($buffer, 0, $pos + 1);
                // Hapus baris yang sudah diambil dari buffer
                $buffer = substr($buffer, $pos + 1);

                // Proses baris yang sudah bersih
                $dataFromArduino = trim($line);
                
                if (!empty($dataFromArduino)) {
                    echo "\nData diterima dari Arduino: '$dataFromArduino'\n";
                    
                    if ($dataFromArduino == "Logam Terdeteksi") {
                        kirimKeServer("Logam Terdeteksi");
                    }
                }
            }
            
            // Beri jeda singkat agar tidak membebani CPU
            usleep(100000); // 100ms
        }

    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
        echo "Script akan berhenti.\n";
    } finally {
        if (isset($fp) && is_resource($fp)) {
            fclose($fp);
        }
    }
}

// Jalankan fungsi utama
main();

?>
