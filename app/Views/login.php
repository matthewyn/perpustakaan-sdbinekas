<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center align-items-center" style="min-height: calc(100vh - 67px); background-image: url('<?= base_url('/background.webp') ?>'); background-size: cover; background-position: center;">
    <div class="col-md-4">
        <img src="<?= base_url('/logo.png') ?>" alt="Logo" width="160" class="d-block mx-auto">
        <div class="card" style="border-style: dashed; border-color: #ced4da;">
            <div class="card-body">
                <h1 class="fs-3 text-center">Login</h1>
                <p class="text-center mb-4">Selamat datang kembali</p>
                <form method="post" action="<?= base_url('login') ?>">
                    <div class="mb-3">
                        <label for="username" class="form-label required">Username</label>
                        <input type="text" class="form-control" id="username" name="username" aria-describedby="usernameHelp" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label required">Password</label>
                        <input type="password" id="password" name="password" class="form-control" aria-describedby="passwordHelpBlock" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>