<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BookController; // Add this
use App\Libraries\Firebase;

ini_set('max_execution_time', 1000);
ini_set('memory_limit', '512M');

class TransactionController extends Controller
{
    private $db;
    private $books = [];

    public function __construct()
    {
        $firebase = new Firebase();
        $this->db = $firebase->getDatabase();
    }

    public function peminjaman()
    {
        $books = $this->db->getReference('buku')->getValue() ?? [];

        // Get available books (assuming 'available' field exists and is truthy)
        $availableBooks = array_filter($books, fn($book) => !empty($book['available']));
        $totalAvailable = count($availableBooks);

        // Get genres from BookController
        $bookController = new BookController();
        $genres = $bookController->getGenres();

        return view('peminjaman', [
            'totalAvailable' => $totalAvailable,
            'genres' => $genres,
            'availableBooks' => $availableBooks
        ]);
    }
}