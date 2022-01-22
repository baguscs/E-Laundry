<!DOCTYPE html>
<html lang="en">
<head>
<title>E-Laundry Mitra Jaya</title>
<!-- custom-theme -->
<link rel="shortcut icon" href="images/icon.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //custom-theme -->
<!-- css files -->
<link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=devanagari,latin-ext" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" type="text/css" rel="stylesheet" media="all">   
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<!-- //css files -->

<link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}"> 
<!-- Font-Awesome-Icons-CSS -->
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

</head>
<!-- body starts -->
<body>
<!-- section -->
<section class="register">
	<div class="register-full">
		<div class="register-left">
			<div class="register">
				<div class="logo">
					<img src="images/wash.jpg" alt="" width="25%">
				</div>
				<h1>E-Laundry Mitra Jaya</h1>
				<p>Melayani palanggan dengan sepenuh hati, dengan dedikasi penuh demi kenyamanan pelanggan.</p>
			</div>
		</div>
		<div class="register-right">
			<div class="register-in">
				<h2><span class="fa fa-user"></span> Login here</h2>
				<div class="register-form">
					@if ($messege = Session::get("pesan"))
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan</h5>
								{{Session::get("pesan") }}
						</div>
					@endif
					<form method="POST" action="{{ route('login') }}">
						@csrf
						@error('email')
							<div class="alert alert-danger" role="alert">
							Maaf E-Mail dan Password Anda Tidak Terdaftar
							</div>   
						@enderror
						<div class="fields-grid">
							<div class="styled-input">
								<input type="email" name="email" required="" autocomplete="off" :value="old('email')">
								<label>Email</label>
								<span></span>
							</div>
							<div class="styled-input">
								<input type="password" name="password" required="" autocomplete="current-password">
								<label>Password</label>
								<span></span>
							</div>
							<div class="clear"> </div>
							<div>
								<a href="{{ route('forgot') }}" style="color: white">Forgot your password?</a>
							</div>
						</div>
						<input type="submit" value="Login">
					</form>
				</div>
			</div>
			<div class="clear"> </div>
		</div>
	<div class="clear"> </div>
	</div>
</section>
<!-- //section -->
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>	
<!-- //body ends -->
</html>