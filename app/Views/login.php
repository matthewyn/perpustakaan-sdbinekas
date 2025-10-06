<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center align-items-center" style="min-height: calc(100vh - 67px); background-image: url('<?= base_url('/background.webp') ?>'); background-size: cover; background-position: center;">
  <div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <h1 class="fs-3 text-center">Login</h1>
            <p class="text-center mb-4">Selamat datang kembali</p>
            <div class="mb-3">
                <label for="username" class="form-label required">Username</label>
                <input type="text" class="form-control" id="username" aria-describedby="usernameHelp">
            </div>
            <div class="mb-4">
                <label for="password" class="form-label required">Password</label>
                <input type="password" id="password" class="form-control" aria-describedby="passwordHelpBlock">
            </div>
            <button type="button" class="btn btn-primary w-100">Login</button>
        </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>