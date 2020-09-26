<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		@yield('aimeos_header')
		<title>Laravel</title>
		@yield('aimeos_styles')
	</head>
	<body>
		<nav class="navbar navbar-default">
			@yield('aimeos_head')
		</nav>
		@yield('aimeos_nav')
		@yield('aimeos_stage')
		@yield('aimeos_body')
		@yield('aimeos_aside')
		@yield('content')

		@yield('aimeos_scripts')
	</body>
</html>
