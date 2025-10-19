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
        $users = $this->db->getReference('users')->getValue() ?? [];
        $borrowings = $this->db->getReference('borrowings')->getValue() ?? [];

        // Get available books (assuming 'available' field exists and is truthy)
        $availableBooks = array_filter($books, fn($book) => !empty($book['available']));
        $totalAvailable = count($availableBooks);

        // Get genres from BookController
        $bookController = new BookController();
        $genres = $bookController->getGenres();

        // Prepare borrowings with user name and book title
        $borrowingRows = [];

        if ($borrowings) {
            foreach ($borrowings as $key => $borrowing) {
                // Only include if both user_id and book_id exist and are valid
                if (
                    isset($borrowing['user_id']) && 
                    isset($borrowing['book_id']) && 
                    isset($users[$borrowing['user_id']]) && 
                    isset($books[$borrowing['book_id']])
                ) {
                    $nama = $users[$borrowing['user_id']]['nama'] ?? '-';
                    $judul = $books[$borrowing['book_id']]['title'] ?? '-';
                    $tanggal = $borrowing['tanggal'] ?? '-';
                    
                    // Only add to table if book is actually borrowed
                    if (!empty($nama) && !empty($judul)) {
                        $borrowingRows[] = [
                            'nama' => $nama,
                            'judul' => $judul,
                            'tanggal' => $tanggal
                        ];
                    }
                }
            }
        }

        return view('peminjaman', [
            'totalAvailable' => $totalAvailable,
            'genres' => $genres,
            'availableBooks' => $availableBooks,
            'borrowings' => $borrowingRows
        ]);
    }

    public function addBorrowing()
    {
        $nisn = $this->request->getPost('nisnCari'); // NISN siswa
        $bukuTitle = $this->request->getPost('judulCari'); // Judul buku

        $books = $this->db->getReference('buku')->getValue() ?? [];
        $users = $this->db->getReference('users')->getValue() ?? [];

        // Cari user_id berdasarkan nisn
        $userId = null;
        foreach ($users as $key => $user) {
            if (isset($user['nisn']) && $user['nisn'] == $nisn) {
                $userId = $key;
                break;
            }
        }

        // Cari book_id berdasarkan title
        $bookId = null;
        $bookData = null;
        foreach ($books as $key => $book) {
            if (isset($book['title']) && $book['title'] === $bukuTitle) {
                $bookId = $key;
                $bookData = $book;
                break;
            }
        }

        if (!$userId) {
            return redirect()->back()->with('error', 'Siswa tidak ditemukan');
        }
        if (!$bookId || !$bookData) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan');
        }
        if (empty($bookData['quantity']) || $bookData['quantity'] < 1) {
            return redirect()->back()->with('error', 'Stok buku habis');
        }

        try {
            // Tambah data peminjaman
            $this->db->getReference('borrowings')->push([
                'user_id' => $userId,
                'book_id' => $bookId,
                'tanggal' => date('Y-m-d')
            ]);

            // Update quantity dan available
            $newQuantity = $bookData['quantity'] - 1;
            $updateData = [
                'quantity' => $newQuantity,
                'available' => $newQuantity > 0 ? true : false
            ];
            $this->db->getReference('buku/'.$bookId)->update($updateData);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Peminjaman added successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Peminjaman not added'
            ]);
        }
    }
    
    // /**
    //  * Simpan pengembalian buku
    //  */
    // public function addReturn()
    // {
    //     $bukuTitle = $this->request->getPost('buku');

    //     $books = $this->db->getReference('buku')->getValue() ?? [];

    //     // Cari book_id berdasarkan title
    //     $bookId = null;
    //     $borrower = '';
    //     foreach ($books as $key => $book) {
    //         if (isset($book['title']) && $book['title'] === $bukuTitle) {
    //             $bookId = $key;
    //             $borrower = $book['borrower'] ?? '';
    //             break;
    //         }
    //     }

    //     if (!$bookId) {
    //         return redirect()->back()->with('error', 'Buku tidak ditemukan');
    //     }

    //     // Tambah data pengembalian
    //     $this->db->getReference('returns')->push([
    //         'user_id' => $borrower,
    //         'book_id' => $bookId,
    //         'tanggal' => date('Y-m-d')
    //     ]);

    //     // Update buku jadi tersedia
    //     $this->db->getReference('buku/'.$bookId)->update(['available' => true, 'borrower' => '']);

    //     return redirect()->to('/peminjaman')->with('message', 'Buku berhasil dikembalikan');
    // }
}