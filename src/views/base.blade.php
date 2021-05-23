<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar', 'az', 'dv', 'fa', 'he', 'ku', 'ur']) ? 'rtl' : 'ltr' }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@yield('aimeos_header')
	<title>{{ config('app.name', 'Aimeos') }}</title>
	<link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4/dist/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="{{ asset(config('shop.client.html.common.template.baseurl', 'vendor/shop/themes/elegance') . '/aimeos.css') }}" />
	@yield('aimeos_styles')
	<style>
		/* Theme: Black&White */
		/* body {
			--ai-primary: #000; --ai-primary-light: #000; --ai-primary-alt: #fff;
			--ai-bg: #fff; --ai-bg-light: #fff; --ai-bg-alt: #000;
			--ai-secondary: #555; --ai-light: #D0D0D0;
		} */
		body { color: #000; color: var(--ai-primary, #000); background-color: #fff; background-color: var(--ai-bg, #fff); }
		.navbar, footer { color: #555; color: var(--ai-primary-alt, #555); background-color: #f8f8f8; background-color: var(--ai-bg-alt, #f8f8f8); }
		.navbar a:not(.btn), .navbar a:before, .navbar span, footer a:not(.btn) { color: #555 !important; color: var(--ai-primary-alt, #555) !important; }
		.content { margin: 0 5% } .catalog-stage-image { margin: 0 -5.55% }
		.sm { display: block } .sm:before { font: normal normal normal 14px/1 FontAwesome; padding: 0 0.2em; font-size: 225% }
		.facebook:before { content: "\f082" } .twitter:before { content: "\f081" } .instagram:before { content: "\f16d" } .youtube:before { content: "\f167" }
	</style>
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-light">
		<a class="navbar-brand" href="/">
			<img src="http://aimeos.org/fileadmin/template/icons/logo.png" height="30" title="Aimeos Logo">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
			<ul class="navbar-nav">
				@if (Auth::guest())
					<li class="nav-item login"><a class="nav-link" href="/login">Login</a></li>
				@else
					<li class="nav-item profile dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a class="nav-link" href="{{ route('aimeos_shop_account',['site'=>Route::current()->parameter('site','default'),'locale'=>Route::current()->parameter('locale','en'),'currency'=>Route::current()->parameter('currency','EUR')]) }}" title="Profile">Profile</a></li>
							<li><form id="logout" action="/logout" method="POST">{{csrf_field()}}</form><a class="nav-link" href="javascript: document.getElementById('logout').submit();">Logout</a></li>
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
		@yield('aimeos_aside')
		@yield('aimeos_body')
		@yield('content')
	</div>
	<footer class="mt-5 p-5">
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-sm-6 my-4">
						<h2 class="pb-3">LEGAL</h2>
						<p><a href="#">Terms & Conditions</a></p>
						<p><a href="#">Privacy Notice</a></p>
						<p><a href="#">Imprint</a></p>
					</div>
					<div class="col-sm-6 my-4">
						<h2 class="pb-3">ABOUT US</h2>
						<p><a href="#">Contact us</a></p>
						<p><a href="#">Company</a></p>
					</div>
				</div>
			</div>
			<div class="col-md-4 my-4">
				<a class="px-2 py-4 d-inline-block" href="/">
					<img src="http://aimeos.org/fileadmin/template/icons/logo.png" style="width: 160px" title="Logo">
				</a>
				<div class="social">
					<a href="#" class="sm facebook" title="Facebook" rel="noopener">Facebook</a>
					<a href="#" class="sm twitter" title="Twitter" rel="noopener">Twitter</a>
					<a href="#" class="sm instagram" title="Instagram" rel="noopener">Instagram</a>
					<a href="#" class="sm youtube" title="Youtube" rel="noopener">Youtube</a>
				</div>
			</div>
		</div>
	</footer>
	<!-- Scripts -->
	<script type="text/javascript" src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/combine/npm/jquery@3,npm/bootstrap@4"></script>
	<script type="text/javascript" src="{{ asset('vendor/shop/themes/aimeos.js') }}"></script>
	<script type="text/javascript" src="{{ asset(config('shop.client.html.common.template.baseurl', 'vendor/shop/themes/elegance') . '/aimeos.js') }}"></script>
	@yield('aimeos_scripts')
	</body>
</html>
