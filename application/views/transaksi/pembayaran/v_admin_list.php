<h2>Daftar Verifikasi Pembayaran</h2>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
<?php endif; ?>

<?php if (empty($pembayaran)): ?>
    <div class="alert alert-info">Tidak ada pembayaran yang menunggu verifikasi saat ini.</div>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>ID Komisi</th>
                <th>Nama Klien</th>
                <th>Metode Bayar</th>
                <th>Nominal</th>
                <th>Bukti Transfer</th>
                <th>Aksi Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pembayaran as $item): ?>
            <tr>
                <td>#<?= $item->id_transaksi; ?></td>
                <td><a href="<?= base_url('komisi/detail_admin/' . $item->id_komisi); ?>">#<?= $item->id_komisi; ?></a></td>
                <td><?= $item->nama_klien; ?></td>
                <td><?= $item->nama_metode; ?></td>
                <td>Rp <?= number_format($item->jumlah_bayar, 0, ',', '.'); ?> (Tagihan: Rp <?= number_format($item->total_harga, 0, ',', '.'); ?>)</td>
                <td>
                    <?php if ($item->bukti_bayar == 'N/A'): ?>
                        <span class="badge badge-secondary">Konfirmasi Non-Upload</span>
                    <?php else: ?>
                        <a href="<?= base_url('assets/bukti_bayar/' . $item->bukti_bayar); ?>" target="_blank" class="btn btn-sm btn-secondary">Lihat Bukti</a>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= base_url('pembayaran/proses_verifikasi/' . $item->id_transaksi . '/Lunas'); ?>" 
                       class="btn btn-sm btn-success" 
                       onclick="return confirm('Verifikasi dan Mulai Proyek?')">✔ Lunas</a>
                    <a href="<?= base_url('pembayaran/proses_verifikasi/' . $item->id_transaksi . '/Gagal'); ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Tolak Pembayaran? Status komisi akan kembali Pending.')">✖ Tolak</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>