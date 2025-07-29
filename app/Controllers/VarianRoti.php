<?php namespace App\Controllers;

use App\Models\VarianRotiModel;

class VarianRoti extends BaseController
{
    public function index()
    {
        // Hanya admin yang bisa akses
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $model = new VarianRotiModel();
        $data = [
            'title' => 'Manajemen Varian Roti',
            'variants' => $model->findAll()
        ];
        return view('varian_roti_view', $data);
    }

    public function save()
    {
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $model = new VarianRotiModel();
        $id = $this->request->getPost('id');
        $data = [
            'nama_varian' => $this->request->getPost('nama_varian'),
        ];

        if ($id) { // Update
            $model->update($id, $data);
            session()->setFlashdata('success', 'Varian roti berhasil diperbarui.');
        } else { // Insert
            $model->insert($data);
            session()->setFlashdata('success', 'Varian roti baru berhasil ditambahkan.');
        }

        return redirect()->to('/varian-roti');
    }

    public function delete($id)
    {
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/dashboard');
        }
        
        $model = new VarianRotiModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Varian roti berhasil dihapus.');
        return redirect()->to('/varian-roti');
    }
}
