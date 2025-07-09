<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'pengguna'; // Disesuaikan
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_lengkap', 'username', 'password', 'peran']; // Disesuaikan
}