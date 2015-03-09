<a href="http://aimeos.org/">
    <img src="http://aimeos.org/fileadmin/template/icons/logo.png" alt="Aimeos logo" title="Aimeos" align="right" height="60" />
</a>

# Aimeos Laravel package

The repository contains the Laravel web shop package for 4.1, 4.2 and 5.0
integrating the Aimeos e-commerce library into Laravel. The package provides
controllers for e.g. faceted filter, product lists and detail views, for
searching products as well as baskets and the checkout process. A full set of
pages including routing is also available for a quick start.

## Table of content

- [Installation](#installation)
- [Setup](#setup)
- [Hints](#hints)
- [License](#license)
- [Links](#links)

## Installation

The Aimeos Laravel web shop package is a composer based library that can be
installed easiest by using [Composer](https://getcomposer.org). Before, the
Aimeos provider class must be added to the `providers` array of the
`config/app.php` file so the composer post install/update scripts won't fail:

```
return array(
    'providers' => array(
        ...
        'Aimeos\Shop\ShopServiceProvider',
    ),
);
```

Make sure that the **database is set up and it is configured** in your
`config/database.php` or `.env` file (depending on the Laravel version). Then
add these lines to your composer.json of your Laravel project:

```
    "repositories": [ {
        "type": "vcs",
        "url": "https://github.com/aimeos/arcavias-core"
    } ],
    "prefer-stable": true,
    "minimum-stability": "dev",
    "require": {
        "aimeos/aimeos-laravel": "dev-master",
        ...
    },
    "scripts": {
        "post-install-cmd": [
			"php artisan aimeos:setup --option=setup/default/demo:1",
			"php artisan aimeos:cache",
        	"php artisan vendor:publish",
			...
        ],
        "post-update-cmd": [
			"php artisan aimeos:setup --option=setup/default/demo:1",
			"php artisan aimeos:cache",
        	"php artisan vendor:publish",
            ...
        ]
    }
```

Afterwards, install the Aimeos shop package using

`composer update`

In a production environment or if you don't want that the demo data gets
installed, leave out the `--option=setup/default/demo:1` option.

## Setup

To see all components and get everything working, you also need to adapt your
main Blade template in `resources/views/app.blade.php`. This is a working
example using the [Twitter bootstrap CSS framework](http://getbootstrap.com/):

```
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
@yield('aimeos_header')
	<title>Laravel</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
@yield('aimeos_styles')
	<link href="/css/app.css" rel="stylesheet">
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
@yield('aimeos_head')
	<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Laravel</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="/">Home</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="/auth/login">Login</a></li>
						<li><a href="/auth/register">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/auth/logout">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
    <div class="col-xs-12">
@yield('aimeos_nav')
@yield('aimeos_stage')
@yield('aimeos_body')
@yield('aimeos_aside')
@yield('content')
	</div>

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@yield('aimeos_scripts')
	</body>
</html>
```

**Note:** Since **Laravel 5.0** CSRF protection is enabled by default but the Aimeos
web shop package is not yet prepared to use it. You have to **disable the global
CSRF protection** and enable it manually for specific routes for now. For that
purpose, move the `App\Http\Middleware\VerifyCsrfToken` line in your
`app/Http/Kernel.php` from the `$middleware` to the `$routeMiddleware` array as
`'csrf' => 'App\Http\Middleware\VerifyCsrfToken'`:

```
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
	];

	protected $routeMiddleware = [
		'auth' => 'App\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',
		'csrf' => 'App\Http\Middleware\VerifyCsrfToken',
	];
```

Then, you should be able to call the catalog list page in your browser using

```http://<your public root>/index.php/list```

or for the administration interface:

```http://<your public root>/index.php/admin```

## Hints

To simplify development, you should configure to use no content cache. You can
do this in the `config/shop.php` file of your Laravel application by adding
these lines at the bottom:

```
    'classes' => array(
        'cache' => array(
            'manager' => array(
                'name' => 'None',
            ),
        ),
    ),
```

## License

The Aimeos Laravel package is licensed under the terms of the MIT license and
is available for free.

## Links

* [Web site](http://aimeos.org)
* [Documentation](http://aimeos.org/docs)
* [Help](http://aimeos.org/help)
* [Issue tracker](https://github.com/aimeos/aimeos-laravel/issues)
* [Source code](https://github.com/aimeos/aimeos-laravel)
