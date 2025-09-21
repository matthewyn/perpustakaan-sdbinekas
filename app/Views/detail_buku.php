<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Main -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="<?= base_url() ?>">Katalog</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Detail</li>
  </ol>
</nav>

<h1 class="mb-4">Detail Buku</h1>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-auto">
        <img src="<?= base_url($book['image']) ?>" class="img-fluid" alt="Gambar Buku">
      </div>
      <div class="col">
        <h2 class="fs-3">Informasi Buku</h2>
        <h3 class="fs-5 mb-1">Judul</h3>
        <p class="mb-2"><?= esc($book['title']) ?></p>
        <h3 class="fs-5 mb-1">Kategori</h3>
        <p class="mb-2"><?= esc($book['genre']) ?></p>
        <h3 class="fs-5 mb-1">Pengarang</h3>
        <p class="mb-2"><?= esc($book['author']) ?></p>
        <h3 class="fs-5 mb-1">Tahun</h3>
        <p class="mb-2"><?= esc($book['year']) ?></p>
      </div>
      <div class="col">
        <h2 class="fs-3">Abstraksi</h2>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repudiandae fugiat voluptatibus amet saepe eveniet officiis harum unde magni ipsa temporibus eum cum, non ad ducimus quis quidem praesentium blanditiis incidunt. Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum laudantium harum eligendi quisquam alias esse officiis ducimus tempora id saepe vitae molestiae, pariatur quibusdam sunt molestias nisi sit nihil nemo. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam cumque molestias, cum, incidunt fuga laboriosam ex porro dignissimos repellat totam illo consequatur reprehenderit labore ad, quos perspiciatis autem eos! Mollitia? Lorem, ipsum dolor sit amet consectetur adipisicing elit. Non dolore fuga sunt aut hic, saepe illum consectetur adipisci dolorem reiciendis rerum beatae. Ea odio atque quo harum exercitationem, ipsa temporibus!</p>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
});
</script>

<?= $this->endSection() ?>