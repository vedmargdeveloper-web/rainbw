<!doctype html>
<html lang="en">
<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Meta -->
		<meta name="description" content="">
		<link rel="shortcut icon" href="img/fav.png" />
		<title>Rainbow Login</title>
		<link rel="stylesheet" href="{{ asset('resources/css/bootstrap.min.css') }}" />

		<!-- Master CSS -->
		<link rel="stylesheet" href="{{ asset('resources/css/main.css') }}" />

	</head>

	<body class="authentication">

		<!-- Container start -->
		<div class="container">
			
			<form class="form" method="POST" action="{{ route('admin.login') }}">
				@csrf
				<div class="row justify-content-md-center">
					<div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
						<div class="login-screen">
							<div class="login-box">
								<a href="#" class="login-logo">
									RAINBOW
								</a>
								<h5>Welcome back,<br />Please Login to your Account.</h5>
								@if( session()->has('message') )
									<span class="text-warning">{{ session()->get('message') }}</span>
								@endif
								<div class="form-group">
									<input type="text" class="form-control" name="email" placeholder="Email Address" />
									@error('email')
											<span class="text-warning">{{ $message }}</span>
									@endError
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Password" />
									@error('password')
											<span class="text-warning">{{ $message }}</span>
										@endError
								</div>
								<div class="actions mb-4">
									<!-- <div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="remember_pwd">
										<label class="custom-control-label" for="remember_pwd">Remember me</label>
									</div> -->
									<button type="submit" class="btn btn-primary">Login</button>
								</div>
								<!-- <div class="forgot-pwd">
									<a class="link" href="forgot-pwd.html">Forgot password?</a>
								</div> -->
								<hr>
								<!-- <div class="actions align-left">
									<span class="additional-link">New here?</span>
									<a href="signup.html" class="btn btn-dark">Create an Account</a>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>