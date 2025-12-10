<h2>Konfirmasi Pembayaran Komisi #<?= $komisi->id_komisi; ?></h2>

<div class="alert alert-info">
    Total Tagihan: <strong>Rp <?= number_format($komisi->total_harga, 0, ',', '.'); ?></strong>
</div>

<form action="<?= base_url('pembayaran/proses_konfirmasi'); ?>" method="post" enctype="multipart/form-data">
    
    <input type="hidden" name="id_komisi" value="<?= $komisi->id_komisi; ?>">
    <input type="hidden" name="jumlah_bayar" value="<?= $komisi->total_harga; ?>"> <div class="form-group">
        <label for="id_metode_bayar">Metode Pembayaran yang Dipilih</label>
        <select name="id_metode_bayar" id="id_metode_bayar" class="form-control">
            <option value="">-- Pilih Metode Pembayaran --</option>
            <?php foreach ($metode_bayar as $metode): ?>
                <option value="<?= $metode->id_bayar; ?>">
                    <?= $metode->nama_metode; ?> (<?= $metode->nomor_rekening; ?> a/n <?= $metode->atas_nama; ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <?= form_error('id_metode_bayar', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="tanggal_bayar">Tanggal Transfer</label>
        <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control" value="<?= date('Y-m-d'); ?>">
        <?= form_error('tanggal_bayar', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="bukti_bayar">Upload Bukti Transfer (Gambar JPG/PNG max 2MB)</label>
        <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-control" required>
        <?php if ($this->session->flashdata('error')): ?>
            <small class="text-danger"><?= $this->session->flashdata('error'); ?></small>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
    <a href="<?= base_url('komisi'); ?>" class="btn btn-secondary">Kembali</a>
</form>