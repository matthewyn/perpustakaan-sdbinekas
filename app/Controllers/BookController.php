<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\Firebase;

ini_set('max_execution_time', 1000);
ini_set('memory_limit', '512M');

class BookController extends Controller
{
    private $db;

    private $books = [];
    private $genres = null;
    private $perPage = 10;

    public function __construct()
    {
        $firebase = new Firebase();
        $this->db = $firebase->getDatabase();
    }

    public function getGenres(): array
    {
        $books = $this->db->getReference('buku')->getValue() ?? [];
        $genres = [];
        foreach ($books as $book) {
            if (isset($book['genre'])) {
                $genres[] = $book['genre'];
            }
        }
        $genres = array_unique($genres);
        sort($genres);
        return $genres;
    }

    private function filterBooks(array $books, string $search = '', array $selectedGenres = []): array
    {
        if ($search !== '') {
            $searchLower = strtolower($search);
            $books = array_filter($books, function($book) use ($searchLower) {
                return str_contains(strtolower($book['title'] ?? ''), $searchLower)
                    || str_contains(strtolower($book['author'] ?? ''), $searchLower)
                    || str_contains(strtolower($book['genre'] ?? ''), $searchLower)
                    || str_contains((string)($book['year'] ?? ''), $searchLower);
            });
        }

        if (!empty($selectedGenres)) {
            $books = array_filter($books, fn($book) => in_array($book['genre'] ?? '', $selectedGenres));
        }

        return $books;
    }

    private function paginateBooks(array $books, int $page): array
    {
        $books = array_values($books); // Ensure numeric keys
        $totalBooks = count($books);
        $totalPages = max(1, ceil($totalBooks / $this->perPage));
        $page = max(1, min($page, $totalPages));
        $start = ($page - 1) * $this->perPage;

        return [
            'books' => array_slice($books, $start, $this->perPage),
            'totalPages' => $totalPages,
            'page' => $page
        ];
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $selectedGenres = $this->request->getGet('genres') ?? [];
        $page = (int)($this->request->getGet('page') ?? 1);

        $books = $this->db->getReference('buku')->getValue() ?? [];
        $books = array_values($books); // Ensure numeric keys

        $filteredBooks = $this->filterBooks($books, $search, $selectedGenres);
        $pagination = $this->paginateBooks($filteredBooks, $page);

        // Get 3 latest books (assuming books are sorted by created time or just take last 3)
        $latestBooks = array_slice(array_reverse($books), 0, 3);
        $bookTitles = array_map(fn($b) => $b['title'], $books);

        return view('welcome_message', [
            'booksOnPage' => $pagination['books'],
            'genres' => $this->getGenres(),
            'selectedGenres' => $selectedGenres,
            'search' => $search,
            'page' => $pagination['page'],
            'totalPages' => $pagination['totalPages'],
            'books' => $filteredBooks,
            'allBooks' => $books,
            'latestBooks' => $latestBooks,
            'bookTitles' => $bookTitles,
        ]);
    }

    public function filter()
    {
        $search = $this->request->getGet('search') ?? '';
        $selectedGenres = $this->request->getGet('genres') ?? [];
        $page = (int)($this->request->getGet('page') ?? 1);

        // Fetch books from Firebase
        $books = $this->db->getReference('buku')->getValue() ?? [];
        $books = array_values($books);

        $filteredBooks = $this->filterBooks($books, $search, $selectedGenres);
        $pagination = $this->paginateBooks($filteredBooks, $page);

        return view('partials/book_list', [
            'booksOnPage' => $pagination['books'],
        ]);
    }

    public function add()
    {
        // Validate file upload
        $validationRule = [
            'gambar' => [
                'label' => 'Image File',
                'rules' => 'uploaded[gambar]'
                    . '|is_image[gambar]'
                    . '|mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[gambar,2048]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid file upload'
            ]);
        }

        $file = $this->request->getFile('gambar');
        if (!$file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid file'
            ]);
        }

        // Generate new filename
        $fileName = $file->getRandomName();

        // Move file to uploads directory
        $file->move(FCPATH . 'uploads', $fileName);

        // Get other form data
        $data = [
            'judul' => $this->request->getPost('judul'),
            'pengarang' => $this->request->getPost('pengarang'),
            'kategori' => $this->request->getPost('kategori'),
            'tahun' => $this->request->getPost('tahun'),
            'gambar' => $fileName
        ];

        // Add to your books model/database
        // $this->booksModel->insert($data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Book added successfully'
        ]);
    }

    public function edit()
    {
        $originalTitle = $this->request->getPost('originalTitle');
        $title = $this->request->getPost('title');
        $author = $this->request->getPost('author');
        $illustrator = $this->request->getPost('illustrator');
        $publisher = $this->request->getPost('publisher');
        $series = $this->request->getPost('series');
        $genre = $this->request->getPost('genre');
        $image = $this->request->getFile('image');
        $quantity = $this->request->getPost('quantity');
        $notes = $this->request->getPost('notes');

        $booksRef = $this->db->getReference('buku')->getValue() ?? [];
        $updated = false;

        foreach ($booksRef as $key => $book) {
            if (isset($book['title']) && $book['title'] === $originalTitle) {
                $imageName = $book['image'] ?? '';
                if ($image && $image->isValid() && !$image->hasMoved()) {
                    $imageName = $image->getRandomName();
                    $image->move(FCPATH . 'uploads', $imageName);
                }

                $updateData = [
                    'title' => $title,
                    'author' => $author,
                    'illustrator' => $illustrator,
                    'publisher' => $publisher,
                    'series' => $series,
                    'genre' => $genre,
                    'quantity' => $quantity,
                    'notes' => $notes,
                    'image' => $imageName
                ];

                $this->db->getReference('buku/' . $key)->update($updateData);
                $updated = true;
                break;
            }
        }

        if ($updated) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Book updated successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Book not found'
            ]);
        }
    }

    public function detail()
    {
        $title = $this->request->getGet('title'); // Use title as identifier

        // Fetch books from Firebase
        $books = $this->db->getReference('buku')->getValue() ?? [];
        $book = null;

        foreach ($books as $b) {
            if (isset($b['title']) && $b['title'] === $title) {
                $book = $b;
                break;
            }
        }

        if (!$book) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Book not found");
        }

        return view('detail_buku', [
            'book' => $book
        ]);
    }

    public function uploadImage()
    {
        $file = $this->request->getFile('gambar');
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['success' => false]);
        }
        $fileName = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $fileName);
        $imageUrl = base_url('uploads/' . $fileName);
        return $this->response->setJSON(['success' => true, 'imageUrl' => $imageUrl]);
    }

    public function all()
    {
        $books = $this->db->getReference('buku')->getValue() ?? [];
        $books = array_values($books);
        return $this->response->setJSON(['books' => $books]);
    }
}
