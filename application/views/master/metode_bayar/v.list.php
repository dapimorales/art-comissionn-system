<h2>Data Metode Pembayaran</h2>
<a href="<?= base_url('metode_bayar/form'); ?>" class="btn btn-primary">➕ Tambah Metode Baru</a>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Metode</th>
            <th>Nomor Rekening / ID</th>
            <th>Atas Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($metode_bayar as $metode): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $metode->nama_metode; ?></td>
            <td><?= $metode->nomor_rekening; ?></td>
            <td><?= $metode->atas_nama; ?></td>
            <td>
                <a href="<?= base_url('metode_bayar/form/' . $metode->id_bayar); ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= base_url('metode_bayar/hapus/' . $metode->id_bayar); ?>" 
                   class="btn btn-sm btn-danger" 
                   onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>