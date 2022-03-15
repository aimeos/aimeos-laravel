<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar', 'az', 'dv', 'fa', 'he', 'ku', 'ur']) ? 'rtl' : 'ltr' }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Security-Policy" content="base-uri 'self'; default-src 'self' 'nonce-{{ app( 'aimeos.context' )->get()->nonce() }}'; style-src 'unsafe-inline' 'self'; img-src 'self' data: https://aimeos.org; frame-src https://www.youtube.com https://player.vimeo.com">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		@if( in_array(app()->getLocale(), ['ar', 'az', 'dv', 'fa', 'he', 'ku', 'ur']) )
			<link type="text/css" rel="stylesheet" href="{{ asset('vendor/shop/themes/default/app.rtl.css?v=' . config( 'shop.version', 1 ) ) }}">
		@else
			<link type="text/css" rel="stylesheet" href="{{ asset('vendor/shop/themes/default/app.css?v=' . config( 'shop.version', 1 ) ) }}">
		@endif
		<link type="text/css" rel="stylesheet" href="{{ asset('vendor/shop/themes/default/aimeos.css?v=' . config( 'shop.version', 1 ) ) }}" />

		@yield('aimeos_header')

		<link rel="icon" href="{{ asset( 'aimeos/' . ( app( 'aimeos.context' )->get()->locale()->getSiteItem()->getIcon() ?: '../vendor/shop/themes/default/assets/icon.png' ) ) }}"/>

		<link rel="preload" href="/vendor/shop/themes/default/assets/roboto-condensed-v19-latin-regular.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="/vendor/shop/themes/default/assets/roboto-condensed-v19-latin-700.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="/vendor/shop/themes/default/assets/bootstrap-icons.woff2" as="font" type="font/woff2" crossorigin>
	</head>
	<body class="{{ $page }}">
		<nav class="navbar navbar-expand-md navbar-top">
			<a class="navbar-brand" href="/" title="Logo">
				<img src="{{ asset( 'aimeos/' . ( app( 'aimeos.context' )->get()->locale()->getSiteItem()->getLogo() ?: '../vendor/shop/themes/default/assets/logo.png' ) ) }}" height="40" title="Logo">
			</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-top" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbar-top">
				@yield('aimeos_head_nav')
			</div>

			@yield('aimeos_head_locale')
			@yield('aimeos_head_search')

			<ul class="navbar-nav">
				@if (Auth::guest() && config('app.shop_registration'))
					<li class="nav-item register"><a class="nav-link" href="{{ airoute( 'register' ) }}" title="{{ __( 'Register' ) }}"><span class="name">{{ __('Register') }}</span></a></li>
				@endif
				@if (Auth::guest())
					<li class="nav-item login"><a class="nav-link" href="{{ airoute( 'login' ) }}" title="{{ __( 'Login' ) }}"><span class="name">{{ __( 'Login' ) }}</span></a></li>
				@else
					<li class="nav-item login profile dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false" title="{{ __( 'Account' ) }}"><span class="name">{{ __( 'Account' ) }}</span> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="dropdown-item"><a class="nav-link" href="{{ airoute( 'aimeos_shop_account' ) }}"><span class="name">{{ __( 'Profile' ) }}</span></a></li>
							<li class="dropdown-item"><form id="logout" action="{{ airoute( 'logout' ) }}" method="POST">{{ csrf_field() }}<button class="nav-link"><span class="name">{{ __( 'Logout' ) }}</span></button></form></li>
						</ul>
					</li>
				@endif
			</ul>

			@yield('aimeos_head_basket')
		</nav>

		<div class="content">
			@yield('aimeos_stage')
			@yield('aimeos_body')
			@yield('content')
		</div>


		<footer>
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<div class="row">
							<div class="col-sm-6 footer-left">
								<div class="footer-block">
									<h2 class="pb-3">{{ __( 'LEGAL' ) }}</h2>
									<p><a href="#">{{ __( 'Terms & Conditions' ) }}</a></p>
									<p><a href="#">{{ __( 'Privacy Notice' ) }}</a></p>
									<p><a href="#">{{ __( 'Imprint' ) }}</a></p>
								</div>
							</div>
							<div class="col-sm-6 footer-center">
								<div class="footer-block">
									<h2 class="pb-3">{{ __( 'ABOUT US' ) }}</h2>
									<p><a href="#">{{ __( 'Contact us' ) }}</a></p>
									<p><a href="#">{{ __( 'Company' ) }}</a></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 footer-right">
						<div class="footer-block">
							<a class="logo" href="/" title="Logo">
							    <img src="{{ asset( 'aimeos/' . ( app( 'aimeos.context' )->get()->locale()->getSiteItem()->getLogo() ?: '../vendor/shop/themes/default/assets/logo.png' ) ) }}" height="40" title="Logo">
							</a>
							<div class="social">
								<p><a href="#" class="sm facebook" title="Facebook" rel="noopener">Facebook</a></p>
								<p><a href="#" class="sm twitter" title="Twitter" rel="noopener">Twitter</a></p>
								<p><a href="#" class="sm instagram" title="Instagram" rel="noopener">Instagram</a></p>
								<p><a href="#" class="sm youtube" title="Youtube" rel="noopener">Youtube</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>



		<a id="toTop" class="back-to-top" href="#" title="{{ __( 'Back to top' ) }}">
			<div class="top-icon"></div>
		</a>

		<!-- Scripts -->
		<script src="{{ asset('vendor/shop/themes/default/app.js?v=' . config( 'shop.version', 1 ) ) }}"></script>
		<script src="{{ asset('vendor/shop/themes/default/aimeos.js?v=' . config( 'shop.version', 1 ) ) }}"></script>
		@yield('aimeos_scripts')
	</body>
</html>
