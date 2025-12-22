<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="main-title m-0">Dashboard Overview</h2>
            <p class="text-muted small">Selamat Datang, <?= $user['nama']; ?> (Artist/Admin)</p>
        </div>
        <div>
            <span class="badge badge-gold">Status: Online</span>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card shadow-sm">
                <div class="card-title">⚠️ Verifikasi Pembayaran</div>
                <div class="d-flex align-items-baseline">
                    <div class="display-4"><?= sprintf("%02d", $transaksi_pending); ?></div>
                    <div class="ms-2 text-muted small">Transaksi</div>
                </div>
                <div class="mt-3">
                    <a href="<?= base_url('pembayaran/verifikasi_list'); ?>">Lihat Detail &rarr;</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="stat-card shadow-sm">
                <div class="card-title">⏳ Komisi Berjalan</div>
                <?php 
                    $in_progress = 0;
                    foreach($komisi_stats as $stat) {
                        if ($stat->status_komisi == 'In Progress') $in_progress = $stat->total;
                    }
                ?>
                <div class="d-flex align-items-baseline">
                    <div class="display-4"><?= sprintf("%02d", $in_progress); ?></div>
                    <div class="ms-2 text-muted small">Proyek</div>
                </div>
                <div class="mt-3">
                    <a href="<?= base_url('komisi/list_admin/inprogress'); ?>">Kelola Antrean &rarr;</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="stat-card shadow-sm">
                <div class="card-title">✅ Komisi Selesai</div>
                <?php 
                    $completed = 0;
                    foreach($komisi_stats as $stat) {
                        if ($stat->status_komisi == 'Completed') $completed = $stat->total;
                    }
                ?>
                <div class="d-flex align-items-baseline">
                    <div class="display-4"><?= sprintf("%02d", $completed); ?></div>
                    <div class="ms-2 text-muted small">Karya</div>
                </div>
                <div class="mt-3">
                    <a href="<?= base_url('komisi/list_admin/completed'); ?>">Lihat Arsip &rarr;</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-5">
            <div class="table-box shadow-sm">
                <h6 class="mb-4" style="color: var(--gold-accent); font-weight: 600;">📈 Statistik Status</h6>
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Status Komisi</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($komisi_stats as $stat): ?>
                        <tr>
                            <td><?= $stat->status_komisi; ?></td>
                            <td class="text-end fw-bold"><?= $stat->total; ?> <span class="text-muted small">Pesanan</span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-7">
            <div class="table-box shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="m-0" style="color: var(--gold-accent); font-weight: 600;">⭐ 5 Komisi Terbaru</h6>
                    <button class="btn btn-gold btn-sm" onclick="location.reload();">Refresh</button>
                </div>
                
                <ul class="list-group list-group-flush bg-transparent">
                    <?php 
                    if (!function_exists('get_status_badge_class_admin')) {
                        function get_status_badge_class_admin($status) {
                            switch ($status) {
                                case 'Pending': return 'bg-warning text-dark';
                                case 'Menunggu Verifikasi': return 'bg-danger';
                                case 'In Progress': return 'bg-primary';
                                case 'Completed': return 'bg-success';
                                case 'Sudah Dibayar': return 'bg-info';
                                default: return 'bg-secondary';
                            }
                        }
                    }
                    ?>
                    <?php if (!empty($komisi_terbaru)): ?>
                        <?php foreach ($komisi_terbaru as $komisi): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-secondary px-0 py-3" style="border-bottom: 1px solid rgba(255,255,255,0.05) !important;">
                                <div>
                                    <span class="fw-bold" style="color: var(--gold-accent);">#<?= $komisi->id_komisi; ?></span>
                                    <span class="ms-2 text-white"><?= $komisi->nama_klien; ?></span>
                                    <div class="small text-muted mt-1"><?= $komisi->nama_gaya; ?></div>
                                </div>
                                <div class="text-end">
                                    <span class="badge rounded-pill <?= get_status_badge_class_admin($komisi->status_komisi); ?> mb-2" style="font-size: 10px;">
                                        <?= $komisi->status_komisi; ?>
                                    </span>
                                    <br>
                                    <a href="<?= base_url('progress/detail/' . $komisi->id_komisi); ?>" class="btn btn-outline-warning btn-sm border-0 p-0" style="font-size: 11px;">Update Progres &raquo;</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-center text-muted bg-transparent border-0 py-4">Belum ada pesanan terbaru.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>