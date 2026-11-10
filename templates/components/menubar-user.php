<!-- Menubar Pengguna -->
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
</a>

<a href="<?php echo base_url('dashboard/panduan'); ?>" class="sidebar-link <?php if(strpos($hal, 'Panduan') !== false) echo 'active'; ?>">
	<div class="sidebar-link-inner">
		<i class="fas fa-book"></i>
		<span>Panduan</span>
	</div>
</a>
