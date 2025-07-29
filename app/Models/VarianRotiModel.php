<?php namespace App\Models;

use CodeIgniter\Model;

class VarianRotiModel extends Model
{
    protected $table = 'varian_roti';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_varian'];
}
