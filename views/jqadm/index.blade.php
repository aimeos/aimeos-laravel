<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $localeDir }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}" />

		@if( config('app.debug') !== true )
			<meta http-equiv="Content-Security-Policy" content="default-src 'self' data: blob:; {{ config( 'shop.csp.backend', 'style-src \'unsafe-inline\' \'self\' https://cdnjs.cloudflare.com; script-src \'unsafe-eval\' \'self\'; connect-src \'self\' https://*.deepl.com https://api.openai.com; img-src \'self\' data: blob: https://*.tile.openstreetmap.org https://aimeos.org; frame-src https://www.youtube.com https://player.vimeo.com' ) }}">
		@endif

		<title>Aimeos administration interface</title>

		<link rel="stylesheet" href="<?= airoute( 'aimeos_shop_jqadm_file', ['site' => $site, 'locale' => 'en', 'name' => 'vendor-css'] ) ?>">
		@if( $localeDir == 'rtl' )
			<link rel="stylesheet" href="<?= airoute( 'aimeos_shop_jqadm_file', ['site' => $site, 'locale' => 'en', 'name' => 'index-rtl-css'] ) ?>">
		@else
			<link rel="stylesheet" href="<?= airoute( 'aimeos_shop_jqadm_file', ['site' => $site, 'locale' => 'en', 'name' => 'index-ltr-css'] ) ?>">
		@endif
		<link rel="stylesheet" href="<?= airoute( 'aimeos_shop_jqadm_file', ['site' => $site, 'locale' => 'en', 'name' => 'index-css'] ) ?>">

		<style nonce="{{ app( 'aimeos.context' )->get( false )->nonce() }}">
			body.dark .btn-theme.dark-mode {display:none}
			body.light .btn-theme.light-mode {display:none}
			.app-menu .icon {cursor: pointer; padding: 0.75rem; height: 2.5rem; width: 2.5rem; margin: 0 0.25rem;}
			.app-menu button {border: none; color: var(--ai-bg); background-color: transparent; padding: 0}
			#logout-form {display: inline-block}
		</style>
	</head>
	<body class="{{ $theme }}">
		<div class="app-menu">
			<span class="menu"></span>
			<div class="app-menu-end">
				<form id="logout-form" action="{{ airoute( 'logout', ['locale' => Request::get( 'locale', app()->getLocale() )] ) }}" method="POST">
					{{ csrf_field() }}
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sun icon btn-theme light-mode" viewBox="0 0 16 16"><path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/></svg>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon icon btn-theme dark-mode" viewBox="0 0 16 16"><path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286"/></svg>
					<button><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right icon logout" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/><path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/></svg></button>
				</form>
			</div>
		</div>

<?= $content ?>

		<script src="<?= airoute( 'aimeos_shop_jqadm_file', array( 'site' => $site, 'locale' => 'en', 'name' => 'vendor-js' ) ) ?>"></script>
		<script src="<?= airoute( 'aimeos_shop_jqadm_file', array( 'site' => $site, 'locale' => 'en', 'name' => 'index-js' ) ) ?>"></script>
	</body>
</html>
