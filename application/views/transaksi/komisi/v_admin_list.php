<h2><?= $title; ?></h2>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Klien</th>
            <th>Gaya/Tipe</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Tanggal Request</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($komisi_list)): ?>
            <?php foreach ($komisi_list as $komisi): ?>
            <tr>
                <td>#<?= $komisi->id_komisi; ?></td>
                <td><?= $komisi->nama_klien; ?></td>
                <td><?= $komisi->nama_gaya; ?> / <?= $komisi->nama_tipe; ?></td>
                <td>Rp <?= number_format($komisi->total_harga, 0, ',', '.'); ?></td>
                <td><span class="badge bg-primary"><?= $komisi->status_komisi; ?></span></td>
                <td><?= date('d M Y', strtotime($komisi->tanggal_request)); ?></td>
                <td>
                    <a href="<?= base_url('progress/detail/' . $komisi->id_komisi); ?>" class="btn btn-sm btn-info">Lihat Progres</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">Tidak ada komisi yang ditemukan dengan status ini.</td></tr>
        <?php endif; ?>
    </tbody>
</table>