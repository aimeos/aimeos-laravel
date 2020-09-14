<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Aimeos administration interface</title>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4/css/font-awesome.min.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/css/bootstrap.min.css" />

		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<style type="text/css">
			form.login {
				position: absolute;
				left: 50%;
				top: 50%;
				width: 20rem;
				margin: -6rem -10rem;
			}

			form.login .input-group-addon {
				font-size: 1.25rem;
				min-width: 3.65rem;
			}
		</style>
	</head>
	<body>

		<form class="login" method="POST" action="{{ url('login') }}" >
			{!! csrf_field() !!}
			<div class="form-group input-group input-group-lg">
				<span class="input-group-addon fa fa-at" id="email-addon"></span>
				<input class="form-control" type="email" name="email" required="required" placeholder="Email" value="{{ old('email') }}" aria-describedby="email-addon">
			</div>
			<div class="form-group input-group input-group-lg">
				<span class="input-group-addon fa fa-lock" id="password-addon"></span>
				<input class="form-control" type="password" name="password" required="required" placeholder="Password" aria-describedby="password-addon" />
			</div>
			<hr>
			<button class="btn btn-block btn-lg btn-primary" type="submit">Login</button>
		</form>
		<script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/js/bootstrap.bundle.min.js"></script>
	</body>
</html>
