<h2>Data Tahapan Proyek</h2>
<a href="<?= base_url('tahapan_proyek/form'); ?>" class="btn btn-primary">➕ Tambah Tahapan Baru</a>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th>Urutan</th>
            <th>Nama Tahapan</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tahapan_proyek as $tahapan): ?>
        <tr>
            <td><?= $tahapan->urutan; ?></td>
            <td><?= $tahapan->nama_tahapan; ?></td>
            <td><?= $tahapan->deskripsi; ?></td>
            <td>
                <a href="<?= base_url('tahapan_proyek/form/' . $tahapan->id_tahapan); ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= base_url('tahapan_proyek/hapus/' . $tahapan->id_tahapan); ?>" 
                   class="btn btn-sm btn-danger" 
                   onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>