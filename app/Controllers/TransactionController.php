<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TransactionController extends Controller
{
    public function peminjaman()
    {
        $jsonPath = FCPATH . 'book_list.json';
        $totalAvailable = 0;
        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $books = json_decode($json, true) ?? [];
            // Count books where 'available' is true
            $totalAvailable = count(array_filter($books, fn($book) => !empty($book['available'])));
        }
        return view('peminjaman', [
            'totalAvailable' => $totalAvailable
        ]);
    }

    public function pengembalian()
    {
        return view('pengembalian');
    }
}