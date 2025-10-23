<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<style>
  .ui-autocomplete {
    z-index: 2000 !important;
  }
</style>
<!-- Main -->
<div class="d-flex justify-content-center align-items-center my-4">
  <img src="<?= base_url('/pattern.png') ?>" alt="Logo" width="100" class="d-inline-block align-text-top me-2">
  <h1>
    Katalog
  </h1>
</div>

<div class="card relative" style="border-style: dashed;">
  <img src="<?= base_url('/children.png') ?>" alt="Children" class="position-absolute end-0" style="width: 170px; top: -120px"/>
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
          <?php if (session('role') === 'admin'): ?>
            <div class="col-auto">
                <button type="button" id="tambah" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  <i class="bi bi-plus"></i>
                  Tambah Buku
                </button>
                <button type="button" id="ubah" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" style="visibility: hidden;">
                <i class="bi bi-pencil-square"></i>
                Ubah Buku
              </button>
            </div>
          <?php endif; ?>
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
      <div class="col">
        <h2 class="fs-4">
          Koleksi Buku Terbaru
        </h2>
        <?php foreach ($latestBooks as $book): ?>
          <div class="card border-light mb-3 shadow-sm" style="width: 18rem;">
            <img src="https://placehold.co/600x400" class="card-img-top" alt="Gambar Buku">
            <div class="card-body">
              <h5 class="card-title"><?= esc($book['title'] ?? 'Tanpa Judul') ?></h5>
              <p class="card-text"><?= esc($book['synopsis'] ?? 'Tidak ada sinopsis.') ?></p>
              <a href="<?= base_url('books/detail?title=' . urlencode($book['title'])) ?>" class="btn btn-secondary btn-sm">Detail <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah buku</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Upload foto -->
        <!-- <div id="uploadSection" class="text-center">
          <div>
            <button type="button" id="openCameraBtn" class="btn btn-outline-primary mb-2">
              <i class="bi bi-camera"></i> Buka Kamera
            </button>
            <button type="button" id="captureBtn" class="btn btn-success mb-2" style="display:none;">
              <i class="bi bi-camera-fill"></i> Ambil Foto
            </button>
          </div>
          <video id="cameraPreview" width="300" height="220" autoplay playsinline class="mx-auto p-3 border-1 my-3" style="display:none; border-style: dashed; border-color: #ced4da;"></video>
          <canvas id="cameraCanvas" width="300" height="220" style="display:none;"></canvas>
          <p id="cameraHint">Arahkan kamera ke sampul buku untuk mengunggah gambar.</p>
        </div> -->
        <!-- Tambah -->
        <div id="tambahSection" style="display: none;">
          <div class="row mb-3">
            <div class="col">
              <label for="judul" class="form-label">Judul</label>
              <input type="text" class="form-control" id="judul" aria-describedby="judulHelp">
            </div>
            <div class="col">
              <label for="pengarang" class="form-label">Pengarang</label>
              <input type="text" class="form-control" id="pengarang" aria-describedby="pengarangHelp">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label for="illustrator" class="form-label">Illustrator</label>
              <input type="text" class="form-control" id="illustrator" aria-describedby="illustratorHelp">
            </div>
            <div class="col">
              <label for="publisher" class="form-label">Publisher</label>
              <input type="text" class="form-control" id="publisher" aria-describedby="publisherHelp">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label for="series" class="form-label">Series</label>
              <input type="text" class="form-control" id="series" aria-describedby="seriesHelp">
            </div>
            <div class="col">
              <label for="kategori" class="form-label">Kategori</label>
              <select class="form-select" id="kategori" name="kategori" aria-label="Select category">
                <option selected disabled>Pilih kategori</option>
                <?php
                  // Get unique categories from $genres (already prepared in controller)
                  foreach ($genres as $genre) {
                    echo "<option value=\"" . esc($genre) . "\">" . esc($genre) . "</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label for="gambar" class="form-label">Sampul</label>
              <input class="form-control" type="file" id="gambar">
            </div>
            <div class="col">
              <label for="quantity" class="form-label">Quantity</label>
              <input type="number" class="form-control" id="quantity" aria-describedby="quantityHelp">
            </div>
          </div>
          <div class="mb-3">
            <label for="notes" class="form-label">Catatan</label>
            <textarea class="form-control" id="notes" rows="3"></textarea>
          </div>
        </div>
        <!-- Ubah -->
        <div id="ubahSection" style="display: none;">
          <div class="mb-3">
            <label for="judulCari" class="form-label required">Cari Judul</label>
            <input type="text" class="form-control" id="judulCari" placeholder="Ketik judul">
          </div>
          <div id="ubahFormFields" style="display: none;">
            <div class="row mb-3">
              <div class="col">
                <label for="judulUbah" class="form-label required">Judul</label>
                <input type="text" class="form-control" id="judulUbah" aria-describedby="judulHelp">
              </div>
              <div class="col">
                <label for="pengarangUbah" class="form-label required">Pengarang</label>
                <input type="text" class="form-control" id="pengarangUbah" aria-describedby="pengarangHelp">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col">
                <label for="illustratorUbah" class="form-label required">Illustrator</label>
                <input type="text" class="form-control" id="illustratorUbah" aria-describedby="illustratorHelp">
              </div>
              <div class="col">
                <label for="publisherUbah" class="form-label required">Publisher</label>
                <input type="text" class="form-control" id="publisherUbah" aria-describedby="publisherHelp">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col">
                <label for="seriesUbah" class="form-label required">Series</label>
                <input type="text" class="form-control" id="seriesUbah" aria-describedby="seriesHelp">
              </div>
              <div class="col">
                <label for="kategoriUbah" class="form-label">Kategori</label>
                <select class="form-select" id="kategoriUbah" name="kategoriUbah" aria-label="Select category">
                  <option selected disabled>Pilih kategori</option>
                  <?php
                    foreach ($genres as $genre) {
                      echo "<option value=\"" . esc($genre) . "\">" . esc($genre) . "</option>";
                    }
                  ?>
                  ?>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col">
                <label for="gambarUbah" class="form-label">Sampul</label>
                <input class="form-control" type="file" id="gambarUbah">
              </div>
              <div class="col">
                <label for="quantityUbah" class="form-label required">Quantity</label>
                <input type="number" class="form-control" id="quantityUbah" aria-describedby="quantityHelp">
              </div>
            </div>
            <div class="mb-3">
              <label for="notesUbah" class="form-label">Catatan</label>
              <textarea class="form-control" id="notesUbah" rows="3"></textarea>
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
  const bookTitles = <?= json_encode($bookTitles) ?>;
  const books = <?= json_encode($allBooks) ?>;
  window.books = books;
  // let cameraStream;
  // const openCameraBtn = document.getElementById('openCameraBtn');
  // const captureBtn = document.getElementById('captureBtn');
  // const video = document.getElementById('cameraPreview');
  // const canvas = document.getElementById('cameraCanvas');
  // const hint = document.getElementById('cameraHint');

  // Autocomplete for title only
  $('#judulCari').autocomplete({
    source: function(request, response) {
      // Filter titles based on the user's input
      const results = window.books
        .map(b => b.title)
        .filter(title => title.toLowerCase().includes(request.term.toLowerCase()));
      response(results);
    },
    minLength: 1,
    select: function(event, ui) {
      $(this).val(ui.item.value);
      fillEditForm(ui.item.value);
      return false;
    }
  });

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

  function loadBooksAndDatalist() {
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

        // Fetch all books for datalist and update global books array
        $.ajax({
          url: "<?= base_url('books/all') ?>",
          type: "GET",
          dataType: "json",
          success: function(data) {
            updateDatalistOptions(data.books);
            // Update global books array
            window.books = data.books;
          }
        });
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
    const newIllustrator = $('#illustratorUbah').val();
    const newPublisher = $('#publisherUbah').val();
    const newSeries = $('#seriesUbah').val();
    const newGenre = $('#kategoriUbah').val();
    const newImage = $('#gambarUbah')[0].files[0];
    const newQuantity = $('#quantityUbah').val();
    const newNotes = $('#notesUbah').val();

    if (!originalTitle || !newTitle || !newAuthor || !newIllustrator || !newPublisher || !newSeries || !newQuantity) {
      alert('Semua field harus diisi!');
      return;
    }

    const formData = new FormData();
    formData.append('originalTitle', originalTitle);
    formData.append('title', newTitle);
    formData.append('author', newAuthor);
    formData.append('illustrator', newIllustrator);
    formData.append('publisher', newPublisher);
    formData.append('series', newSeries);
    formData.append('genre', newGenre);
    formData.append('quantity', newQuantity);
    formData.append('notes', newNotes);
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
          // Fetch all books and update window.books
          $.ajax({
            url: "<?= base_url('books/all') ?>",
            type: "GET",
            dataType: "json",
            success: function(data) {
              window.books = data.books;
              loadBooks(); // Optionally reload the book list display
              showToast('Berhasil mengubah buku dengan judul: ' + newTitle);
            }
          });
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
    // document.getElementById('uploadSection').style.display = 'block';

    // Clear form fields
    clearForm();
  });

  // openCameraBtn.addEventListener('click', async () => {
  //   try {
  //     cameraStream = await navigator.mediaDevices.getUserMedia({ video: true });
  //     video.srcObject = cameraStream;

  //     // Show the video preview and capture button
  //     video.style.display = 'block';
  //     captureBtn.style.display = 'inline-block';
  //     openCameraBtn.style.display = 'none';
  //     hint.textContent = 'Klik "Ambil Foto" untuk menangkap gambar.';
  //   } catch (err) {
  //     alert('Tidak dapat mengakses kamera: ' + err.message);
  //   }
  // });

  // captureBtn.addEventListener('click', () => {
  //   const ctx = canvas.getContext('2d');
  //   ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

  //   canvas.toBlob(blob => {
  //     const file = new File([blob], "capture.png", { type: "image/png" });
  //     const formData = new FormData();
  //     formData.append('gambar', file);

  //     // Upload image to server
  //     $.ajax({
  //       url: "<?= base_url('books/upload-image') ?>", // Create this endpoint
  //       type: "POST",
  //       data: formData,
  //       processData: false,
  //       contentType: false,
  //       success: function(response) {
  //         if (response.success && response.imageUrl) {
  //           // Call analyze-image API with the uploaded image URL
  //           $.get("<?= base_url('api/analyze-image') ?>", { image_url: response.imageUrl }, function(data) {
  //             // Do something with the returned book JSON
  //             console.log(data);
  //             // You can autofill the form fields here if needed
  //           });
  //         } else {
  //           alert('Gagal upload gambar');
  //         }
  //       },
  //       error: function() {
  //         alert('Gagal upload gambar');
  //       }
  //     });
  //   });

  //   // Stop camera
  //   cameraStream.getTracks().forEach(track => track.stop());
  //   video.style.display = 'none';
  //   captureBtn.style.display = 'none';
  //   openCameraBtn.style.display = 'inline-block';
  //   hint.textContent = 'Foto berhasil diambil.';
  // });

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

  // $('#judulCari').on('input', function() {
  //   const input = $(this);
  //   const datalist = $('#datalistOptions')[0];
  //   const options = datalist.options;
  //   const hiddenForm = $('#ubahFormFields'); // Always select by ID

  //   // Reset form values first
  //   hiddenForm.find('#judulUbah').val('');
  //   hiddenForm.find('#pengarangUbah').val('');
  //   hiddenForm.find('#kategoriUbah').prop('selectedIndex', 0);
  //   hiddenForm.find('#tahunUbah').prop('selectedIndex', 0);
  //   hiddenForm.find('#gambarUbah').val('');
  //   hiddenForm.find('#illustratorUbah').val(''); // Reset illustrator field
  //   hiddenForm.find('#publisherUbah').val(''); // Reset publisher field
  //   hiddenForm.find('#seriesUbah').val(''); // Reset series field
  //   hiddenForm.find('#quantityUbah').val(''); // Reset quantity field
  //   hiddenForm.find('#notesUbah').val(''); // Reset notes field
  //   input.removeData('originalImage');
  //   hiddenForm.hide();

  //   let matchFound = false;

  //   for (let option of options) {
  //     if (option.value === input.val()) {
  //       matchFound = true;
  //       // Show the hidden form
  //       hiddenForm.show();

  //       // Fill the form with selected book data
  //       hiddenForm.find('#judulUbah').val(option.value);
  //       hiddenForm.find('#pengarangUbah').val(option.dataset.author);
  //       hiddenForm.find('#kategoriUbah').val(option.dataset.genre);
  //       hiddenForm.find('#tahunUbah').val(option.dataset.year);
  //       hiddenForm.find('#illustratorUbah').val(option.dataset.illustrator); // Fill illustrator field
  //       hiddenForm.find('#publisherUbah').val(option.dataset.publisher); // Fill publisher field
  //       hiddenForm.find('#seriesUbah').val(option.dataset.series); // Fill series field
  //       hiddenForm.find('#quantityUbah').val(option.dataset.quantity); // Fill quantity field
  //       hiddenForm.find('#notesUbah').val(option.dataset.notes); // Fill notes field
  //       input.data('originalImage', option.dataset.image);
  //       break;
  //     }
  //   }
  // });

  // Fill edit form when input changes or autocomplete selects
  $('#judulCari').on('input', function() {
    fillEditForm($(this).val());
  });

  function fillEditForm(selectedTitle) {
    const book = window.books.find(b => b.title === selectedTitle);
    const hiddenForm = $('#ubahFormFields');
    if (book) {
      hiddenForm.show();
      hiddenForm.find('#judulUbah').val(book.title);
      hiddenForm.find('#pengarangUbah').val(book.author || '');
      hiddenForm.find('#kategoriUbah').val(book.genre || '');
      hiddenForm.find('#tahunUbah').val(book.year || '');
      hiddenForm.find('#illustratorUbah').val(book.illustrator || '');
      hiddenForm.find('#publisherUbah').val(book.publisher || '');
      hiddenForm.find('#seriesUbah').val(book.series || '');
      hiddenForm.find('#quantityUbah').val(book.quantity || '');
      hiddenForm.find('#notesUbah').val(book.notes || '');
      $('#judulCari').data('originalImage', book.image || '');
    } else {
      hiddenForm.hide();
    }
  }
});
</script>

<?= $this->endSection() ?>
