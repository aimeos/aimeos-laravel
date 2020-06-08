<a href="https://aimeos.org/">
    <img src="https://aimeos.org/fileadmin/template/icons/logo.png" alt="Aimeos logo" title="Aimeos" align="right" height="60" />
</a>

# Aimeos Laravel package
[![Total Downloads](https://poser.pugx.org/aimeos/aimeos-laravel/d/total.svg)](https://packagist.org/packages/aimeos/aimeos-laravel)
[![Build Status](https://travis-ci.org/aimeos/aimeos-laravel.svg)](https://travis-ci.org/aimeos/aimeos-laravel)
[![Coverage Status](https://coveralls.io/repos/aimeos/aimeos-laravel/badge.svg?branch=master&service=github)](https://coveralls.io/github/aimeos/aimeos-laravel?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/aimeos/aimeos-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/aimeos/aimeos-laravel/?branch=master)

:star: Star us on GitHub — it helps!

[Aimeos](https://aimeos.org/Laravel) is THE professional, full-featured and
ultra fast e-commerce package for Laravel 5 and 6!  You can install it in your
existing Laravel application within 5 minutes and can adapt, extend, overwrite
and customize anything to your needs.

[![Aimeos Laravel demo](https://aimeos.org/fileadmin/aimeos.org/images/aimeos-github.png)](http://laravel.demo.aimeos.org/)

## Table of content

- [Supported versions](#supported-versions)
- [Basic application](#basic-application)
- [Database](#database)
- [Installation](#installation)
- [Setup](#setup)
- [Admin](#admin)
- [Hints](#hints)
- [License](#license)
- [Links](#links)

## Supported versions

This document is for the Aimeos Laravel package **2019.10 and later**.

- Stable release: 2020.04 (6.x and 7.x)
- LTS release: 2019.10 (Laravel 5.5+, 6.x and 7.x)

If you want to **upgrade between major versions**, please have a look into the
[upgrade guide](https://aimeos.org/docs/Laravel/Upgrade)!

## Basic application

### Full shop application

If you want to set up a new application or test Aimeos, we recommend the
[Aimeos shop application](https://github.com/aimeos/aimeos). It will install a
complete shop system using the **last LTS version** including demo data for a quick
start without the need to follow the steps described in this readme:

```
composer create-project aimeos/aimeos myshop
```

More about the full package: :star: [Aimeos shop](https://github.com/aimeos/aimeos)

### Shop package only

The Aimeos Laravel online shop package is a composer based library. It can be
installed easiest by using [Composer](https://getcomposer.org) in the root
directory of your exisisting Laravel application:

```
composer require aimeos/aimeos-laravel:~2020.04
```

## Database

Make sure that you've **created the database** in advance and added the configuration
to the `.env` file in your application directory. Sometimes, using the .env file makes
problems and you will get exceptions that the connection to the database failed. In that
case, add the database credentials to the **resource/db section of your ./config/shop.php**
file too!

If you don't have at least MySQL 5.7.8 or MariaDB 10.2.2 installed, you will probably get an error like

```Specified key was too long; max key length is 767 bytes```

To circumvent this problem, drop the new tables if there have been any created and
change the charset/collation setting in `./config/database.php` to these values before
installing Aimeos again:

```php
'connections' => [
    'mysql' => [
        // ...
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        // ...
    ]
]
```

If you want to use a database server other than MySQL, please have a look into the article about
[supported database servers](https://aimeos.org/docs/Developers/Library/Database_support)
and their specific configuration. Supported are:

* MySQL, MariaDB (fully)
* PostgreSQL (fully)
* SQL Server (fully)

## Installation

Then, add these lines to the composer.json of the **Laravel skeleton application**:

```
    "prefer-stable": true,
    "minimum-stability": "dev",
    "require": {
        "aimeos/aimeos-laravel": "~2020.04",
        ...
    },
    "scripts": {
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=public --force",
            "@php artisan migrate",
            "\\Aimeos\\Shop\\Composer::join"
        ],
        ...
    }
```

Afterwards, install the Aimeos shop package using

`composer update`

In the last step you must now execute these artisan commands to get a working
or updated Aimeos installation:

```
php artisan vendor:publish --all
php artisan migrate
php artisan aimeos:setup --option=setup/default/demo:1
```

In a production environment or if you don't want that the demo data gets
installed, leave out the `--option=setup/default/demo:1` option.

## Setup

To see all components and get everything working, you also need to create your
main Blade template in `resources/views/app.blade.php`. This is a working
example using the [Twitter bootstrap CSS framework](http://getbootstrap.com/):

```html
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@yield('aimeos_header')
	<title>Aimeos on Laravel</title>
	<link type="text/css" rel="stylesheet" href='https://fonts.googleapis.com/css?family=Roboto:400,300'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<style>
		/* Theme: Black&White */
		/* body {
			--ai-primary: #000; --ai-primary-light: #000; --ai-primary-alt: #fff;
			--ai-bg: #fff; --ai-bg-light: #fff; --ai-bg-alt: #000;
			--ai-secondary: #555; --ai-light: #D0D0D0;
		} */
		body { color: #000; color: var(--ai-primary, #000); background-color: #fff; background-color: var(--ai-bg, #fff); }
		.navbar, footer { color: #555; color: var(--ai-primary-alt, #555); background-color: #f8f8f8; background-color: var(--ai-bg-alt, #f8f8f8); }
		.navbar a, .navbar a:before, .navbar span, footer a { color: #555 !important; color: var(--ai-primary-alt, #555) !important; }
		.sm:before { font: normal normal normal 14px/1 FontAwesome; padding: 0 0.2em; font-size: 225% }
		.facebook:before { content: "\f082" } .twitter:before { content: "\f081" } .instagram:before { content: "\f16d" } .youtube:before { content: "\f167" }
	</style>
	@yield('aimeos_styles')
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-light mb-5">
		<a class="navbar-brand" href="/">
			<img src="http://aimeos.org/fileadmin/template/icons/logo.png" height="30" title="Aimeos Logo">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
			<ul class="navbar-nav">
				@if (Auth::guest())
					<li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
					<li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
				@else
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
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
    <div class="container">
		@yield('aimeos_nav')
		@yield('aimeos_stage')
		@yield('aimeos_body')
		@yield('aimeos_aside')
		@yield('content')
	</div>
	<footer class="mt-5 p-5">
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="col-sm-6 my-4"><h2>LEGAL</h2><p><a href="#">Terms & Conditions</a></p><p><a href="#">Privacy Notice</a></p><p><a href="#">Imprint</a></p></div>
					<div class="col-sm-6 my-4"><h2>ABOUT US</h2><p><a href="#">Contact us</a></p><p><a href="#">Company</a></p></div>
				</div>
			</div>
			<div class="col-md-4 my-4">
				<div class="social"><a href="#" class="sm facebook"></a><a href="#" class="sm twitter"></a><a href="#" class="sm instagram"></a><a href="#" class="sm youtube"></a></div>
				<a style="display: inline-block; padding: 1.5em 0.5em" href="/"><img src="http://aimeos.org/fileadmin/template/icons/logo.png" style="width: 200px; max-width: 100%" title="Aimeos Logo"></a>
			</div>
		</div>
	</footer>
	<!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	@yield('aimeos_scripts')
	</body>
</html>
```

Afterwards, you should clear the Laravel cache files. Otherwise, you might get
an exception due to old cached data.

```php artisan cache:clear```

To reference images correctly, you have to adapt your `.env` file and set the `APP_URL`
to your real URL, e.g.

```APP_URL=http://127.0.0.1:8000```

**Caution:** Make sure, Laravel uses the `file` session driver in your `.env` file!
Otherwise, the shopping basket content won't get stored correctly!

```SESSION_DRIVER=file```

Then, you should be able to call the catalog list page in your browser. For a
quick start, you can use the integrated web server that is available since PHP 5.4.
Simply execute this command in the base directory of your application:

```php artisan serve```

Point your browser to the list page of the shop using:

http://127.0.0.1:8000/index.php/shop

**Note:** Integrating the Aimeos package adds some routes like `/shop` or `/admin` to your
Laravel installation but the **home page stays untouched!**

[![Aimeos frontend](https://aimeos.org/fileadmin/aimeos.org/images/aimeos-frontend.png)](http://127.0.0.1:8000/index.php/shop)

## Admin

To use the admin interface, you have to set up Laravel authentication first:

### Laravel 7

```
composer require laravel/ui:^2.0
php artisan ui vue --auth
npm install && npm run dev
```

For more information, please follow the Laravel documentation:
* [Laravel 7.x](https://laravel.com/docs/7.x/authentication)

### Laravel 6

```
composer require laravel/ui:^1.0
php artisan ui vue --auth
npm install && npm run dev
```

For more information, please follow the Laravel documentation:
* [Laravel 6.x](https://laravel.com/docs/6.x/authentication)

### Laravel 5.x

```php artisan make:auth```

For more information, please follow the Laravel documentation:
* [Laravel 5.8](https://laravel.com/docs/5.8/authentication)
* [Laravel 5.7](https://laravel.com/docs/5.7/authentication)
* [Laravel 5.6](https://laravel.com/docs/5.6/authentication)
* [Laravel 5.5](https://laravel.com/docs/5.5/authentication)

### Create account

Test if your authentication setup works before you continue. Create an admin account
for your Laravel application so you will be able to log into the Aimeos admin interface:

```php artisan aimeos:account --super <email>```

The e-mail address is the user name for login and the account will work for the
frontend too. To protect the new account, the command will ask you for a password.
The same command can create limited accounts by using "--admin", "--editor" or "--api"
instead of "--super" (access to everything).

### Configure authentication

As a last step, you need to extend the `boot()` method of your
`App\Providers\AuthServiceProvider` class and add the lines to define how
authorization for "admin" is checked in `app/Providers/AuthServiceProvider.php`:

```php
    public function boot()
    {
        // Keep the lines before

        Gate::define('admin', function($user, $class, $roles) {
            if( isset( $user->superuser ) && $user->superuser ) {
                return true;
            }
            return app( '\Aimeos\Shop\Base\Support' )->checkUserGroup( $user, $roles );
        });
    }
```

### Test

If your `./public` directory isn't writable by your web server, you have to create these
directories:
```
mkdir public/files public/preview public/uploads
chmod 777 public/files public/preview public/uploads
```

In a production environment, you should be more specific about the granted permissions!
If you've still started the internal PHP web server (`php artisan serve`)
you should now open this URL in your browser:

http://127.0.0.1:8000/index.php/admin

Enter the e-mail address and the password of the newly created user and press "Login".
If you don't get redirected to the admin interface (that depends on the authentication
code you've created according to the Laravel documentation), point your browser to the
`/admin` URL again.

**Caution:** Make sure that you aren't already logged in as a non-admin user! In this
case, login won't work because Laravel requires to log out first.

[![Aimeos backend](https://aimeos.org/fileadmin/aimeos.org/images/aimeos-backend.png)](http://127.0.0.1:8000/index.php/admin)

## Hints

To simplify development, you should configure to use no content cache. You can
do this in the `config/shop.php` file of your Laravel application by adding
these lines at the bottom:

```php
    'madmin' => array(
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
* [Forum](https://aimeos.org/help/laravel-package-f18/)
* [Issue tracker](https://github.com/aimeos/aimeos-laravel/issues)
* [Composer packages](https://packagist.org/packages/aimeos/aimeos-laravel)
* [Source code](https://github.com/aimeos/aimeos-laravel)
