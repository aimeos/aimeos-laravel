<a href="https://aimeos.org/">
    <img src="https://aimeos.org/fileadmin/template/icons/logo.png" alt="Aimeos logo" title="Aimeos" align="right" height="60" />
</a>

# Aimeos Laravel package
[![Build Status](https://travis-ci.org/aimeos/aimeos-laravel.svg)](https://travis-ci.org/aimeos/aimeos-laravel)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/aimeos/aimeos-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/aimeos/aimeos-laravel/?branch=master)
[![HHVM Status](http://hhvm.h4cc.de/badge/aimeos/aimeos-laravel.svg)](http://hhvm.h4cc.de/package/aimeos/aimeos-laravel)

The repository contains the web shop package for Laravel 5
integrating the Aimeos e-commerce library into Laravel. The package provides
controllers for e.g. faceted filter, product lists and detail views, for
searching products as well as baskets and the checkout process. A full set of
pages including routing is also available for a quick start.

[![Aimeos Laravel demo](https://aimeos.org/fileadmin/user_upload/laravel-demo.jpg)](http://laravel.demo.aimeos.org/)

## Table of content

- [Installation](#installation)
- [Setup](#setup)
- [Hints](#hints)
- [License](#license)
- [Links](#links)

## Installation or update

The Aimeos Laravel web shop package is a composer based library that can be
installed easiest by using [Composer](https://getcomposer.org).

Make sure that the **database is set up and it is configured** in your
`config/database.php` or `.env` file (depending on the Laravel version). Then
add these lines to your composer.json of your Laravel project:

```
    "prefer-stable": true,
    "minimum-stability": "dev",
    "require": {
        "aimeos/aimeos-laravel": "dev-master",
        ...
    },
    "scripts": {
        "post-install-cmd": [
            "php artisan vendor:publish",
            "php artisan migrate",
            ...
        ],
        "post-update-cmd": [
            "php artisan vendor:publish --tag=public --force",
            "php artisan vendor:publish",
            "php artisan migrate",
            ...
        ]
    }
```

Afterwards, install the Aimeos shop package using

`composer update`

Next, the Aimeos provider class must be added to the `providers` array of the
`config/app.php` file so the application and Laravel command task will work:

```
return array(
    'providers' => array(
        ...
        'Aimeos\Shop\ShopServiceProvider',
    ),
);
```

In the last step you must now execute these artisan commands to get a working
or updated Aimeos installation:

```
php artisan aimeos:setup --option=setup/default/demo:1
php artisan aimeos:cache
```

In a production environment or if you don't want that the demo data gets
installed, leave out the `--option=setup/default/demo:1` option.

## Setup

To see all components and get everything working, you also need to adapt your
main Blade template in `resources/views/app.blade.php`. This is a working
example using the [Twitter bootstrap CSS framework](http://getbootstrap.com/):

```
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
@yield('aimeos_header')
	<title>Aimeos on Laravel</title>

	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
@yield('aimeos_styles')
	<link href="/css/app.css" rel="stylesheet">
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
	<script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@yield('aimeos_scripts')
	</body>
</html>
```

**Note:** Since **Laravel 5.0** CSRF protection is enabled by default but for the
```/confirm``` and ```/update``` routes, you may have to [disable CSRF](http://laravel.com/docs/5.1/routing#csrf-excluding-uris)
if one of the payment providers is sending data via POST requests.

Afterwards, you should clear the Laravel cache files. Otherwise, you might get
an exception due to old cached data.

```php artisan cache:clear```

Then, you should be able to call the catalog list page in your browser. For a
quick start, you can use the integrated web server that is available since PHP 5.4.
Simply execute this command in the base directory of your application:

```php -S 127.0.0.1:8000 -t public```

Afterwards, you will be able to open the list page of the shop in your browser using:

http://127.0.0.1:8000/index.php/list

or for the administration interface:

http://127.0.0.1:8000/index.php/admin

**Caution:** You need to protect the ```/admin``` routes so only editors are
able to access them. This is especially crucial as it grants direct access to
the administration interface where you can manage your shop!

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

* [Web site](https://aimeos.org/Laravel)
* [Documentation](https://aimeos.org/docs/Laravel)
* [Help](https://aimeos.org/help/laravel-package-f18/)
* [Issue tracker](https://github.com/aimeos/aimeos-laravel/issues)
* [Source code](https://github.com/aimeos/aimeos-laravel)
