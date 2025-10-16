<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\Firebase;

ini_set('max_execution_time', 1000);
ini_set('memory_limit', '512M');

class Buku extends Controller
{
    private $db;

    public function __construct()
    {
        $firebase = new Firebase();
        $this->db = $firebase->getDatabase();
    }

    // List semua buku
    public function index()
    {
        $books = $this->db->getReference('buku')->getValue() ?? [];
        return view('buku_view', ['books' => $books]);
    }

    // Tambah buku
    public function add()
    {
        $file = $this->request->getFile('image');
        $imageName = '';
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $imageName);
        }

        $data = [
            'code' => $this->request->getPost('code'),
            'genre' => $this->request->getPost('genre'),
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'illustrator' => $this->request->getPost('illustrator'),
            'publisher' => $this->request->getPost('publisher'),
            'series' => $this->request->getPost('series'),
            'image' => $imageName,
            'quantity' => $this->request->getPost('quantity') ?? 1,
            'notes' => $this->request->getPost('notes'),
            'shelfPosition' => $this->request->getPost('shelfPosition'),
            'synopsis' => $this->request->getPost('synopsis'),
            'isInClass' => $this->request->getPost('isInClass') ?? false,
            'year' => $this->request->getPost('year')
        ];

        $this->db->getReference('buku')->push($data);
        return redirect()->to('/buku');
    }

    // Edit buku
    public function edit($code)
    {
        $booksRef = $this->db->getReference('buku')->getValue() ?? [];

        foreach ($booksRef as $key => $book) {
            if (isset($book['code']) && $book['code'] == $code) {
                $file = $this->request->getFile('image');
                $imageName = $book['image'] ?? '';
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    $imageName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads', $imageName);
                }

                $updateData = [
                    'code' => $this->request->getPost('code'),
                    'genre' => $this->request->getPost('genre'),
                    'title' => $this->request->getPost('title'),
                    'author' => $this->request->getPost('author'),
                    'illustrator' => $this->request->getPost('illustrator'),
                    'publisher' => $this->request->getPost('publisher'),
                    'series' => $this->request->getPost('series'),
                    'image' => $imageName,
                    'quantity' => $this->request->getPost('quantity') ?? 1,
                    'notes' => $this->request->getPost('notes'),
                    'shelfPosition' => $this->request->getPost('shelfPosition'),
                    'synopsis' => $this->request->getPost('synopsis'),
                    'isInClass' => $this->request->getPost('isInClass') ?? false,
                    'year' => $this->request->getPost('year')
                ];

                $this->db->getReference('buku/' . $key)->update($updateData);
                return redirect()->to('/buku');
            }
        }

        return redirect()->to('/buku')->with('error', 'Buku tidak ditemukan');
    }

    // Hapus buku
    public function delete()
    {
        $code = $this->request->getGetPost('code'); // bisa dari GET/POST
        $booksRef = $this->db->getReference('buku')->getValue() ?? [];

        foreach ($booksRef as $key => $book) {
            if (isset($book['code']) && trim($book['code']) == $code) {
                $this->db->getReference('buku/' . $key)->remove();
                session()->setFlashdata('message', 'Buku berhasil dihapus');
                return redirect()->to('/buku');
            }
        }

        session()->setFlashdata('error', 'Buku tidak ditemukan');
        return redirect()->to('/buku');
    }




    // Import JSON
    public function importJson()
    {
        $file = $this->request->getFile('json_file');
        if (!$file || !$file->isValid()) {
            return redirect()->to('/buku')->with('error', 'File JSON tidak valid');
        }

        $jsonContent = file_get_contents($file->getTempName());
        $booksData = json_decode($jsonContent, true);

        if (!is_array($booksData)) {
            return redirect()->to('/buku')->with('error', 'Format JSON tidak valid');
        }

        foreach ($booksData as $book) {
            $this->db->getReference('buku')->push([
                'code' => $book['code'] ?? '',
                'genre' => $book['genre'] ?? '',
                'title' => $book['title'] ?? '',
                'author' => $book['author'] ?? '',
                'illustrator' => $book['illustrator'] ?? '',
                'publisher' => $book['publisher'] ?? '',
                'series' => $book['series'] ?? '',
                'image' => $book['image'] ?? '',
                'quantity' => $book['quantity'] ?? 1,
                'notes' => $book['notes'] ?? '',
                'shelfPosition' => $book['shelfPosition'] ?? '',
                'synopsis' => $book['synopsis'] ?? '',
                'isInClass' => $book['isInClass'] ?? false,
                'year' => $book['year'] ?? ''
            ]);
        }

        return redirect()->to('/buku')->with('success', 'Import JSON berhasil');
    }
}