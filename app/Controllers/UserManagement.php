<?php namespace App\Controllers;

use App\Models\UserModel;

class UserManagement extends BaseController
{
    public function index()
    {
        // Hanya admin yang bisa akses
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $model = new UserModel();
        $data = [
            'title' => 'Manajemen Pengguna',
            'users' => $model->findAll()
        ];
        return view('user_management_view', $data);
    }

    public function save()
    {
        $model = new UserModel();
        $id = $this->request->getPost('id');
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username' => $this->request->getPost('username'),
            'peran' => $this->request->getPost('peran'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($id) { // Update
            $model->update($id, $data);
            session()->setFlashdata('success', 'Data pengguna berhasil diperbarui.');
        } else { // Insert
            $model->insert($data);
            session()->setFlashdata('success', 'Pengguna baru berhasil ditambahkan.');
        }

        return redirect()->to('/users');
    }

    public function delete($id)
    {
        $model = new UserModel();
        // Cegah admin menghapus diri sendiri
        if ($id == session()->get('user_id')) {
            session()->setFlashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return redirect()->to('/users');
        }
        
        $model->delete($id);
        session()->setFlashdata('success', 'Pengguna berhasil dihapus.');
        return redirect()->to('/users');
    }
}