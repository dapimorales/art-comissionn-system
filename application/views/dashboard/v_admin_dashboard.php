<div class="container-fluid">
    <h2>👋 Selamat Datang, <?= $user['nama']; ?> (Admin/Artist)!</h2>
    <hr>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">⚠️ Pembayaran Menunggu Verifikasi</h5>
                    <p class="card-text display-4"><?= $transaksi_pending; ?></p>
                    <a href="<?= base_url('pembayaran/verifikasi_list'); ?>" class="text-white">Lihat Detail &rarr;</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">⏳ Komisi Sedang Berjalan</h5>
                    <?php 
                        $in_progress = 0;
                        foreach($komisi_stats as $stat) {
                            if ($stat->status_komisi == 'In Progress') $in_progress = $stat->total;
                        }
                    ?>
                    <p class="card-text display-4"><?= $in_progress; ?></p>
                    <a href="<?= base_url('komisi/list_admin/inprogress'); ?>" class="text-white">Kelola Progres &rarr;</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">✅ Komisi Selesai</h5>
                    <?php 
                        $completed = 0;
                        foreach($komisi_stats as $stat) {
                            if ($stat->status_komisi == 'Completed') $completed = $stat->total;
                        }
                    ?>
                    <p class="card-text display-4"><?= $completed; ?></p>
                    <a href="<?= base_url('komisi/list_admin/completed'); ?>" class="text-white">Lihat Arsip &rarr;</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <h3>📈 Statistik Status Komisi</h3>
            <table class="table table-bordered">
                <?php foreach($komisi_stats as $stat): ?>
                <tr>
                    <td><?= $stat->status_komisi; ?></td>
                    <td><?= $stat->total; ?> Pesanan</td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="col-md-6">
            <h3>⭐ 5 Komisi Terbaru</h3>
            <ul class="list-group">
                <?php if (!empty($komisi_terbaru)): ?>
                    <?php foreach ($komisi_terbaru as $komisi): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            #<?= $komisi->id_komisi; ?> (<?= $komisi->nama_klien; ?>) - <?= $komisi->nama_gaya; ?>
                            <a href="<?= base_url('progress/detail/' . $komisi->id_komisi); ?>" class="badge bg-primary rounded-pill"><?= $komisi->status_komisi; ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">Belum ada pesanan komisi.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>