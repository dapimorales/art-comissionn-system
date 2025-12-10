<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Komisi Karya Seni'; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        .sidebar {
            height: 100vh;
            background-color: #212529; /* Dark background */
            padding-top: 20px;
        }
        .content {
            padding: 20px;
        }
        .nav-link {
            color: #ccc;
        }
        .nav-link:hover {
            color: #fff;
            background-color: #343a40;
        }
    </style>
</head>
<body>

<?php
    // Ambil data user dari session (asumsi session sudah dimuat di controller)
    $user_role = $this->session->userdata('role');
    $user_name = $this->session->userdata('nama');
?>

<div class="d-flex">
    <div class="sidebar text-white p-3">
        <h4 class="text-center mb-4 border-bottom pb-2">Art Commission App</h4>
        <p class="text-center small text-muted">Role: <strong><?= ucfirst($user_role); ?></strong></p>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard'); ?>">
                    🏠 Dashboard
                </a>
            </li>
            
            <li class="nav-item my-2"><hr class="text-white-50"></li>
            
            <?php if ($user_role == 'admin'): ?>
                <li class="nav-item nav-header text-uppercase small text-white-50 mt-2">Data Master</li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('gaya_seni'); ?>">🖼️ Gaya Seni</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('tipe_komisi'); ?>">👤 Tipe Komisi</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('metode_bayar'); ?>">💳 Metode Bayar</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('tahapan_proyek'); ?>">🏗️ Tahapan Proyek</a></li>

                <li class="nav-item my-2"><hr class="text-white-50"></li>

                <li class="nav-item nav-header text-uppercase small text-white-50 mt-2">Transaksi Admin</li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('pembayaran/verifikasi_list'); ?>">💰 Verifikasi Bayar</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('komisi/list_admin'); ?>">📝 Semua Komisi</a></li>
                
            <?php elseif ($user_role == 'klien'): ?>
                <li class="nav-item nav-header text-uppercase small text-white-50 mt-2">Pesanan Saya</li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('komisi/form'); ?>">➕ Buat Komisi Baru</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('komisi'); ?>">📜 Riwayat Pesanan</a></li>
                
            <?php endif; ?>
            
            <li class="nav-item my-2"><hr class="text-white-50"></li>
            
            <li class="nav-item">
                <a class="nav-link text-danger" href="<?= base_url('auth/logout'); ?>">
                    ➡️ Logout
                </a>
            </li>
        </ul>
    </div>

    <div class="content flex-grow-1">
        <h1 class="mb-4"><?= $title ?? 'Halaman Utama'; ?></h1>
        
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        ```

<!-- ### B. Melengkapi `application/views/layout/v_footer.php`

File ini akan berisi *tag* penutup dan koneksi JavaScript Bootstrap.

```php -->
</div> </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>