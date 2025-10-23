<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\Firebase;

ini_set('max_execution_time', 1000);
ini_set('memory_limit', '512M');

class BookManagementController extends Controller
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
        return view('management_buku', ['books' => $books]);
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

        $uidArray = $this->request->getPost('uid') ?? [];
        $uidArray = array_filter($uidArray, fn($u) => !empty(trim($u)));

        $data = [
            'uid' => $uidArray,
            'quantity'=> count($uidArray),
            'code' => $this->request->getPost('code'),
            'genre' => $this->request->getPost('genre'),
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'illustrator' => $this->request->getPost('illustrator'),
            'publisher' => $this->request->getPost('publisher'),
            'series' => $this->request->getPost('series'),
            'image' => $imageName,
            'notes' => $this->request->getPost('notes'),
            'shelfPosition' => $this->request->getPost('shelfPosition'),
            'synopsis' => $this->request->getPost('synopsis'),
            'isInClass' => $this->request->getPost('isInClass') ? true : false,
            'year' => $this->request->getPost('year'),
            'isOneDayBook' => $this->request->getPost('isOneDayBookAdd') ? true : false,
            'available' => true,
        ];

        $this->db->getReference('buku')->push($data);
        return redirect()->to('/management-buku')->with('message', 'Buku berhasil ditambahkan');
    }

    // Form edit
    public function editForm($key)
    {
        $book = $this->db->getReference('buku/'.$key)->getValue();
        if(!$book){
            return redirect()->to('/management-buku')->with('error', 'Buku tidak ditemukan');
        }
        return view('buku_edit', ['book' => $book, 'key' => $key]);
    }

    // Submit edit
    public function edit($key)
    {
        $book = $this->db->getReference('buku/'.$key)->getValue();
        if(!$book){
            return redirect()->to('/management-buku')->with('error', 'Buku tidak ditemukan');
        }

        $file = $this->request->getFile('imageUbah');
        $imageName = $book['image'] ?? '';
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $imageName);
        }

        $uidArray = $this->request->getPost('uidUbah') ?? $book['uid'] ?? [];
        $uidArray = array_filter($uidArray, fn($u) => !empty(trim($u))); 

        $updateData = [
            'uid' => $uidArray,
            'quantity' => count($uidArray),
            'code' => $this->request->getPost('codeUbah'),
            'title' => $this->request->getPost('titleUbah'),
            'author' => $this->request->getPost('authorUbah'),
            'publisher' => $this->request->getPost('publisherUbah'),
            'year' => $this->request->getPost('yearUbah'),
            'genre' => $this->request->getPost('genreUbah'),
            'illustrator' => $this->request->getPost('illustratorUbah'),
            'series' => $this->request->getPost('seriesUbah'),
            'notes' => $this->request->getPost('notesUbah'),
            'synopsis' => $this->request->getPost('synopsisUbah'),
            'isOneDayBook' => $this->request->getPost('isOneDayBookUbah') ? true : false,
            'available' => $this->request->getPost('availableUbah') ? true : false,
            'image' => $imageName
        ];

        $this->db->getReference('buku/'.$key)->update($updateData);
        return redirect()->to('/management-buku')->with('message', 'Buku berhasil diupdate');
    }

    // Hapus buku
    public function delete()
    {
        $code = $this->request->getGetPost('code');
        $books = $this->db->getReference('buku')->getValue() ?? [];

        foreach($books as $key => $book){
            if(isset($book['code']) && trim($book['code']) == $code){
                $this->db->getReference('buku/'.$key)->remove();
                return redirect()->to('/management-buku')->with('message', 'Buku berhasil dihapus');
            }
        }

        return redirect()->to('/management-buku')->with('error', 'Buku tidak ditemukan');
    }

    // Import JSON
    public function importJson()
    {
        $file = $this->request->getFile('json_file');
        if(!$file || !$file->isValid()){
            return redirect()->to('/management-buku')->with('error', 'File JSON tidak valid');
        }

        $jsonContent = file_get_contents($file->getTempName());
        $booksData = json_decode($jsonContent, true);
        if(!is_array($booksData)){
            return redirect()->to('/management-buku')->with('error', 'Format JSON tidak valid');
        }

        foreach($booksData as $book){
            $uidArray = $book['uid'] ?? [];
            $uidArray = is_array($uidArray) ? $uidArray : [$uidArray];

            $this->db->getReference('buku')->push([
                'uid' => $uidArray,
                'quantity' => count($uidArray),
                'code' => $book['code'] ?? '',
                'genre' => $book['genre'] ?? '',
                'title' => $book['title'] ?? '',
                'author' => $book['author'] ?? '',
                'illustrator' => $book['illustrator'] ?? '',
                'publisher' => $book['publisher'] ?? '',
                'series' => $book['series'] ?? '',
                'image' => $book['image'] ?? '',
                'notes' => $book['notes'] ?? '',
                'shelfPosition' => $book['shelfPosition'] ?? '',
                'synopsis' => $book['synopsis'] ?? '',
                'isInClass' => $book['isInClass'] ?? false,
                'year' => $book['year'] ?? '',
                'isOneDayBook' => $book['isOneDayBook'] ?? false,
                'available' => $book['available'] ?? true,
                'borrower' => $book['borrower'] ?? '',
            ]);
        }

        return redirect()->to('/management-buku')->with('message', 'Import JSON berhasil');
    }
}