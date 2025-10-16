<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<style>
    .page-item.active .page-link {
        background-color: #f4f4f4;
        border-color: #dee2e6;
        color: white;
    }
</style>
<div class="container mt-4">
    <!-- Main -->
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb mt-3">
        <li class="breadcrumb-item">
        <a href="<?= base_url() ?>">Katalog</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Manajemen User</li>
    </ol>
    </nav>
    <div class="d-flex justify-content-end mt-4 gap-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-plus"></i> Tambah Siswa
        </button>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-pencil-square"></i> Edit Siswa
        </button>
    </div>
    <div class="card border-light mt-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            List siswa
            <i class="bi bi-chevron-down" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSiswaExample" aria-expanded="false" aria-controls="collapseSiswaExample">
            </i>
        </div>
        <div class="card-body">
            <div class="collapse" id="collapseSiswaExample">
                <div class="input-group input-group-sm mb-3 justify-content-end">
                    <input type="text" id="searchSiswa" class="form-control" placeholder="Cari dengan NISN/Nama" aria-label="Cari dengan NISN/nama" aria-describedby="button-addon2" style="max-width: 200px;">
                    <button class="btn btn-success" type="button" id="button-addon2">Cari</button>
                </div>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">NISN</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tempat/Tgl Lahir</th>
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
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item"><a href="#" class="page-link text-secondary">Previous</a></li>
                        <li class="page-item"><a class="page-link text-secondary" href="#">1</a></li>
                        <li class="page-item active">
                        <a class="page-link text-secondary" href="#" aria-current="page">2</a>
                        </li>
                        <li class="page-item"><a class="page-link text-secondary" href="#">3</a></li>
                        <li class="page-item"><a class="page-link text-secondary" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4 gap-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-plus"></i> Tambah Guru
        </button>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-pencil-square"></i> Edit Guru
        </button>
    </div>
    <div class="card border-light mt-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            List guru
            <i class="bi bi-chevron-down" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGuruExample" aria-expanded="false" aria-controls="collapseGuruExample">
            </i>
        </div>
        <div class="card-body">
            <div class="collapse" id="collapseGuruExample">
                <div class="input-group input-group-sm mb-3 justify-content-end">
                    <input type="text" id="searchSiswa" class="form-control" placeholder="Cari dengan NIP/Nama" aria-label="Cari dengan NIP/nama" aria-describedby="button-addon2" style="max-width: 200px;">
                    <button class="btn btn-success" type="button" id="button-addon2">Cari</button>
                </div>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">NIP</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jabatan</th>
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
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item"><a href="#" class="page-link text-secondary">Previous</a></li>
                        <li class="page-item"><a class="page-link text-secondary" href="#">1</a></li>
                        <li class="page-item active">
                        <a class="page-link text-secondary" href="#" aria-current="page">2</a>
                        </li>
                        <li class="page-item"><a class="page-link text-secondary" href="#">3</a></li>
                        <li class="page-item"><a class="page-link text-secondary" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const searchInput = document.getElementById('searchSiswa');
  const siswaTable = document.querySelector('#collapseSiswaExample table tbody');

  function filterSiswaTable() {
    const query = searchInput.value.toLowerCase();
    const rows = siswaTable.querySelectorAll('tr');
    rows.forEach(row => {
      const nisn = row.children[1]?.textContent.toLowerCase() || '';
      const nama = row.children[2]?.textContent.toLowerCase() || '';
      if (nisn.includes(query) || nama.includes(query)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  searchInput.addEventListener('input', filterSiswaTable);
  document.getElementById('button-addon2').addEventListener('click', filterSiswaTable);
});
</script>

<?= $this->endSection() ?>