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
		<nav class="navbar navbar-expand-md navbar-light">
			<a class="navbar-brand" href="/">
				<img src="https://aimeos.org/media/logo.png" height="30" title="Aimeos Logo">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
				<ul class="navbar-nav">
					@if (Auth::guest())
						<li class="nav-item login"><a class="nav-link" href="/login">{{ __( 'Login' ) }}</a></li>
					@else
						<li class="nav-item profile dropdown">
							<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ __( 'Account' ) }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a class="nav-link" href="{{ route( 'aimeos_shop_account', ['site' => Route::current()->parameter( 'site', 'default' ),'locale' => Route::current()->parameter( 'locale', 'en' ), 'currency' => Route::current()->parameter( 'currency', 'EUR' ) ] ) }}">{{ __( 'Profile' ) }}</a></li>
								<li><form id="logout" action="{{ route( 'logout', Request::get( 'locale', app()->getLocale() ) ) }}" method="POST">{{ csrf_field() }}<button class="nav-link">{{ __( 'Logout' ) }}</button></form></li>
							</ul>
						</li>
					@endif
				</ul>
				@yield('aimeos_head')
			</div>
		</nav>

		<div class="content">
			@yield('aimeos_stage')
			@yield('aimeos_nav')
			@yield('aimeos_body')
			@yield('aimeos_aside')
			@yield('content')
		</div>

		<footer>
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-sm-6 footer-right">
							<h2 class="pb-3">LEGAL</h2>
							<p><a href="#">Terms & Conditions</a></p>
							<p><a href="#">Privacy Notice</a></p>
							<p><a href="#">Imprint</a></p>
						</div>
						<div class="col-sm-6 footer-center">
							<h2 class="pb-3">ABOUT US</h2>
							<p><a href="#">Contact us</a></p>
							<p><a href="#">Company</a></p>
						</div>
					</div>
				</div>
				<div class="col-md-4 footer-right">
					<a class="logo" href="/">
						<img src="https://aimeos.org/media/logo.png" title="Logo">
					</a>
					<div class="social">
						<p><i class="bi">facebook</i><a href="#" class="sm facebook" title="Facebook" rel="noopener">Facebook</a></p>
						<p><i class="bi">twitter</i><a href="#" class="sm twitter" title="Twitter" rel="noopener">Twitter</a></p>
						<p><i class="bi">instagram</i><a href="#" class="sm instagram" title="Instagram" rel="noopener">Instagram</a></p>
						<p><i class="bi">youtube</i><a href="#" class="sm youtube" title="Youtube" rel="noopener">Youtube</a></p>
					</div>
				</div>
			</div>
		</footer>

		<a id="toTop" class="back-to-top" href="#">
			<div class="top-icon">
				<i class="bi">arrow-up-short</i>
			</div>
		</a>

		<!-- Scripts -->
		<script type="text/javascript" src="https://cdn.jsdelivr.net/combine/npm/jquery@3,npm/bootstrap@4"></script>
		<script type="text/javascript" src="{{ asset('vendor/shop/themes/default/aimeos.js') }}"></script>
		@yield('aimeos_scripts')
	</body>
</html>
