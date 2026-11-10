<!-- Menubar Admin -->
<div class="sidebar-section-title">Menu Utama</div>

<a href="<?php echo base_url('dashboard'); ?>" class="sidebar-link <?php if($hal == 'Beranda') echo 'active'; ?>">
	<div class="sidebar-link-inner">
		<i class="fas fa-home"></i>
		<span>Dashboard</span>
	</div>
</a>

<a href="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>" class="sidebar-link <?php if($hal == 'Ketersediaan Ruangan') echo 'active'; ?>">
	<div class="sidebar-link-inner">
		<i class="far fa-calendar-alt"></i>
		<span>Ketersediaan Ruang</span>
	</div>
</a>

<a href="<?php echo base_url('dashboard/data-peminjaman'); ?>" class="sidebar-link <?php if($hal == 'Data Peminjaman' || $hal == 'Laporan Peminjaman') echo 'active'; ?>">
	<div class="sidebar-link-inner">
		<i class="fas fa-list-ul"></i>
		<span>Data Peminjaman</span>
	</div>
	<span id="pending-request-badge" style="font-size:11px; background:#dc2626; color:#fff; padding:1px 6px; font-weight:600; <?php if(empty($jumlah_menunggu)) echo 'display:none;'; ?>">
		<?php echo isset($jumlah_menunggu) ? $jumlah_menunggu : 0; ?>
	</span>
</a>

<div class="sidebar-section-title">Master Data</div>

<a href="<?php echo base_url('dashboard/data-ruangan'); ?>" class="sidebar-link <?php if($hal == 'Kelola Data Ruangan' || $hal == 'Daftar Ruang Meeting') echo 'active'; ?>">
	<div class="sidebar-link-inner">
		<i class="fas fa-building"></i>
		<span>Data Ruangan</span>
	</div>
</a>

<a href="<?php echo base_url('dashboard/akun-pengguna'); ?>" class="sidebar-link <?php if($hal == 'Kelola Akun Pengguna') echo 'active'; ?>">
	<div class="sidebar-link-inner">
		<i class="fas fa-users"></i>
		<span>Akun Pengguna</span>
	</div>
</a>

<a href="<?php echo base_url('dashboard/akses-ruangan'); ?>" class="sidebar-link <?php if($hal == 'Riwayat Akses Ruangan') echo 'active'; ?>">
	<div class="sidebar-link-inner">
		<i class="fas fa-history"></i>
		<span>Riwayat Akses</span>
	</div>
</a>

<a href="<?php echo base_url('dashboard/panduan'); ?>" class="sidebar-link <?php if(strpos($hal, 'Panduan') !== false) echo 'active'; ?>">
	<div class="sidebar-link-inner">
		<i class="fas fa-book"></i>
		<span>Panduan</span>
	</div>
</a>

<script>
(function () {
	var badge = document.getElementById('pending-request-badge');
	if (!badge) return;
	window.setInterval(function () {
		fetch('<?php echo base_url('dashboard/notifikasi-pengajuan'); ?>', {credentials: 'same-origin'})
			.then(function (response) { return response.json(); })
			.then(function (data) {
				badge.textContent = data.jumlah;
				badge.style.display = data.jumlah > 0 ? '' : 'none';
			})
			.catch(function () {});
	}, 30000);
})();
</script>
