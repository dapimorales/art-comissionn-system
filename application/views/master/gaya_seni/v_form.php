<h2><?= $title; ?></h2>

<form action="<?= base_url('gaya_seni/simpan'); ?>" method="post">
    
    <input type="hidden" name="id_gaya" value="<?= $gaya->id_gaya ?? ''; ?>">

    <div class="form-group">
        <label for="nama_gaya">Nama Gaya Seni</label>
        <input type="text" name="nama_gaya" id="nama_gaya" class="form-control" 
               value="<?= set_value('nama_gaya', $gaya->nama_gaya); ?>">
        <?= form_error('nama_gaya', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="harga_dasar">Harga Dasar (Rp)</label>
        <input type="number" name="harga_dasar" id="harga_dasar" class="form-control" 
               value="<?= set_value('harga_dasar', $gaya->harga_dasar); ?>">
        <?= form_error('harga_dasar', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control"><?= set_value('deskripsi', $gaya->deskripsi); ?></textarea>
    </div>

    <button type="submit" class="btn btn-success">Simpan Data</button>
    <a href="<?= base_url('gaya_seni'); ?>" class="btn btn-secondary">Kembali</a>
</form>