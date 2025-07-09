<?php namespace App\Controllers;

use App\Models\DetectionModel;
use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    use ResponseTrait;

    public function record()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->fail('Metode tidak diizinkan', 405);
        }

        $status = $this->request->getPost('status');
        $id_operator = $this->request->getPost('id_user_operator');
        $varian_roti = $this->request->getPost('varian_roti'); // [PERUBAHAN] Ambil data varian roti

        // [PERUBAHAN] Tambahkan varian_roti ke validasi
        if (empty($status) || empty($id_operator) || empty($varian_roti)) {
            return $this->fail('Data tidak lengkap: status, id_user_operator, dan varian_roti diperlukan.', 400);
        }

        $model = new DetectionModel();
        $data = [
            'status' => $status,
            'id_pengguna_operator' => $id_operator,
            'varian_roti' => $varian_roti, // [PERUBAHAN] Tambahkan ke data yang akan disimpan
        ];

        if ($model->insert($data)) {
            return $this->respondCreated(['status' => 'sukses', 'message' => 'Data berhasil disimpan']);
        } else {
            return $this->fail('Gagal menyimpan data ke database', 500);
        }
    }
}