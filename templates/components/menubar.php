<?php

/*
|--------------------------------------------------------------------------
| Limitasi Hak Akses Menubar
|--------------------------------------------------------------------------
|
| Membatasi menu yang bisa diakses oleh user 
| berdasarkan tingkatan akses yang dimiliki.
|
*/

if($this->session->userdata('level') == "Admin")
{
	$this->load->view('components/menubar-admin');
}
elseif($this->session->userdata('level') == "Pengguna")
{
	$this->load->view('components/menubar-user');
}

?>