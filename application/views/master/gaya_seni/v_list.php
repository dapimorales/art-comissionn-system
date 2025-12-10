<h2>Data Gaya Seni</h2>
<a href="<?= base_url('gaya_seni/form'); ?>" class="btn btn-primary">➕ Tambah Gaya Baru</a>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Gaya</th>
            <th>Harga Dasar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($gaya_seni as $gaya): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $gaya->nama_gaya; ?></td>
            <td>Rp <?= number_format($gaya->harga_dasar, 0, ',', '.'); ?></td>
            <td>
                <a href="<?= base_url('gaya_seni/form/' . $gaya->id_gaya); ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= base_url('gaya_seni/hapus/' . $gaya->id_gaya); ?>" 
                   class="btn btn-sm btn-danger" 
                   onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>