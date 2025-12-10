<h2><?= $title; ?></h2>

<form action="<?= base_url('metode_bayar/simpan'); ?>" method="post">
    
    <input type="hidden" name="id_metode" value="<?= $metode->id_metode ?? ''; ?>">

    <div class="form-group mb-3">
        <label for="nama_metode">Nama Metode (Contoh: BCA, Dana, OVO)</label>
        <input type="text" name="nama_metode" id="nama_metode" class="form-control" 
               value="<?= set_value('nama_metode', $metode->nama_metode); ?>">
        <?= form_error('nama_metode', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group mb-3">
        <label for="nomor_rekening">Nomor Rekening / ID</label>
        <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control" 
               value="<?= set_value('nomor_rekening', $metode->nomor_rekening); ?>">
        <?= form_error('nomor_rekening', '<small class="text-danger">', '</small>'); ?>
    </div>
    
    <div class="form-group mb-3">
        <label for="atas_nama">Atas Nama</label>
        <input type="text" name="atas_nama" id="atas_nama" class="form-control" 
               value="<?= set_value('atas_nama', $metode->atas_nama); ?>">
        <?= form_error('atas_nama', '<small class="text-danger">', '</small>'); ?>
    </div>

    <button type="submit" class="btn btn-success">Simpan Data</button>
    <a href="<?= base_url('metode_bayar'); ?>" class="btn btn-secondary">Kembali</a>
</form>