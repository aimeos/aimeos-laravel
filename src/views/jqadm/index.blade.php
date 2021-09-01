<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $localeDir }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Security-Policy" content="default-src 'self' data: blob: https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; style-src 'unsafe-inline' 'self' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; script-src 'unsafe-eval' 'self' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; img-src 'self' data: blob: https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://*.tile.openstreetmap.org https://aimeos.org; frame-src https://www.youtube.com">

		<title>Aimeos administration interface</title>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4/css/font-awesome.min.css" />
@if( $localeDir == 'rtl' )
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/bootstrap@5/dist/css/bootstrap.rtl.min.css,npm/flatpickr@4/dist/flatpickr.min.css,npm/flatpickr@4/dist/plugins/confirmDate/confirmDate.min.css,npm/vue-select@3/dist/vue-select.min.css,npm/leaflet@1/dist/leaflet.min.css">
@else
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/bootstrap@5/dist/css/bootstrap.min.css,npm/flatpickr@4/dist/flatpickr.min.css,npm/flatpickr@4/dist/plugins/confirmDate/confirmDate.min.css,npm/vue-select@3/dist/vue-select.min.css,npm/leaflet@1/dist/leaflet.min.css">
@endif
		<link rel="stylesheet" href="<?= route( 'aimeos_shop_jqadm_file', ['site' => $site, 'locale' => 'en', 'type' => 'css'] ); ?>" />
		<style>
			body.dark .btn-theme.dark-mode {display:none}
			body.light .btn-theme.light-mode {display:none}
			.app-menu .icon {vertical-align: middle; padding: 0.5rem 1rem; font-size: 125%; background-color: transparent; border: none; color: inherit}
			#logout-form {display: inline}
		</style>
	</head>
	<body class="{{ $theme }}">
		<div class="app-menu">
			<span class="menu"></span>
			<div class="app-menu-end">
				<i class="icon btn-theme light-mode fa fa-sun-o"></i><i class="icon btn-theme dark-mode fa fa-moon-o"></i>
				<form id="logout-form" action="{{ route( 'logout', Request::get( 'locale', app()->getLocale() ) ) }}" method="POST">{{ csrf_field() }}<button class="icon logout fa fa-sign-out"></button></form>
			</div>
		</div>

<?= $content ?>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script src="https://cdn.jsdelivr.net/combine/npm/bootstrap@5/dist/js/bootstrap.bundle.min.js,npm/vue@2/dist/vue.min.js,npm/vue-select@3/dist/vue-select.min.js,npm/flatpickr@4,npm/flatpickr@4/dist/l10n/index.min.js,npm/flatpickr@4/dist/plugins/confirmDate/confirmDate.min.js,npm/vue-flatpickr-component@8,npm/sortablejs@1,npm/vuedraggable@2,npm/leaflet@1/dist/leaflet-src.min.js,npm/vue2-leaflet@2/dist/vue2-leaflet.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/ckeditor@4/ckeditor.js"></script>
		<script src="<?= route( 'aimeos_shop_jqadm_file', array( 'site' => $site, 'locale' => 'en', 'type' => 'js' ) ); ?>"></script>
	</body>
</html>
