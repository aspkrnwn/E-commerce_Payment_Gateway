<!doctype html>
	<html lang="en">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Login</title>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="<?= base_url("properties/admin") ?>/assets/vendor/bootstrap/css/bootstrap.min.css">
		<link href="<?= base_url("properties/admin") ?>/assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
		<link rel="stylesheet" href="<?= base_url("properties/admin") ?>/assets/libs/css/style.css">
		<link rel="stylesheet" href="<?= base_url("properties/admin") ?>/assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
		<style>
			html,
			body {
				height: 100%;
			}

			body {
				display: -ms-flexbox;
				display: flex;
				-ms-flex-align: center;
				align-items: center;
				padding-top: 40px;
				padding-bottom: 40px;
			}
		</style>
	</head>

	<body>
		<!-- ============================================================== -->
		<!-- login page  -->
		<!-- ============================================================== -->
		<div class="alert_failed_login" data-flashdata="<?php echo $this->session->flashdata('alert_failed_login') ?>"></div>
		<div class="splash-container">
			<div class="card ">
				<div class="card-header text-center"><a href="<?= base_url("admin/login") ?>"><img class="logo-img" width="100" src="<?= base_url("properties/admin") ?>/assets/images/logo.png" alt="logo"></a><span class="splash-description">Please enter your user information for login to Admin / Owner Portal.</span></div>
				<div class="card-body">
					<form method="post" action="<?= base_url("admin/login/login_action") ?>">
						<div class="form-group">
							<input class="form-control form-control-lg" id="username" type="text" placeholder="Username" autocomplete="off" name="username" required autofocus>
						</div>
						<div class="form-group">
							<input class="form-control form-control-lg" name="password" required id="password" type="password" placeholder="Password">
						</div>
						<button type="submit" class="btn btn-primary btn-lg btn-block">Log in</button>
					</form>
				</div>
				<div class="card-footer bg-white p-0  ">
					<div class="card-footer-item card-footer-item-bordered">
						<a href="#" class="footer-link">Forgot Password</a>
					</div>
				</div>
			</div>
		</div>

		<!-- ============================================================== -->
		<!-- end login page  -->
		<!-- ============================================================== -->
		<!-- Optional JavaScript -->
		<script src="<?= base_url("properties/admin") ?>/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
		<script src="<?= base_url("properties/admin") ?>/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>

		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script type="text/javascript">
			const alert_failed_login = $('.alert_failed_login').data('flashdata');

			if(alert_failed_login){
				Swal.fire({
					text: '' + alert_failed_login,
					icon: 'error',
					timer: 5000
				})
			}
		</script>
	</body>

	</html>