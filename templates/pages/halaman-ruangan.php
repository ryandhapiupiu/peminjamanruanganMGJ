<table class="cp-table">
	<thead>
		<tr>
			<th style="width:50px; text-align:center;">No.</th>
			<th style="width:120px;">ID Ruangan</th>
			<th>Nama Ruang Meeting</th>
			<th style="width:130px; text-align:center;">Kapasitas</th>
			<th style="width:140px; text-align:center;">Status</th>
			<th style="width:210px; text-align:center;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1; foreach ($tb as $baris): ?>
		<tr>
			<td align="center" style="text-align:center;"><?php echo $no; ?></td>
			<td><?php echo htmlspecialchars($baris['id_ruangan']); ?></td>
			<td><strong><?php echo htmlspecialchars($baris['nama_ruangan']); ?></strong></td>
			<td align="center" style="text-align:center;"><?php echo isset($baris['kapasitas']) ? $baris['kapasitas'] . ' orang' : '-'; ?></td>
			<td align="center" style="text-align:center;">
				<span class="badge-status status-disetujui"><?php echo htmlspecialchars($baris['status']); ?></span>
			</td>
			<td align="center" style="text-align:center;">
				<div class="button-edit">
					<a href="<?php echo base_url('dashboard/qr-ruangan/' . rawurlencode($baris['id_ruangan'])); ?>" target="_blank">Cetak QR</a>
				</div>
				<div class="button-edit">
					<a href="" data-toggle="modal" data-target="#suntingruangan<?php echo $baris['id_ruangan']; ?>" data-backdrop="static">Edit</a>
				</div>
				<div class="button-delete">
					<a href="" data-toggle="modal" data-target="#hapusruangan<?php echo $baris['id_ruangan']; ?>" data-backdrop="static">Hapus</a>
				</div>
			</td>
		</tr>
		<?php $no++; endforeach; ?>
	</tbody>
</table>

<!-- Modal Buat Ruangan -->
<div id="buatruangan" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Tambah Ruang Meeting</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/buat-ruangan'); ?>
				<ul>
					<li>
						<div><i class="lnr lnr-tag"></i></div><input type="text" name="id_ruangan" placeholder="ID ruangan" required />
					</li>
					<li>
						<div><i class="lnr lnr-text-format"></i></div><input type="text" name="nama_ruangan" placeholder="Nama ruang meeting" maxlength="50" required />
					</li>
					<li>
						<div><i class="lnr lnr-users"></i></div><input type="number" name="kapasitas" placeholder="Kapasitas (orang)" min="1" required />
					</li>
					<hr />
					<li>
						<input type="submit" name="tombol_tambah" value="Tambah" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<!-- Modal Perbarui Data Ruangan -->
<?php foreach ($tb as $baris): ?>
<div id="suntingruangan<?php echo $baris['id_ruangan']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Edit Data Ruang Meeting</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/perbarui-ruangan'); ?>
				<ul>
					<input type="hidden" name="id_ruangan" value="<?php echo $baris['id_ruangan']; ?>">
					<li>
						<div><i class="lnr lnr-tag"></i></div><input type="text" value="<?php echo $baris['id_ruangan']; ?>" disabled />
					</li>
					<li>
						<div><i class="lnr lnr-text-format"></i></div><input type="text" name="nama_ruangan" placeholder="Nama ruang meeting" maxlength="50" value="<?php echo htmlspecialchars($baris['nama_ruangan']); ?>" required />
					</li>
					<li>
						<div><i class="lnr lnr-users"></i></div><input type="number" name="kapasitas" placeholder="Kapasitas (orang)" min="1" value="<?php echo isset($baris['kapasitas']) ? $baris['kapasitas'] : ''; ?>" required />
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

<!-- Modal Hapus Data Ruangan -->
<?php foreach ($tb as $baris): ?>
<div id="hapusruangan<?php echo $baris['id_ruangan']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Hapus Data Ruangan</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/hapus-ruangan'); ?>
				<ul>
					<input type="hidden" name="id_ruangan" value="<?php echo $baris['id_ruangan']; ?>">
					<li>
						<p>Hapus ruangan <span><?php echo htmlspecialchars($baris['nama_ruangan']); ?></span> dari sistem?</p>
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
