<?php namespace App\Models;

use CodeIgniter\Model;

class DetectionModel extends Model
{
    protected $table = 'deteksi';
    protected $primaryKey = 'id';
    // [PERUBAHAN] Tambahkan 'varian_roti' ke field yang diizinkan
    protected $allowedFields = ['status', 'catatan', 'id_pengguna_operator', 'varian_roti'];
    protected $useTimestamps = true;
    protected $createdField  = 'waktu';
    protected $updatedField  = '';
}