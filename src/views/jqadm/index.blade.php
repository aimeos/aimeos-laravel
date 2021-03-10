<!DOCTYPE html>
@if( in_array( $lang = Request::get( 'lang', config( 'app.locale', 'en' ) ), ['ar', 'he'] ) )
<html lang="{{ $lang }}" dir="rtl">
@else
<html lang="{{ $lang }}" dir="ltr">
@endif
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Aimeos administration interface</title>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4/css/font-awesome.min.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css,npm/flatpickr@4/dist/flatpickr.min.css,npm/flatpickr@4/dist/plugins/confirmDate/confirmDate.min.css,npm/vue-select@3/dist/vue-select.min.css">
		<link rel="stylesheet" href="<?= route( 'aimeos_shop_jqadm_file', array( 'site' => $site, 'lang' => 'en', 'type' => 'css' ) ); ?>" />
	</head>
	<body>
		<div class="app-menu">
			<span class="menu"></span>
			<i class="logout fa fa-sign-out" aria-hidden="true" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></i>
			<form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
		</div>

<?= $content ?>

		<script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script src="https://cdn.jsdelivr.net/combine/npm/vue@2/dist/vue.min.js,npm/vue-select@3/dist/vue-select.min.js,npm/flatpickr@4,npm/flatpickr@4/dist/l10n/index.min.js,npm/flatpickr@4/dist/plugins/confirmDate/confirmDate.min.js,npm/vue-flatpickr-component@8,npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js,npm/sortablejs@1,npm/vuedraggable@2"></script>
		<script src="https://cdn.jsdelivr.net/npm/ckeditor@4/ckeditor.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/ckeditor@4/adapters/jquery.js"></script>
		<script src="<?= route( 'aimeos_shop_jqadm_file', array( 'site' => $site, 'lang' => 'en', 'type' => 'js' ) ); ?>"></script>
	</body>
</html>
