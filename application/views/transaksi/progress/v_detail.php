<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0" style="color: var(--text-black);">Detail Progres Komisi #<?= $komisi->id_komisi; ?></h4>
            <p class="text-muted small">Kelola pengerjaan karya dan pantau revisi klien secara real-time.</p>
        </div>
        <a href="<?= base_url('komisi/list_admin/inprogress'); ?>" class="btn btn-sm btn-outline-dark px-3 rounded-pill shadow-sm">
            &larr; Kembali
        </a>
    </div>

    <div class="table-box mb-4 shadow-sm border-0">
        <h6 class="mb-4 d-flex align-items-center" style="color: var(--gold-primary); font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">
            <span class="me-2">📄</span> Info Utama Pesanan
        </h6>
        <div class="row g-3">
            <div class="col-md-3 border-end">
                <div class="px-2">
                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Klien</small>
                    <span class="fw-bold text-dark"><?= $komisi->nama_klien; ?></span>
                </div>
            </div>
            <div class="col-md-3 border-end">
                <div class="px-2">
                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Status Saat Ini</small>
                    <span class="badge rounded-pill bg-primary px-3" style="font-size: 10px;"><?= $komisi->status_komisi; ?></span>
                </div>
            </div>
            <div class="col-md-3 border-end">
                <div class="px-2">
                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Gaya & Tipe</small>
                    <span class="fw-bold text-dark"><?= $komisi->nama_gaya; ?> - <?= $komisi->nama_tipe; ?></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="px-2">
                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Request Deskripsi</small>
                    <span class="small italic text-muted">"<?= $komisi->deskripsi_request; ?>"</span>
                </div>
            </div>
        </div>
    </div>

    <?php if ($this->session->userdata('role') == 'admin' && $komisi->status_komisi == 'In Progress'): ?>
    <div class="table-box mb-5 border-start border-4 border-warning shadow-sm">
        <h6 class="mb-4" style="color: var(--text-black); font-weight: 700;">⚒️ Update Progres Pengerjaan</h6>
        
        <form action="<?= base_url('progress/update_progress'); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_komisi" value="<?= $komisi->id_komisi; ?>">
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-muted">Pilih Tahapan Proyek</label>
                    <select name="id_tahap" class="form-select shadow-none border-0 bg-light p-2" style="font-size: 13px;" required>
                        <option value="">-- Pilih Tahapan --</option>
                        <?php foreach ($tahapan_proyek as $tahap): ?>
                            <option value="<?= $tahap->id_tahap; ?>">
                                [Urutan <?= $tahap->urutan; ?>] <?= $tahap->nama_tahap; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-muted">Upload Preview (Gambar JPG/PNG)</label>
                    <input type="file" name="file_preview" class="form-control shadow-none border-0 bg-light p-2" style="font-size: 13px;" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold small text-muted">Catatan untuk Klien</label>
                    <textarea name="catatan_artist" class="form-control shadow-none border-0 bg-light p-3" style="font-size: 13px;" rows="2" placeholder="Contoh: Sketsa dasar selesai, menunggu konfirmasi revisi..." required></textarea>
                </div>
            </div>
            
            <div class="form-check mt-3 p-3 bg-white rounded border border-warning shadow-sm">
                <input type="checkbox" name="is_final" value="1" class="form-check-input ms-0 me-2" id="is_final" style="width: 1.2em; height: 1.2em; cursor: pointer;">
                <label class="form-check-label fw-bold text-danger small" for="is_final" style="cursor: pointer;">
                    🔥 TANDAI SEBAGAI TAHAPAN FINAL (SELESAI)
                </label>
                <div class="text-muted mt-1" style="font-size: 11px; margin-left: 28px;">
                    Centang ini jika proyek sudah benar-benar selesai. Status utama akan berubah menjadi <strong>Completed</strong>.
                </div>
            </div>

            <button type="submit" class="btn btn-gold btn-sm mt-3 px-4 py-2 fw-bold shadow-sm">Kirim Update Progres</button>
        </form>
    </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-md-7">
            <h6 class="mb-4 fw-bold d-flex align-items-center">
                <span class="me-2" style="color: var(--gold-primary);">📅</span> Riwayat Progres Pengerjaan
            </h6>
            
            <?php if (empty($riwayat_progress)): ?>
                <div class="table-box text-center py-5 border-0 shadow-sm">
                    <p class="text-muted small m-0">Belum ada riwayat progres yang diunggah untuk komisi ini.</p>
                </div>
            <?php else: ?>
                <div class="position-relative">
                    <?php foreach ($riwayat_progress as $prog): ?>
                    <div class="stat-card mb-4 border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <span class="badge badge-gold mb-3 px-3 rounded-pill"><?= $prog->nama_tahap; ?></span>
                                    <small class="text-muted" style="font-size: 10px;">🕒 <?= date('d M Y, H:i', strtotime($prog->tanggal_update)); ?></small>
                                </div>
                                <p class="mb-3 text-dark small fw-medium" style="line-height: 1.6;">"<?= $prog->catatan_artist; ?>"</p>
                                <div class="text-end mt-2">
                                    <a href="<?= base_url('assets/preview_progress/' . $prog->file_preview); ?>" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill px-3" style="font-size: 11px;">
                                        🔍 Lihat Preview Full
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-5">
            <h6 class="mb-4 fw-bold d-flex align-items-center">
                <span class="me-2" style="color: var(--gold-primary);">💬</span> Feedback Klien
            </h6>
            
            <?php if ($this->session->userdata('role') == 'klien' && $komisi->status_komisi != 'Completed'): ?>
                <div class="table-box p-3 mb-4 border-start border-4 border-info shadow-none bg-white">
                    <form action="<?= base_url('progress/kirim_feedback'); ?>" method="post">
                        <input type="hidden" name="id_komisi" value="<?= $komisi->id_komisi; ?>">
                        <label class="fw-bold small mb-2 text-dark">Beri Masukan / Revisi</label>
                        <textarea name="catatan_klien" class="form-control small shadow-none border-0 bg-light p-3" rows="2" placeholder="Tulis feedback Anda di sini..." required></textarea>
                        <button type="submit" class="btn btn-dark btn-sm mt-3 w-100 py-2 shadow-sm" style="font-size: 11px;">Kirim Feedback ke Artist</button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if (empty($feedback_list)): ?>
                <div class="text-center py-5 bg-white rounded border border-dashed small text-muted shadow-sm">
                    Belum ada feedback dari klien.
                </div>
            <?php else: ?>
                <?php foreach ($feedback_list as $fb): ?>
                <div class="p-3 bg-white rounded border-0 shadow-sm mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge <?= ($fb->status_revisi == 'Diterima') ? 'bg-info' : 'bg-secondary'; ?> rounded-pill" style="font-size: 9px;"><?= $fb->status_revisi; ?></span>
                        <small class="text-muted" style="font-size: 10px;"><?= date('d M H:i', strtotime($fb->tanggal_feedback)); ?></small>
                    </div>
                    <p class="mb-0 small text-dark fst-italic" style="line-height: 1.5;">"<?= $fb->catatan_klien; ?>"</p>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>