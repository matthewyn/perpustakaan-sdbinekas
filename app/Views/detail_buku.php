<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Main -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb mt-3">
    <li class="breadcrumb-item">
      <a href="<?= base_url() ?>">Katalog</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
  </ol>
</nav>

<h1 class="mb-4">Detail Buku</h1>

<div class="card" style="border-style: dashed;">
  <div class="card-body">
    <div class="row">
      <div class="col-auto">
        <img src="<?= base_url($book['image']) ?>" class="img-fluid" alt="Gambar Buku">
      </div>
      <div class="col">
        <div class="d-flex align-items-center gap-2">
          <h2 class="fs-3">Informasi Buku</h2>
          <?php if (empty($book['available'])): ?>
            <span class="badge rounded-pill text-bg-success">Available</span>
          <?php else: ?>
            <span class="badge rounded-pill text-bg-danger">Not Available</span>
          <?php endif; ?>
        </div>
        <h3 class="fs-5 mb-1">Judul</h3>
        <p class="mb-2"><?= esc($book['title']) ?></p>
        <h3 class="fs-5 mb-1">Kategori</h3>
        <p class="mb-2"><?= esc($book['genre']) ?></p>
        <h3 class="fs-5 mb-1">Pengarang</h3>
        <p class="mb-2"><?= esc($book['author']) ?></p>
        <h3 class="fs-5 mb-1">Series</h3>
        <p class="mb-2"><?= esc($book['series']) ?></p>
        <h3 class="fs-5 mb-1">Tahun</h3>
        <p class="mb-2"><?= esc($book['year']) ?></p>
        <?php if (empty($book['isInClass'])): ?>
          <h3 class="fs-5 mb-1">Posisi Rak</h3>
          <p class="mb-2"><?= esc($book['shelfPosition']) ?></p>
        <?php endif; ?>
      </div>
      <div class="col">
        <h2 class="fs-3">Sinopsis</h2>
        <p><?= esc($book['synopsis']) ?></p>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
});
</script>

<?= $this->endSection() ?>