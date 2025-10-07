<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BookController extends Controller
{
    private $books = [];
    private $genres = null;
    private $perPage = 10;

    public function __construct()
    {
        $jsonPath = FCPATH . 'book_list.json';
        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $rawBooks = json_decode($json, true) ?? [];
            // Map JSON fields to expected fields
            $this->books = array_map(function($book) {
                // Extract year from code using regex
                preg_match('/(\d{4})$/', $book['code'], $matches);
                $year = $matches[1] ?? '';
                
                return [
                    'code'  => $book['code'] ?? '',
                    'genre'  => $book['category'] ?? '',
                    'title'  => $book['title'] ?? '',
                    'author' => $book['author'] ?? '',
                    'illustrator' => $book['illustrator'] ?? '',
                    'publisher' => $book['publisher'] ?? '',
                    'series' => $book['series'] ?? '',
                    'image'  => $book['image'] ?? '',
                    'quantity'  => $book['quantity'] ?? '',
                    'notes'  => $book['notes'] ?? '',
                    'shelfPosition'  => $book['shelfPosition'] ?? '',
                    'synopsis'  => $book['synopsis'] ?? '',
                    'isInClass'  => $book['isInClass'] ?? '',
                    'year'   => $year,
                    // add other fields if needed
                ];
            }, $rawBooks);
        }
    }

    private function getGenres(): array
    {
        if ($this->genres === null) {
            $this->genres = array_unique(array_map(fn($book) => $book['genre'], $this->books));
            sort($this->genres);
        }
        return $this->genres;
    }

    private function filterBooks(array $books, string $search = '', array $selectedGenres = []): array
    {
        if ($search !== '') {
            $searchLower = strtolower($search);
            $books = array_filter($books, function($book) use ($searchLower) {
                return str_contains(strtolower($book['title']), $searchLower)
                    || str_contains(strtolower($book['author']), $searchLower)
                    || str_contains(strtolower($book['genre']), $searchLower)
                    || str_contains((string)$book['year'], $searchLower);
            });
        }

        if (!empty($selectedGenres)) {
            $books = array_filter($books, fn($book) => in_array($book['genre'], $selectedGenres));
        }

        return $books;
    }

    private function paginateBooks(array $books, int $page): array
    {
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

        $filteredBooks = $this->filterBooks($this->books, $search, $selectedGenres);
        $pagination = $this->paginateBooks($filteredBooks, $page);

        return view('welcome_message', [
            'booksOnPage' => $pagination['books'],
            'genres' => $this->getGenres(),
            'selectedGenres' => $selectedGenres,
            'search' => $search,
            'page' => $pagination['page'],
            'totalPages' => $pagination['totalPages'],
            'books' => $filteredBooks,
            'allBooks' => $this->books,
        ]);
    }

    public function filter()
    {
        $search = $this->request->getGet('search') ?? '';
        $selectedGenres = $this->request->getGet('genres') ?? [];
        $page = (int)($this->request->getGet('page') ?? 1);

        $filteredBooks = $this->filterBooks($this->books, $search, $selectedGenres);
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
        $genre = $this->request->getPost('genre');
        $year = $this->request->getPost('year');
        $image = $this->request->getFile('image');

        // Find the book by original title
        foreach ($this->books as &$book) {
            if ($book['title'] === $originalTitle) {
                $book['title'] = $title;
                $book['author'] = $author;
                $book['genre'] = $genre;
                $book['year'] = $year;

                // Handle image upload if a new image is provided
                if ($image && $image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $image->move(FCPATH . 'uploads', $newName);
                    $book['image'] = $newName;
                }

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Book updated successfully'
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Book not found'
        ]);
    }

    public function detail()
    {
        $title = $this->request->getGet('title');
        // If you use id: $id = $this->request->getGet('id');

        // Find the book by title
        $book = null;
        foreach ($this->books as $b) {
            if ($b['title'] === $title) {
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
}
