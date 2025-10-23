<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<style>
    .page-item.active .page-link {
        background-color: #f4f4f4;
        border-color: #dee2e6;
        color: white;
    }
    .ui-autocomplete {
        z-index: 2000 !important;
    }
    .table img {
        border-radius: 4px;
    }
    .table td {
        max-width: 140px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .table tbody tr {
        cursor: pointer;
    }
</style>

<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Katalog</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manajemen Buku</li>
        </ol>
    </nav>

    <!-- Tombol Tambah & Import -->
    <div class="d-flex justify-content-end gap-2 mt-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus"></i> Tambah Buku
        </button>
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="bi bi-file-earmark-arrow-up"></i> Import JSON
        </button>
    </div>

    <!-- Tabel Buku -->
    <div class="card border-light mt-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            List buku
            <i class="bi bi-chevron-down" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBuku" aria-expanded="false" aria-controls="collapseBuku"></i>
        </div>
        <div class="card-body">
            <div class="collapse show" id="collapseBuku">
                <div class="input-group input-group-sm mb-3 justify-content-end">
                    <input type="text" id="searchBuku" class="form-control" placeholder="Cari dengan Kode/Judul" style="max-width: 250px;">
                    <button class="btn btn-success" type="button" id="cariBuku">Cari</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bukuTableBody">
                            <?php $i=1; foreach($books as $key => $book): ?>
                                <tr data-book='<?= json_encode(array_merge($book, ["key" => $key])) ?>'>
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($book['code'] ?? '-') ?></td>
                                    <td><?= esc($book['title'] ?? '-') ?></td>
                                    <td><?= esc($book['author'] ?? '-') ?></td>
                                    <td><?= esc($book['publisher'] ?? '-') ?></td>
                                    <td><?= esc($book['year'] ?? '-') ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btn-edit-buku" type="button">Edit</button>
                                        <a href="<?= base_url('management-buku/delete?code='.urlencode($book['code'])) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if(empty($books)): ?>
                                <tr>
                                    <td colspan="12" class="text-center">Data buku kosong</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <nav aria-label="...">
                <ul class="pagination justify-content-center"></ul>
            </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Buku -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="bukuForm" action="<?= base_url('buku/add') ?>" method="post" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBukuTitle">Tambah Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Tambah buku -->
        <div id="tambahSection">
            <div class="row mb-3">
                <div class="col">
                    <label for="uid" class="form-label required">UID (tap RFID atau tambah manual)</label>
                    <div class="uid-container">
                        <input type="text" name="uid[]" class="form-control mb-1" placeholder="Masukkan UID">
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-add-uid">
                        + Tambah UID
                    </button>
                </div>
                <div class="col">
                    <label for="code" class="form-label required">Kode</label>
                    <input type="text" name="code" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="title" class="form-label required">Judul</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="col">
                    <label for="author" class="form-label required">Penulis</label>
                    <input type="text" name="author" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="publisher" class="form-label required">Penerbit</label>
                    <input type="text" name="publisher" class="form-control">
                </div>
                <div class="col">
                    <label for="genre" class="form-label required">Genre</label>
                    <input type="text" name="genre" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="year" class="form-label required">Tahun</label>
                    <input type="number" name="year" class="form-control">
                </div>
                <div class="col">
                    <label for="illustrator" class="form-label required">Illustrator</label>
                    <input type="text" name="illustrator" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="series" class="form-label required">Seri</label>
                    <input type="text" name="series" class="form-control">
                </div>
                <div class="col">
                    <label for="notes" class="form-label">Catatan</label>
                    <input type="text" name="notes" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="isOneDayBookAdd" name="isOneDayBookAdd">
                    <label class="form-check-label" for="isOneDayBookAdd">Buku 1 Hari</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="synopsis" class="form-label required">Sinopsis</label>
                <textarea name="synopsis" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <!-- Ubah buku -->
        <div id="ubahSection" style="display: none;">
            <div class="row mb-3">
                <div class="col">
                    <label for="uidUbah" class="form-label">UID (tap RFID atau tambah manual)</label>
                    <div class="uid-container">
                        <input type="text" name="uidUbah[]" class="form-control mb-1" placeholder="Masukkan UID">
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-add-uid">
                        + Tambah UID
                    </button>
                </div>
                <div class="col">
                    <label for="codeUbah" class="form-label required">Kode</label>
                    <input type="text" name="codeUbah" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="titleUbah" class="form-label required">Judul</label>
                    <input type="text" name="titleUbah" class="form-control" required>
                </div>
                <div class="col">
                    <label for="authorUbah" class="form-label required">Penulis</label>
                    <input type="text" name="authorUbah" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="publisherUbah" class="form-label required">Penerbit</label>
                    <input type="text" name="publisherUbah" class="form-control">
                </div>
                <div class="col">
                    <label for="genreUbah" class="form-label required">Genre</label>
                    <input type="text" name="genreUbah" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="yearUbah" class="form-label required">Tahun</label>
                    <input type="number" name="yearUbah" class="form-control">
                </div>
                <div class="col">
                    <label for="illustratorUbah" class="form-label required">Illustrator</label>
                    <input type="text" name="illustratorUbah" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="seriesUbah" class="form-label required">Seri</label>
                    <input type="text" name="seriesUbah" class="form-control">
                </div>
                <div class="col">
                    <label for="notesUbah" class="form-label">Catatan</label>
                    <input type="text" name="notesUbah" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label for="imageUbah" class="form-label">Gambar</label>
                <input type="file" name="imageUbah" class="form-control">
            </div>
            <div class="mb-3">
                <div class="d-flex gap-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="isOneDayBookUbah" name="isOneDayBookUbah">
                        <label class="form-check-label" for="isOneDayBookUbah">Buku 1 Hari</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="availableUbah" name="availableUbah">
                        <label class="form-check-label" for="availableUbah">Tersedia</label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="synopsisUbah" class="form-label required">Sinopsis</label>
                <textarea name="synopsisUbah" class="form-control" rows="3"></textarea>
            </div>
            <input type="hidden" name="editKey" id="editKey">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="submitBukuBtn">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Detail Buku -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Buku</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table pe-none">
            <tr><th>Kode</th><td id="detailKode"></td></tr>
            <tr><th>Judul</th><td id="detailJudul"></td></tr>
            <tr><th>Penulis</th><td id="detailPenulis"></td></tr>
            <tr><th>Penerbit</th><td id="detailPenerbit"></td></tr>
            <tr><th>Tahun</th><td id="detailTahun"></td></tr>
            <tr><th>Genre</th><td id="detailGenre"></td></tr>
            <tr><th>Series</th><td id="detailSeries"></td></tr>
            <tr><th>Posisi Rak</th><td id="detailShelfPosition"></td></tr>
            <tr><th>Tersedia</th><td id="detailAvailable"></td></tr>
            <!-- Add more fields as needed -->
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Import JSON -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= base_url('buku/importJson') ?>" method="post" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Import Buku dari JSON</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label for="json_file" class="form-label required">File JSON</label>
        <input type="file" name="json_file" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Import</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('searchBuku');
    const tableBody = document.getElementById('bukuTableBody');
    const rowsPerPage = 25;
    let currentPage = 1;

    // Tombol tambah UID
    document.querySelectorAll('.btn-add-uid').forEach(btn => {
        btn.addEventListener('click', () => {
            const container = btn.closest('.col').querySelector('.uid-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'uid[]';
            input.className = 'form-control mb-1';
            input.placeholder = 'Masukkan UID';
            container.appendChild(input);
        });
    });

    // Reset modal saat ditutup (hapus UID tambahan)
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', () => {
            const container = modal.querySelector('.uid-container');
            if (container) {
                // Jika modal edit ada UID sebelumnya, biarkan 1 input, hapus sisanya
                const inputs = container.querySelectorAll('input');
                const firstValue = inputs[0]?.value || '';
                container.innerHTML = `<input type="text" name="uid[]" class="form-control mb-1" value="${firstValue}" placeholder="Masukkan UID">`;
            }
        });
    });

    // Utility to enable/disable all inputs in a section
    function setSectionInputsEnabled(sectionId, enabled) {
        document.querySelectorAll(`#${sectionId} input, #${sectionId} textarea, #${sectionId} select`).forEach(el => {
            el.disabled = !enabled;
        });
    }

    // Handle Add Buku button
    document.querySelector('[data-bs-target="#addModal"]').addEventListener('click', function() {
        document.getElementById('modalBukuTitle').textContent = 'Tambah Buku';
        document.getElementById('bukuForm').action = "<?= base_url('management-buku/add') ?>";
        document.getElementById('tambahSection').style.display = '';
        document.getElementById('ubahSection').style.display = 'none';
        setSectionInputsEnabled('tambahSection', true);
        setSectionInputsEnabled('ubahSection', false);
        document.getElementById('bukuForm').reset();
    });

    // Handle Edit Buku button
    document.querySelectorAll('.btn-edit-buku').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const tr = btn.closest('tr');
            const book = JSON.parse(tr.getAttribute('data-book'));
            document.getElementById('modalBukuTitle').textContent = 'Edit Buku';
            document.getElementById('bukuForm').action = "<?= base_url('management-buku/edit/') ?>" + book.key;
            document.getElementById('tambahSection').style.display = 'none';
            document.getElementById('ubahSection').style.display = '';
            setSectionInputsEnabled('tambahSection', false);
            setSectionInputsEnabled('ubahSection', true);

            // Fill ubahSection fields
            document.querySelector('[name="uid[]"]').value = (book.uid && book.uid[0]) ? book.uid[0] : '';
            document.querySelector('[name="codeUbah"]').value = book.code || '';
            document.querySelector('[name="titleUbah"]').value = book.title || '';
            document.querySelector('[name="authorUbah"]').value = book.author || '';
            document.querySelector('[name="publisherUbah"]').value = book.publisher || '';
            document.querySelector('[name="genreUbah"]').value = book.genre || '';
            document.querySelector('[name="yearUbah"]').value = book.year || '';
            document.querySelector('[name="illustratorUbah"]').value = book.illustrator || '';
            document.querySelector('[name="seriesUbah"]').value = book.series || '';
            document.querySelector('[name="notesUbah"]').value = book.notes || '';
            document.querySelector('[name="synopsisUbah"]').value = book.synopsis || '';
            document.getElementById('editKey').value = book.key;

            var addModal = new bootstrap.Modal(document.getElementById('addModal'));
            addModal.show();
        });
    });

    function renderPagination(totalRows) {
        const pages = Math.ceil(totalRows / rowsPerPage);
        const paginationContainer = document.querySelector('.pagination');
        paginationContainer.innerHTML = '';

        if (pages <= 1) return; // jika cuma 1 halaman, tidak perlu pagination

        const createPageItem = (text, page, disabled = false, active = false) => {
            const li = document.createElement('li');
            li.className = 'page-item' + (active ? ' active' : '') + (disabled ? ' disabled' : '');
            const a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#';
            a.textContent = text;
            a.addEventListener('click', function(e) {
                e.preventDefault();
                if (!disabled) {
                    currentPage = page;
                    filterTable();
                }
            });
            li.appendChild(a);
            return li;
        };

        // tombol Previous
        paginationContainer.appendChild(createPageItem('Previous', currentPage - 1, currentPage === 1));

        // nomor halaman
        for (let p = 1; p <= pages; p++) {
            paginationContainer.appendChild(createPageItem(p, p, false, p === currentPage));
        }

        // tombol Next
        paginationContainer.appendChild(createPageItem('Next', currentPage + 1, currentPage === pages));
    }

    function filterTable() {
        const query = searchInput.value.toLowerCase();
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        
        // filter data
        const filtered = rows.filter(row => {
            const code = row.children[1]?.textContent.toLowerCase() || '';
            const title = row.children[2]?.textContent.toLowerCase() || '';
            return code.includes(query) || title.includes(query);
        });

        // hide semua row
        rows.forEach(row => row.style.display = 'none');

        // tampilkan row halaman ini
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        filtered.slice(start, end).forEach(row => row.style.display = '');

        // render pagination
        renderPagination(filtered.length);
    }

    function renderPagination(totalRows) {
        const pages = Math.ceil(totalRows / rowsPerPage);
        const paginationContainer = document.querySelector('.pagination');
        paginationContainer.innerHTML = '';

        if (pages <= 1) return;

        const createPageItem = (text, page, disabled = false, active = false) => {
            const li = document.createElement('li');
            li.className = 'page-item' + (active ? ' active' : '') + (disabled ? ' disabled' : '');
            const a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#';
            a.textContent = text;
            a.addEventListener('click', function(e) {
                e.preventDefault();
                if (!disabled && page >= 1 && page <= pages) {
                    currentPage = page;
                    filterTable();
                }
            });
            li.appendChild(a);
            return li;
        };

        // tombol Previous
        paginationContainer.appendChild(createPageItem('Previous', currentPage - 1, currentPage === 1));

        const visiblePages = 5; // jumlah nomor halaman yang ditampilkan di tengah
        let startPage = Math.max(currentPage - Math.floor(visiblePages / 2), 1);
        let endPage = startPage + visiblePages - 1;

        if (endPage > pages) {
            endPage = pages;
            startPage = Math.max(endPage - visiblePages + 1, 1);
        }

        if (startPage > 1) {
            paginationContainer.appendChild(createPageItem(1, 1));
            if (startPage > 2) {
                const li = document.createElement('li');
                li.className = 'page-item disabled';
                li.innerHTML = `<span class="page-link">...</span>`;
                paginationContainer.appendChild(li);
            }
        }

        for (let p = startPage; p <= endPage; p++) {
            paginationContainer.appendChild(createPageItem(p, p, false, p === currentPage));
        }

        if (endPage < pages) {
            if (endPage < pages - 1) {
                const li = document.createElement('li');
                li.className = 'page-item disabled';
                li.innerHTML = `<span class="page-link">...</span>`;
                paginationContainer.appendChild(li);
            }
            paginationContainer.appendChild(createPageItem(pages, pages));
        }

        // tombol Next
        paginationContainer.appendChild(createPageItem('Next', currentPage + 1, currentPage === pages));
    }

    document.querySelectorAll('#bukuTableBody tr').forEach(function(row) {
        row.addEventListener('dblclick', function() {
            const book = JSON.parse(row.getAttribute('data-book'));
            document.getElementById('detailKode').textContent = book.code || '-';
            document.getElementById('detailJudul').textContent = book.title || '-';
            document.getElementById('detailPenulis').textContent = book.author || '-';
            document.getElementById('detailPenerbit').textContent = book.publisher || '-';
            document.getElementById('detailTahun').textContent = book.year || '-';
            document.getElementById('detailGenre').textContent = book.genre || '-';
            document.getElementById('detailSeries').textContent = book.series || '-';
            document.getElementById('detailShelfPosition').textContent = book.shelfPosition || '-';
            document.getElementById('detailAvailable').textContent = book.available ? 'Ya' : 'Tidak';
            // Add more fields as needed

            var detailModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            detailModal.show();
        });
    });

    searchInput.addEventListener('input', () => { currentPage = 1; filterTable(); });
    document.getElementById('cariBuku').addEventListener('click', () => { currentPage = 1; filterTable(); });

    filterTable(); // initial render
});

</script>

<?php if (session()->getFlashdata('message')): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        showToast("<?= esc(session()->getFlashdata('message'), 'js') ?>");
    });
</script>
<?php endif; ?>

<?= $this->endSection() ?>