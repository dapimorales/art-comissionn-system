<h2>Konfirmasi Pembayaran Komisi #<?= $komisi->id_komisi; ?></h2>

<form action="<?= base_url('pembayaran/proses_konfirmasi'); ?>" method="post">
    <input type="hidden" name="id_komisi" value="<?= $komisi->id_komisi; ?>">
    <input type="hidden" name="jumlah_bayar" value="<?= $komisi->total_harga; ?>"> 
    
    <div class="form-group">
        <label for="id_metode_bayar">Metode Pembayaran yang Dipilih</label>
        <select name="id_metode_bayar" id="id_metode_bayar" class="form-control">
            <option value="">-- Pilih Metode Pembayaran --</option>
            <?php foreach ($metode_bayar as $metode): ?>
                <option value="<?= $metode->id_metode; ?>">
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

            <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
    <a href="<?= base_url('komisi'); ?>" class="btn btn-secondary">Kembali</a>
</form>