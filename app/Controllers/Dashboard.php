<?php namespace App\Controllers;

use App\Models\DetectionModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $model = new DetectionModel();
        $data['title'] = 'Dashboard Real-time';
        $data['detections'] = $model->select('deteksi.*, pengguna.nama_lengkap')
                                    ->join('pengguna', 'pengguna.id = deteksi.id_pengguna_operator')
                                    ->orderBy('deteksi.waktu', 'DESC')
                                    ->limit(10)
                                    ->findAll();
        
        return view('dashboard_view', $data);
    }

    private function getFilteredData()
    {
        $detectionModel = new DetectionModel();
        $filterBulan = $this->request->getGet('bulan');
        $filterOperator = $this->request->getGet('operator');

        $query = $detectionModel->select('deteksi.*, pengguna.nama_lengkap')
                                ->join('pengguna', 'pengguna.id = deteksi.id_pengguna_operator');

        if ($filterBulan && $filterBulan !== 'semua') {
            $query->where("DATE_FORMAT(deteksi.waktu, '%Y-%m')", $filterBulan);
        }

        if ($filterOperator && $filterOperator !== 'semua') {
            $query->where('deteksi.id_pengguna_operator', $filterOperator);
        }

        return $query->orderBy('deteksi.waktu', 'DESC')->findAll();
    }

    public function fullReport()
    {
        $userModel = new UserModel();

        $data['detections'] = $this->getFilteredData();
        $data['title'] = 'Laporan Keseluruhan';
        $data['operators'] = $userModel->findAll();
        $data['selectedBulan'] = $this->request->getGet('bulan');
        $data['selectedOperator'] = $this->request->getGet('operator');
        
        return view('report_view', $data);
    }

    // [PERUBAHAN] Fungsi baru untuk halaman cetak
    public function printReport()
    {
        $data['detections'] = $this->getFilteredData();
        $data['title'] = 'Cetak Laporan Deteksi';
        $data['filterBulan'] = $this->request->getGet('bulan');
        $data['filterOperator'] = $this->request->getGet('operator');
        
        // Jika operator difilter, ambil nama operator untuk ditampilkan di judul
        if($data['filterOperator'] && $data['filterOperator'] !== 'semua'){
            $userModel = new UserModel();
            $op = $userModel->find($data['filterOperator']);
            $data['namaOperator'] = $op['nama_lengkap'];
        }

        return view('print_report_view', $data);
    }

    public function getRealtimeData()
    {
        $model = new DetectionModel();
        $data = $model->select('deteksi.*, pengguna.nama_lengkap')
                      ->join('pengguna', 'pengguna.id = deteksi.id_pengguna_operator')
                      ->orderBy('deteksi.waktu', 'DESC')
                      ->limit(10)
                      ->findAll();
        return $this->response->setJSON($data);
    }
}