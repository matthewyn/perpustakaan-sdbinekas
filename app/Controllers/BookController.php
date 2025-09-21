<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BookController extends Controller
{
    private $books = [
        ['title' => 'Harry Potter', 'author' => 'J.K Rowling', 'genre' => 'Fantasy', 'year' => 2023, 'image' => 'book-1.jpg'],
        ['title' => 'The Hobbit', 'author' => 'J.R.R Tolkien', 'genre' => 'Fantasy', 'year' => 2020, 'image' => 'book-2.jpg'],
        ['title' => 'Atomic Habits', 'author' => 'James Clear', 'genre' => 'Self Improvement', 'year' => 2018, 'image' => 'book-3.jpg'],
        ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'genre' => 'Classic', 'year' => 1960, 'image' => 'book-4.jpg'],
        ['title' => '1984', 'author' => 'George Orwell', 'genre' => 'Dystopian', 'year' => 1949, 'image' => 'book-5.jpg'],
        ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'genre' => 'Classic', 'year' => 1925, 'image' => 'book-6.jpg'],
        ['title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'genre' => 'History', 'year' => 2011, 'image' => 'book-7.jpg'],
        ['title' => 'The Alchemist', 'author' => 'Paulo Coelho', 'genre' => 'Adventure', 'year' => 1988, 'image' => 'book-8.jpg'],
        ['title' => 'Rich Dad Poor Dad', 'author' => 'Robert Kiyosaki', 'genre' => 'Finance', 'year' => 1997, 'image' => 'book-9.jpg'],
        ['title' => 'The Subtle Art of Not Giving a F*ck', 'author' => 'Mark Manson', 'genre' => 'Self Help', 'year' => 2016, 'image' => 'book-10.jpg'],
        ['title' => 'The Catcher in the Rye', 'author' => 'J.D. Salinger', 'genre' => 'Classic', 'year' => 1951, 'image' => 'book-11.jpg'],
        ['title' => 'The Lord of the Rings', 'author' => 'J.R.R Tolkien', 'genre' => 'Fantasy', 'year' => 1954, 'image' => 'book-12.jpg'],
        ['title' => 'Thinking, Fast and Slow', 'author' => 'Daniel Kahneman', 'genre' => 'Psychology', 'year' => 2011, 'image' => 'book-13.jpg'],
        ['title' => 'The Power of Habit', 'author' => 'Charles Duhigg', 'genre' => 'Self Improvement', 'year' => 2012, 'image' => 'book-14.jpg'],
        ['title' => 'Educated', 'author' => 'Tara Westover', 'genre' => 'Memoir', 'year' => 2018, 'image' => 'book-15.jpg'],
        ['title' => 'Becoming', 'author' => 'Michelle Obama', 'genre' => 'Memoir', 'year' => 2018, 'image' => 'book-16.jpg'],
        ['title' => 'The Lean Startup', 'author' => 'Eric Ries', 'genre' => 'Business', 'year' => 2011, 'image' => 'book-17.jpg'],
        ['title' => 'Zero to One', 'author' => 'Peter Thiel', 'genre' => 'Business', 'year' => 2014, 'image' => 'book-18.jpg'],
        ['title' => 'Deep Work', 'author' => 'Cal Newport', 'genre' => 'Productivity', 'year' => 2016, 'image' => 'book-19.jpg'],
        ['title' => 'Start With Why', 'author' => 'Simon Sinek', 'genre' => 'Business', 'year' => 2009, 'image' => 'book-20.jpg'],
        ['title' => 'The Psychology of Money', 'author' => 'Morgan Housel', 'genre' => 'Finance', 'year' => 2020, 'image' => 'book-21.jpg'],
        ['title' => 'Ikigai', 'author' => 'Héctor García', 'genre' => 'Self Help', 'year' => 2016, 'image' => 'book-22.jpg'],
        ['title' => 'Man\'s Search for Meaning', 'author' => 'Viktor Frankl', 'genre' => 'Psychology', 'year' => 1946, 'image' => 'book-23.jpg'],
        ['title' => 'The Four Agreements', 'author' => 'Don Miguel Ruiz', 'genre' => 'Self Help', 'year' => 1997, 'image' => 'book-24.jpg'],
        ['title' => 'Dune', 'author' => 'Frank Herbert', 'genre' => 'Science Fiction', 'year' => 1965, 'image' => 'book-25.jpg'],
        ['title' => 'The Silent Patient', 'author' => 'Alex Michaelides', 'genre' => 'Thriller', 'year' => 2019, 'image' => 'book-26.jpg'],
        ['title' => 'Project Hail Mary', 'author' => 'Andy Weir', 'genre' => 'Science Fiction', 'year' => 2021, 'image' => 'book-27.jpg'],
        ['title' => 'Normal People', 'author' => 'Sally Rooney', 'genre' => 'Fiction', 'year' => 2018, 'image' => 'book-28.jpg'],
        ['title' => 'The Midnight Library', 'author' => 'Matt Haig', 'genre' => 'Fiction', 'year' => 2020, 'image' => 'book-29.jpg'],
        ['title' => 'Where the Crawdads Sing', 'author' => 'Delia Owens', 'genre' => 'Mystery', 'year' => 2018, 'image' => 'book-30.jpg'],
    ];
    private $genres = null;
    private $perPage = 10;

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
