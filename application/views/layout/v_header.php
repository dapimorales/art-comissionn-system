<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Komisi Karya Seni'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        :root {
            --light-bg: #f8f9fa;      
            --sidebar-dark: #111111;  
            --gold-primary: #B8860B;  
            --text-black: #1a1a1a;    
            --text-grey: #666666;     
        }

        body {
            background-color: var(--light-bg);
            color: var(--text-black);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
        }

        /* Sidebar Styling */
        .sidebar {
            min-height: 100vh;
            background-color: var(--sidebar-dark) !important;
            width: 240px;
            padding: 25px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar .nav-link {
            color: #999 !important; 
            padding: 12px 25px;
            font-size: 13px;
            text-decoration: none !important;
            display: block;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #D4AF37 !important;
            background: rgba(211, 175, 55, 0.1) !important;
            border-left: 4px solid #D4AF37;
        }

        .app-title {
            font-size: 1.1rem;
            color: #D4AF37;
            text-align: center;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        /* Card & Box Dimension */
        .stat-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05), 0 2px 6px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(184, 134, 11, 0.15);
            border-color: rgba(184, 134, 11, 0.2);
        }

        .table-box {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.05);
            margin-top: 25px;
        }

        .menu-label {
            color: #666 !important;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 0 25px;
            margin-top: 25px;
            margin-bottom: 10px;
            display: block;
        }

        .content { padding: 40px 50px; }

        /* Print Optimization */
        @media print {
            .sidebar, .d-print-none { display: none !important; }
            .content { padding: 0 !important; margin: 0 !important; }
            body { background-color: white !important; }
        }
    </style>
</head>
<body>

<?php
    $user_role = $this->session->userdata('role');
    $user_name = $this->session->userdata('nama');
?>

<div class="d-flex">
    <div class="sidebar">
        <h4 class="app-title">Art Commission</h4>
        <div class="px-4 mb-4">
            <p class="m-0" style="color: #666; font-size: 11px;">LOGGED IN AS</p>
            <p class="fw-bold m-0" style="color: #D4AF37;"><?= $user_name; ?></p>
        </div>
        <hr style="border-color: rgba(255,255,255,0.1)">
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard'); ?>">🏠 Dashboard</a>
            </li>
            
            <?php if ($user_role == 'admin'): ?>
                <span class="menu-label">Admin Panel</span>
                <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(2) == 'verifikasi_list') ? 'active' : '' ?>" href="<?= base_url('pembayaran/verifikasi_list'); ?>">💰 Verifikasi Bayar</a></li>
                <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(3) == 'inprogress') ? 'active' : '' ?>" href="<?= base_url('komisi/list_admin/inprogress'); ?>">🔨 Kelola Komisi</a></li>
                <li class="nav-item"><a class="nav-link <?= ($this->uri->segment(3) == 'completed') ? 'active' : '' ?>" href="<?= base_url('komisi/list_admin/completed'); ?>">📦 Arsip Selesai</a></li>
                
                <li class="nav-item mt-1">
                    <a class="nav-link <?= ($this->uri->segment(1) == 'laporan') ? 'active' : '' ?>" href="<?= base_url('laporan'); ?>">📊 Laporan Transaksi</a>
                </li>

                <span class="menu-label">Data Master</span>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('gaya_seni'); ?>">🎨 Gaya Seni</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('tipe_komisi'); ?>">🖼️ Tipe Komisi</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('metode_bayar'); ?>">💳 Metode Bayar</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('tahapan_proyek'); ?>">✅ Tahapan Proyek</a></li>
            <?php else: ?>
                <span class="menu-label">Pesanan Saya</span>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('komisi/form'); ?>">➕ Buat Komisi Baru</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('komisi'); ?>">📜 Riwayat Pesanan</a></li>
            <?php endif; ?>
            
            <li class="nav-item mt-4">
                <a class="nav-link text-danger" href="<?= base_url('auth/logout'); ?>">➡️ Logout</a>
            </li>
        </ul>
    </div>

    <div class="content flex-grow-1">