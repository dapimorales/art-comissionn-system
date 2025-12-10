<h2>Detail Progres Komisi #<?= $komisi->id_komisi; ?></h2>

<div class="card mb-4">
    <div class="card-header">Info Pesanan</div>
    <div class="card-body">
        <p>Klien: <strong><?= $komisi->nama_klien; ?></strong></p>
        <p>Status Komisi: <span class="badge bg-primary"><?= $komisi->status_komisi; ?></span></p>
        <p>Gaya & Tipe: <?= $komisi->nama_gaya; ?> - <?= $komisi->nama_tipe; ?></p>
        <p>Deskripsi Request: <i><?= $komisi->deskripsi_request; ?></i></p>
    </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
<?php endif; ?>

<?php if ($this->session->userdata('role') == 'admin' && $komisi->status_komisi == 'In Progress'): ?>
<div class="card mb-4 border-info">
    <div class="card-header bg-info text-white">Update Progres Pengerjaan</div>
    <div class="card-body">
        <form action="<?= base_url('progress/update_progress'); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_komisi" value="<?= $komisi->id_komisi; ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <label for="id_tahap">Tahapan Saat Ini</label>
                    <select name="id_tahap" id="id_tahap" class="form-control" required>
                        <?php foreach ($tahapan_proyek as $tahap): ?>
                            <option value="<?= $tahap->id_tahap; ?>" data-urutan="<?= $tahap->urutan; ?>">
                                [Urutan <?= $tahap->urutan; ?>] <?= $tahap->nama_tahap; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="file_preview">Upload Preview (Gambar)</label>
                    <input type="file" name="file_preview" id="file_preview" class="form-control" required>
                </div>
            </div>
            
            <div class="form-group mt-3">
                <label for="catatan_artist">Catatan untuk Klien</label>
                <textarea name="catatan_artist" id="catatan_artist" class="form-control" rows="3" required></textarea>
            </div>
            
            <div class="form-check mt-2">
                <input type="checkbox" name="is_final" value="1" class="form-check-input" id="is_final">
                <label class="form-check-label" for="is_final">Tandai sebagai **Tahapan Final (Selesai)**</label>
            </div>

            <button type="submit" class="btn btn-info mt-3">Upload Progres</button>
        </form>
    </div>
</div>
<?php endif; ?>

<?php if ($this->session->userdata('role') == 'klien' && ($komisi->status_komisi == 'In Progress' || $komisi->status_komisi == 'Completed')): ?>
<div class="card mb-4 border-warning">
    <div class="card-header bg-warning text-dark">Kirim Feedback / Permintaan Revisi</div>
    <div class="card-body">
        <form action="<?= base_url('progress/kirim_feedback'); ?>" method="post">
            <input type="hidden" name="id_komisi" value="<?= $komisi->id_komisi; ?>">
            <div class="form-group">
                <label for="catatan_klien">Catatan Feedback/Revisi</label>
                <textarea name="catatan_klien" id="catatan_klien" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-warning mt-3">Kirim Feedback</button>
        </form>
    </div>
</div>
<?php endif; ?>

---

<h3>Riwayat Progres Pengerjaan</h3>
<div class="row">
    <div class="col-md-7">
        <?php if (empty($riwayat_progress)): ?>
            <p class="alert alert-secondary">Belum ada riwayat progres untuk komisi ini.</p>
        <?php else: ?>
            <?php foreach ($riwayat_progress as $prog): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>[<?= $prog->nama_tahap; ?>]</h5>
                        <p>Catatan: <i><?= $prog->catatan_artist; ?></i></p>
                        <p class="text-muted">Tanggal: <?= date('d M Y H:i', strtotime($prog->tanggal_update)); ?></p>
                        <a href="<?= base_url('assets/preview_progress/' . $prog->file_preview); ?>" target="_blank" class="btn btn-sm btn-info">Lihat Preview</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <div class="col-md-5">
        <h4>Riwayat Feedback Klien</h4>
        <?php if (empty($feedback_list)): ?>
            <p class="alert alert-light">Belum ada feedback dari klien.</p>
        <?php else: ?>
            <?php foreach ($feedback_list as $fb): ?>
                <div class="card mb-2 border-secondary">
                    <div class="card-body p-2">
                        <small class="float-end text-muted"><?= date('d M H:i', strtotime($fb->tanggal_feedback)); ?></small>
                        <p class="mb-0"><strong>Status: </strong> <?= $fb->status_revisi; ?></p>
                        <p class="mb-0 small">"<?= $fb->catatan_klien; ?>"</p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>