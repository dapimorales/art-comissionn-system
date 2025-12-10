<h2>Data Tipe Komisi</h2>
<a href="<?= base_url('tipe_komisi/form'); ?>" class="btn btn-primary">➕ Tambah Tipe Baru</a>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Tipe</th>
            <th>Biaya Tambahan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($tipe_komisi as $tipe): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $tipe->nama_tipe; ?></td>
            <td>Rp <?= number_format($tipe->biaya_tambahan, 0, ',', '.'); ?></td>
            <td>
                <a href="<?= base_url('tipe_komisi/form/' . $tipe->id_tipe); ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= base_url('tipe_komisi/hapus/' . $tipe->id_tipe); ?>" 
                   class="btn btn-sm btn-danger" 
                   onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>