<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Aimeos administration interface</title>

		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/css/tether.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
		<script src="//code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>
