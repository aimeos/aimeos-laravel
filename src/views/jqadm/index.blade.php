<!DOCTYPE html>
@if( in_array( $lang = Request::get( 'lang', config( 'app.locale', 'en' ) ), ['ar', 'az', 'dv', 'fa', 'he', 'ku', 'ur'] ) )
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
		@if( in_array( $lang = Request::get( 'lang', config( 'app.locale', 'en' ) ), ['ar', 'az', 'dv', 'fa', 'he', 'ku', 'ur'] ) )
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.rtl.min.css,npm/flatpickr@4/dist/flatpickr.min.css,npm/flatpickr@4/dist/plugins/confirmDate/confirmDate.min.css,npm/vue-select@3/dist/vue-select.min.css">
		@else
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css,npm/flatpickr@4/dist/flatpickr.min.css,npm/flatpickr@4/dist/plugins/confirmDate/confirmDate.min.css,npm/vue-select@3/dist/vue-select.min.css">
		@endif
		<link rel="stylesheet" href="<?= route( 'aimeos_shop_jqadm_file', array( 'site' => $site, 'lang' => 'en', 'type' => 'css' ) ); ?>" />
		<style>
			body.dark .btn-theme.dark-mode {display:none}
			body.light .btn-theme.light-mode {display:none}
			.app-menu .icon {vertical-align: middle; padding: 0.5rem 1rem; font-size: 125%}
		</style>
	</head>
	<body class="{{ ($_COOKIE['aimeos_backend_theme'] ?? '') == 'dark' ? 'dark' : 'light' }}">
		<div class="app-menu">
			<span class="menu"></span>
			<div class="app-menu-end">
				<i class="icon btn-theme light-mode fa fa-sun-o"></i><i class="icon btn-theme dark-mode fa fa-moon-o"></i>
				<i class="icon logout fa fa-sign-out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></i>
				<form id="logout-form" action="{{ route( 'logout', Request::get( 'lang', app()->getLocale() ) ) ) }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
			</div>
		</div>
		<script>
			const prefersDark = window.matchMedia("(prefers-color-scheme: dark)");
			if (prefersDark.matches && !document.cookie.includes('aimeos_backend_theme=light')) {
				['light', 'dark'].map(cl => document.body.classList.toggle(cl));
			}

			document.querySelectorAll(".btn-theme").forEach(item => {
				item.addEventListener("click", function() {
					['light', 'dark'].map(cl => document.body.classList.toggle(cl));
					const theme = document.body.classList.contains("dark") ? "dark" : "light";
					document.cookie = "aimeos_backend_theme=" + theme + ";path=/";
				});
			});
		</script>

<?= $content ?>

		<script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script src="https://cdn.jsdelivr.net/combine/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js,npm/vue@2/dist/vue.min.js,npm/vue-select@3/dist/vue-select.min.js,npm/flatpickr@4,npm/flatpickr@4/dist/l10n/index.min.js,npm/flatpickr@4/dist/plugins/confirmDate/confirmDate.min.js,npm/vue-flatpickr-component@8,npm/sortablejs@1,npm/vuedraggable@2"></script>
		<script src="https://cdn.jsdelivr.net/npm/ckeditor@4/ckeditor.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/ckeditor@4/adapters/jquery.js"></script>
		<script src="<?= route( 'aimeos_shop_jqadm_file', array( 'site' => $site, 'lang' => 'en', 'type' => 'js' ) ); ?>"></script>
	</body>
</html>
