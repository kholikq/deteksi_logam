<?php namespace App\Controllers;

use App\Models\ProductionModel;
use App\Models\DetectionModel;
use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    use ResponseTrait;

    public function record()
    {
        $status = $this->request->getPostGet('status');
        if (empty($status) || $status !== 'Logam Terdeteksi') {
            return $this->fail('Data "status" tidak valid.', 400);
        }

        $prodModel = new ProductionModel();
        
        // Cari sesi produksi yang sedang berjalan (hanya boleh ada satu)
        $activeProduction = $prodModel->where('status', 'Berjalan')->first();

        if (!$activeProduction) {
            return $this->fail('Tidak ada sesi produksi yang sedang berjalan.', 404);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Catat waktu deteksi
        $detectModel = new DetectionModel();
        $detectModel->insert([
            'id_produksi' => $activeProduction['id']
        ]);

        // 2. Tambah jumlah terdeteksi di tabel produksi
        $prodModel->update($activeProduction['id'], [
            'jumlah_terdeteksi' => $activeProduction['jumlah_terdeteksi'] + 1
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->fail('Gagal menyimpan data deteksi.', 500);
        }

        return $this->respondCreated(['status' => 'sukses', 'message' => 'Deteksi berhasil dicatat.']);
    }
}
