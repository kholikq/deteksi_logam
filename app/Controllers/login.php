<?php namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login_page');
    }

    public function process()
    {
        $session = session();
        $model = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        $data = $model->where('username', $username)->first();
        
        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'user_id'       => $data['id'],
                    'user_name'     => $data['nama_lengkap'],
                    'user_username' => $data['username'],
                    'user_role'     => $data['peran'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);

                // [PERUBAHAN] Arahkan admin ke laporan, operator ke dashboard produksi
                if ($data['peran'] == 'admin') {
                    return redirect()->to('/dashboard/full-report');
                } else {
                    return redirect()->to('/dashboard');
                }

            } else {
                $session->setFlashdata('msg', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}