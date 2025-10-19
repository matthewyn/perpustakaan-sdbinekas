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
        <li class="breadcrumb-item"><a href="#">Form</a></li>
        <li class="breadcrumb-item active" aria-current="page">Peminjaman</li>
    </ol>
    </nav>
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
    <div class="card border-light mt-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            Statistik Peminjaman Buku
            <div class="float-end">
                <div>
                    <button type="button" class="btn btn-outline-secondary btn-sm">Hari</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm">Bulan</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm">Tahun</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                    <div class="col-lg-9">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <ul class="stat-list">
                            <li>
                                <h2 class="fs-4 m-0">2,346</h2>
                                <small>Buku yang dipinjam</small>
                                <div class="stat-percent text-success">48% <i class="bi bi-caret-up-fill"></i></div>
                                <div class="progress progress-mini">
                                    <div style="width: 48%;" class="progress-bar bg-success"></div>
                                </div>
                            </li>
                            <li>
                                <h2 class="fs-4 m-0">4,422</h2>
                                <small>Buku yang dikembalikan</small>
                                <div class="stat-percent text-success">60% <i class="bi bi-caret-up-fill"></i></div>
                                <div class="progress progress-mini">
                                    <div style="width: 60%;" class="progress-bar bg-success"></div>
                                </div>
                            </li>
                            <li>
                                <h2 class="fs-4 m-0">9,180</h2>
                                <small>Total buku</small>
                                <div class="stat-percent text-success">22% <i class="bi bi-caret-up-fill"></i></div>
                                <div class="progress progress-mini">
                                    <div style="width: 22%;" class="progress-bar bg-success"></div>
                                </div>
                            </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-plus"></i> Tambah Peminjaman
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
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Buku</th>
                        <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($borrowings)): ?>
                            <?php $no = 1; foreach ($borrowings as $row): ?>
                                <tr>
                                    <th scope="row"><?= $no++ ?></th>
                                    <td><?= esc($row['nama']) ?></td>
                                    <td><?= esc($row['judul']) ?></td>
                                    <td><?= esc($row['tanggal']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data peminjaman.</td>
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
    <div class="d-flex justify-content-end mt-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-plus"></i> Tambah Pengembalian
        </button>
    </div>
    <div class="card border-light mt-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            List pengembalian
            <i class="bi bi-chevron-down" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePengembalianExample" aria-expanded="false" aria-controls="collapsePengembalianExample">
            </i>
        </div>
        <div class="card-body">
            <div class="collapse" id="collapsePengembalianExample">
                <table class="table table-hover table-striped">
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
            <h1 class="modal-title fs-5" id="exampleModalLabel">Form Peminjaman</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col siswa-select">
                        <label for="nisnCari" class="form-label required">Cari NISN Siswa</label>
                        <input type="text" class="form-control" id="nisnCari" name="nisnCari" placeholder="Ketik NISN" required>
                    </div>
                    <div class="col">
                        <label for="judulCari" class="form-label required">Cari Judul Buku</label>
                        <input type="text" class="form-control" id="judulCari" name="judulCari" placeholder="Ketik judul" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var collapse = document.getElementById('collapsePeminjamanExample');
    var chevronIcon = document.querySelector('[data-bs-target="#collapsePeminjamanExample"]');
    const modal = document.getElementById('exampleModal');
    const modalTitle = modal.querySelector('.modal-title');
    let siswaList = [];
    let bookTitles = [];

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

    var data2 = [
        [gd(2012, 1, 1), 7], [gd(2012, 1, 2), 6], [gd(2012, 1, 3), 4], [gd(2012, 1, 4), 8],
        [gd(2012, 1, 5), 9], [gd(2012, 1, 6), 7], [gd(2012, 1, 7), 5], [gd(2012, 1, 8), 4],
        [gd(2012, 1, 9), 7], [gd(2012, 1, 10), 8], [gd(2012, 1, 11), 9], [gd(2012, 1, 12), 6],
        [gd(2012, 1, 13), 4], [gd(2012, 1, 14), 5], [gd(2012, 1, 15), 11], [gd(2012, 1, 16), 8],
        [gd(2012, 1, 17), 8], [gd(2012, 1, 18), 11], [gd(2012, 1, 19), 11], [gd(2012, 1, 20), 6],
        [gd(2012, 1, 21), 6], [gd(2012, 1, 22), 8], [gd(2012, 1, 23), 11], [gd(2012, 1, 24), 13],
        [gd(2012, 1, 25), 7], [gd(2012, 1, 26), 9], [gd(2012, 1, 27), 9], [gd(2012, 1, 28), 8],
        [gd(2012, 1, 29), 5], [gd(2012, 1, 30), 8], [gd(2012, 1, 31), 25]
    ];

    var data3 = [
        [gd(2012, 1, 1), 800], [gd(2012, 1, 2), 500], [gd(2012, 1, 3), 600], [gd(2012, 1, 4), 700],
        [gd(2012, 1, 5), 500], [gd(2012, 1, 6), 456], [gd(2012, 1, 7), 800], [gd(2012, 1, 8), 589],
        [gd(2012, 1, 9), 467], [gd(2012, 1, 10), 876], [gd(2012, 1, 11), 689], [gd(2012, 1, 12), 700],
        [gd(2012, 1, 13), 500], [gd(2012, 1, 14), 600], [gd(2012, 1, 15), 700], [gd(2012, 1, 16), 786],
        [gd(2012, 1, 17), 345], [gd(2012, 1, 18), 888], [gd(2012, 1, 19), 888], [gd(2012, 1, 20), 888],
        [gd(2012, 1, 21), 987], [gd(2012, 1, 22), 444], [gd(2012, 1, 23), 999], [gd(2012, 1, 24), 567],
        [gd(2012, 1, 25), 786], [gd(2012, 1, 26), 666], [gd(2012, 1, 27), 888], [gd(2012, 1, 28), 900],
        [gd(2012, 1, 29), 178], [gd(2012, 1, 30), 555], [gd(2012, 1, 31), 993]
    ];


    var dataset = [
        {
            label: "Pinjam",
            data: data3,
            color: "#1ab394",
            bars: {
                show: true,
                align: "center",
                barWidth: 24 * 60 * 60 * 600,
                lineWidth:0
            }

        }, {
            label: "Kembali",
            data: data2,
            yaxis: 2,
            color: "#1C84C6",
            lines: {
                lineWidth:1,
                    show: true,
                    fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.2
                    }, {
                        opacity: 0.4
                    }]
                }
            },
            splines: {
                show: false,
                tension: 0.6,
                lineWidth: 1,
                fill: 0.1
            },
        }
    ];


    var options = {
        xaxis: {
            mode: "time",
            tickSize: [3, "day"],
            tickLength: 0,
            axisLabel: "Date",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Arial',
            axisLabelPadding: 10,
            color: "#d5d5d5"
        },
        yaxes: [{
            position: "left",
            max: 1070,
            color: "#d5d5d5",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Arial',
            axisLabelPadding: 3
        }, {
            position: "right",
            clolor: "#d5d5d5",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: ' Arial',
            axisLabelPadding: 67
        }
        ],
        legend: {
            noColumns: 1,
            labelBoxBorderColor: "#000000",
            position: "nw"
        },
        grid: {
            hoverable: false,
            borderWidth: 0
        }
    };

    function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
    }

    var previousPoint = null, previousLabel = null;

    $.plot($("#flot-dashboard-chart"), dataset, options);

    function fetchSiswaData() {
        $.get("<?= base_url('user/list') ?>", function(response) {
            if (response.success && Array.isArray(response.users)) {
            siswaList = response.users.filter(u => u.role === 'murid');
            }
        });
    }

    // Call this on page load
    fetchSiswaData();

    function fetchBookData() {
        $.get("<?= base_url('books/all') ?>", function(response) {
            if (response.books && Array.isArray(response.books)) {
            bookTitles = response.books
                .map(b => b.title)
                .filter(title => !!title);
            }
        });
    }

    // Call this on page load
    fetchBookData();

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
            // Optionally, fill other fields or trigger actions here
            return false;
        }
    });

    // Autocomplete for title only
    $('#judulCari').autocomplete({
        source: function(request, response) {
            const results = bookTitles.filter(title =>
            title.toLowerCase().includes(request.term.toLowerCase())
            );
            response(results);
        },
        minLength: 1,
        select: function(event, ui) {
            $(this).val(ui.item.value);
            // Optionally, fill other fields or trigger actions here
            return false;
        }
    });

    // Add form submission handler for the modal
    $('#exampleModal .modal-footer .btn-primary').on('click', function(e) {
        e.preventDefault();
        
        handlePeminjamanAdd();
    });

    function handlePeminjamanAdd() {
        const peminjamanForm = modal.querySelector('form');
        const nisn = peminjamanForm.nisnCari.value.trim();
        const judul = peminjamanForm.judulCari.value.trim();

        if (!nisn || !judul) {
            showToast('NISN dan Judul Buku harus diisi!');
            return;
        }

        const formData = new FormData();
        formData.append('nisnCari', nisn);
        formData.append('judulCari', judul);

        $.ajax({
            url: "<?= base_url('peminjaman/add') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#exampleModal').modal('hide');
                    showToast('Peminjaman berhasil ditambahkan!');
                } else {
                    showToast('Gagal menambahkan peminjaman.');
                }
            },
            error: function(xhr, status, error) {
                showToast('Terjadi kesalahan saat menambah peminjaman!');
            }
        });
    }

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
});
</script>

<!-- Tambahkan form atau tabel sesuai kebutuhan -->
<?= $this->endSection() ?>