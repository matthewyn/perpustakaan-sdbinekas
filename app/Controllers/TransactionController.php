<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BookController; // Add this

class TransactionController extends Controller
{
    public function peminjaman()
    {
        $jsonPath = FCPATH . 'book_list.json';
        $totalAvailable = 0;
        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $books = json_decode($json, true) ?? [];
            $totalAvailable = count(array_filter($books, fn($book) => !empty($book['available'])));
        }

        $bookController = new BookController();
        $genres = $bookController->getGenres();

        // Get available books
        $availableBooks = array_filter($books, fn($book) => !empty($book['available']));

        return view('peminjaman', [
            'totalAvailable' => $totalAvailable,
            'genres' => $genres,
            'availableBooks' => $availableBooks // Pass available books to view
        ]);
    }
}