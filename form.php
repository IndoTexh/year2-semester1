<!doctype html>
<html lang="en">

<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/style.css">

</head>

<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
	<section class="ftco-section">
		<div class="container">

			<?php
			session_start();
			if (isset($_SESSION['username'])) {
				header('Location: dashboard.php');
				exit();
			}			
			if (isset($_SESSION['error_message'])):
				?>
				<div class="alert alert-danger text-center" role="alert">
					<?php echo $_SESSION['error_message']; ?>
				</div>
				<?php
				unset($_SESSION['error_message']); // Clear the session variable
			endif;
			?>

			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
						<h3 class="mb-4 text-center">Admin Panel</h3>
						<form action="Login.php" class="signin-form" method="POST">
							<div class="form-group">
								<input type="text" name="name" class="form-control" placeholder="Username" required>
							</div>
							<div class="form-group">
								<input id="password-field" name="password" type="password" class="form-control"
									placeholder="Password" required>
								<span toggle="#password-field"
									class="fa fa-fw fa-eye field-icon toggle-password"></span>
							</div>
							<div class="form-group">
								<button type="submit" name="submit" class="form-control btn btn-primary submit px-3">Log
									in</button>
							</div>
							<div class="form-group d-md-flex">
								<div class="w-50">
									<label class="checkbox-wrap checkbox-primary">Remember Me
										<input type="checkbox" checked>
										<span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="#" style="color: #fff">Forgot Password</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>

</body>

</html>