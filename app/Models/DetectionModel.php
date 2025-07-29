<?php namespace App\Models;

use CodeIgniter\Model;

class DetectionModel extends Model
{
    protected $table = 'deteksi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_produksi', 'waktu'];
    protected $useTimestamps = true;
    protected $createdField  = 'waktu';
    protected $updatedField  = '';
}