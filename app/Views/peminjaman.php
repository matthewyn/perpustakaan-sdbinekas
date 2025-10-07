<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row g-3">
        <div class="col">
            <div class="card border-light">
                <div class="card-header">
                    Buku yang Dipinjam
                </div>
                <div class="card-body">
                    <h2>561</h2>
                    <div class="d-flex align-items-center">
                        <span>Buku baru yang dipinjam</span>
                        <span class="ms-auto text-success">+5% <i class="bi bi-caret-up-fill"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-light">
                <div class="card-header">
                    Buku yang Dikembalikan
                </div>
                <div class="card-body">
                    <h2>452</h2>
                    <div class="d-flex align-items-center">
                        <span>Buku baru yang dikembalikan</span>
                        <span class="ms-auto text-success">+15% <i class="bi bi-caret-up-fill"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-light">
                <div class="card-header">
                    Total Buku
                </div>
                <div class="card-body">
                    <h2><?= esc($totalAvailable) ?></h2>
                    <div class="d-flex align-items-center">
                        <span>Total buku yang bertambah</span>
                        <span class="ms-auto text-success">+25% <i class="bi bi-caret-up-fill"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="d-flex justify-content-end mt-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah Peminjaman
        </button>
    </div>
    <div class="card border-light mt-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            List peminjaman
            <i class="bi bi-chevron-down" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePeminjamanExample" aria-expanded="false" aria-controls="collapsePeminjamanExample">
            </i>
        </div>
        <div class="card-body">
            <div class="collapse" id="collapsePeminjamanExample">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Buku</th>
                        <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td>John</td>
                        <td>Doe</td>
                        <td>@social</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card border-light mt-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            List pengembalian
            <i class="bi bi-chevron-down" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePengembalianExample" aria-expanded="false" aria-controls="collapsePengembalianExample">
            </i>
        </div>
        <div class="card-body">
            <div class="collapse" id="collapsePengembalianExample">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Buku</th>
                        <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td>John</td>
                        <td>Doe</td>
                        <td>@social</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var collapse = document.getElementById('collapsePeminjamanExample');
    var chevronIcon = document.querySelector('[data-bs-target="#collapsePeminjamanExample"]');

    collapse.addEventListener('show.bs.collapse', function () {
        chevronIcon.classList.remove('bi-chevron-down');
        chevronIcon.classList.add('bi-chevron-up');
    });
    collapse.addEventListener('hide.bs.collapse', function () {
        chevronIcon.classList.remove('bi-chevron-up');
        chevronIcon.classList.add('bi-chevron-down');
    });

    // Set initial icon state
    if (!collapse.classList.contains('show')) {
        chevronIcon.classList.remove('bi-chevron-up');
        chevronIcon.classList.add('bi-chevron-down');
    }
});
</script>

<!-- Tambahkan form atau tabel sesuai kebutuhan -->
<?= $this->endSection() ?>