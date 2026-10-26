<?php date_default_timezone_set('Asia/Jakarta'); ?>

<?php if($this->session->userdata('level') == 'Admin' && !empty($jumlah_menunggu)): ?>
<div class="alert alert-warning" role="status">
	Ada <?php echo $jumlah_menunggu; ?> pengajuan peminjaman yang menunggu persetujuan Admin.
</div>
<?php endif; ?>

<!-- Daftar Data Peminjaman Ruang [Awal] -->
<table>
	<tr>
		<th>No.</th>
		<th>ID Peminjaman</th>
		<th>Pengguna</th>
		<th>Ruang</th>
		<th>Jadwal Meeting</th>
		<th>Agenda Meeting</th>
		<th>Waktu Pengajuan</th>
		<th>Persetujuan Admin</th>
		<th>Status <br />Peminjaman</th>
		<?php if(in_array($this->session->userdata('level'), array('Admin', 'Pengguna'), TRUE)): ?>
		<th>Aksi</th>
		<?php endif; ?>
	</tr>
 	
 	<?php if(empty($tb)): ?>
	<tr>
		<td align="center" colspan="10">Tidak ada data peminjaman.</td>
	</tr>
 	<?php endif; ?>

	<?php $no = 1; foreach ($tb as $baris): ?>
	<tr>
		<td align="center"><?php echo $no; ?></td>
		<td align="center"><?php echo $baris['id_peminjaman']; ?></td>
		<td><?php echo $baris['peminjam']; ?></td>
		<td align="center"><?php echo $baris['ruangan_dipinjam']; ?></td>
		<td align="center"><?php echo !empty($baris['tanggal_meeting']) && !empty($baris['jam_meeting']) ? date('d/m/Y', strtotime($baris['tanggal_meeting'])) . ' ' . substr($baris['jam_meeting'], 0, 5) : '-'; ?></td>
		<td><?php echo $baris['keterangan']; ?></td>
		<td align="center"><?php echo date('d/m/Y H:i', strtotime($baris['waktu_pengajuan'])); ?></td>
		<td align="center">
			<?php if($baris['status_pinjam'] == 'Menunggu'): ?>
				Menunggu admin
			<?php elseif($baris['status_pinjam'] == 'Dibatalkan'): ?>
				Dibatalkan
			<?php else: ?>
				Disetujui admin
			<?php endif; ?>
		</td>
		<td align="center">
			<div>
				<?php echo $baris['status_pinjam']; ?>

				<?php if($this->session->userdata('level') == "Admin" OR $this->session->userdata('level') == "Pengguna"): ?>
					<?php if($baris['status_pinjam'] == 'Menunggu' OR $baris['status_pinjam'] == 'Disetujui' && $this->session->userdata('level') == "Admin"): ?>

						<a class="dropdown-status" id="dropdown-status" data-toggle="dropdown">…</a>
						
					<?php endif; ?>
				<?php endif; ?>
				
			<!-- Kotak menu dropdown akan selalu tampil selama status peminjaman bukan "Selesai" atau "Dibatalkan" [Awal] -->
			<?php if($baris['status_pinjam'] != 'Selesai' && $baris['status_pinjam'] != 'Dibatalkan'): ?>
				<div <?php if($baris['status_pinjam'] == 'Disetujui' && $this->session->userdata('level') == "Pengguna") echo "class='sembunyikan'"; ?> class="dropdown-menu" aria-labelledby="dropdown-status">

					<!-- Opsi "Setujui" dan "Batalkan" tampil bila status peminjaman menjadi "Menunggu" [Awal] -->
					<?php if($baris['status_pinjam'] == 'Menunggu'): ?>

						<!-- Opsi "Setujui" hanya tampil untuk Admin [Awal] -->
						<?php if($this->session->userdata('level') == "Admin"): ?>
						<a class="dropdown-item" href="" data-toggle="modal" data-target="#setujui<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static">
							Setujui
						</a>
						<?php endif; ?>
						<!-- Opsi "Setujui" hanya tampil untuk Admin [Akhir] -->

						<!-- Opsi "Batalkan" [Awal] -->
						<?php if($this->session->userdata('level') == "Admin" OR $this->session->userdata('level') == "Pengguna"): ?>
						<a class="dropdown-item" href="" data-toggle="modal" data-target="#batalkan<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static">
							Batalkan
						</a>
						<?php endif; ?>
						<!-- Opsi "Batalkan" [Akhir] -->

					<?php endif; ?>
					<!-- Opsi "Setujui" dan "Batalkan" tampil bila status peminjaman menjadi "Menunggu" [Akhir] -->

					<!-- Opsi "Selesai" hanya tampil untuk Admin setelah peminjaman disetujui [Awal] -->
					<?php if($baris['status_pinjam'] == 'Disetujui' && $this->session->userdata('level') == "Admin"): ?>
					<a class="dropdown-item" href="" data-toggle="modal" data-target="#selesaikan<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static">
						Selesai
					</a>
					<?php endif; ?>
					<!-- Opsi "Selesai" hanya tampil untuk Admin setelah peminjaman disetujui [Akhir] -->

				</div>
			<?php endif; ?>
			<!-- Kotak menu dropdown akan selalu tampil selama status peminjaman bukan "Selesai" atau "Dibatalkan" [Akhir] -->

			</div>
		</td>
		<?php if(in_array($this->session->userdata('level'), array('Admin', 'Pengguna'), TRUE)): ?>
		<td align="center">
			<div <?php if($baris['status_pinjam'] == 'Selesai' OR $baris['status_pinjam'] == 'Dibatalkan' OR $baris['status_pinjam'] == 'Disetujui') echo "style='pointer-events: none; opacity: 0.35;'"; ?> class="mini-edit">
	            <a href="" data-toggle="modal" data-target="#suntingpinjam<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static"><span class="lnr lnr-pencil"></span></a>
	        </div>
	        <?php if($this->session->userdata('level') == "Admin"): ?>
	        <div class="mini-delete">
	        	<a href="" data-toggle="modal" data-target="#hapuspinjam<?php echo $baris['id_peminjaman']; ?>" data-backdrop="static"><span class="lnr lnr-trash"></span></a>
	        </div>
	    	<?php endif; ?>
		</td>
		<?php endif; ?>
	</tr>
  	<?php $no++; endforeach; ?>
</table>
<!-- Daftar Data Peminjaman Ruang [Akhir] -->


<!-- Fungsi untuk Cetak ID Peminjaman Otomatis [Awal] -->
<?php foreach($tb_idpinjam as $baris_id): ?>
	<?php
		// Mengambil string setelah karakter ke-4 sebanyak 5 karakter
		$kode   = substr($baris_id['id_peminjaman'],4,5);

		// Menambahkan 1 nilai
		$tambah = $kode + 1;

		if($tambah < 10)
		{
			$id_pinjam = "DPK-0000".$tambah;
		}
		else
		{
			$id_pinjam = "DPK-000".$tambah;
		}
	?>
<?php endforeach; ?>
<!-- Fungsi untuk Cetak ID Peminjaman Otomatis [Akhir] -->


<!-- Modal Pengajuan Pinjam Ruang [Awal] -->
<div id="ajukanpinjam" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Ajukan Peminjaman Ruang Meeting
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/pinjam-ruang'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $id_pinjam; ?>">
					<li>
						<div><i class="lnr lnr-user"></i></div><input type="text" value="<?php echo $id_pinjam; ?>" disabled />
					</li>
					<input type="hidden" name="peminjam" value="<?php echo $this->session->userdata('namalengkap'); ?>">
					<input type="hidden" name="waktu_pengajuan" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<div><i class="lnr lnr-layers"></i></div><select name="nama_ruangan" required="required">
							<option value="" selected>Ruang</option>

							<?php foreach($tb_ruangan as $baris_ruangan): ?>
								<option value="<?php echo $baris_ruangan['nama_ruangan']; ?>" <?php if($selected_room == $baris_ruangan['nama_ruangan']) echo 'selected'; ?>>
									<?php echo $baris_ruangan['nama_ruangan']; ?><?php if(isset($baris_ruangan['kapasitas'])) echo ' (' . $baris_ruangan['kapasitas'] . ' orang)'; ?>
								</option>
							<?php endforeach; ?>

						</select>
					</li>
					<li>
						<div><i class="lnr lnr-calendar-full"></i></div><input type="date" name="tanggal_meeting" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $selected_date; ?>" required />
					</li>
					<li>
						<div><i class="lnr lnr-clock"></i></div><select name="jam_meeting" required>
							<option value="">Pilih jam meeting</option>
							<?php foreach($booking_slots as $booking_slot): ?>
							<option value="<?php echo $booking_slot; ?>" <?php if(in_array($booking_slot, $occupied_slots)) echo 'disabled'; ?> <?php if($selected_time == $booking_slot && !in_array($booking_slot, $occupied_slots)) echo 'selected'; ?>><?php echo $booking_slot; ?> - <?php echo date('H:i', strtotime($booking_slot) + 3600); ?><?php if(in_array($booking_slot, $occupied_slots)) echo ' (Sudah dipesan)'; ?></option>
							<?php endforeach; ?>
						</select>
					</li>
					<li>
						<div><i class="lnr lnr-text-format"></i></div><input type="text" name="keterangan" placeholder="Agenda meeting" maxlength="50" required />
					</li>
					<br /><hr />
					<li>
						<input type="submit" name="tombol_tambah" value="Ajukan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>

			<div class="modal-footer">
				<span>Pastikan data telah terisi dengan benar.</span>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<!-- Modal Pengajuan Pinjam Ruang [Akhir] -->


<!-- Modal Perbarui Status Peminjaman [Awal] -->
<?php foreach ($tb as $baris): ?>
<div id="suntingpinjam<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Sunting Pengajuan Meeting
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/perbarui-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<li>
						<div><i class="lnr lnr-user"></i></div><input type="text" value="<?php echo $baris['id_peminjaman']; ?> (tidak dapat diubah)" disabled />
					</li>
					<li>
						<div><i class="lnr lnr-text-format"></i></div><input type="text" name="keterangan" placeholder="Agenda meeting" maxlength="50" value="<?php echo $baris['keterangan']; ?>" required />
					</li>
					<br /><hr />
					<li>
						<input type="submit" name="tombol_simpan" value="Simpan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>

			<div class="modal-footer" >
				<span>Pastikan data telah terisi dengan benar.</span>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<?php endforeach; ?>
<!-- Modal Perbarui Status Peminjaman [Akhir] -->


<!-- Modal Hapus Peminjaman Ruang [Awal] -->
<?php foreach ($tb as $baris): ?>
<div id="hapuspinjam<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Hapus Peminjaman Ruang
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/hapus-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<li>
						<p>Apakah Anda yakin ingin menghapus peminjaman <span><?php echo $baris['id_peminjaman']; ?></span> dari sistem?</p>
					</li>
					<br />
					<li>
						<input type="submit" name="tombol_hapus" value="Hapus" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<?php endforeach; ?>
<!-- Modal Hapus Peminjaman Ruang [Akhir] -->


<!-- Modal Penyetujuan Peminjaman Ruang [Awal] -->
<?php foreach ($tb as $baris): ?>
<div id="setujui<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Setujui Peminjaman Ruang
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/setujui-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<input type="hidden" name="waktu_penyetujuan" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<p>Apakah Anda yakin ingin menyetujui pengajuan <span><?php echo $baris['id_peminjaman']; ?></span> untuk Ruang <?php echo $baris['ruangan_dipinjam']; ?>?</p>
					</li>
					<?php foreach($tb_ruangan as $baris_ruangan): ?>
						<?php if($baris_ruangan['status'] == 'Menunggu' && $baris_ruangan['nama_ruangan'] == $baris['ruangan_dipinjam']): ?>
							<input type="hidden" name="id_ruangan" value="<?php echo $baris_ruangan['id_ruangan']; ?>">
						<?php endif; ?>
					<?php endforeach; ?>
					<br />
					<li>
						<input type="submit" name="tombol_setujui" value="Setujui" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<?php endforeach; ?>
<!-- Modal Penyetujuan Peminjaman Ruang [Akhir] -->


<!-- Modal Pembatalan Peminjaman Ruang [Awal] -->
<?php foreach ($tb as $baris): ?>
<div id="batalkan<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Batalkan Peminjaman Ruang
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/batalkan-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<input type="hidden" name="waktu_pembatalan" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<p>Apakah Anda yakin ingin membatalkan pengajuan <span><?php echo $baris['id_peminjaman']; ?></span> untuk Ruang <?php echo $baris['ruangan_dipinjam']; ?>?</p>
					</li>
					<?php foreach($tb_ruangan as $baris_ruangan): ?>
						<?php if($baris_ruangan['status'] == 'Menunggu' && $baris_ruangan['nama_ruangan'] == $baris['ruangan_dipinjam']): ?>
							<input type="hidden" name="id_ruangan" value="<?php echo $baris_ruangan['id_ruangan']; ?>">
						<?php endif; ?>
					<?php endforeach; ?>
					<br />
					<li>
						<input type="submit" name="tombol_batalkan" value="Batalkan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<?php endforeach; ?>
<!-- Modal Pembatalan Peminjaman Ruang [Akhir] -->


<!-- Modal Selesaikan Peminjaman Ruang [Awal] -->
<?php foreach ($tb as $baris): ?>
<div id="selesaikan<?php echo $baris['id_peminjaman']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Selesaikan Peminjaman Ruang
				<button type="button" class="close" data-dismiss="modal"><span class="lnr lnr-cross-circle"></span></button>
			</div>

			<div class="modal-body">
				<?php echo form_open('dashboard/selesaikan-peminjaman'); ?>
				<ul>
					<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']; ?>">
					<input type="hidden" name="waktu_pengembalian" value="<?php echo date('Y-m-d H:i:s'); ?>">
					<li>
						<p>Apakah Anda yakin ingin menyelesaikan pengajuan <span><?php echo $baris['id_peminjaman']; ?></span> untuk Ruang <?php echo $baris['ruangan_dipinjam']; ?>?</p>
					</li>
					<?php foreach($tb_ruangan as $baris_ruangan): ?>
						<?php if($baris_ruangan['status'] == 'Sedang digunakan' && $baris_ruangan['nama_ruangan'] == $baris['ruangan_dipinjam']): ?>
							<input type="hidden" name="id_ruangan" value="<?php echo $baris_ruangan['id_ruangan']; ?>">
						<?php endif; ?>
					<?php endforeach; ?>
					<br />
					<li>
						<input type="submit" name="tombol_selesaikan" value="Selesaikan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<?php endforeach; ?>
<!-- Modal Selesaikan Peminjaman Ruang [Akhir] -->


<!-- Modal Laporan Peminjaman Ruang [Awal] -->
<div id="lap-peminjaman" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Konten Modal [Awal] -->
		<div class="modal-content">
			<div class="modal-header">
				Laporan Peminjaman Ruang
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
					<br /><hr />
					<li>
						<input type="submit" value="Tampilkan" />
					</li>
				</ul>
				<?php echo form_close(); ?>
			</div>

			<div class="modal-footer">
				<span>Pastikan data telah terisi dengan benar.</span>
			</div>
		</div>
		<!-- Konten Modal [Akhir] -->
	</div>
</div>
<!-- Modal Laporan Peminjaman Ruang [Akhir] -->


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