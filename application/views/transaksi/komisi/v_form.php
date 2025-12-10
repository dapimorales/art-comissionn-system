<h2>Form Pemesanan Komisi Baru</h2>

<form action="<?= base_url('komisi/proses_pesan'); ?>" method="post">
    
    <div class="form-group">
        <label for="id_gaya">Pilih Gaya Seni</label>
        <select name="id_gaya" id="id_gaya" class="form-control">
            <option value="">-- Pilih Gaya Seni --</option>
            <?php foreach ($gaya_seni as $gaya): ?>
                <option value="<?= $gaya->id_gaya; ?>" data-harga="<?= $gaya->harga_dasar; ?>">
                    <?= $gaya->nama_gaya; ?> (Harga Dasar: Rp <?= number_format($gaya->harga_dasar); ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <?= form_error('id_gaya', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="id_tipe">Pilih Tipe Komisi</label>
        <select name="id_tipe" id="id_tipe" class="form-control">
            <option value="">-- Pilih Tipe Komisi --</option>
            <?php foreach ($tipe_komisi as $tipe): ?>
                <option value="<?= $tipe->id_tipe; ?>" data-tambahan="<?= $tipe->biaya_tambahan; ?>">
                    <?= $tipe->nama_tipe; ?> (Biaya Tambahan: Rp <?= number_format($tipe->biaya_tambahan); ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <?= form_error('id_tipe', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="deskripsi_request">Deskripsi & Detail Request</label>
        <textarea name="deskripsi_request" id="deskripsi_request" class="form-control" rows="5"><?= set_value('deskripsi_request'); ?></textarea>
        <?= form_error('deskripsi_request', '<small class="text-danger">', '</small>'); ?>
    </div>
    
    <hr>
    <p>Perkiraan Total Harga: <strong id="total_display">Rp 0</strong> (Akan dikalkulasi ulang di server)</p>
    <small class="text-info">Pastikan data Master Gaya Seni dan Tipe Komisi sudah terisi, agar harga bisa dihitung.</small>
    
    <button type="submit" class="btn btn-success">Buat Pesanan</button>
    <a href="<?= base_url('komisi'); ?>" class="btn btn-secondary">Batal</a>
</form>

<script>
    // Sederhana JS untuk menampilkan estimasi harga di sisi klien (opsional, harga final dihitung di proses_pesan)
    document.addEventListener('DOMContentLoaded', function() {
        const gayaSelect = document.getElementById('id_gaya');
        const tipeSelect = document.getElementById('id_tipe');
        const totalDisplay = document.getElementById('total_display');

        function updateHarga() {
            let hargaDasar = parseFloat(gayaSelect.options[gayaSelect.selectedIndex].getAttribute('data-harga')) || 0;
            let biayaTambahan = parseFloat(tipeSelect.options[tipeSelect.selectedIndex].getAttribute('data-tambahan')) || 0;
            
            let total = hargaDasar + biayaTambahan;
            totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        gayaSelect.addEventListener('change', updateHarga);
        tipeSelect.addEventListener('change', updateHarga);
    });
</script>