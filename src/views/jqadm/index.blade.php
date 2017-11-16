<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Aimeos administration interface</title>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/css/tether.min.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?= route( 'aimeos_shop_jqadm_file', array( 'site' => $site, 'lang' => 'en', 'type' => 'css' ) ); ?>">
	</head>
	<body>
		<div class="app-menu" style="text-align: right; margin: 0 2.5%;">
			<a class="logout" style="padding: 0.25rem 0.75rem; font-weight: bold" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				Logout
			</a>
			<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
				{{ csrf_field() }}
			</form>
		</div>

<?= $content ?>

		<script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.10.2/d3.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/ckeditor.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/adapters/jquery.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
		<script src="<?= route( 'aimeos_shop_jqadm_file', array( 'site' => $site, 'lang' => 'en', 'type' => 'js' ) ); ?>"></script>
	</body>
</html>
