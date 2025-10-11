<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Perpustakaan SD Binekas' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .form-label.required:after {
            content:"*";
            color:red;
        }
        .list-group-item:hover {
            background-color: var(--bs-dark);
            color: #fff;
        }
        body.login-page {
            background-image: url('<?= base_url('/background.webp') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
    </style>
</head>
<body class="<?= esc($bodyClass ?? '') ?>">
    <nav class="navbar navbar-expand-lg border-bottom bg-white">
        <div class="container">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><i class="bi bi-list"></i></button>
                <div class="d-flex align-items-center ml-3">
                    <img src="<?= base_url('/logo.png') ?>" alt="Logo" width="50" height="50" class="d-inline-block align-text-top me-2">
                    <a class="navbar-brand" href="<?= base_url('/') ?>">Perpustakaan SD Binekas</a>
                </div>
            </div>
            <?php if (session('role')): ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= base_url('/profile.jpg') ?>" alt="User" width="40" height="40" class="d-inline-block align-text-top rounded-circle">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="link-underline-light">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Selamat datang, <?= session('name') ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <ul class="list-group list-group-flush">
                <li class="list-group-item border-0" id="formListItem">
                    <a data-bs-toggle="collapse" href="#formExample" role="button" aria-expanded="false" aria-controls="formExample" style="text-decoration: none; color: inherit;" class="d-flex align-items-center justify-content-between">
                        <span>
                            <i class="bi bi-file-earmark-text"></i>
                            Form
                        </span>
                        <i class="bi bi-chevron-left"></i>
                    </a>
                    <div class="collapse" id="formExample">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item text-bg-dark border-0">
                                <a href="<?= base_url('peminjaman') ?>" style="text-decoration: none; color: inherit;">Peminjaman</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="container-xxl">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="js/plugins/flot/jquery.flot.time.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var collapse = document.getElementById('formExample');
        var listItem = document.getElementById('formListItem');
        var chevronIcon = listItem.querySelector('.bi-chevron-left');

        collapse.addEventListener('show.bs.collapse', function () {
            listItem.classList.add('text-bg-dark', 'border-start', 'border-5', 'border-success');
            if (chevronIcon) {
                chevronIcon.classList.remove('bi-chevron-left');
                chevronIcon.classList.add('bi-chevron-down');
            }
        });
        collapse.addEventListener('hide.bs.collapse', function () {
            listItem.classList.remove('text-bg-dark', 'border-start', 'border-5', 'border-success');
            if (chevronIcon) {
                chevronIcon.classList.remove('bi-chevron-down');
                chevronIcon.classList.add('bi-chevron-left');
            }
        });
    });
    </script>
</body>
</html>
