<h2><?= $title; ?></h2>

<form action="<?= base_url('tahapan_proyek/simpan'); ?>" method="post">
    
    <input type="hidden" name="id_tahap" value="<?= $tahapan->id_tahap ?? ''; ?>">

    <div class="form-group mb-3">
        <label for="urutan">Urutan Tahapan</label>
        <input type="number" name="urutan" id="urutan" class="form-control" 
               value="<?= set_value('urutan', $tahapan->urutan); ?>" placeholder="Contoh: 1, 2, 3">
        <?= form_error('urutan', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group mb-3">
        <label for="nama_tahapan">Nama Tahapan</label>
        <input type="text" name="nama_tahapan" id="nama_tahapan" class="form-control" 
               value="<?= set_value('nama_tahapan', $tahapan->nama_tahapan); ?>">
        <?= form_error('nama_tahapan', '<small class="text-danger">', '</small>'); ?>
    </div>
    
    <div class="form-group mb-3">
        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control"><?= set_value('deskripsi', $tahapan->deskripsi); ?></textarea>
    </div>

    <button type="submit" class="btn btn-success">Simpan Data</button>
    <a href="<?= base_url('tahapan_proyek'); ?>" class="btn btn-secondary">Kembali</a>
</form>