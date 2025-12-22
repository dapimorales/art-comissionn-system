<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0" style="color: var(--text-black);">Laporan Transaksi Art Commission</h4>
            <p class="text-muted small">Data keseluruhan pendapatan dari pesanan yang selesai.</p>
        </div>
        <div class="d-print-none"> <button onclick="exportTableToExcel('tabelLaporan', 'Laporan-Komisi')" class="btn btn-sm btn-success shadow-sm px-3">📊 Excel</button>
            <button onclick="window.print()" class="btn btn-sm btn-danger shadow-sm px-3 ms-2">📕 Cetak PDF</button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card shadow-sm border-0">
                <div class="card-title" style="font-size: 10px; font-weight: 700; color: #888;">TOTAL PENDAPATAN (COMPLETED)</div>
                <div class="display-4" style="color: var(--gold-primary); font-size: 2rem; font-weight: 800;">
                    Rp <?= number_format($total_pendapatan ?? 0, 0, ',', '.'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="table-box shadow-sm border-0" id="tabelLaporan">
        <table class="table align-middle" style="font-size: 13px;">
            <thead>
                <tr style="color: var(--gold-primary); text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">
                    <th>ID</th>
                    <th>Klien</th>
                    <th>Gaya & Tipe</th>
                    <th>Harga</th>
                    <th class="text-center">Status</th>
                    <th class="text-end">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($laporan as $row): ?>
                <tr>
                    <td class="text-muted fw-bold">#<?= $row->id_komisi; ?></td>
                    <td class="fw-bold text-dark"><?= $row->nama_klien; ?></td>
                    <td><?= $row->nama_gaya; ?> - <?= $row->nama_tipe; ?></td>
                    <td class="fw-bold text-success">Rp <?= number_format($row->total_harga, 0, ',', '.'); ?></td>
                    <td class="text-center">
                        <span class="badge rounded-pill bg-light text-dark border shadow-sm" style="font-size: 10px;">
                            <?= $row->status_komisi; ?>
                        </span>
                    </td>
                    <td class="text-end text-muted small"><?= date('d M Y', strtotime($row->tanggal_request)); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function exportTableToExcel(tableID, filename = ''){
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML;

    var uri = 'data:application/vnd.ms-excel;base64,';
    
    // TEMPLATE XML DENGAN STYLE BORDER & PADDING
    var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">' +
    '<head>' +
    '' +
    '<style>' +
    'table { border-collapse: collapse; } ' + // Menyatukan garis border
    'th, td { border: 0.5pt solid #000000; padding: 5px; } ' + // Memberikan border hitam dan jarak teks
    'th { background-color: #f2f2f2; font-weight: bold; } ' + // Memberikan warna latar pada judul kolom
    '</style>' +
    '<meta http-equiv="content-type" content="text/plain; charset=UTF-8">' +
    '</head>' +
    '<body><table>{table}</table></body></html>';
    
    var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
    var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) };

    var ctx = {
        worksheet: filename || 'Laporan',
        table: tableHTML
    };

    var link = document.createElement("a");
    link.href = uri + base64(format(template, ctx));
    link.download = (filename ? filename + '.xls' : 'Laporan_Komisi.xls');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

<style>
/* CSS khusus untuk mempercantik hasil print PDF */
@media print {
    .sidebar, .d-print-none, hr { display: none !important; }
    .content { padding: 0 !important; margin: 0 !important; }
    .table-box { box-shadow: none !important; border: 1px solid #ddd !important; }
    body { background-color: white !important; }
}
</style>