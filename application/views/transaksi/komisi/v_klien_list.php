<h2>Riwayat Pesanan Komisi Anda</h2>
<a href="<?= base_url('komisi/form'); ?>" class="btn btn-primary">➕ Buat Pesanan Baru</a>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID Komisi</th>
            <th>Gaya & Tipe</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($komisi_list as $komisi): ?>
        <tr>
            <td>#<?= $komisi->id_komisi; ?></td>
            <td><?= $komisi->nama_gaya; ?> - <?= $komisi->nama_tipe; ?></td>
            <td>Rp <?= number_format($komisi->total_harga, 0, ',', '.'); ?></td>
            <td>
                <span class="badge 
                    <?php 
                        if ($komisi->status_komisi == 'Pending') echo 'bg-warning text-dark';
                        else if ($komisi->status_komisi == 'In Progress') echo 'bg-info';
                        else if ($komisi->status_komisi == 'Completed') echo 'bg-success';
                        else echo 'bg-secondary'; 
                    ?>">
                    <?= $komisi->status_komisi; ?>
                </span>
            </td>
            <td>
                <a href="<?= base_url('komisi/detail/' . $komisi->id_komisi); ?>" class="btn btn-sm btn-info">Detail</a>
                
                <?php if ($komisi->status_komisi == 'Pending'): ?>
                    <a href="<?= base_url('pembayaran/form/' . $komisi->id_komisi); ?>" class="btn btn-sm btn-success">Bayar Sekarang</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>