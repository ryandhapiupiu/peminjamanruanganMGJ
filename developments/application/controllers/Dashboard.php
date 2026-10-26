<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Dashboard extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();

		// Memanggil library untuk templating halaman
		$this->load->library('template');

		// Pemeriksaan session masuk (login)
		if($this->session->userdata('status-masuk') != 'masuk')
		{
			redirect(base_url());
		}

		// Memanggil Model
		$this->load->model('model_user');
		$this->load->model('model_ruangan');
		$this->load->model('model_peminjaman');
		$this->load->model('model_tap');
	}

	public function index()
	{
		$halaman ['hal'] = "Beranda";
		$this->template->utama('pages/halaman-beranda', $halaman);
	}

	private function wajib_admin()
	{
		if ($this->session->userdata('level') != 'Admin')
		{
			redirect(base_url('dashboard'));
		}
	}

	public function notifikasi_pengajuan()
	{
		$this->wajib_admin();
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('jumlah' => $this->model_peminjaman->jumlah_menunggu())));
	}


	/*
	|-----------------------------------------------------------------
	| Fitur CRUD User
	|-----------------------------------------------------------------
	*/

	public function akun_pengguna()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if($this->session->userdata('level') != "Admin")
		{
			redirect(base_url('dashboard'));
		}

		// Memanggil fungsi lihat data pada Model User
		$query   = $this->model_user->tampil()->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb'   => $query,
			'hal'  => 'Kelola Akun Pengguna'
		);

		$this->template->utama('pages/halaman-user', $halaman);
	}

	public function buat_user()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$fullname = $this->input->post('fullname');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$level    = $this->input->post('level');
		if (!in_array($level, array('Admin', 'Pengguna'), TRUE))
		{
			redirect(base_url('dashboard/akun-pengguna'));
		}
		
		// Data yang akan disimpan/dibuat
		$data     = array
		(
			'fullname' => $fullname,
			'username' => $username,
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'level'    => $level
		);

		$query    = $this->model_user->buat($data);

		if ($query)
		{
			redirect(base_url('dashboard/akun-pengguna'));
		}
		else
		{
			echo "Proses penambahan data gagal.";
		}
	}

	public function perbarui_user()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$fullname = $this->input->post('fullname');
		$username = $this->input->post('username');
		$level    = $this->input->post('level');
		if (!in_array($level, array('Admin', 'Pengguna'), TRUE))
		{
			redirect(base_url('dashboard/akun-pengguna'));
		}
		
		// Data yang akan diperbarui
		$data     = array
		(
			'fullname' => $fullname,
			'level'    => $level
		);

		// Username digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('username' => $username);

		$query    = $this->model_user->perbarui($data, $where);

		if ($query)
		{
			redirect(base_url('dashboard/akun-pengguna'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function hapus_user()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$username = $this->input->post('username');

		// Username digunakan sebagai pengenal data mana yang akan dihapus
		$where   = array('username' => $username);

		$query   = $this->model_user->hapus($where);

		if($query)
		{
			redirect(base_url('dashboard/akun-pengguna'));
		}
		else
		{
			echo "Proses penghapusan data gagal.";
		}
	}


	/*
	|-----------------------------------------------------------------
	| Fitur CRUD Ruangan
	|-----------------------------------------------------------------
	*/

	public function data_ruangan()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if($this->session->userdata('level') != "Admin")
		{
			redirect(base_url('dashboard'));
		}

		// Memanggil fungsi lihat data pada Model Ruangan
		$query   = $this->model_ruangan->tampil()->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb'   => $query,
			'hal'  => 'Kelola Data Ruangan'
		);

		$this->template->utama('pages/halaman-ruangan', $halaman);
	}

	public function daftar_ruangan()
	{
		$halaman = array
		(
			'tb'  => $this->model_ruangan->tampil()->result_array(),
			'hal' => 'Daftar Ruang Meeting'
		);

		$this->template->utama('pages/daftar-ruangan', $halaman);
	}

	public function ketersediaan_ruangan()
	{
		$rooms = $this->model_ruangan->tampil()->result_array();
		$tanggal = $this->input->get('tanggal', TRUE);
		$nama_ruangan = $this->input->get('ruangan', TRUE);
		if (!$tanggal || date('Y-m-d', strtotime($tanggal)) != $tanggal || $tanggal < date('Y-m-d'))
		{
			$tanggal = date('Y-m-d');
		}
		if (!$nama_ruangan && !empty($rooms))
		{
			$nama_ruangan = $rooms[0]['nama_ruangan'];
		}
		$room_names = array_column($rooms, 'nama_ruangan');
		if (!in_array($nama_ruangan, $room_names))
		{
			$nama_ruangan = !empty($rooms) ? $rooms[0]['nama_ruangan'] : '';
		}

		$slots = array();
		for ($hour = 8; $hour < 17; $hour++)
		{
			$slots[] = sprintf('%02d:00', $hour);
		}

		$booked_slots = array();
		$elapsed_slots = array();
		if ($nama_ruangan)
		{
			$reservations = $this->model_peminjaman->slot_terpakai($nama_ruangan, $tanggal)->result_array();
			foreach ($reservations as $reservation)
			{
				$booked_slots[] = substr($reservation['jam_meeting'], 0, 5);
			}
		}
		if ($tanggal == date('Y-m-d'))
		{
			foreach ($slots as $slot)
			{
				if ($slot <= date('H:00'))
				{
					$elapsed_slots[] = $slot;
				}
			}
		}

		$halaman = array
		(
			'tb'           => $rooms,
			'slots'        => $slots,
			'booked_slots' => $booked_slots,
			'elapsed_slots' => $elapsed_slots,
			'tanggal'      => $tanggal,
			'nama_ruangan' => $nama_ruangan,
			'hal'          => 'Ketersediaan Ruangan'
		);

		$this->template->utama('pages/ketersediaan-ruangan', $halaman);
	}

	public function buat_ruangan()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_ruangan  = $this->input->post('id_ruangan');
		$namaruangan = $this->input->post('nama_ruangan');
		$kapasitas   = $this->input->post('kapasitas');
		
		// Data yang akan disimpan/dibuat
		$data     = array
		(
			'id_ruangan'   => $id_ruangan,
			'nama_ruangan' => $namaruangan,
			'kapasitas'    => $kapasitas,
			'status'       => 'Tersedia'
		);

		$query    = $this->model_ruangan->buat($data);

		if ($query)
		{
			redirect(base_url('dashboard/data-ruangan'));
		}
		else
		{
			echo "Proses penambahan data gagal.";
		}
	}

	public function perbarui_ruangan()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_ruangan  = $this->input->post('id_ruangan');
		$namaruangan = $this->input->post('nama_ruangan');
		$kapasitas   = $this->input->post('kapasitas');
		
		// Data yang akan diperbarui
		$data     = array
		(
			'nama_ruangan' => $namaruangan,
			'kapasitas'    => $kapasitas
		);

		// ID ruangan digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('id_ruangan' => $id_ruangan);

		$query    = $this->model_ruangan->perbarui($data, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-ruangan'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function hapus_ruangan()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_ruangan = $this->input->post('id_ruangan');

		// ID ruangan digunakan sebagai pengenal data mana yang akan dihapus
		$where   = array('id_ruangan' => $id_ruangan);

		$query   = $this->model_ruangan->hapus($where);

		if($query)
		{
			redirect(base_url('dashboard/data-ruangan'));
		}
		else
		{
			echo "Proses penghapusan data gagal.";
		}
	}


	/*
	|-----------------------------------------------------------------
	| Fitur CRUD Peminjaman
	|-----------------------------------------------------------------
	*/

	public function data_peminjaman()
	{
		// Memanggil fungsi lihat data pada Model Peminjaman dan Model Ruangan
		if($this->session->userdata('level') == "Pengguna")
		{
			// Nama peminjam digunakan sebagai pengenal data mana yang akan ditampilkan
			$where = array('peminjam' => $this->session->userdata('namalengkap'));

			$query = $this->model_peminjaman->tampil_detail($where)->result_array();
		}
		else
		{
			$query = $this->model_peminjaman->tampil()->result_array();
		}
		
		$query_b = $this->model_ruangan->tampil()->result_array();
		$query_c = $this->model_peminjaman->tampil_id()->result_array();
		$selected_date = $this->input->get('tanggal_meeting', TRUE);
		if (!$selected_date || date('Y-m-d', strtotime($selected_date)) != $selected_date)
		{
			$selected_date = date('Y-m-d');
		}
		$selected_room = $this->input->get('nama_ruangan', TRUE);
		$selected_time = $this->input->get('jam_meeting', TRUE);
		$room_names = array_column($query_b, 'nama_ruangan');
		if (!in_array($selected_room, $room_names))
		{
			$selected_room = !empty($query_b) ? $query_b[0]['nama_ruangan'] : '';
		}
		$booking_slots = array();
		for ($hour = 8; $hour < 17; $hour++)
		{
			$booking_slots[] = sprintf('%02d:00', $hour);
		}
		if (!in_array($selected_time, $booking_slots))
		{
			$selected_time = '';
		}
		$occupied_slots = array();
		$elapsed_booking_slots = array();
		if ($selected_room)
		{
			$rows = $this->model_peminjaman->slot_terpakai($selected_room, $selected_date)->result_array();
			foreach ($rows as $row)
			{
				$occupied_slots[] = substr($row['jam_meeting'], 0, 5);
			}
		}
		if ($selected_date == date('Y-m-d'))
		{
			foreach ($booking_slots as $booking_slot)
			{
				if ($booking_slot <= date('H:00'))
				{
					$elapsed_booking_slots[] = $booking_slot;
				}
			}
		}

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb'          => $query,
			'tb_ruangan'  => $query_b,
			'tb_idpinjam' => $query_c,
			'booking_slots' => $booking_slots,
			'occupied_slots' => $occupied_slots,
			'elapsed_booking_slots' => $elapsed_booking_slots,
			'selected_date' => $selected_date,
			'selected_room' => $selected_room,
			'selected_time' => $selected_time,
			'hal'         => 'Data Peminjaman'
		);

		$this->template->utama('pages/halaman-peminjaman', $halaman);
	}

	public function laporan_peminjaman()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if($this->session->userdata('level') != "Admin")
		{
			redirect(base_url('dashboard'));
		}

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$tgl_awal  = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');

		// Mencegah halaman diakses langsung melalui tautan dengan kondisi data yang kosong
		if(empty($tgl_awal && $tgl_akhir))
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}

		// Tanggal awal dan akhir digunakan sebagai pengenal data mana yang akan ditampilkan
		$where = array
		(
			'waktu_pengajuan >=' => $tgl_awal,
			'waktu_pengajuan <=' => $tgl_akhir
		);

		$query     = $this->model_peminjaman->tampil_detail($where)->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb'            => $query,
			'tanggal_awal'  => $tgl_awal,
			'tanggal_akhir' => $tgl_akhir,
			'hal'           => 'Laporan Peminjaman'
		);

		$this->template->utama('pages/halaman-laporan', $halaman);
	}

	public function pinjam_ruang()
	{
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		$peminjam      = $this->input->post('peminjam');
		$w_pengajuan   = $this->input->post('waktu_pengajuan');
		$keterangan    = $this->input->post('keterangan');
		$nama_ruangan  = $this->input->post('nama_ruangan');
		$tanggal_meeting = $this->input->post('tanggal_meeting');
		$jam_meeting   = $this->input->post('jam_meeting');
		$valid_slots   = array();
		for ($hour = 8; $hour < 17; $hour++)
		{
			$valid_slots[] = sprintf('%02d:00', $hour);
		}

		$date_parts = explode('-', (string) $tanggal_meeting);
		$date_is_valid = count($date_parts) == 3 && checkdate((int) $date_parts[1], (int) $date_parts[2], (int) $date_parts[0]);
		if (!$date_is_valid || $tanggal_meeting < date('Y-m-d') || !in_array($jam_meeting, $valid_slots))
		{
			echo 'Tanggal atau jam meeting tidak valid.';
			return;
		}

		if ($tanggal_meeting == date('Y-m-d') && $jam_meeting <= date('H:00'))
		{
			echo 'Jam meeting tersebut sudah lewat. Silakan pilih jam lain.';
			return;
		}

		$room_exists = $this->db->get_where('tb_ruangan', array('nama_ruangan' => $nama_ruangan))->num_rows() > 0;
		if (!$room_exists || $this->model_peminjaman->slot_sudah_dipesan($nama_ruangan, $tanggal_meeting, $jam_meeting . ':00'))
		{
			echo 'Slot tersebut baru saja dipesan. Silakan pilih ruang atau jam lain.';
			return;
		}
		
		// Data yang akan disimpan/dibuat
		$data_isi = array
		(
			'id_peminjaman'    => $id_peminjaman,
			'peminjam'         => $peminjam,
			'waktu_pengajuan'  => $w_pengajuan,
			'tanggal_meeting'  => $tanggal_meeting,
			'jam_meeting'      => $jam_meeting,
			'keterangan'       => $keterangan,
			'ruangan_dipinjam' => $nama_ruangan,
			'verifikasi_bp'    => '-',
			'verifikasi_kabag' => '-',
			'status_pinjam'    => 'Menunggu'
		);

		$query    = $this->model_peminjaman->buat($data_isi);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses penambahan data gagal.";
		}
	}

	public function perbarui_peminjaman()
	{
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		$keterangan    = $this->input->post('keterangan');
		
		// Data yang akan diperbarui
		$data  = array('keterangan' => $keterangan);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where = array('id_peminjaman' => $id_peminjaman);

		$query = $this->model_peminjaman->perbarui($data, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function verifikasi_bp()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		
		// Pengubahan status pada tabel peminjaman dari "-" menjadi "OK"
		// Data yang akan diperbarui
		$data = array
		(
			'verifikasi_bp'     => 'OK'
		);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('id_peminjaman' => $id_peminjaman);

		$query    = $this->model_peminjaman->perbarui($data, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function verifikasi_kabag()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		
		// Pengubahan status pada tabel peminjaman dari "-" menjadi "OK"
		// Data yang akan diperbarui
		$data = array
		(
			'verifikasi_kabag'     => 'OK'
		);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('id_peminjaman' => $id_peminjaman);

		$query    = $this->model_peminjaman->perbarui($data, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function setujui_peminjaman()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		$w_penyetujuan = $this->input->post('waktu_penyetujuan');
		
		// Pengubahan status pada tabel peminjaman dari "Menunggu" menjadi "Disetujui"
		// Data yang akan diperbarui
		$data_isi = array
		(
			'waktu_penyetujuan' => $w_penyetujuan,
			'verifikasi_bp'     => 'OK',
			'verifikasi_kabag'  => 'OK',
			'status_pinjam'     => 'Disetujui'
		);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('id_peminjaman' => $id_peminjaman);

		$query    = $this->model_peminjaman->perbarui($data_isi, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function batalkan_peminjaman()
	{
		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');
		$w_pembatalan  = $this->input->post('waktu_pembatalan');
		
		// Pengubahan status pada tabel peminjaman dari "Menunggu" menjadi "Dibatalkan"
		// Data yang akan diperbarui
		$data_isi = array
		(
			'waktu_pembatalan' => $w_pembatalan,
			'status_pinjam'    => 'Dibatalkan'
		);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('id_peminjaman' => $id_peminjaman);

		$query    = $this->model_peminjaman->perbarui($data_isi, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function selesaikan_peminjaman()
	{
		$this->wajib_admin();

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$id_peminjaman  = $this->input->post('id_peminjaman');
		$w_pengembalian = $this->input->post('waktu_pengembalian');
		
		// Pengubahan status pada tabel peminjaman dari "Disetujui" menjadi "Selesai"
		// Data yang akan diperbarui
		$data_isi = array
		(
			'waktu_pengembalian' => $w_pengembalian,
			'status_pinjam'      => 'Selesai'
		);

		// ID peminjaman digunakan sebagai pengenal data mana yang akan diperbarui
		$where    = array('id_peminjaman' => $id_peminjaman);

		$query    = $this->model_peminjaman->perbarui($data_isi, $where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));

		}
		else
		{
			echo "Proses pengubahan data gagal.";
		}
	}

	public function hapus_peminjaman()
	{
		$this->wajib_admin();

		// Menerima input dan lalu disimpan pada variabel-variabel berikut
		$id_peminjaman = $this->input->post('id_peminjaman');

		// ID peminjaman digunakan sebagai pengenal data mana yang akan dihapus
		$where = array('id_peminjaman' => $id_peminjaman);

		$query = $this->model_peminjaman->hapus($where);

		if ($query)
		{
			redirect(base_url('dashboard/data-peminjaman'));
		}
		else
		{
			echo "Proses penghapusan data gagal.";
		}
	}


	/*
	|-----------------------------------------------------------------
	| Riwayat Akses Ruangan
	|-----------------------------------------------------------------
	*/

	public function akses_ruangan()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if($this->session->userdata('level') != "Admin")
		{
			redirect(base_url('dashboard'));
		}

		// Memanggil fungsi lihat data pada Model Tap
		$query   = $this->model_tap->tampil()->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb'            => $query,
			'hal'           => 'Riwayat Akses Ruangan'
		);

		$this->template->utama('pages/halaman-akses-ruangan', $halaman);
	}


	/*
	|-----------------------------------------------------------------
	| Fitur Unduh Data
	|-----------------------------------------------------------------
	*/

	public function unduh_akses_ruangan()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if($this->session->userdata('level') != "Admin")
		{
			redirect(base_url('dashboard'));
		}

		// Memanggil fungsi lihat data pada Model Tap
		$query   = $this->model_tap->tampil()->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb'            => $query,
			'hal'           => 'Riwayat Akses Ruangan'
		);

		$this->load->view('pages/unduh-akses-ruangan', $halaman);
	}

	public function unduh_laporan_peminjaman()
	{
		// Membatasi level pengguna yang dapat mengakses halaman
		if($this->session->userdata('level') != "Admin")
		{
			redirect(base_url('dashboard'));
		}

		// Menerima input, lalu disimpan pada variabel-variabel berikut
		$tgl_awal  = $this->input->post('tanggal_awal');
		$tgl_akhir = $this->input->post('tanggal_akhir');

		// Tanggal awal dan akhir digunakan sebagai pengenal data mana yang akan ditampilkan
		$where = array
		(
			'waktu_pengajuan >=' => $tgl_awal,
			'waktu_pengajuan <=' => $tgl_akhir
		);

		$query     = $this->model_peminjaman->tampil_detail($where)->result_array();

		// Data disimpan sementara pada array
		$halaman = array
		(
			'tb'            => $query,
			'tanggal_awal'  => $tgl_awal,
			'tanggal_akhir' => $tgl_akhir,
			'hal'           => 'Laporan Peminjaman'
		);

		$unduh = $this->load->view('pages/unduh-laporan', $halaman);
	}


	/*
	|-----------------------------------------------------------------
	| Fitur Logout
	|-----------------------------------------------------------------
	*/

	public function logout()
	{
		$sesi	= array
		(
			'namalengkap',
			'level',
			'status-masuk'
		);

		$this->session->unset_userdata($sesi);

		redirect(base_url());
	}
}