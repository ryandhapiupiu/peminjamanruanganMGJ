<?php
$totAgenda   = isset($total_agenda) ? (int)$total_agenda : 0;
$totRuang    = isset($total_ruangan) ? (int)$total_ruangan : 0;
$totHariIni  = isset($booking_hari_ini) ? (int)$booking_hari_ini : 0;
$cntMenunggu = isset($status_counts['menunggu']) ? (int)$status_counts['menunggu'] : 0;
$jadwalHariIni = isset($jadwal_hari_ini) ? $jadwal_hari_ini : array();
?>

<div class="cp-header-row no-print">
	<h1 class="cp-page-title">Dashboard Peminjaman Ruang Meeting</h1>
	<div style="display:flex; align-items:center; gap:8px;">
		<a href="<?php echo base_url('dashboard/data-peminjaman'); ?>" class="btn-mq-outline">Data Peminjaman</a>
		<a href="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>" class="btn-mq-primary">+ Pinjam Ruangan</a>
	</div>
</div>

<!-- Ringkasan Data -->
<div class="summary-strip no-print">
	<div class="summary-box">
		<div class="summary-label">Jumlah Ruang Meeting</div>
		<div class="summary-val"><?php echo $totRuang; ?></div>
		<div class="summary-note">Ruangan terdaftar</div>
	</div>
	<div class="summary-box">
		<div class="summary-label">Jadwal Hari Ini</div>
		<div class="summary-val"><?php echo $totHariIni; ?></div>
		<div class="summary-note">Tanggal <?php echo date('d/m/Y'); ?></div>
	</div>
	<div class="summary-box">
		<div class="summary-label">Menunggu Persetujuan</div>
		<div class="summary-val"><?php echo $cntMenunggu; ?></div>
		<div class="summary-note">Pengajuan baru</div>
	</div>
	<div class="summary-box">
		<div class="summary-label">Total Data Peminjaman</div>
		<div class="summary-val"><?php echo $totAgenda; ?></div>
		<div class="summary-note">Seluruh riwayat</div>
	</div>
</div>

<!-- Tabel Jadwal Hari Ini -->
<div class="cp-table-card" style="margin-bottom:14px;">
	<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
		<strong style="color:#212529; font-size:13.5px;">Jadwal Pemakaian Ruang Hari Ini (<?php echo date('d/m/Y'); ?>)</strong>
		<a href="<?php echo base_url('dashboard/data-peminjaman?periode=hari_ini'); ?>" style="font-size:12px;">Lihat Detail &rarr;</a>
	</div>

	<table class="cp-table">
		<thead>
			<tr>
				<th style="width:45px; text-align:center;">No.</th>
				<th style="width:110px;">Jam</th>
				<th style="width:190px;">Ruang Meeting</th>
				<th style="width:220px;">Peminjam / Departemen</th>
				<th>Agenda / Keperluan</th>
				<th style="width:120px; text-align:center;">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php if(empty($jadwalHariIni)): ?>
			<tr>
				<td colspan="6" align="center" style="text-align:center; padding:18px !important; color:#64748b;">
					Belum ada jadwal peminjaman ruang meeting untuk hari ini.
				</td>
			</tr>
			<?php else: ?>
				<?php $no = 1; foreach($jadwalHariIni as $jh): ?>
				<tr>
					<td align="center" style="text-align:center;"><?php echo $no++; ?></td>
					<td><strong><?php echo !empty($jh['jam_meeting']) ? substr($jh['jam_meeting'], 0, 5) . ' WIB' : '-'; ?></strong></td>
					<td><?php echo htmlspecialchars($jh['ruangan_dipinjam']); ?></td>
					<td>
						<?php echo htmlspecialchars(!empty($jh['nama_peminjam']) ? $jh['nama_peminjam'] : $jh['peminjam']); ?>
						<?php if(!empty($jh['departemen_peminjam'])): ?>
							<span style="color:#64748b;">(<?php echo htmlspecialchars($jh['departemen_peminjam']); ?>)</span>
						<?php endif; ?>
					</td>
					<td><?php echo htmlspecialchars($jh['keterangan']); ?></td>
					<td align="center" style="text-align:center;">
						<?php if($jh['status_pinjam'] == 'Menunggu'): ?>
							<span class="badge-status status-menunggu">Menunggu</span>
						<?php elseif($jh['status_pinjam'] == 'Disetujui'): ?>
							<span class="badge-status status-disetujui">Disetujui</span>
						<?php elseif($jh['status_pinjam'] == 'Selesai'): ?>
							<span class="badge-status status-selesai">Selesai</span>
						<?php else: ?>
							<span class="badge-status status-dibatalkan">Dibatalkan</span>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<!-- Tabel Daftar Ruang Meeting -->
<div class="cp-table-card">
	<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
		<strong style="color:#212529; font-size:13.5px;">Daftar Ruang Meeting</strong>
		<?php if($this->session->userdata('level') == 'Admin'): ?>
			<a href="<?php echo base_url('dashboard/data-ruangan'); ?>" style="font-size:12px;">Kelola Ruangan &rarr;</a>
		<?php endif; ?>
	</div>

	<table class="cp-table">
		<thead>
			<tr>
				<th style="width:45px; text-align:center;">No.</th>
				<th style="width:110px;">ID Ruangan</th>
				<th>Nama Ruang Meeting</th>
				<th style="width:130px; text-align:center;">Kapasitas</th>
				<th style="width:130px; text-align:center;">Status</th>
				<th style="width:160px; text-align:center;">Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php if(empty($rooms)): ?>
			<tr>
				<td colspan="6" align="center" style="text-align:center; padding:18px !important; color:#64748b;">
					Belum ada data ruangan.
				</td>
			</tr>
			<?php else: ?>
				<?php $no = 1; foreach ($rooms as $r): ?>
				<tr>
					<td align="center" style="text-align:center;"><?php echo $no++; ?></td>
					<td><?php echo htmlspecialchars($r['id_ruangan']); ?></td>
					<td><strong><?php echo htmlspecialchars($r['nama_ruangan']); ?></strong></td>
					<td align="center" style="text-align:center;"><?php echo (int)$r['kapasitas']; ?> orang</td>
					<td align="center" style="text-align:center;">
						<span class="badge-status status-disetujui"><?php echo htmlspecialchars($r['status']); ?></span>
					</td>
					<td align="center" style="text-align:center;">
						<div class="button-edit">
							<a href="<?php echo base_url('dashboard/ketersediaan-ruangan?ruangan=' . rawurlencode($r['nama_ruangan'])); ?>">Cek Jadwal</a>
						</div>
						<?php if($this->session->userdata('level') == 'Admin'): ?>
						<div class="button-edit">
							<a href="<?php echo base_url('dashboard/qr-ruangan/' . rawurlencode($r['id_ruangan'])); ?>" target="_blank">QR</a>
						</div>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>
