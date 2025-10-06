<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Main -->
<div class="d-flex justify-content-center align-items-center mb-4">
  <img src="<?= base_url('/pattern.png') ?>" alt="Logo" width="100" class="d-inline-block align-text-top me-2">
  <h1>
    Katalog
  </h1>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-9">
        <div class="row mb-2">
          <nav aria-label="Page navigation example" class="col-4">
            <ul class="pagination mb-0">
              <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php
                // Pagination window logic
                $maxPagesToShow = 5;
                $startPage = max(1, $page - floor($maxPagesToShow / 2));
                $endPage = $startPage + $maxPagesToShow - 1;
                if ($endPage > $totalPages) {
                  $endPage = $totalPages;
                  $startPage = max(1, $endPage - $maxPagesToShow + 1);
                }
                for ($i = $startPage; $i <= $endPage; $i++):
              ?>
                <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                  <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                </li>
              <?php endfor; ?>
              <li class="page-item<?= $page >= $totalPages ? ' disabled' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $totalPages])) ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
          <div class="col">
            <form id="searchForm" class="d-flex" role="search">
              <input class="form-control me-2" type="search" name="search" placeholder="Ketik Kata Kunci" aria-label="Search" value="<?= esc($search) ?>"/>
              <?php foreach ($selectedGenres as $selected): ?>
                <input type="hidden" name="genres[]" value="<?= esc($selected) ?>">
              <?php endforeach; ?>
              <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
            </form>
          </div>
        </div>
        <div class="row justify-content-between mb-4">
          <div class="col-auto">
            <button type="button" id="tambah" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
              <i class="bi bi-plus"></i>
              Tambah Buku
            </button>
            <button type="button" id="ubah" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
              <i class="bi bi-pencil-square"></i>
              Ubah Buku
            </button>
          </div>
          <div class="col-4">
            <form method="get" id="selectpickerForm">
              <?php if ($search): ?>
                <input type="hidden" name="search" value="<?= esc($search) ?>">
              <?php endif; ?>
              <select id="genreSelectpicker" class="selectpicker form-control" name="genres[]" multiple data-live-search="true" data-actions-box="true">
                <?php foreach ($genres as $genre): ?>
                  <option value="<?= esc($genre) ?>" <?= in_array($genre, $selectedGenres) ? 'selected' : '' ?>>
                    <?= esc($genre) ?>
                  </option>
                <?php endforeach; ?>
            </select>
            </form>
          </div>
        </div>
        <?= $this->include('partials/book_list') ?>
      </div>
      <div class="col text-bg-danger">
        CC
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah buku</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Tambah -->
        <div id="tambahSection">
          <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" aria-describedby="judulHelp">
          </div>
          <div class="mb-3">
            <label for="pengarang" class="form-label">Pengarang</label>
            <input type="text" class="form-control" id="pengarang" aria-describedby="pengarangHelp">
          </div>
          <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" id="kategori" name="kategori" aria-label="Select category">
              <option selected disabled>Pilih kategori</option>
              <?php 
              $categories = [
                'Fiction' => [
                  'Adventure',
                  'Classic',
                  'Comic Book',
                  'Detective',
                  'Fantasy',
                  'Historical Fiction',
                  'Horror',
                  'Literary Fiction',
                  'Mystery',
                  'Romance',
                  'Science Fiction',
                  'Thriller'
                ],
                'Non-Fiction' => [
                  'Art',
                  'Biography',
                  'Business',
                  'Cookbook',
                  'Education',
                  'History',
                  'Philosophy',
                  'Politics',
                  'Psychology',
                  'Religion',
                  'Science',
                  'Self-Help',
                  'Technology'
                ]
              ];

              foreach ($categories as $mainCategory => $subCategories) {
                echo "<optgroup label=\"$mainCategory\">";
                foreach ($subCategories as $category) {
                  echo "<option value=\"$category\">$category</option>";
                }
                echo "</optgroup>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <select class="form-select" id="tahun" name="tahun" aria-label="Select year">
              <option selected disabled>Pilih tahun</option>
              <?php 
              $currentYear = date('Y');
              for ($year = $currentYear; $year >= 1900; $year--) {
                echo "<option value=\"$year\">$year</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="gambar" class="form-label">Sampul</label>
            <input class="form-control" type="file" id="gambar">
          </div>
        </div>
        <!-- Ubah -->
        <div id="ubahSection" style="display: none;">
          <div class="mb-3">
            <label for="judulCari" class="form-label">Cari Judul</label>
            <input class="form-control" list="datalistOptions" id="judulCari" placeholder="Ketik judul">
            <datalist id="datalistOptions">
              <?php foreach ($allBooks as $book): ?>
                <option value="<?= esc($book['title']) ?>" 
                  data-author="<?= esc($book['author']) ?>"
                  data-genre="<?= esc($book['genre']) ?>"
                  data-year="<?= esc($book['year']) ?>"
                  data-image="<?= esc($book['image']) ?>">
              <?php endforeach; ?>
            </datalist>
          </div>
          <div id="ubahFormFields" style="display: none;">
            <div class="mb-3">
              <label for="judulUbah" class="form-label">Judul</label>
              <input type="text" class="form-control" id="judulUbah" aria-describedby="judulHelp">
            </div>
            <div class="mb-3">
              <label for="pengarangUbah" class="form-label">Pengarang</label>
              <input type="text" class="form-control" id="pengarangUbah" aria-describedby="pengarangHelp">
            </div>
            <div class="mb-3">
              <label for="kategoriUbah" class="form-label">Kategori</label>
              <select class="form-select" id="kategoriUbah" name="kategoriUbah" aria-label="Select category">
                <option selected disabled>Pilih kategori</option>
                <?php 
                $categories = [
                  'Fiction' => [
                    'Adventure',
                    'Classic',
                    'Comic Book',
                    'Detective',
                    'Fantasy',
                    'Historical Fiction',
                    'Horror',
                    'Literary Fiction',
                    'Mystery',
                    'Romance',
                    'Science Fiction',
                    'Thriller'
                  ],
                  'Non-Fiction' => [
                    'Art',
                    'Biography',
                    'Business',
                    'Cookbook',
                    'Education',
                    'History',
                    'Philosophy',
                    'Politics',
                    'Psychology',
                    'Religion',
                    'Science',
                    'Self-Help',
                    'Technology'
                  ]
                ];

                foreach ($categories as $mainCategory => $subCategories) {
                  echo "<optgroup label=\"$mainCategory\">";
                  foreach ($subCategories as $category) {
                    echo "<option value=\"$category\">$category</option>";
                  }
                  echo "</optgroup>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="tahunUbah" class="form-label">Tahun</label>
              <select class="form-select" id="tahunUbah" name="tahunUbah" aria-label="Select year">
                <option selected disabled>Pilih tahun</option>
                <?php 
                $currentYear = date('Y');
                for ($year = $currentYear; $year >= 1900; $year--) {
                  echo "<option value=\"$year\">$year</option>";
                }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="gambarUbah" class="form-label">Sampul</label>
              <input class="form-control" type="file" id="gambarUbah">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary">Kirim</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById('exampleModal');
  const modalTitle = modal.querySelector('.modal-title');
  const tambahSection = document.getElementById('tambahSection');
  const ubahSection = document.getElementById('ubahSection');

  $('#genreSelectpicker').on('changed.bs.select', function (e) {
    loadBooks();
  });

  let searchTimeout;
  $('input[name="search"]').on('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      loadBooks();
    }, 500);
  });

  function loadBooks() {
    let formData = $('#selectpickerForm').serialize();
    let searchValue = $('input[name="search"]').val();
    if (searchValue) {
      formData += '&search=' + encodeURIComponent(searchValue);
    }

    $.ajax({
      url: "<?= base_url('books/filter') ?>",
      type: "GET",
      data: formData,
      success: function(response) {
        $('#booksContainer').html(response);
      },
      error: function(xhr, status, error) {
      }
    });
  }

  $('#selectpickerForm, #searchForm').on('submit', function(e) {
    e.preventDefault();
    loadBooks();
  });

  // Add form submission handler for the modal
  $('.modal-footer .btn-primary').on('click', function(e) {
    e.preventDefault();

    const isEditMode = ubahSection.style.display === 'block';
    
    if (isEditMode) {
      handleBookEdit();
    } else {
      handleBookAdd();
    }
  });

  function handleBookAdd() {
    // Create FormData object to handle file upload
    const formData = new FormData();
    formData.append('judul', $('#judul').val());
    formData.append('pengarang', $('#pengarang').val());
    formData.append('kategori', $('#kategori').val());
    formData.append('tahun', $('#tahun').val());
    formData.append('gambar', $('#gambar')[0].files[0]);

    // Validate form
    if (!formData.get('judul') || !formData.get('pengarang') || 
        !formData.get('kategori') || !formData.get('tahun') || 
        !formData.get('gambar')) {
      alert('Semua field harus diisi!');
      return;
    }

    $.ajax({
      url: "<?= base_url('books/add') ?>",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if (response.success) {
          // Close modal
          $('#exampleModal').modal('hide');
          
          // Clear form
          $('#judul').val('');
          $('#pengarang').val('');
          $('#kategori').val('');
          $('#tahun').val('');
          $('#gambar').val('');
          
          // Reload books
          loadBooks();
          
          alert('Buku berhasil ditambahkan!');
        } else {
          alert('Gagal menambahkan buku: ' + response.message);
        }
      },
      error: function(xhr, status, error) {
        alert('Terjadi kesalahan saat menambahkan buku');
      }
    });
  }

  function handleBookEdit() {
    // Get the original title (as the unique identifier)
    const originalTitle = $('#judulCari').val();

    // Get the new values from the form
    const newTitle = $('#judulUbah').val();
    const newAuthor = $('#pengarangUbah').val();
    const newGenre = $('#kategoriUbah').val();
    const newYear = $('#tahunUbah').val();
    const newImage = $('#gambarUbah')[0].files[0];

    if (!originalTitle || !newTitle || !newAuthor || !newGenre || !newYear) {
      alert('Semua field harus diisi!');
      return;
    }

    const formData = new FormData();
    formData.append('originalTitle', originalTitle);
    formData.append('title', newTitle);
    formData.append('author', newAuthor);
    formData.append('genre', newGenre);
    formData.append('year', newYear);
    if (newImage) {
      formData.append('image', newImage);
    }

    $.ajax({
      url: "<?= base_url('books/edit') ?>",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if (response.success) {
          $('#exampleModal').modal('hide');
          clearForm();
          loadBooks();
          alert('Buku berhasil diubah!');
        } else {
          alert('Gagal mengubah buku: ' + response.message);
        }
      },
      error: function(xhr, status, error) {
        alert('Terjadi kesalahan saat mengubah buku');
        console.error('Error:', error);
      }
    });
  }

  // Handle modal open for Tambah
  document.getElementById('tambah').addEventListener('click', function() {
    modalTitle.textContent = 'Tambah Buku';
    tambahSection.style.display = 'block';
    ubahSection.style.display = 'none';
    
    // Clear form fields
    clearForm();
  });

  // Handle modal open for Ubah
  document.getElementById('ubah').addEventListener('click', function() {
    modalTitle.textContent = 'Ubah Buku';
    tambahSection.style.display = 'none';
    ubahSection.style.display = 'block';

    // Always hide the ubah form fields when opening
    $('#ubahFormFields').hide();
    
    // Clear form fields
    clearForm();
  });

  // Function to clear form fields
  function clearForm() {
    const inputs = modal.querySelectorAll('input, select');
    inputs.forEach(input => {
      if (input.type === 'file') {
        input.value = '';
      } else if (input.type === 'select-one') {
        input.selectedIndex = 0;
      } else {
        input.value = '';
      }
    });
  }

  $('#judulCari').on('input', function() {
    const input = $(this);
    const datalist = $('#datalistOptions')[0];
    const options = datalist.options;
    const hiddenForm = $('#ubahFormFields'); // Always select by ID

    // Reset form values first
    hiddenForm.find('#judulUbah').val('');
    hiddenForm.find('#pengarangUbah').val('');
    hiddenForm.find('#kategoriUbah').prop('selectedIndex', 0);
    hiddenForm.find('#tahunUbah').prop('selectedIndex', 0);
    hiddenForm.find('#gambarUbah').val('');
    input.removeData('originalImage');
    hiddenForm.hide();

    let matchFound = false;

    for (let option of options) {
      if (option.value === input.val()) {
        matchFound = true;
        // Show the hidden form
        hiddenForm.show();

        // Fill the form with selected book data
        hiddenForm.find('#judulUbah').val(option.value);
        hiddenForm.find('#pengarangUbah').val(option.dataset.author);

        // Set kategori
        hiddenForm.find('#kategoriUbah').val(option.dataset.genre);

        // Set tahun
        hiddenForm.find('#tahunUbah').val(option.dataset.year);

        // Store the original image name
        input.data('originalImage', option.dataset.image);
        break;
      }
    }
  });
});
</script>

<?= $this->endSection() ?>
