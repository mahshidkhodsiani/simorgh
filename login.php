<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>صفحه ورود</title>

	<?php
	include 'includes.php';
	?>
	<style>
		body {
			background-image: url('images/bg.jpg');
		}
	</style>
</head>
<body>
	<div class="row mt-5">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<form action="login_proccess.php" method="POST">
				<h3 class="d-flex justify-content-center">صفحه ورود</h3>
				<div class="form-group">
					<label for="">Username</label>
					<input type="username" name="username" class="form-control"  placeholder="Enter email">
					<!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" name="password" class="form-control"  placeholder="Password">
				</div>
				<!-- <div class="form-group form-check">
					<input type="checkbox" class="form-check-input" id="exampleCheck1">
					<label class="form-check-label" for="exampleCheck1">Check me out</label>
				</div> -->
				<br>
				<button name="enter" class="btn btn-outline-primary">ورود</button>
			</form>
		</div>
		<div class="col-md-4"></div>

	</div>

</body>
</html>