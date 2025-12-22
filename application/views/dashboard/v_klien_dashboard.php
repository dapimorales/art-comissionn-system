<div class="container-fluid">
    <h2 class="main-title">👋 Selamat Datang, <?= $user['nama']; ?>!</h2>
    <p class="lead text-muted mb-5">Dashboard ringkasan pesanan komisi karya seni Anda.</p>
    
    <div class="row mb-5">
        <?php 
        $all_counts = []; 
        $total_pesanan = 0;
        foreach($komisi_stats as $stat) {
             $total_pesanan += $stat->total;
             $all_counts[$stat->status_komisi] = $stat->total;
        }

        // Menggabungkan status terkait Pembayaran dan Verifikasi
        $count_pembayaran_aktif = ($all_counts['Pending'] ?? 0) + ($all_counts['Menunggu Verifikasi'] ?? 0) + ($all_counts['Sudah Dibayar'] ?? 0);
        $count_in_progress = $all_counts['In Progress'] ?? 0;
        $count_completed = $all_counts['Completed'] ?? 0;
        ?>

        <div class="col-md-3 mb-4">
            <div class="stat-card card-verification">
                <div class="card-body">
                    <h5 class="card-title">💵 Pembayaran Aktif</h5>
                    <p class="card-text display-4"><?= $count_pembayaran_aktif; ?></p>
                    <a href="<?= base_url('komisi'); ?>" class="text-white">Detail Pembayaran &rarr;</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="stat-card card-progress">
                <div class="card-body">
                    <h5 class="card-title">⏳ Sedang Dikerjakan</h5>
                    <p class="card-text display-4"><?= $count_in_progress; ?></p>
                    <a href="<?= base_url('komisi'); ?>" class="text-white">Lihat Progres &rarr;</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="stat-card card-completed">
                <div class="card-body">
                    <h5 class="card-title">✅ Selesai</h5>
                    <p class="card-text display-4"><?= $count_completed; ?></p>
                    <a href="<?= base_url('komisi'); ?>" class="text-white">Lihat Arsip &rarr;</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
             <div class="stat-card card-total">
                <div class="card-body">
                    <h5 class="card-title">📜 Total Semua Pesanan</h5>
                    <p class="card-text display-4"><?= $total_pesanan; ?></p>
                    <a href="<?= base_url('komisi'); ?>" class="text-white">Riwayat Komisi &rarr;</a>
                </div>
            </div>
        </div>
    </div>
    
    <a href="<?= base_url('komisi/form'); ?>" class="btn btn-lg btn-primary mb-5" style="background-color: #FF6F61; border-color: #FF6F61;">
        ✨ Buat Pesanan Komisi Baru
    </a>
    
    <h3 class="mt-5 mb-4">🎨 Galeri Contoh Karya</h3>
    <p class="text-muted">Lihat berbagai gaya seni yang dapat Anda pesan.</p>
    
    <div class="row portfolio-grid mb-5">
        <div class="col-md-3 mb-4">
            <img src="<?= base_url('assets/portfolio/karya1.jpg'); ?>" class="img-fluid w-100 shadow-sm" alt="Contoh Karya 1">
        </div>
        <div class="col-md-3 mb-4">
            <img src="<?= base_url('assets/portfolio/karya2.jpg'); ?>" class="img-fluid w-100 shadow-sm" alt="Contoh Karya 2">
        </div>
        <div class="col-md-3 mb-4">
            <img src="<?= base_url('assets/portfolio/karya3.jpg'); ?>" class="img-fluid w-100 shadow-sm" alt="Contoh Karya 3">
        </div>
        <div class="col-md-3 mb-4">
            <img src="<?= base_url('assets/portfolio/karya4.jpg'); ?>" class="img-fluid w-100 shadow-sm" alt="Contoh Karya 4">
        </div>
    </div>

    </div>