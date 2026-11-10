<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$userFullname = $this->session->userdata('namalengkap') ?: 'User';
$userLevel    = $this->session->userdata('level') ?: 'Pengguna';
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo htmlspecialchars($hal); ?> - Peminjaman Ruang Meeting PT Medquest Jaya Global</title>
	<link rel="icon" href="<?php echo base_url('assets/img/logo_medquest.png'); ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/linearicons.min.css'); ?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>?v=mq_natural_v2">
	<script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
</head>
<body>

<div class="app-layout">
	<aside class="app-sidebar no-print">
		<a href="<?php echo base_url('dashboard'); ?>" class="sidebar-brand">
			<img src="<?php echo base_url('assets/img/logo_medquest.png'); ?>" alt="Medquest" class="sidebar-logo-centered">
		</a>

		<div class="sidebar-menu">
			<?php echo $menubar; ?>
		</div>

		<div class="sidebar-footer">
			<div style="margin-bottom:6px;">
				<div style="font-weight:600; color:#ffffff;"><?php echo htmlspecialchars($userFullname); ?></div>
				<div style="color:#94a3b8; font-size:11px;"><?php echo htmlspecialchars($userLevel); ?></div>
			</div>
			<a href="<?php echo base_url('dashboard/logout'); ?>" style="color:#cbd5e1; font-size:12px; display:inline-block;"
			   onclick="return confirm('Keluar dari akun?')">
				<i class="fas fa-sign-out-alt" style="margin-right:5px;"></i> Keluar
			</a>
		</div>
	</aside>

	<div class="app-main">
		<header id="main-header" class="app-topbar no-print">
			<div style="display:flex; align-items:center; gap:12px;">
				<button type="button" id="sidebarToggleBtn" class="sidebar-toggle-btn" title="Buka / Tutup Menu">
					<i class="fas fa-bars"></i>
				</button>
				<span style="font-weight:600; color:#334155; font-size:13px;">Sistem Peminjaman Ruang Meeting</span>
			</div>

			<div class="topbar-actions">
				<span style="color:#475569;">
					Login sebagai: <strong style="color:#1e293b;"><?php echo htmlspecialchars($userFullname); ?></strong>
					<span class="mq-dept-badge" style="margin-left:4px;"><?php echo htmlspecialchars($userLevel); ?></span>
				</span>
				<span style="color:#cbd5e1;">|</span>
				<a href="<?php echo base_url('dashboard/logout'); ?>" style="color:#b91c1c; font-weight:600;" onclick="return confirm('Keluar dari sistem?')">
					Keluar
				</a>
			</div>
		</header>

		<main class="app-content">
			<?php if($hal != "Beranda"): ?>
			<div class="cp-header-row no-print">
				<h1 class="cp-page-title"><?php echo htmlspecialchars($hal); ?></h1>

				<div style="display:flex; flex-wrap:wrap; align-items:center; gap:8px;">
					<?php if($hal == "Kelola Akun Pengguna"): ?>
					<div class="button-add">
						<a href="" data-toggle="modal" data-target="#buatuser" data-backdrop="static">+ Tambah Pengguna</a>
					</div>
					<?php endif; ?>

					<?php if($hal == "Kelola Data Ruangan"): ?>
					<div class="button-add">
						<a href="" data-toggle="modal" data-target="#buatruangan" data-backdrop="static">+ Tambah Ruangan</a>
					</div>
					<?php endif; ?>

					<?php if($hal == "Data Peminjaman"): ?>
						<?php if($this->session->userdata('level') == "Admin"): ?>
						<div class="button-datapick">
							<a href="" data-toggle="modal" data-target="#lap-peminjaman" data-backdrop="static">Filter Tanggal</a>
						</div>
						<?php endif; ?>

						<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis', 'Pengguna'), TRUE)): ?>
						<div class="button-add">
							<a href="" data-toggle="modal" data-target="#ajukanpinjam" data-backdrop="static">+ Ajukan Peminjaman</a>
						</div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if($hal == "Riwayat Akses Ruangan"): ?>
						<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE)): ?>
						<div class="button-datapick">
							<a href="<?php echo base_url('dashboard/unduh-akses-ruangan'); ?>">Unduh Data</a>
						</div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if($hal == "Laporan Peminjaman"): ?>
						<?php if($this->session->userdata('level') == "Admin"): ?>
						<div class="button-datapick">
							<a href="" data-toggle="modal" data-target="#unduh-lap-peminjaman" data-backdrop="static">Unduh Laporan</a>
						</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if($hal == "Beranda"): ?>
				<div class="outer-main"><?php echo $content; ?></div>
			<?php else: ?>
				<div class="outer-main">
					<div class="cp-table-card">
						<?php echo $content; ?>
					</div>
				</div>
			<?php endif; ?>
		</main>

		<footer class="mq-footer no-print">
			<div class="mq-footer-main">
				<div class="mq-fluid-bar mq-footer-grid">
					<div class="mq-footer-col">
						<div class="mq-footer-logo-box">
							<img src="<?php echo base_url('assets/img/logo_medquest.png'); ?>" alt="PT Medquest Jaya Global">
						</div>
						<p class="mq-footer-desc">
							PT. Medquest Jaya Global &mdash; Menara Salemba Lt. 6 Zone 1, Jl. Salemba Raya No. 5 - 5A, Jakarta Pusat 10440.
						</p>
						<ul class="mq-footer-contacts">
							<li><i class="fas fa-phone"></i> <span>+62-21 39842961</span></li>
							<li><i class="fas fa-envelope"></i> <a href="mailto:info@medquest.co.id">info@medquest.co.id</a></li>
						</ul>
					</div>

					<div class="mq-footer-col mq-footer-links">
						<h4 class="mq-footer-title">Menu Sistem</h4>
						<ul>
							<li><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
							<li><a href="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>">Ketersediaan Ruangan</a></li>
							<li><a href="<?php echo base_url('dashboard/data-peminjaman'); ?>">Data Peminjaman</a></li>
							<li><a href="<?php echo base_url('dashboard/panduan'); ?>">Panduan Penggunaan</a></li>
						</ul>
					</div>

					<div class="mq-footer-col">
						<h4 class="mq-footer-title">Kontak Operasional</h4>
						<div class="mq-hotline-card">
							<div class="mq-hotline-label">Layanan Internal / General Affairs</div>
							<div class="mq-hotline-number">+62-21-29260000</div>
						</div>
					</div>
				</div>
			</div>
			<div class="mq-footer-bottom">
				<div class="mq-fluid-bar">
					&copy; <?php echo date('Y'); ?> PT Medquest Jaya Global &middot; Sistem Peminjaman Ruang Meeting
				</div>
			</div>
		</footer>
	</div>
</div>

<script>
(function() {
	var layoutEl = document.querySelector('.app-layout');
	var toggleBtn = document.getElementById('sidebarToggleBtn');
	if (!layoutEl || !toggleBtn) return;

	if (localStorage.getItem('mq_sidebar_collapsed') === '1') {
		layoutEl.classList.add('sidebar-collapsed');
	}

	toggleBtn.addEventListener('click', function() {
		layoutEl.classList.toggle('sidebar-collapsed');
		var isCollapsed = layoutEl.classList.contains('sidebar-collapsed');
		localStorage.setItem('mq_sidebar_collapsed', isCollapsed ? '1' : '0');
	});
})();
</script>
</body>
</html>
