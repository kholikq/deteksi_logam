<?php namespace App\Models;

use CodeIgniter\Model;

class ProductionModel extends Model
{
    protected $table = 'produksi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_varian_roti', // [PERUBAHAN]
        'jumlah_target', 
        'jumlah_terdeteksi', 
        'id_pengguna_operator', 
        'waktu_mulai', 
        'waktu_selesai', 
        'status'
    ];
    protected $useTimestamps = false;
}
