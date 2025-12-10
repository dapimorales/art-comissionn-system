<div class="container-fluid">
    <h2>👋 Selamat Datang, <?= $user['nama']; ?>!</h2>
    <p>Lihat status terbaru pesanan komisi karya seni Anda di sini.</p>
    <hr>

    <div class="row mb-4">
        <?php 
        $status_map = [
            'Pending' => ['text' => 'Menunggu Pembayaran', 'color' => 'bg-warning text-dark', 'link' => 'komisi'],
            'Menunggu Verifikasi' => ['text' => 'Menunggu Verifikasi Admin', 'color' => 'bg-danger text-white', 'link' => 'komisi'],
            'In Progress' => ['text' => 'Sedang Dikerjakan', 'color' => 'bg-info text-white', 'link' => 'komisi'],
            'Completed' => ['text' => 'Selesai', 'color' => 'bg-success text-white', 'link' => 'komisi']
        ];
        
        $total_pesanan = 0;
        foreach($komisi_stats as $stat) {
             $total_pesanan += $stat->total;
        }

        foreach ($status_map as $key => $map): ?>
            <?php 
                $count = 0;
                foreach($komisi_stats as $stat) {
                    if ($stat->status_komisi == $key) $count = $stat->total;
                }
            ?>
            <div class="col-md-3">
                <div class="card <?= $map['color']; ?> mb-2">
                    <div class="card-body">
                        <h6 class="card-title"><?= $map['text']; ?></h6>
                        <p class="card-text display-4"><?= $count; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <a href="<?= base_url('komisi/form'); ?>" class="btn btn-primary mb-4">🎨 Buat Pesanan Komisi Baru</a>

    <h3>Riwayat Pesanan Anda (<?= $total_pesanan; ?> Total Pesanan)</h3>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Gaya & Tipe</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($komisi_list)): ?>
                <?php foreach ($komisi_list as $komisi): ?>
                <tr>
                    <td>#<?= $komisi->id_komisi; ?></td>
                    <td><?= $komisi->nama_gaya; ?> - <?= $komisi->nama_tipe; ?></td>
                    <td>Rp <?= number_format($komisi->total_harga, 0, ',', '.'); ?></td>
                    <td><span class="badge <?= $status_map[$komisi->status_komisi]['color']; ?>"><?= $komisi->status_komisi; ?></span></td>
                    <td>
                        <a href="<?= base_url('progress/detail/' . $komisi->id_komisi); ?>" class="btn btn-sm btn-info">Progres/Feedback</a>
                        <?php if ($komisi->status_komisi == 'Pending'): ?>
                            <a href="<?= base_url('pembayaran/form/' . $komisi->id_komisi); ?>" class="btn btn-sm btn-success">Bayar Sekarang</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">Anda belum memiliki riwayat pesanan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>