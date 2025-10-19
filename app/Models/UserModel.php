<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'users';        // nama tabel kamu
    protected $primaryKey = 'id';    // kunci utama

    protected $allowedFields = [
        'nama',
        'password',
        'role',
        'nisn',
        'kelas',
    ];

    // opsional: atur timestamp otomatis
    protected $useTimestamps = false;
}
