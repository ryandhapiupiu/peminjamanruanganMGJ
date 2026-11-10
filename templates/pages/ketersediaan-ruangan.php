<form method="get" action="<?php echo base_url('dashboard/ketersediaan-ruangan'); ?>" class="availability-filter">
	<div class="filter-group">
		<label for="availability-date">Tanggal</label>
		<input id="availability-date" type="date" name="tanggal" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $tanggal; ?>" required>
	</div>
	<div class="filter-group">
		<label for="availability-room">Ruang Meeting</label>
		<select id="availability-room" name="ruangan" required>
			<?php foreach ($tb as $baris): ?>
			<option value="<?php echo htmlspecialchars($baris['nama_ruangan']); ?>" <?php if($nama_ruangan == $baris['nama_ruangan']) echo 'selected'; ?>><?php echo htmlspecialchars($baris['nama_ruangan']); ?><?php if(isset($baris['kapasitas'])) echo ' (' . $baris['kapasitas'] . ' orang)'; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<button type="submit">Lihat Jadwal</button>
</form>

<?php if(empty($tb)): ?>
	<p>Belum ada ruang meeting terdaftar.</p>
<?php else: ?>
	<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:10px;">
		<div>
			<strong style="color:#212529; font-size:14px;"><?php echo htmlspecialchars($nama_ruangan); ?></strong>
			<span style="color:#64748b; margin-left:6px;">Tanggal: <?php echo date('d/m/Y', strtotime($tanggal)); ?></span>
		</div>
		<div style="font-size:12px; color:#64748b;">
			Klik pada jam yang tersedia untuk mengajukan peminjaman.
		</div>
	</div>

	<div class="availability-slots">
		<?php foreach ($slots as $slot): ?>
			<?php $is_booked = in_array($slot, $booked_slots); $is_elapsed = in_array($slot, $elapsed_slots); ?>
			<?php if($is_booked || $is_elapsed): ?>
				<button class="availability-slot unavailable" type="button" disabled>
					<strong><?php echo $slot; ?> - <?php echo date('H:i', strtotime($slot) + 3600); ?></strong>
					<small><?php echo $is_booked ? 'Sudah dipesan' : 'Waktu lewat'; ?></small>
				</button>
			<?php else: ?>
				<a class="availability-slot available" href="<?php echo base_url('dashboard/data-peminjaman?nama_ruangan=' . rawurlencode($nama_ruangan) . '&tanggal_meeting=' . $tanggal . '&jam_meeting=' . rawurlencode($slot)); ?>">
					<strong><?php echo $slot; ?> - <?php echo date('H:i', strtotime($slot) + 3600); ?></strong>
					<small>Tersedia (Pilih)</small>
				</a>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
