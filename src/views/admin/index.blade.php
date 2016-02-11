<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Aimeos administration interface</title>

		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="/packages/aimeos/shop/themes/default/admin.css">

		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

	</head>
	<body>

		<form class="login" method="POST" action="{{ URL::action('Auth\AuthController@login') }}" >
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

		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js"></script>
	</body>
</html>
