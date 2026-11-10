<?php
$level = $this->session->userdata('level') ?: 'Pengguna';
?>
<div style="line-height:1.65; color:#334155;">
	<div style="display:flex; justify-content:space-between; align-items:center; padding-bottom:12px; border-bottom:1px solid #d8dee4; margin-bottom:16px;">
		<div>
			<strong style="font-size:14px; color:#212529;">Panduan Penggunaan &amp; Ketentuan Ruang Meeting</strong>
			<div style="font-size:12px; color:#64748b;">PT Medquest Jaya Global &middot; Level Akses: <?php echo htmlspecialchars($level); ?></div>
		</div>
		<button onclick="window.print()" class="btn-mq-outline no-print">Cetak Panduan</button>
	</div>

	<h6 style="font-weight:700; color:#212529; font-size:13px; margin-bottom:8px;">1. Alur Peminjaman Ruang Meeting</h6>
	<ol style="padding-left:18px; margin-bottom:18px; font-size:12.5px;">
		<li style="margin-bottom:6px;">
			<strong>Cek Ketersediaan Jadwal:</strong> Buka menu <em>Ketersediaan Ruang</em>, pilih tanggal dan nama ruangan untuk melihat jam yang masih kosong (08:00 - 17:00 WIB).
		</li>
		<li style="margin-bottom:6px;">
			<strong>Pengajuan Peminjaman:</strong> Klik pada jam yang tersedia atau klik tombol <em>+ Ajukan Peminjaman</em> di halaman <em>Data Peminjaman</em>. Isi nama peminjam, departemen, nomor telepon, dan agenda rapat.
		</li>
		<li style="margin-bottom:6px;">
			<strong>Persetujuan &amp; Kalender:</strong> Pengajuan akan diverifikasi oleh Admin / Resepsionis. Jadwal yang telah disetujui dapat langsung ditambahkan ke Google Calendar atau Outlook (.ics).
		</li>
		<li style="margin-bottom:6px;">
			<strong>Konfirmasi Kehadiran (Check-In):</strong> Peminjam wajib melakukan Check-In saat tiba di ruangan (melalui tombol <em>Check-In</em> di sistem atau scan QR di pintu ruangan) maksimal <strong>10 menit</strong> setelah jadwal dimulai.
		</li>
	</ol>

	<h6 style="font-weight:700; color:#212529; font-size:13px; margin-bottom:8px;">2. Ketentuan Penggunaan Ruangan</h6>
	<ul style="padding-left:18px; margin-bottom:18px; font-size:12.5px;">
		<li style="margin-bottom:5px;">Batas toleransi keterlambatan Check-In adalah <strong>10 menit</strong> dari jam mulai rapat. Apabila melewati batas tersebut tanpa Check-In, jadwal otomatis dibatalkan agar ruangan dapat digunakan oleh karyawan lain.</li>
		<li style="margin-bottom:5px;">Jika rapat selesai lebih awal atau batal dilaksanakan, harap segera memperbarui status peminjaman atau menginformasikan kepada Resepsionis.</li>
		<li style="margin-bottom:5px;">Pastikan kebersihan ruangan, papan tulis, serta matikan televisi/proyektor dan AC setelah rapat selesai.</li>
	</ul>

	<?php if ($level == 'Admin'): ?>
	<h6 style="font-weight:700; color:#212529; font-size:13px; margin-bottom:8px;">3. Daftar Akun Sistem (Khusus Admin)</h6>
	<table class="cp-table" style="max-width:680px;">
		<thead>
			<tr>
				<th>Level</th>
				<th>Username</th>
				<th>Password</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Admin</td>
				<td><code>ryan</code></td>
				<td><code>123123</code></td>
				<td>Pengelolaan ruangan, akun pengguna, dan persetujuan penuh</td>
			</tr>
			<tr>
				<td>Resepsionis</td>
				<td><code>operator</code></td>
				<td><code>123123</code></td>
				<td>Verifikasi persetujuan jadwal harian, check-in, dan laporan</td>
			</tr>
			<tr>
				<td>Pengguna</td>
				<td><code>nawal</code></td>
				<td><code>123123</code></td>
				<td>Akun karyawan untuk pengajuan peminjaman ruangan</td>
			</tr>
		</tbody>
	</table>
	<?php endif; ?>
</div>
