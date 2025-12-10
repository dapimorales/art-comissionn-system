<h2><?= $title; ?></h2>

<form action="<?= base_url('tipe_komisi/simpan'); ?>" method="post">
    
    <input type="hidden" name="id_tipe" value="<?= $tipe->id_tipe ?? ''; ?>">

    <div class="form-group">
        <label for="nama_tipe">Nama Tipe Komisi</label>
        <input type="text" name="nama_tipe" id="nama_tipe" class="form-control" 
               value="<?= set_value('nama_tipe', $tipe->nama_tipe); ?>">
        <?= form_error('nama_tipe', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="biaya_tambahan">Biaya Tambahan (Rp)</label>
        <input type="number" name="biaya_tambahan" id="biaya_tambahan" class="form-control" 
               value="<?= set_value('biaya_tambahan', $tipe->biaya_tambahan); ?>">
        <?= form_error('biaya_tambahan', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi Tipe</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control"><?= set_value('deskripsi', $tipe->deskripsi); ?></textarea>
    </div>

    <button type="submit" class="btn btn-success">Simpan Data</button>
    <a href="<?= base_url('tipe_komisi'); ?>" class="btn btn-secondary">Kembali</a>
</form>