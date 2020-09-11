<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Aimeos administration interface</title>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?= route( 'aimeos_shop_jqadm_file', array( 'site' => $site, 'lang' => 'en', 'type' => 'css' ) ); ?>" />
	</head>
	<body>
		<div class="app-menu" style="text-align: right; margin: 0 2.5%;">
			<a class="logout" style="padding: 0.25rem 0.75rem; font-weight: bold" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				Logout
			</a>
			<form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
				{{ csrf_field() }}
			</form>
		</div>

<?= $content ?>

		<script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.12/vue.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.13.0/d3.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/adapters/jquery.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.9.0/Sortable.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.23.0/vuedraggable.umd.min.js"></script>
		<script src="<?= route( 'aimeos_shop_jqadm_file', array( 'site' => $site, 'lang' => 'en', 'type' => 'js' ) ); ?>"></script>
	</body>
</html>
