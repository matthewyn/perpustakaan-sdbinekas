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
        <button type="button" id="tambah" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-plus"></i> Tambah Siswa
        </button>
        <button type="button" id="ubah" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                    <input type="text" id="searchSiswa" class="form-control" placeholder="Cari dengan NISN/Nama" aria-label="Cari dengan NISN/nama" aria-describedby="cariSiswa" style="max-width: 200px;">
                    <button class="btn btn-success" type="button" id="cariSiswa">Cari</button>
                </div>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">NISN</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php $no = 1; foreach ($users as $key => $user): ?>
                                <?php if (isset($user['role']) && $user['role'] === 'murid'): ?>
                                    <tr>
                                        <th scope="row"><?= $no++ ?></th>
                                        <td><?= esc($user['nisn'] ?? '-') ?></td>
                                        <td><?= esc($user['nama'] ?? '-') ?></td>
                                        <td><?= esc($user['kelas'] ?? '-') ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data siswa.</td>
                            </tr>
                        <?php endif; ?>
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
        <button type="button" id="tambahGuru" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalGuru">
            <i class="bi bi-plus"></i> Tambah Guru
        </button>
        <button type="button" id="ubahGuru" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalGuru">
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
                    <input type="text" id="searchGuru" class="form-control" placeholder="Cari dengan NIP/Nama" aria-label="Cari dengan NIP/nama" aria-describedby="cariGuru" style="max-width: 200px;">
                    <button class="btn btn-success" type="button" id="cariGuru">Cari</button>
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
                      <?php if (!empty($users)): ?>
                        <?php $no = 1; foreach ($users as $key => $user): ?>
                          <?php if (isset($user['role']) && $user['role'] === 'guru'): ?>
                            <tr>
                              <th scope="row"><?= $no++ ?></th>
                              <td><?= esc($user['nisn'] ?? '-') ?></td>
                              <td><?= esc($user['nama'] ?? '-') ?></td>
                              <td><?= esc($user['jabatan'] ?? '-') ?></td>
                            </tr>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="4" class="text-center">Belum ada data guru.</td>
                        </tr>
                      <?php endif; ?>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah Siswa</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form>
        <div class="modal-body">
          <!-- Tambah siswa -->
          <div id="tambahSection" style="display: none;">
              <div class="row mb-3">
                  <div class="col">
                      <label for="nama" class="form-label required">Nama</label>
                      <input type="text" class="form-control" id="nama" name="nama" aria-describedby="namaHelp" required>
                  </div>
                  <div class="col">
                      <label for="nisn" class="form-label required">NISN</label>
                      <input type="text" class="form-control" id="nisn" name="nisn" aria-describedby="nisnHelp" required>
                  </div>
              </div>
              <div class="row mb-3">
                  <div class="col">
                      <label for="kelas" class="form-label required">Kelas</label>
                      <input type="text" class="form-control" id="kelas" name="kelas" aria-describedby="kelasHelp" required>
                  </div>
              </div>
          </div>
          <!-- Ubah siswa -->
          <div id="ubahSection" style="display: none;">
              <div class="mb-3">
                  <label for="nisnCari" class="form-label required">Cari NISN</label>
                  <input type="text" class="form-control" id="nisnCari" placeholder="Ketik NISN">
              </div>
              <div id="ubahFormFields" style="display: none;">
                  <div class="row mb-3">
                      <div class="col">
                          <label for="nisnUbah" class="form-label required">NISN</label>
                          <input type="text" class="form-control" id="nisnUbah" aria-describedby="nisnHelp">
                      </div>
                      <div class="col">
                          <label for="namaUbah" class="form-label required">Nama</label>
                          <input type="text" class="form-control" id="namaUbah" aria-describedby="namaHelp">
                      </div>
                  </div>
                  <div class="row mb-3">
                      <div class="col">
                          <label for="kelasUbah" class="form-label required">Kelas</label>
                          <input type="text" class="form-control" id="kelasUbah" aria-describedby="kelasHelp">
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Guru -->
<div class="modal fade" id="exampleModalGuru" tabindex="-1" aria-labelledby="exampleModalGuruLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalGuruLabel">Form Tambah Guru</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form>
        <div class="modal-body">
            <!-- Tambah guru -->
            <div id="tambahSectionGuru" style="display: none;">
                <div class="row mb-3">
                    <div class="col">
                        <label for="namaGuru" class="form-label required">Nama</label>
                        <input type="text" class="form-control" id="namaGuru" name="namaGuru" aria-describedby="namaGuruHelp" required>
                    </div>
                    <div class="col">
                        <label for="nip" class="form-label required">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" aria-describedby="nipHelp" required>
                    </div>
                </div>
            </div>
            <!-- Ubah guru -->
            <div id="ubahSectionGuru" style="display: none;">
                <div class="mb-3">
                    <label for="nipCari" class="form-label required">Cari NIP</label>
                    <input type="text" class="form-control" id="nipCari" placeholder="Ketik NIP">
                </div>
                <div id="ubahFormFieldsGuru" style="display: none;">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nipUbah" class="form-label required">NIP</label>
                            <input type="text" class="form-control" id="nipUbah" aria-describedby="nipHelp">
                        </div>
                        <div class="col">
                            <label for="namaGuruUbah" class="form-label required">Nama</label>
                            <input type="text" class="form-control" id="namaGuruUbah" aria-describedby="namaGuruHelp">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const searchInput = document.getElementById('searchSiswa');
  const siswaTable = document.querySelector('#collapseSiswaExample table tbody');
  const searchInputGuru = document.getElementById('searchGuru');
  const guruTable = document.querySelector('#collapseGuruExample table tbody');
  const modal = document.getElementById('exampleModal');
  const modalTitle = modal.querySelector('.modal-title');
  const tambahSection = document.getElementById('tambahSection');
  const ubahSection = document.getElementById('ubahSection');
  const modalGuru = document.getElementById('exampleModalGuru');
  const modalTitleGuru = modalGuru.querySelector('.modal-title');
  const tambahSectionGuru = document.getElementById('tambahSectionGuru');
  const ubahSectionGuru = document.getElementById('ubahSectionGuru');
  let siswaList = [];
  let guruList = [];

  function fetchSiswaData() {
    $.get("<?= base_url('user/list') ?>", function(response) {
      if (response.success && Array.isArray(response.users)) {
        siswaList = response.users.filter(u => u.role === 'murid');
        renderSiswaTable(siswaList);
      }
    });
  }
  fetchSiswaData();

  function fetchGuruData() {
    $.get("<?= base_url('user/list') ?>", function(response) {
      if (response.success && Array.isArray(response.users)) {
        guruList = response.users.filter(u => u.role === 'guru');
        renderGuruTable(guruList);
      }
    });
  }
  fetchGuruData();

  // Autocomplete for NISN
  $('#nisnCari').autocomplete({
    source: function(request, response) {
      const results = siswaList
        .map(u => u.nisn)
        .filter(nisn => nisn && nisn.toLowerCase().includes(request.term.toLowerCase()));
      response(results);
    },
    minLength: 1,
    select: function(event, ui) {
      $(this).val(ui.item.value);
      fillEditForm(ui.item.value);
      return false;
    }
  });

  $('#nipCari').autocomplete({
    source: function(request, response) {
      const results = guruList
        .map(u => u.nisn)
        .filter(nip => nip && nip.toLowerCase().includes(request.term.toLowerCase()));
      response(results);
    },
    minLength: 1,
    select: function(event, ui) {
      $(this).val(ui.item.value);
      fillEditFormGuru(ui.item.value);
      return false;
    }
  });

  function fillEditForm(selectedNisn) {
    const siswa = siswaList.find(u => u.nisn === selectedNisn);
    const hiddenForm = $('#ubahFormFields');
    if (siswa) {
      hiddenForm.show();
      hiddenForm.find('#nisnUbah').val(siswa.nisn);
      hiddenForm.find('#namaUbah').val(siswa.nama || '');
      hiddenForm.find('#kelasUbah').val(siswa.kelas || '');
      // Store Firebase key in a hidden field
      if ($('#siswaKey').length === 0) {
        hiddenForm.append('<input type="hidden" id="siswaKey">');
      }
      $('#siswaKey').val(siswa.key || siswa.firebaseKey || siswa.id || siswa._key || siswa.keyName || siswa.key_id || siswa.nisn); // fallback to nisn if key not present
    } else {
      hiddenForm.hide();
    }
  }

  function fillEditFormGuru(selectedNip) {
    const guru = guruList.find(u => u.nisn === selectedNip);
    const hiddenForm = $('#ubahFormFieldsGuru');
    if (guru) {
      hiddenForm.show();
      hiddenForm.find('#nipUbah').val(guru.nisn);
      hiddenForm.find('#namaGuruUbah').val(guru.nama || '');
      // Store Firebase key in a hidden field
      if ($('#guruKey').length === 0) {
        hiddenForm.append('<input type="hidden" id="guruKey">');
      }
      $('#guruKey').val(guru.key || guru.firebaseKey || guru.id || guru._key || guru.keyName || guru.key_id || guru.nisn);
    } else {
      hiddenForm.hide();
    }
  }

  $('#nisnCari').on('input', function() {
    fillEditForm($(this).val());
  });

  $('#nipCari').on('input', function() {
    fillEditFormGuru($(this).val());
  });

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

  function filterGuruTable() {
    const query = searchInputGuru.value.toLowerCase();
    const rows = guruTable.querySelectorAll('tr');
    rows.forEach(row => {
      const nip = row.children[1]?.textContent.toLowerCase() || '';
      const nama = row.children[2]?.textContent.toLowerCase() || '';
      if (nip.includes(query) || nama.includes(query)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  // Render siswa table rows
  function renderSiswaTable(users) {
    let html = '';
    let no = 1;
    users.forEach(function(user) {
      if (user.role === 'murid') {
        html += `<tr>
          <th scope="row">${no++}</th>
          <td>${user.nisn ?? '-'}</td>
          <td>${user.nama ?? '-'}</td>
          <td>${user.kelas ?? '-'}</td>
        </tr>`;
      }
    });
    if (html === '') {
      html = `<tr><td colspan="4" class="text-center">Belum ada data siswa.</td></tr>`;
    }
    siswaTable.innerHTML = html;
    filterSiswaTable();
  }

  function renderGuruTable(users) {
    let html = '';
    let no = 1;
    users.forEach(function(user) {
      html += `<tr>
        <th scope="row">${no++}</th>
        <td>${user.nisn ?? '-'}</td>
        <td>${user.nama ?? '-'}</td>
        <td>${user.jabatan ?? '-'}</td>
      </tr>`;
    });
    if (html === '') {
      html = `<tr><td colspan="4" class="text-center">Belum ada data guru.</td></tr>`;
    }
    guruTable.innerHTML = html;
    filterGuruTable();
  }

  // Add form submission handler for the modal
  $('#exampleModal .modal-footer .btn-primary').on('click', function(e) {
    e.preventDefault();

    const isEditMode = ubahSection.style.display === 'block';
    
    if (isEditMode) {
      handleUserEdit();
    } else {
      handleUserAdd();
    }
  });

  $('#exampleModalGuru .modal-footer .btn-primary').on('click', function(e) {
    e.preventDefault();
    const isEditMode = ubahSectionGuru.style.display === 'block';
    if (isEditMode) {
      handleGuruEdit();
    } else {
      handleGuruAdd();
    }
  });

  function handleUserAdd() {
    const siswaForm = modal.querySelector('form');
    const nama = siswaForm.nama.value.trim();
    const nisn = siswaForm.nisn.value.trim();
    const kelas = siswaForm.kelas.value.trim();

    const formData = new FormData();
    formData.append('nama', nama);
    formData.append('nisn', nisn);
    formData.append('kelas', kelas);

    $.ajax({
      url: "<?= base_url('user/add') ?>",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if (response.success) {
          $('#exampleModal').modal('hide');
          $('#nama').val('');
          $('#nisn').val('');
          $('#kelas').val('');
          showToast('Berhasil menambahkan siswa dengan NISN: ' + nisn);
          fetchSiswaData();
        } else {
          showToast('Gagal menambahkan siswa dengan NISN: ' + nisn);
        }
      },
      error: function(xhr, status, error) {
        alert('Terjadi kesalahan saat menambahkan buku');
      }
    });
  }

  function handleUserEdit() {
    const key = $('#siswaKey').val();
    const nama = $('#namaUbah').val().trim();
    const nisn = $('#nisnUbah').val().trim();
    const kelas = $('#kelasUbah').val().trim();

    if (!key) {
      showToast('Tidak dapat menemukan data siswa untuk diubah.');
      return;
    }

    const formData = new FormData();
    formData.append('nama', nama);
    formData.append('nisn', nisn);
    formData.append('kelas', kelas);

    $.ajax({
      url: "<?= base_url('user/update') ?>/" + key,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if (response.success) {
          $('#exampleModal').modal('hide');
          showToast('Berhasil mengubah data siswa.');
          fetchSiswaData();
        } else {
          showToast('Gagal mengubah data siswa.');
        }
      },
      error: function() {
        showToast('Terjadi kesalahan saat mengubah data siswa.');
      }
    });
  }
  
  function handleGuruAdd() {
    const guruForm = modalGuru.querySelector('form');
    const nama = guruForm.namaGuru.value.trim();
    const nip = guruForm.nip.value.trim();

    const formData = new FormData();
    formData.append('namaGuru', nama);
    formData.append('nip', nip);

    $.ajax({
      url: "<?= base_url('user/add-guru') ?>",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if (response.success) {
          $('#exampleModalGuru').modal('hide');
          $('#namaGuru').val('');
          $('#nip').val('');
          showToast('Berhasil menambahkan guru dengan NIP: ' + nip);
          fetchGuruData();
        } else {
          showToast('Gagal menambahkan guru dengan NIP: ' + nip);
        }
      },
      error: function() {
        showToast('Terjadi kesalahan saat menambahkan guru');
      }
    });
  }

  function handleGuruEdit() {
    const key = $('#guruKey').val();
    const nama = $('#namaGuruUbah').val().trim();
    const nip = $('#nipUbah').val().trim();

    if (!key) {
      showToast('Tidak dapat menemukan data guru untuk diubah.');
      return;
    }

    const formData = new FormData();
    formData.append('namaGuruUbah', nama);
    formData.append('nipUbah', nip);

    $.ajax({
      url: "<?= base_url('user/update-guru') ?>/" + key,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if (response.success) {
          $('#exampleModalGuru').modal('hide');
          showToast('Berhasil mengubah data guru.');
          fetchGuruData();
        } else {
          showToast('Gagal mengubah data guru.');
        }
      },
      error: function() {
        showToast('Terjadi kesalahan saat mengubah data guru.');
      }
    });
  }

  // Handle modal open for Tambah
  document.getElementById('tambah').addEventListener('click', function() {
    modalTitle.textContent = 'Form Tambah Siswa';
    tambahSection.style.display = 'block';
    ubahSection.style.display = 'none';

    clearForm();
  });

  // Handle modal open for Ubah
  document.getElementById('ubah').addEventListener('click', function() {
    modalTitle.textContent = 'Form Ubah Siswa';
    tambahSection.style.display = 'none';
    ubahSection.style.display = 'block';

    // Always hide the ubah form fields when opening
    $('#ubahFormFields').hide();
    
    // Clear form fields
    clearForm();
  });
  
  // Handle modal open for Tambah
  document.getElementById('tambahGuru').addEventListener('click', function() {
    modalTitleGuru.textContent = 'Form Tambah Guru';
    tambahSectionGuru.style.display = 'block';
    ubahSectionGuru.style.display = 'none';

    clearForm();
  });

  // Handle modal open for Ubah
  document.getElementById('ubahGuru').addEventListener('click', function() {
    modalTitleGuru.textContent = 'Form Ubah Guru';
    tambahSectionGuru.style.display = 'none';
    ubahSectionGuru.style.display = 'block';

    // Always hide the ubah form fields when opening
    $('#ubahFormFieldsGuru').hide();
    
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

  searchInput.addEventListener('input', filterSiswaTable);
  document.getElementById('cariSiswa').addEventListener('click', filterSiswaTable);
  
  searchInputGuru.addEventListener('input', filterGuruTable);
  document.getElementById('cariGuru').addEventListener('click', filterGuruTable);
});
</script>

<?= $this->endSection() ?>