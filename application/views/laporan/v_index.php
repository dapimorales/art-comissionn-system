<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0" style="color: var(--text-black);">Laporan Transaksi Art Commission</h4>
            <p class="text-muted small">Kelola data pendapatan dan pantau antrean pesanan secara mendetail.</p>
        </div>
        <div class="d-print-none"> 
            <button onclick="exportTableToExcel('areaLaporan', 'Laporan-Art-Commission')" class="btn btn-sm btn-success shadow-sm px-3">📊 Excel</button>
            <button onclick="window.print()" class="btn btn-sm btn-danger shadow-sm px-3 ms-2">📕 Cetak PDF</button>
        </div>
    </div>

    <div class="table-box shadow-sm border-0 mb-4 p-4 d-print-none">
        <form action="<?= base_url('laporan'); ?>" method="get" class="row align-items-end g-3">
            <div class="col-md-3">
                <label class="small fw-bold text-muted mb-1" style="font-size: 10px;">DARI TANGGAL</label>
                <input type="date" name="tgl_awal" class="form-control form-control-sm border-0 bg-light shadow-none" value="<?= $this->input->get('tgl_awal'); ?>">
            </div>
            <div class="col-md-3">
                <label class="small fw-bold text-muted mb-1" style="font-size: 10px;">SAMPAI TANGGAL</label>
                <input type="date" name="tgl_akhir" class="form-control form-control-sm border-0 bg-light shadow-none" value="<?= $this->input->get('tgl_akhir'); ?>">
            </div>
            <div class="col-md-3">
                <label class="small fw-bold text-muted mb-1" style="font-size: 10px;">STATUS PESANAN</label>
                <select name="status" class="form-select form-select-sm border-0 bg-light shadow-none">
                    <option value="">-- Semua Status --</option>
                    <option value="Pending" <?= ($this->input->get('status') == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="In Progress" <?= ($this->input->get('status') == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                    <option value="Completed" <?= ($this->input->get('status') == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <button type="submit" class="btn btn-sm btn-dark px-3 shadow-sm">🔍 Filter Laporan</button>
                <a href="<?= base_url('laporan'); ?>" class="btn btn-sm btn-outline-secondary px-3 shadow-sm ms-1">🔄 Reset</a>
            </div>
        </form>
    </div>

    <div id="areaLaporan">
        <div class="d-none d-print-block mb-4 p-2 border-bottom">
            <h5 class="fw-bold">Laporan Transaksi Art Commission</h5>
            <p class="small m-0">
                Periode: <?= $this->input->get('tgl_awal') ? date('d M Y', strtotime($this->input->get('tgl_awal'))) : 'Semua Waktu'; ?> s/d <?= $this->input->get('tgl_akhir') ? date('d M Y', strtotime($this->input->get('tgl_akhir'))) : 'Sekarang'; ?>
                | Status: <b><?= $this->input->get('status') ? $this->input->get('status') : 'Semua Status'; ?></b>
            </p>
        </div>

        <?php if(!$this->input->get('status') || $this->input->get('status') == 'Completed'): ?>
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="stat-card shadow-sm border-0">
                    <div class="card-title" style="font-size: 10px; font-weight: 700; color: #888;">TOTAL PENDAPATAN (COMPLETED)</div>
                    <div class="display-4" style="color: var(--gold-primary); font-size: 2rem; font-weight: 800;">
                        Rp <?= number_format($total_pendapatan ?? 0, 0, ',', '.'); ?>
                    </div>
                    <small class="text-muted" style="font-size: 10px;">*Dihitung dari pesanan berstatus <b>Completed</b></small>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if(!$this->input->get('status') || $this->input->get('status') == 'Completed'): ?>
        <h6 class="fw-bold mb-3" style="color: var(--gold-primary); letter-spacing: 1px; font-size: 12px;">✅ PESANAN SELESAI (OMZET)</h6>
        <div class="table-box shadow-sm border-0 mb-5">
            <table class="table align-middle" style="font-size: 13px;">
                <thead>
                    <tr style="color: #888; text-transform: uppercase; font-size: 11px;">
                        <th>ID</th>
                        <th>Klien</th>
                        <th>Gaya & Tipe</th>
                        <th>Harga</th>
                        <th class="text-end">Tanggal Request</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($laporan_selesai)): ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted small">Tidak ada data transaksi selesai.</td></tr>
                    <?php else: ?>
                        <?php foreach($laporan_selesai as $row): ?>
                        <tr>
                            <td class="text-muted fw-bold">#<?= $row->id_komisi; ?></td>
                            <td class="fw-bold text-dark"><?= $row->nama_klien; ?></td>
                            <td><?= $row->nama_gaya; ?> - <?= $row->nama_tipe; ?></td>
                            <td class="fw-bold text-success">Rp <?= number_format($row->total_harga, 0, ',', '.'); ?></td>
                            <td class="text-end text-muted small"><?= date('d M Y', strtotime($row->tanggal_request)); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <?php if(!$this->input->get('status') || $this->input->get('status') != 'Completed'): ?>
        <h6 class="fw-bold mb-3" style="color: #666; letter-spacing: 1px; font-size: 12px;">⏳ RINGKASAN ANTREAN & PENDING</h6>
        <div class="table-box shadow-sm border-0">
            <table class="table align-middle" style="font-size: 13px;">
                <thead>
                    <tr style="color: #888; text-transform: uppercase; font-size: 11px;">
                        <th>ID</th>
                        <th>Klien</th>
                        <th>Gaya & Tipe</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Potensi Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($laporan_antrean)): ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted small">Tidak ada antrean pesanan aktif.</td></tr>
                    <?php else: ?>
                        <?php foreach($laporan_antrean as $antre): ?>
                        <tr>
                            <td class="text-muted">#<?= $antre->id_komisi; ?></td>
                            <td class="fw-bold"><?= $antre->nama_klien; ?></td>
                            <td><?= $antre->nama_gaya; ?></td>
                            <td class="text-center">
                                <span class="badge rounded-pill <?= ($antre->status_komisi == 'Pending') ? 'bg-light text-danger border' : 'bg-light text-primary border'; ?>" style="font-size: 9px;">
                                    <?= $antre->status_komisi; ?>
                                </span>
                            </td>
                            <td class="text-end fw-bold">Rp <?= number_format($antre->total_harga, 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function exportTableToExcel(areaID, filename = ''){
    var areaSelect = document.getElementById(areaID);
    var areaHTML = areaSelect.outerHTML;
    var uri = 'data:application/vnd.ms-excel;base64,';
    var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><style>table { border-collapse: collapse; } th, td { border: 0.5pt solid #000; padding: 5px; font-family: Arial; font-size: 10pt; } th { background: #f2f2f2; font-weight: bold; }</style></head><body>{table}</body></html>';
    var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
    var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) };
    var ctx = { worksheet: 'Laporan', table: areaHTML };
    var link = document.createElement("a");
    link.href = uri + base64(format(template, ctx));
    link.download = filename + '.xls';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

<style>
@media print {
    .sidebar, .d-print-none, hr { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .table-box, .stat-card { box-shadow: none !important; border: 1px solid #ddd !important; }
    body { background-color: white !important; }
}
</style>