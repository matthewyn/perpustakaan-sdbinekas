<div id="booksContainer">
  <row>
    <?php if (empty($booksOnPage)): ?>
      <div class="col">
        <div class="alert alert-warning">Buku tidak ditemukan.</div>
      </div>
    <?php else: ?>
      <div class="row">
        <?php foreach ($booksOnPage as $book): ?>
        <div class="col-6 mb-4">
          <div class="row">
            <div class="col-4">
              <div class="card">
                <div class="card-body p-1">
                  <img src="<?= base_url($book['image']) ?>" class="img-fluid" alt="Gambar Buku">
                </div>
              </div>
            </div>
            <div class="col">
              <h2 class="fs-5 text-uppercase text-primary mt-2"><?= esc($book['title']) ?></h2>
              <p class="mb-0"><?= esc($book['author']) ?></p>
              <p class="mb-0"><?= esc($book['genre']) ?></p>
              <p><?= esc($book['year']) ?></p>
              <div class="d-grid gap-1 d-md-flex justify-content-md-start">
                <a href="<?= base_url('books/detail?title=' . urlencode($book['title'])) ?>" class="btn btn-primary">Detail</a>
                <a href="#" class="btn btn-success">Pinjam</a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </row>
</div>