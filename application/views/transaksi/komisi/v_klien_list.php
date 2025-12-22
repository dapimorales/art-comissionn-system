<div class="container-fluid">
    <div class="card shadow-sm table-responsive">
        <div class="card-body">
            <a href="<?= base_url('komisi/form'); ?>" class="btn btn-lg mb-4" 
               style="background-color: #FF6F61; border-color: #FF6F61; color: white;">
               ➕ Buat Pesanan Baru
            </a>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (empty($komisi_list)): ?>
                <div class="alert alert-info text-center">
                    Tidak ada pesanan komisi yang ditemukan.
                </div>
            <?php else: ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID Komisi</th>
                            <th>Gaya & Tipe</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Helper status untuk badge
                        function get_klien_badge_class_list($status) {
                            switch ($status) {
                                case 'Pending':
                                    return 'bg-warning text-dark';
                                case 'Menunggu Verifikasi':
                                case 'Sudah Dibayar':
                                    return 'bg-info';
                                case 'In Progress':
                                    return 'bg-primary';
                                case 'Completed':
                                    return 'bg-success';
                                default:
                                    return 'bg-secondary';
                            }
                        }
                        ?>
                        <?php foreach ($komisi_list as $komisi): ?>
                        <tr>
                            <td>#<?= $komisi->id_komisi; ?></td>
                            <td><?= $komisi->nama_gaya; ?> - <?= $komisi->nama_tipe; ?></td>
                            <td>Rp <?= number_format($komisi->total_harga, 0, ',', '.'); ?></td>
                            <td>
                                <span class="badge rounded-pill <?= get_klien_badge_class_list($komisi->status_komisi); ?>">
                                    <?= $komisi->status_komisi; ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('progress/detail/' . $komisi->id_komisi); ?>" class="btn btn-sm btn-info">Progres/Feedback</a>
                                
                                <?php if ($komisi->status_komisi == 'Pending'): ?>
                                    <a href="<?= base_url('pembayaran/form/' . $komisi->id_komisi); ?>" class="btn btn-sm btn-success">Bayar Sekarang</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <?php endif; ?>

        </div>
    </div>
</div>