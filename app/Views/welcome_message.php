<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Main -->
<h1 class="mb-4">Katalog</h1>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-9">
        <div class="row mb-2">
          <nav aria-label="Page navigation example" class="col-4">
            <ul class="pagination mb-0">
              <li class="page-item<?= $page <= 1 ? ' disabled' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page-1])) ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                  <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                </li>
              <?php endfor; ?>
              <li class="page-item<?= $page >= $totalPages ? ' disabled' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page+1])) ?>" aria-label="Next">
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
              <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>
          </div>
        </div>
        <div class="row justify-content-between mb-2">
          <div class="col-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
              Tambah Buku
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
        <div class="mb-3">
          <label for="judul" class="form-label">Judul</label>
          <input type="text" class="form-control" id="judul" aria-describedby="judulHelp">
        </div>
        <div class="mb-3">
          <label for="pengarang" class="form-label">Pengarang</label>
          <input type="text" class="form-control" id="pengarang" aria-describedby="pengarangHelp">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary">Kirim</button>
      </div>
      <select class="form-select" multiple aria-label="Multiple select example">
        <option selected>Open this select menu</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
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
});
</script>

<?= $this->endSection() ?>
