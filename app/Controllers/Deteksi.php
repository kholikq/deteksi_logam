<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\DeteksiModel;

class Deteksi extends Controller
{
    public function submit()
    {
        $model = new DeteksiModel();
        $status = $this->request->getPost('status');

        $model->save([
            'status' => $status,
            'sumber' => 'line1'
        ]);

        return $this->response->setJSON(['success' => true]);
    }

    public function laporan()
    {
        $model = new DeteksiModel();
        $data['semua'] = $model->findAll();
        return view('laporan', $data);
    }
}
