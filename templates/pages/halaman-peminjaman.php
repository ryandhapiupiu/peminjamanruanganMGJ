<?php date_default_timezone_set('Asia/Jakarta'); ?>

<style>
	.btn-action-group {
		display: inline-flex;
		gap: 4px;
		align-items: center;
	}
	.btn-approve {
		background: #059669;
		color: #ffffff !important;
		border: 1px solid #059669;
		padding: 3px 9px;
		font-size: 11.5px;
		font-weight: 600;
		text-decoration: none;
		display: inline-block;
	}
	.btn-approve:hover {
		background: #047857;
		color: #ffffff !important;
	}
	.btn-cancel {
		background: #ffffff;
		color: #b91c1c !important;
		border: 1px solid #fca5a5;
		padding: 3px 9px;
		font-size: 11.5px;
		font-weight: 600;
		text-decoration: none;
		display: inline-block;
	}
	.btn-cancel:hover {
		background: #fef2f2;
		color: #991b1b !important;
	}
	.btn-complete {
		background: #2b579a;
		color: #ffffff !important;
		border: 1px solid #2b579a;
		padding: 3px 9px;
		font-size: 11.5px;
		font-weight: 600;
		text-decoration: none;
		display: inline-block;
	}
	.btn-complete:hover {
		background: #1e3f73;
		color: #ffffff !important;
	}
</style>

<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE) && !empty($jumlah_menunggu)): ?>
<div style="background:#fffbeb; border:1px solid #fde68a; color:#92400e; padding:9px 14px; margin-bottom:12px; font-size:12.5px;">
	Terdapat <strong><?php echo $jumlah_menunggu; ?> pengajuan peminjaman</strong> yang menunggu persetujuan.
</div>
<?php endif; ?>

<?php if($this->session->flashdata('pesan_sukses')): ?>
<div style="background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; padding:9px 14px; margin-bottom:12px; font-size:12.5px;">
	<?php echo $this->session->flashdata('pesan_sukses'); ?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('pesan_error')): ?>
<div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:9px 14px; margin-bottom:12px; font-size:12.5px;">
	<?php echo $this->session->flashdata('pesan_error'); ?>
</div>
<?php endif; ?>

<!-- Filter Bar -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:10px;">
	<div class="cp-pill-group">
		<a href="<?php echo base_url('dashboard/data-peminjaman?periode=semua'); ?>" 
		   class="cp-pill-link <?php echo (!isset($filter_periode) || $filter_periode == 'semua') ? 'active' : ''; ?>">
			Semua Data
		</a>
		<a href="<?php echo base_url('dashboard/data-peminjaman?periode=hari_ini'); ?>" 
		   class="cp-pill-link <?php echo (isset($filter_periode) && $filter_periode == 'hari_ini') ? 'active' : ''; ?>">
			Hari Ini (<?php echo date('d/m'); ?>)
		</a>
		<a href="<?php echo base_url('dashboard/data-peminjaman?periode=kemarin'); ?>" 
		   class="cp-pill-link <?php echo (isset($filter_periode) && $filter_periode == 'kemarin') ? 'active' : ''; ?>">
			Kemarin
		</a>
	</div>

	<div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
		<span style="font-size:12px; color:#64748b;">Total: <strong><?php echo count($tb); ?></strong> data</span>
		<a href="<?php echo base_url('dashboard/ekspor-excel?periode=' . (isset($filter_periode) ? $filter_periode : 'semua')); ?>" target="_blank" class="btn-mq-outline">
			Export CSV
		</a>
		<a href="<?php echo base_url('dashboard/cetak-laporan?periode=' . (isset($filter_periode) ? $filter_periode : 'semua')); ?>" target="_blank" class="btn-mq-outline">
			Cetak Laporan
		</a>
	</div>
</div>

<!-- Tabel Data Peminjaman -->
<table class="cp-table">
	<thead>
		<tr>
			<th style="width:40px; text-align:center;">No.</th>
			<th style="width:95px;">ID</th>
			<th>Peminjam &amp; Departemen</th>
			<th>Ruang Meeting</th>
			<th style="width:145px;">Tanggal &amp; Jam</th>
			<th>Agenda</th>
			<th style="width:100px; text-align:center;">Status</th>
			<th style="width:130px; text-align:center;">Check-In</th>
			<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis', 'Pengguna'), TRUE)): ?>
			<th style="text-align:center; min-width: 155px;">Aksi</th>
			<?php endif; ?>
		</tr>
	</thead>
	<tbody>
		<?php if(empty($tb)): ?>
		<tr>
			<td align="center" colspan="9" style="padding: 24px !important; color:#64748b; text-align:center;">
				Belum ada data peminjaman ruangan.
			</td>
		</tr>
		<?php endif; ?>

		<?php $no = 1; foreach ($tb as $baris): ?>
		<tr>
			<td align="center" style="text-align:center;"><?php echo $no; ?></td>
			<td><?php echo htmlspecialchars($baris['id_peminjaman']); ?></td>
			<td>
				<strong><?php echo htmlspecialchars(!empty($baris['nama_peminjam']) ? $baris['nama_peminjam'] : $baris['peminjam']); ?></strong>
				<?php if(!empty($baris['departemen_peminjam']) || !empty($baris['telepon_peminjam'])): ?>
				<div style="font-size:11px; color:#64748b;">
					<?php echo !empty($baris['departemen_peminjam']) ? htmlspecialchars($baris['departemen_peminjam']) : ''; ?>
					<?php echo !empty($baris['telepon_peminjam']) ? ' - ' . htmlspecialchars($baris['telepon_peminjam']) : ''; ?>
				</div>
				<?php endif; ?>
			</td>
			<td><?php echo htmlspecialchars($baris['ruangan_dipinjam']); ?></td>
			<td>
				<?php if(!empty($baris['tanggal_meeting']) && !empty($baris['jam_meeting'])): ?>
					<?php echo date('d/m/Y', strtotime($baris['tanggal_meeting'])); ?>, <?php echo substr($baris['jam_meeting'], 0, 5); ?>
				<?php else: ?>
					-
				<?php endif; ?>
			</td>
			<td><?php echo htmlspecialchars($baris['keterangan']); ?></td>
			<td align="center" style="text-align:center;">
				<?php if($baris['status_pinjam'] == 'Menunggu'): ?>
					<span class="badge-status status-menunggu">Menunggu</span>
				<?php elseif($baris['status_pinjam'] == 'Disetujui'): ?>
					<span class="badge-status status-disetujui">Disetujui</span>
				<?php elseif($baris['status_pinjam'] == 'Selesai'): ?>
					<span class="badge-status status-selesai">Selesai</span>
				<?php else: ?>
					<span class="badge-status status-dibatalkan">Dibatalkan</span>
				<?php endif; ?>
			</td>
			<td align="center" style="text-align:center;">
				<?php if($baris['status_pinjam'] == 'Disetujui'): ?>
					<?php if(!empty($baris['waktu_checkin'])): ?>
						<span style="color:#065f46; font-size:11.5px; font-weight:600;">
							Hadir (<?php echo date('H:i', strtotime($baris['waktu_checkin'])); ?>)
						</span>
					<?php else: ?>
						<?php 
							$mStart = strtotime($baris['tanggal_meeting'] . ' ' . $baris['jam_meeting']);
							$tolerance = $mStart + 600;
							$now = time();
							$todayDate = date('Y-m-d');
							$isToday = ($baris['tanggal_meeting'] == $todayDate);
						?>
						<?php if(!$isToday || $now < $mStart): ?>
							<span style="color:#64748b; font-size:11px;">Belum mulai</span>
						<?php elseif($now > $tolerance): ?>
							<span style="color:#b91c1c; font-size:11px;">Lewat batas</span>
						<?php else: ?>
							<a href="<?php echo base_url('dashboard/proses-checkin/' . $baris['id_peminjaman']); ?>" class="btn-approve">
								Check-In
							</a>
						<?php endif; ?>
					<?php endif; ?>
				<?php elseif($baris['status_pinjam'] == 'Selesai'): ?>
					<span style="color:#475569; font-size:11.5px;">Selesai</span>
				<?php else: ?>
					<span style="color:#94a3b8;">-</span>
				<?php endif; ?>
			</td>
			<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis', 'Pengguna'), TRUE)): ?>
			<td align="center" style="text-align:center;">
				<div class="btn-action-group">
					<?php if(in_array($this->session->userdata('level'), array('Admin', 'Resepsionis'), TRUE)): ?>
						<?php if($baris['status_pinjam'] == 'Menunggu'): ?>
							<a href="" data-toggle="modal" data-target="#setujui<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static" class="btn-approve">Setujui</a>
							<a href="" data-toggle="modal" data-target="#batalkan<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static" class="btn-cancel">Tolak</a>
						<?php elseif($baris['status_pinjam'] == 'Disetujui'): ?>
							<a href="" data-toggle="modal" data-target="#selesaikan<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static" class="btn-complete">Selesai</a>
							<a href="" data-toggle="modal" data-target="#batalkan<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static" class="btn-cancel">Batal</a>
						<?php endif; ?>
					<?php endif; ?>

					<?php if($this->session->userdata('level') == 'Pengguna' && $baris['status_pinjam'] == 'Menunggu'): ?>
						<a href="" data-toggle="modal" data-target="#batalkan<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static" class="btn-cancel">Batalkan</a>
					<?php endif; ?>

					<?php if($baris['status_pinjam'] == 'Menunggu'): ?>
						<div class="button-edit">
							<a href="" data-toggle="modal" data-target="#suntingpinjam<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static">Edit</a>
						</div>
					<?php endif; ?>

					<?php if(in_array($baris['status_pinjam'], array('Disetujui', 'Selesai'), TRUE)): ?>
						<div class="dropdown" style="display:inline-block;">
							<button class="btn-mq-outline dropdown-toggle" type="button" data-toggle="dropdown" style="font-size:11px; padding:3px 7px;">
								Kalender
							</button>
							<ul class="dropdown-menu dropdown-menu-right" style="font-size:12px; min-width:150px; border:1px solid #cbd5e1; padding:4px 0;">
								<li>
									<a href="<?php echo base_url('dashboard/kalender-google/' . $baris['id_peminjaman']); ?>" target="_blank" style="padding:5px 12px; display:block; color:#212529;">
										Google Calendar
									</a>
								</li>
								<li>
									<a href="<?php echo base_url('dashboard/kalender-ics/' . $baris['id_peminjaman']); ?>" style="padding:5px 12px; display:block; color:#212529;">
										Outlook (.ics)
									</a>
								</li>
							</ul>
						</div>
					<?php endif; ?>

					<?php if($this->session->userdata('level') == 'Admin'): ?>
						<div class="button-delete">
							<a href="" data-toggle="modal" data-target="#hapuspinjam<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static">Hapus</a>
						</div>
					<?php endif; ?>
				</div>
			</td>
			<?php endif; ?>
		</tr>
		<?php $no++; endforeach; ?>
	</tbody>
</table>

<?php
$id_pinjam = "DPK-00001";
foreach($tb_idpinjam as $baris_id) {
	$kode   = (int)substr($baris_id['id_peminjaman'], 4, 5);
	$tambah = $kode + 1;
	if ($tambah < 10) {
		$id_pinjam = "DPK-0000" . $tambah;
	} else {
		$id_pinjam = "DPK-000" . $tambah;
	}
}
?>

<!-- Modal Pengajuan Pinjam Ruang -->
<div id="ajukanpinjam" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Form Pengajuan Peminjaman Ruang</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/pinjam-ruang'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $id_pinjam; ?>">
					<li>
						<div><i class="lnr lnr-tag"></i></div><input type="text" value="<?php echo $id_pinjam; ?>" disabled />
					</li>
					<input type="hidden" name="peminjam" value="<?php echo htmlspecialchars($this->session->userdata('namalengkap')); ?>">
					<input type="hidden" name="waktu_pengajuan" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<div><i class="lnr lnr-user"></i></div><input type="text" name="nama_peminjam" placeholder="Nama peminjam" maxlength="50" value="<?php echo htmlspecialchars($this->session->userdata('namalengkap')); ?>" required />
					</li>
					<li>
						<div><i class="lnr lnr-apartment"></i></div><input type="text" name="departemen_peminjam" placeholder="Departemen / Divisi" maxlength="50" required />
					</li>
					<li>
						<div><i class="lnr lnr-phone-handset"></i></div><input type="tel" name="telepon_peminjam" placeholder="Nomor telepon" maxlength="20" pattern="[0-9+\-\s]{8,20}" required />
					</li>
					<li>
						<div><i class="lnr lnr-layers"></i></div><select name="nama_ruangan" required="required">
							<option value="" selected>Pilih Ruang Meeting</option>
							<?php foreach($tb_ruangan as $baris_ruangan): ?>
								<option value="<?php echo htmlspecialchars($baris_ruangan['nama_ruangan']); ?>" <?php if($selected_room == $baris_ruangan['nama_ruangan']) echo 'selected'; ?>>
									<?php echo htmlspecialchars($baris_ruangan['nama_ruangan']); ?><?php if(isset($baris_ruangan['kapasitas'])) echo ' (' . $baris_ruangan['kapasitas'] . ' orang)'; ?>
								</option>
							<?php endforeach; ?>
						</select>
					</li>
					<li>
						<div><i class="lnr lnr-calendar-full"></i></div><input type="date" name="tanggal_meeting" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $selected_date; ?>" required />
					</li>
					<li>
						<div><i class="lnr lnr-clock"></i></div><select name="jam_meeting" required>
							<option value="">Pilih Jam Meeting</option>
							<?php foreach($booking_slots as $booking_slot): ?>
							<option value="<?php echo $booking_slot; ?>" <?php if(in_array($booking_slot, $occupied_slots)) echo 'disabled'; ?> <?php if($selected_time == $booking_slot && !in_array($booking_slot, $occupied_slots)) echo 'selected'; ?>><?php echo $booking_slot; ?> - <?php echo date('H:i', strtotime($booking_slot) + 3600); ?><?php if(in_array($booking_slot, $occupied_slots)) echo ' (Terisi)'; ?></option>
							<?php endforeach; ?>
						</select>
					</li>
					<li>
						<div><i class="lnr lnr-text-format"></i></div><input type="text" name="keterangan" placeholder="Agenda meeting" maxlength="50" required />
					</li>
					<hr />
					<li>
						<input type="submit" name="tombol_tambah" value="Simpan Pengajuan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>

			<div class="modal-footer">
				<span>Pastikan data telah terisi dengan benar.</span>
			</div>
		</div>
	</div>
</div>

<!-- Modal Sunting -->
<?php foreach ($tb as $baris): ?>
<div id="suntingpinjam<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Edit Agenda Meeting</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/perbarui-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<li>
						<div><i class="lnr lnr-tag"></i></div><input type="text" value="<?php echo $baris['id_peminjaman']; ?>" disabled />
					</li>
					<li>
						<div><i class="lnr lnr-text-format"></i></div><input type="text" name="keterangan" placeholder="Agenda meeting" maxlength="50" value="<?php echo htmlspecialchars($baris['keterangan']); ?>" required />
					</li>
					<hr />
					<li>
						<input type="submit" name="tombol_simpan" value="Simpan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>

<!-- Modal Hapus -->
<?php foreach ($tb as $baris): ?>
<div id="hapuspinjam<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Hapus Data Peminjaman</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/hapus-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<li>
						<p>Hapus data peminjaman <span><?php echo $baris['id_peminjaman']; ?></span> dari sistem?</p>
					</li>
					<hr />
					<li>
						<input type="submit" name="tombol_hapus" value="Hapus" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>

<!-- Modal Setujui -->
<?php foreach ($tb as $baris): ?>
<div id="setujui<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Setujui Peminjaman Ruang</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/setujui-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<input type="hidden" name="waktu_penyetujuan" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<p>Setujui pengajuan <span><?php echo $baris['id_peminjaman']; ?></span> untuk Ruang <?php echo htmlspecialchars($baris['ruangan_dipinjam']); ?>?</p>
					</li>
					<?php foreach($tb_ruangan as $baris_ruangan): ?>
						<?php if($baris_ruangan['status'] == 'Menunggu' && $baris_ruangan['nama_ruangan'] == $baris['ruangan_dipinjam']): ?>
							<input type="hidden" name="id_ruangan" value="<?php echo $baris_ruangan['id_ruangan']; ?>">
						<?php endif; ?>
					<?php endforeach; ?>
					<hr />
					<li>
						<input type="submit" name="tombol_setujui" value="Setujui" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>

<!-- Modal Batalkan -->
<?php foreach ($tb as $baris): ?>
<div id="batalkan<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Batalkan Peminjaman Ruang</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/batalkan-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<input type="hidden" name="waktu_pembatalan" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<p>Batalkan pengajuan <span><?php echo $baris['id_peminjaman']; ?></span> untuk Ruang <?php echo htmlspecialchars($baris['ruangan_dipinjam']); ?>?</p>
					</li>
					<?php foreach($tb_ruangan as $baris_ruangan): ?>
						<?php if($baris_ruangan['status'] == 'Menunggu' && $baris_ruangan['nama_ruangan'] == $baris['ruangan_dipinjam']): ?>
							<input type="hidden" name="id_ruangan" value="<?php echo $baris_ruangan['id_ruangan']; ?>">
						<?php endif; ?>
					<?php endforeach; ?>
					<hr />
					<li>
						<input type="submit" name="tombol_batalkan" value="Batalkan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>

<!-- Modal Selesaikan -->
<?php foreach ($tb as $baris): ?>
<div id="selesaikan<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Selesaikan Peminjaman Ruang</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/selesaikan-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<input type="hidden" name="waktu_pengembalian" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<p>Selesaikan peminjaman <span><?php echo $baris['id_peminjaman']; ?></span> untuk Ruang <?php echo htmlspecialchars($baris['ruangan_dipinjam']); ?>?</p>
					</li>
					<?php foreach($tb_ruangan as $baris_ruangan): ?>
						<?php if($baris_ruangan['status'] == 'Sedang digunakan' && $baris_ruangan['nama_ruangan'] == $baris['ruangan_dipinjam']): ?>
							<input type="hidden" name="id_ruangan" value="<?php echo $baris_ruangan['id_ruangan']; ?>">
						<?php endif; ?>
					<?php endforeach; ?>
					<hr />
					<li>
						<input type="submit" name="tombol_selesaikan" value="Selesaikan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>

<!-- Modal Filter Laporan -->
<div id="lap-peminjaman" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Laporan Peminjaman Ruang</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/laporan-peminjaman'); ?>
				<ul>
					<li>
						<div><i class="lnr lnr-calendar-full"></i></div><input type="text" name="tgl_awal" class="datepicker-report" placeholder="Tanggal awal" required />
					</li>
					<li>
						<div><i class="lnr lnr-calendar-full"></i></div><input type="text" name="tgl_akhir" class="datepicker-report" placeholder="Tanggal akhir" required />
					</li>
					<hr />
					<li>
						<input type="submit" value="Tampilkan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker-report').datepicker({
            format: "yyyy-mm-dd",
            autoclose:true
        });
		<?php if($selected_time): ?>
		$('#ajukanpinjam').modal('show');
		<?php endif; ?>
    });
</script>
