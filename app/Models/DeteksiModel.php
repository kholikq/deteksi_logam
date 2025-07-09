<?php namespace App\Models;

use CodeIgniter\Model;

class DeteksiModel extends Model
{
    protected $table = 'deteksi';
    protected $allowedFields = ['status', 'sumber'];
    protected $useTimestamps = true;
}
