<a href="https://aimeos.org/">
    <img src="https://aimeos.org/fileadmin/template/icons/logo.png" alt="Aimeos logo" title="Aimeos" align="right" height="60" />
</a>

# Aimeos Laravel ecommerce package
[![Total Downloads](https://poser.pugx.org/aimeos/aimeos-laravel/d/total.svg)](https://packagist.org/packages/aimeos/aimeos-laravel)
[![Build Status](https://circleci.com/gh/aimeos/aimeos-laravel.svg?style=shield)](https://circleci.com/gh/aimeos/aimeos-laravel)
[![Coverage Status](https://coveralls.io/repos/aimeos/aimeos-laravel/badge.svg?branch=master&service=github)](https://coveralls.io/github/aimeos/aimeos-laravel?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/aimeos/aimeos-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/aimeos/aimeos-laravel/?branch=master)
[![License](https://poser.pugx.org/aimeos/aimeos/license.svg)](https://packagist.org/packages/aimeos/aimeos)

:star: Star us on GitHub — it helps!

[Aimeos](https://aimeos.org/Laravel) is THE professional, full-featured and
ultra fast e-commerce package for Laravel!  You can install it in your
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

This document is for the Aimeos Laravel package **2021.10 and later**.

- LTS release: 2021.10 (6.x, 7.x and 8.x)

If you want to **upgrade between major versions**, please have a look into the
[upgrade guide](https://aimeos.org/docs/latest/laravel/setup/#upgrade)!

## Basic application

### Full shop application

If you want to set up a new application or test Aimeos, we recommend the
[Aimeos shop application](https://github.com/aimeos/aimeos). You need
*composer 2.1+* to install Aimeos.

It will install a complete shop system including demo data for a quick start
without the need to follow the steps described in this readme.

```
wget https://getcomposer.org/download/latest-stable/composer.phar -O composer
php composer create-project aimeos/aimeos myshop
```

More about the full package: :star: [Aimeos shop](https://github.com/aimeos/aimeos)

### Shop package only

The Aimeos Laravel online shop package is a composer based library. It can be
installed easiest by using [Composer 2.1+](https://getcomposer.org) in the root
directory of your exisisting Laravel application:

```
wget https://getcomposer.org/download/latest-stable/composer.phar -O composer
php composer require aimeos/aimeos-laravel:~2021.10
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
[supported database servers](https://aimeos.org/docs/latest/infrastructure/databases/)
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
        "aimeos/aimeos-laravel": "~2021.10",
        ...
    },
    "scripts": {
        "post-update-cmd": [
            "@php artisan migrate",
            "@php artisan vendor:publish --tag=public --force",
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
Laravel installation but the **home page stays untouched!** If you want to add Aimeos to
the home page as well, replace the route for "/" in `./routes/web.php` by this line:

```php
Route::group(['middleware' => ['web']], function () {
	Route::get('/', '\Aimeos\Shop\Controller\CatalogController@homeAction')->name('aimeos_home');
});
```

For multi-vendor setups, read the article about [multiple shops](https://aimeos.org/docs/latest/laravel/customize/#multiple-shops).

This will display the Aimeos catalog home component on the home page you you get a
nice looking shop home page. The `/shop` page will look like:

[![Aimeos frontend](https://aimeos.org/fileadmin/aimeos.org/images/aimeos-frontend.jpg?2021.07)](http://127.0.0.1:8000/index.php/shop)

## Admin

To use the admin interface, you have to set up Laravel authentication first:

### Laravel 8

```
composer require laravel/jetstream
php artisan jetstream:install livewire
npm install && npm run dev
```

For more information, please follow the Laravel documentation:
* [Laravel 8.x](https://laravel.com/docs/8.x/authentication)

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
mkdir public/aimeos public/vendor
chmod 777 public/aimeos public/vendor
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
