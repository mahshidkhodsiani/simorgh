<?php
session_start();
?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>هفت هنر سیمرغ</title>

	<?php
	include 'includes.php';
	require 'API/Gateway.php';
	require 'ipgcfg.php';
	?>

	<link rel="icon" href="images/logo1.ico" type="image/x-icon">

	<style>
		body {
			font-weight: bold !important;
		}
	</style>
</head>

<body>

	<?php
	include 'header.php';
	include 'config.php';
	include 'PersianCalendar.php';
	include 'jalaliDate.php';
	$sdate = new SDate();
	?>







	<div class="container mt-4 mb-4">

		<div class="row justify-content-center">
			<div class="col-md-5 col-sm-12 border">
				<h5 class="text-center mt-3 mb-3">ورود به حساب کاربری</h5>
				<form action="login_proccess.php" method="POST">
					<div class="mb-3">
						<label for="username" class="form-label">نام کاربری</label>
						<input type="text" class="form-control" id="username" name="username" required>
					</div>
					<div class="mb-3">
						<label for="password" class="form-label">رمز عبور</label>
						<input type="password" class="form-control" id="password" name="password" required>
					</div>
					<div class="d-grid gap-2">
						<button name="enter" class="btn btn-primary">ورود</button>
						<a href="create_account.php" class="btn btn-outline-primary">ثبت نام</a>
					</div>
					<div class="mb-3">
						<h5 class="bold">
							<a href="forgot_password" class="font-weight-bold">فراموشی رمز (کلیک کنید)</a>
						</h5>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php include 'footer.php'; ?>


</body>

</html>