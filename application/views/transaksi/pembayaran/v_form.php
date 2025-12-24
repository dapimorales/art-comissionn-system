<h2>Konfirmasi Pembayaran Komisi #<?= $komisi->id_komisi; ?></h2>

<form action="<?= base_url('pembayaran/proses_konfirmasi'); ?>"
      method="post"
      enctype="multipart/form-data">

    <input type="hidden" name="id_komisi" value="<?= $komisi->id_komisi; ?>">
    <input type="hidden" name="jumlah_bayar" value="<?= $komisi->total_harga; ?>">

    <!-- METODE PEMBAYARAN -->
    <div class="form-group">
        <label for="id_metode_bayar">Metode Pembayaran</label>
        <select name="id_metode_bayar"
                id="id_metode_bayar"
                class="form-control"
                required>
            <option value="">-- Pilih Metode Pembayaran --</option>
            <?php foreach ($metode_bayar as $metode): ?>
                <option value="<?= $metode->id_metode; ?>">
                    <?= $metode->nama_metode; ?>
                    (<?= $metode->nomor_rekening; ?>
                    a/n <?= $metode->atas_nama; ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <?= form_error('id_metode_bayar', '<small class="text-danger">', '</small>'); ?>
    </div>

    <!-- BUKTI TRANSFER (WAJIB) -->
    <div class="form-group mt-3">
        <label for="bukti_bayar">Bukti Transfer</label>
        <input type="file"
               name="bukti_bayar"
               id="bukti_bayar"
               class="form-control"
               accept="image/png, image/jpeg"
               required>
        <small class="text-muted">
            Upload bukti transfer (JPG / PNG, max 2MB)
        </small>
    </div>

    <br>

    <button type="submit" class="btn btn-success">
        Konfirmasi Pembayaran
    </button>
    <a href="<?= base_url('komisi'); ?>" class="btn btn-secondary">
        Kembali
    </a>
</form>
