<h2>Data Master Tahapan Proyek</h2>
<a href="<?= base_url('tahapan_proyek/form'); ?>" class="btn btn-primary mb-3">➕ Tambah Tahapan Baru</a>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Urutan</th>
            <th>Nama Tahapan</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        // FIX: Pengecekan data kosong yang aman
        if (!empty($tahapan_proyek)): 
        ?>
            <?php foreach ($tahapan_proyek as $tahapan): ?>
            <tr>
                <td><?= $tahapan->urutan; ?></td>
                <td><?= $tahapan->nama_tahapan; ?></td>
                <td><?= $tahapan->deskripsi; ?></td>
                <td>
                    <a href="<?= base_url('tahapan_proyek/form/' . $tahapan->id_tahap); ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= base_url('tahapan_proyek/hapus/' . $tahapan->id_tahap); ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
             <tr><td colspan="4" class="text-center">Belum ada data tahapan proyek. Klik "Tambah Tahapan Baru" untuk memulai.</td></tr>
        <?php endif; ?>
    </tbody>
</table>