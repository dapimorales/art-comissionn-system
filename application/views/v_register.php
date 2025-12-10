<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Art Commission System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            max-width: 450px;
            margin-top: 50px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 register-container">
            <h3 class="text-center mb-4">Pendaftaran Klien Baru</h3>
            <p class="text-center text-muted small">Mohon isi data diri Anda untuk membuat akun pesanan.</p>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <form action="<?= base_url('auth/proses_register'); ?>" method="post">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= set_value('nama'); ?>" required>
                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email'); ?>" required>
                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                </div>
                
                <div class="mb-3">
                    <label for="passconf" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="passconf" name="passconf" required>
                    <?= form_error('passconf', '<small class="text-danger">', '</small>'); ?>
                </div>
                
                <button type="submit" class="btn btn-success w-100 mt-3">Daftar Sekarang</button>
            </form>
            
            <p class="text-center mt-4">
                Sudah punya akun? <a href="<?= base_url('auth/login'); ?>">Login di sini</a>
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>