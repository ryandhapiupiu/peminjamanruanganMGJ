<table class="cp-table">
	<thead>
		<tr>
			<th style="width:50px; text-align:center;">No.</th>
			<th>Nama Lengkap</th>
			<th>Username</th>
			<th style="width:150px; text-align:center;">Level</th>
			<th style="width:160px; text-align:center;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1; foreach ($tb as $user): ?>
		<tr>
			<td align="center" style="text-align:center;"><?php echo $no; ?></td>
			<td><strong><?php echo htmlspecialchars($user['fullname']); ?></strong></td>
			<td><?php echo htmlspecialchars($user['username']); ?></td>
			<td align="center" style="text-align:center;">
				<span class="mq-dept-badge"><?php echo htmlspecialchars($user['level']); ?></span>
			</td>
			<td align="center" style="text-align:center;">
				<div class="button-edit">
					<a href="" data-toggle="modal" data-target="#suntinguser<?php echo $user['username']; ?>" data-backdrop="static">Edit</a>
				</div>
				<div class="button-delete">
					<a href="" data-toggle="modal" data-target="#hapususer<?php echo $user['username']; ?>" data-backdrop="static">Hapus</a>
				</div>
			</td>
		</tr>
		<?php $no++; endforeach; ?>
	</tbody>
</table>

<!-- Modal Buat User -->
<div id="buatuser" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Tambah Akun Pengguna</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/buat-user'); ?>
				<ul>
					<li>
						<div><i class="lnr lnr-text-format"></i></div><input type="text" name="fullname" placeholder="Nama lengkap" maxlength="25" required />
					</li>
					<li>
						<div><i class="lnr lnr-user"></i></div><input type="text" name="username" placeholder="Username" maxlength="10" required />
					</li>
					<li>
						<div><i class="lnr lnr-lock"></i></div><input type="password" name="password" placeholder="Password" required />
					</li>
					<li>
						<div><i class="lnr lnr-layers"></i></div><select name="level" required="required">
							<option value="" selected>Pilih Level</option>
							<option value="Pengguna">Pengguna</option>
							<option value="Resepsionis">Resepsionis</option>
							<option value="Admin">Admin</option>
						</select>
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

<!-- Modal Perbarui Data User -->
<?php foreach ($tb as $user): ?>
<div id="suntinguser<?php echo $user['username']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Edit Akun Pengguna</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/perbarui-user'); ?>
				<ul>
					<input type="hidden" name="username" value="<?php echo $user['username']; ?>">
					<li>
						<div><i class="lnr lnr-text-format"></i></div><input type="text" name="fullname" placeholder="Nama lengkap" maxlength="25" value="<?php echo htmlspecialchars($user['fullname']); ?>" required />
					</li>
					<li>
						<div><i class="lnr lnr-user"></i></div><input type="text" value="<?php echo $user['username']; ?>" disabled />
					</li>
					<li>
						<div><i class="lnr lnr-layers"></i></div><select name="level" required="required">
							<option value="">Pilih Level</option>
							<option value="Pengguna" <?php if($user['level'] == 'Pengguna') echo 'selected'; ?>>Pengguna</option>
							<option value="Resepsionis" <?php if($user['level'] == 'Resepsionis') echo 'selected'; ?>>Resepsionis</option>
							<option value="Admin" <?php if($user['level'] == 'Admin') echo 'selected'; ?>>Admin</option>
						</select>
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

<!-- Modal Hapus Data User -->
<?php foreach ($tb as $user): ?>
<div id="hapususer<?php echo $user['username']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>Hapus Akun Pengguna</span>
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/hapus-user'); ?>
				<ul>
					<input type="hidden" name="username" value="<?php echo $user['username']; ?>">
					<li>
						<p>Hapus akun <span><?php echo htmlspecialchars($user['fullname']); ?></span> dari sistem?</p>
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
