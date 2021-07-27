<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar', 'az', 'dv', 'fa', 'he', 'ku', 'ur']) ? 'rtl' : 'ltr' }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Security-Policy" content="default-src 'self' https://cdn.jsdelivr.net; style-src 'unsafe-inline' 'self' https://cdn.jsdelivr.net; img-src 'self' data: https://cdn.jsdelivr.net https://aimeos.org">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		@yield('aimeos_header')

		<title>{{ config('app.name', 'Aimeos') }}</title>

		<link rel="preload" href="/vendor/shop/themes/default/fonts/roboto-condensed-v19-latin/roboto-condensed-v19-latin-regular.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="/vendor/shop/themes/default/fonts/roboto-condensed-v19-latin/roboto-condensed-v19-latin-700.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="/vendor/shop/themes/default/fonts/bootstrap-icons.woff2" as="font" type="font/woff2" crossorigin>

		<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/css/bootstrap.min.css">
		<link type="text/css" rel="stylesheet" href="{{ asset('vendor/shop/themes/default/aimeos.css') }}" />

		@yield('aimeos_styles')

	</head>
	<body>
		<nav class="navbar navbar-expand-md navbar-light navbar-top">
			<a class="navbar-brand" href="/" title="Logo">
				<img src="https://aimeos.org/media/logo-white.svgz" height="40" title="Logo">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				@yield('aimeos_nav')

				<ul class="navbar-nav">
					@if (Auth::guest() && config('app.shop_registration'))
						<li class="nav-item register"><a class="nav-link" href="{{ airoute( 'register' ) }}" title="{{ __( 'Register' ) }}">{{ __('Register') }}</a></li>
					@endif
					@if (Auth::guest())
						<li class="nav-item login"><a class="nav-link" href="{{ airoute( 'login' ) }}" title="{{ __( 'Login' ) }}"><span>{{ __( 'Login' ) }}</span></a></li>
					@else
						<li class="nav-item login profile dropdown">
						    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" title="{{ __( 'Account' ) }}"><span class="">{{ __( 'Account' ) }}</span> <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a class="nav-link" href="{{ airoute( 'aimeos_shop_account' ) }}"><span>{{ __( 'Profile' ) }}</span></a></li>
								<li><form id="logout" action="{{ airoute( 'logout' ) }}" method="POST">{{ csrf_field() }}<button class="nav-link">{{ __( 'Logout' ) }}</button></form></li>
							</ul>
						</li>
					@endif
				</ul>

				@yield('aimeos_head')
			</div>
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
							    <img src="https://aimeos.org/media/logo-white.svgz" height="40" title="Logo">
							</a>
							<div class="social">
								<p><i class="bi">facebook</i><a href="#" class="sm facebook" title="Facebook" rel="noopener">Facebook</a></p>
								<p><i class="bi">twitter</i><a href="#" class="sm twitter" title="Twitter" rel="noopener">Twitter</a></p>
								<p><i class="bi">instagram</i><a href="#" class="sm instagram" title="Instagram" rel="noopener">Instagram</a></p>
								<p><i class="bi">youtube</i><a href="#" class="sm youtube" title="Youtube" rel="noopener">Youtube</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>



		<a id="toTop" class="back-to-top" href="#" title="{{ __( 'Back to top' ) }}">
			<div class="top-icon">
				<i class="bi">arrow-up-short</i>
			</div>
		</a>

		<!-- Scripts -->
		<script src="https://cdn.jsdelivr.net/combine/npm/jquery@3,npm/bootstrap@4"></script>
		<script src="{{ asset('vendor/shop/themes/default/aimeos.js') }}"></script>
		@yield('aimeos_scripts')
	</body>
</html>
