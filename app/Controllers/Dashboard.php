<?php namespace App\Controllers;

use App\Models\ProductionModel;
use App\Models\DetectionModel;
use App\Models\UserModel;
use App\Models\VarianRotiModel;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends BaseController
{
    public function index()
    {
        if (session()->get('user_role') == 'admin') {
            return redirect()->to('/dashboard/full-report');
        }

        $prodModel = new ProductionModel();
        
        $activeProduction = $prodModel->select('produksi.*, varian_roti.nama_varian')
        ->join('varian_roti', 'varian_roti.id = produksi.id_varian_roti')
        ->where('status', 'Berjalan')->first();

        if ($activeProduction) {
            $data['title'] = 'Pemantauan Produksi';
            $data['production'] = $activeProduction;
            return view('dashboard_view', $data);
        } else {
            $varianRotiModel = new VarianRotiModel();
            $data['title'] = 'Mulai Produksi Baru';
            $data['varian_roti_list'] = $varianRotiModel->findAll();
            return view('start_production_view', $data);
        }
    }

    public function startProduction()
    {
        $prodModel = new ProductionModel();
        
        $data = [
            'id_varian_roti' => $this->request->getPost('id_varian_roti'),
            'jumlah_target' => $this->request->getPost('jumlah_target'),
            'id_pengguna_operator' => session()->get('user_id'),
            'status' => 'Berjalan'
        ];

        $prodModel->insert($data);

        return redirect()->to('/dashboard');
    }

    public function finishProduction($id)
    {
        $prodModel = new ProductionModel();
        $prodModel->update($id, [
            'status' => 'Selesai',
            'waktu_selesai' => date('Y-m-d H:i:s')
        ]);

        $finishedProduction = $prodModel->select('produksi.*, pengguna.nama_lengkap, varian_roti.nama_varian')
        ->join('pengguna', 'pengguna.id = produksi.id_pengguna_operator')
        ->join('varian_roti', 'varian_roti.id = produksi.id_varian_roti')
        ->find($id);

        if (!$finishedProduction) {
            return redirect()->to('/dashboard');
        }
        
        $data['title'] = 'Rekap Produksi Selesai';
        $data['production'] = $finishedProduction;

        return view('summary_production_view', $data);
    }

    public function getRealtimeData()
    {
        $prodModel = new ProductionModel();
        $detectModel = new DetectionModel();

        $activeProduction = $prodModel->where('status', 'Berjalan')->first();

        if ($activeProduction) {
            $detections = $detectModel->where('id_produksi', $activeProduction['id'])
            ->orderBy('waktu', 'DESC')
            ->findAll();
            return $this->response->setJSON([
                'production' => $activeProduction,
                'detections' => $detections
            ]);
        }

        return $this->response->setJSON(['error' => 'No active session'], 404);
    }
    
    private function getFilteredData()
    {
        $prodModel = new ProductionModel();
        $filterBulan = $this->request->getGet('bulan');
        $filterOperator = $this->request->getGet('operator');

        $query = $prodModel->select('produksi.*, pengguna.nama_lengkap, varian_roti.nama_varian')
        ->join('pengguna', 'pengguna.id = produksi.id_pengguna_operator')
        ->join('varian_roti', 'varian_roti.id = produksi.id_varian_roti')
        ->where('produksi.status', 'Selesai');

        if ($filterBulan && $filterBulan !== 'semua') {
            $query->where("DATE_FORMAT(produksi.waktu_mulai, '%Y-%m')", $filterBulan);
        }

        if (session()->get('user_role') == 'operator') {
            $query->where('produksi.id_pengguna_operator', session()->get('user_id'));
        } else {
            if ($filterOperator && $filterOperator !== 'semua') {
                $query->where('produksi.id_pengguna_operator', $filterOperator);
            }
        }

        return $query->orderBy('produksi.waktu_mulai', 'DESC')->findAll();
    }

    public function fullReport()
    {
        $userModel = new UserModel();

        $data['productions'] = $this->getFilteredData();
        $data['title'] = 'Laporan Produksi';
        $data['operators'] = $userModel->findAll();
        $data['selectedBulan'] = $this->request->getGet('bulan');
        $data['selectedOperator'] = $this->request->getGet('operator');
        
        return view('report_view', $data);
    }

    public function exportPDF()
    {
        $data['productions'] = $this->getFilteredData();
        $data['title'] = 'Laporan Produksi PDF';

        $html = view('report_view_pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        // [PERUBAHAN] Ganti baris ini untuk menampilkan PDF di browser (preview)
        $dompdf->stream('laporan-produksi.pdf', array("Attachment" => 0));
    }

    public function exportExcel()
    {
        $productions = $this->getFilteredData();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Waktu Mulai');
        $sheet->setCellValue('B1', 'Operator');
        $sheet->setCellValue('C1', 'Varian Roti');
        $sheet->setCellValue('D1', 'Target');
        $sheet->setCellValue('E1', 'Terdeteksi');
        $sheet->setCellValue('F1', 'Aman');

        $row = 2;
        foreach ($productions as $prod) {
            $sheet->setCellValue('A' . $row, date('d-m-Y H:i', strtotime($prod['waktu_mulai'])));
            $sheet->setCellValue('B' . $row, $prod['nama_lengkap']);
            $sheet->setCellValue('C' . $row, $prod['nama_varian']);
            $sheet->setCellValue('D' . $row, $prod['jumlah_target']);
            $sheet->setCellValue('E' . $row, $prod['jumlah_terdeteksi']);
            $sheet->setCellValue('F' . $row, $prod['jumlah_target'] - $prod['jumlah_terdeteksi']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-produksi.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}