<a href="<?= base_url('metode_bayar/form'); ?>" class="btn btn-primary mb-3">➕ Tambah Metode Baru</a>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Bank / E-Wallet</th>
            <th>Nomor Rekening / ID</th>
            <th>Atas Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1; 
        // FIX: Pengecekan data kosong yang aman
        if (!empty($metode_bayar)):
            foreach ($metode_bayar as $metode): 
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $metode->nama_metode; ?></td>
                <td><?= $metode->nomor_rekening; ?></td>
                <td><?= $metode->atas_nama; ?></td>
                <td>
                    <a href="<?= base_url('metode_bayar/form/' . $metode->id_metode); ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= base_url('metode_bayar/hapus/' . $metode->id_metode); ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php 
            endforeach;
        else: 
        ?>
             <tr><td colspan="5" class="text-center">Belum ada data metode pembayaran. Klik "Tambah Metode Baru" untuk memulai.</td></tr>
        <?php endif; ?>
    </tbody>
</table>