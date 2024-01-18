<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $localeDir }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}" />

		@if( config('app.debug') !== true )
			<meta http-equiv="Content-Security-Policy" content="default-src 'self' data: blob: https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; {{ config( 'shop.csp.backend', 'style-src \'unsafe-inline\' \'self\' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; script-src \'unsafe-eval\' \'self\' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; connect-src \'self\' https://*.deepl.com https://api.openai.com; img-src \'self\' data: blob: https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://*.tile.openstreetmap.org https://aimeos.org; frame-src https://www.youtube.com https://player.vimeo.com' ) }}">
		@endif

		<title>Aimeos administration interface</title>

		@if( $localeDir == 'rtl' )
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/bootstrap@5.2/dist/css/bootstrap.rtl.min.css,npm/flatpickr@4/dist/flatpickr.min.css,npm/flatpickr@4/dist/plugins/confirmDate/confirmDate.min.css,npm/vue-select@3/dist/vue-select.min.css,npm/leaflet@1/dist/leaflet.min.css">
		@else
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/bootstrap@5.2/dist/css/bootstrap.min.css,npm/flatpickr@4/dist/flatpickr.min.css,npm/flatpickr@4/dist/plugins/confirmDate/confirmDate.min.css,npm/vue-select@3/dist/vue-select.min.css,npm/leaflet@1/dist/leaflet.min.css">
		@endif
		<link rel="stylesheet" href="<?= airoute( 'aimeos_shop_jqadm_file', ['site' => $site, 'locale' => 'en', 'type' => 'css'] ); ?>">

		<style nonce="{{ app( 'aimeos.context' )->get( false )->nonce() }}">
			body.dark .btn-theme.dark-mode {display:none}
			body.light .btn-theme.light-mode {display:none}
			.app-menu .icon {font: 1rem bootstrap-icons; vertical-align: middle; padding: 0.66rem 1rem; background-color: transparent; border: none; color: inherit}
			.app-menu .icon.light-mode::before {content: "\F5A2"}
			.app-menu .icon.dark-mode::before {content: "\F497"}
			.app-menu .icon.logout::before {content: "\F1C3"}
			.app-menu .icon::before {display: inline-block}
			#logout-form {display: inline-block}
		</style>
	</head>
	<body class="{{ $theme }}">
		<div class="app-menu">
			<span class="menu"></span>
			<div class="app-menu-end">

				<form id="logout-form" action="{{ airoute( 'logout', ['locale' => Request::get( 'locale', app()->getLocale() )] ) }}" method="POST">{{ csrf_field() }}<i class="icon btn-theme light-mode fa"></i><i class="icon btn-theme dark-mode fa"></i><button class="icon logout"></button></form>
			</div>
		</div>

<?= $content ?>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/combine/npm/bootstrap@5.2/dist/js/bootstrap.bundle.min.js,npm/vue@2/dist/vue.min.js,npm/flatpickr@4,npm/flatpickr@4/dist/l10n/index.min.js,npm/flatpickr@4/dist/plugins/confirmDate/confirmDate.min.js,npm/vue-flatpickr-component@8,npm/sortablejs@1,npm/vuedraggable@2,npm/leaflet@1/dist/leaflet-src.min.js,npm/vue2-leaflet@2/dist/vue2-leaflet.min.js"></script>
		<script src="<?= airoute( 'aimeos_shop_jqadm_file', array( 'site' => $site, 'locale' => 'en', 'type' => 'js' ) ); ?>"></script>
	</body>
</html>
