<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';        // nama tabel kamu
    protected $primaryKey = 'code';    // kunci utama

    protected $allowedFields = [
        'code',
        'title',
        'author',
        'genre',
        'illustrator',
        'publisher',
        'series',
        'quantity',
        'notes',
        'shelfPosition',
        'synopsis',
        'isInClass',
        'year'
    ];

    // opsional: atur timestamp otomatis
    protected $useTimestamps = false;
}
