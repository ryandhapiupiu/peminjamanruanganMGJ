<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login - Peminjaman Ruang Meeting PT Medquest Jaya Global</title>
	<link rel="icon" href="<?php echo base_url('assets/img/logo_medquest.png'); ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>?v=mq_natural_v2">
</head>
<body>

	<div class="auth-wrapper">
		<div class="auth-card">
			<div class="auth-card-header">
				<img src="<?php echo base_url('assets/img/logo_medquest.png'); ?>" alt="PT Medquest Jaya Global">
				<h4>Sistem Peminjaman Ruang Meeting</h4>
				<p>PT Medquest Jaya Global</p>
			</div>

			<div class="auth-card-body">
				<?php echo form_open('login/proses'); ?>
					<div class="mq-form-group">
						<label class="mq-form-label">Username</label>
						<input type="text" name="username" class="mq-form-control" placeholder="Masukkan username" required autofocus />
					</div>

					<div class="mq-form-group">
						<label class="mq-form-label">Password</label>
						<input type="password" name="password" class="mq-form-control" placeholder="Masukkan password" required />
					</div>

					<button type="submit" name="tombol_login" value="Masuk" class="btn-auth-submit">
						Masuk
					</button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>

	<footer class="mq-auth-footer">
		&copy; <?php echo date('Y'); ?> PT Medquest Jaya Global &middot; Sistem Peminjaman Ruang Meeting
	</footer>

</body>
</html>
