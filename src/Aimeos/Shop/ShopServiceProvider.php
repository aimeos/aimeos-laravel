<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 */


namespace Aimeos\Shop;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;


/**
 * Aimeos shop service provider for Laravel
 * @package laravel
 */
class ShopServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$ds = DIRECTORY_SEPARATOR;
		$basedir = dirname( dirname( __DIR__ ) ) . $ds;

		$this->loadRoutesFrom( $basedir . 'routes.php' );
		$this->loadViewsFrom( $basedir . 'views', 'shop' );

		$this->publishes( [ $basedir . 'config/shop.php' => config_path( 'shop.php' ) ], 'config' );
		$this->publishes( [ dirname( $basedir ) . $ds . 'public' => public_path( 'packages/aimeos/shop' ) ], 'public' );
	}


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom( dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'default.php', 'shop');

		$this->app->singleton('Aimeos\Shop\Base\Aimeos', function($app) {
			return new \Aimeos\Shop\Base\Aimeos($app['config']);
		});

		$this->app->singleton('Aimeos\Shop\Base\Config', function($app) {
			return new \Aimeos\Shop\Base\Config($app['config'], $app['Aimeos\Shop\Base\Aimeos']);
		});

		$this->app->singleton('Aimeos\Shop\Base\I18n', function($app) {
			return new \Aimeos\Shop\Base\I18n($this->app['config'], $app['Aimeos\Shop\Base\Aimeos']);
		});

		$this->app->singleton('Aimeos\Shop\Base\Locale', function($app) {
			return new \Aimeos\Shop\Base\Locale($app['config']);
		});

		$this->app->singleton('Aimeos\Shop\Base\Context', function($app) {
			return new \Aimeos\Shop\Base\Context($app['session.store'], $app['Aimeos\Shop\Base\Config'], $app['Aimeos\Shop\Base\Locale'], $app['Aimeos\Shop\Base\I18n']);
		});

		$this->app->singleton('Aimeos\Shop\Base\Support', function($app) {
			return new \Aimeos\Shop\Base\Support($app['Aimeos\Shop\Base\Context'], $app['Aimeos\Shop\Base\Locale']);
		});

		$this->app->singleton('Aimeos\Shop\Base\View', function($app) {
			return new \Aimeos\Shop\Base\View($app['config'], $app['Aimeos\Shop\Base\I18n'], $app['Aimeos\Shop\Base\Support']);
		});

		$this->app->singleton('Aimeos\Shop\Base\Shop', function($app) {
			return new \Aimeos\Shop\Base\Shop($app['Aimeos\Shop\Base\Aimeos'], $app['Aimeos\Shop\Base\Context'], $app['Aimeos\Shop\Base\View']);
		});


		$this->commands( array(
			'Aimeos\Shop\Command\AccountCommand',
			'Aimeos\Shop\Command\CacheCommand',
			'Aimeos\Shop\Command\SetupCommand',
			'Aimeos\Shop\Command\JobsCommand',
		) );
	}


	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
			'Aimeos\Shop\Base\Aimeos', 'Aimeos\Shop\Base\I18n', 'Aimeos\Shop\Base\Context',
			'Aimeos\Shop\Base\Config', 'Aimeos\Shop\Base\Locale', 'Aimeos\Shop\Base\View',
			'Aimeos\Shop\Base\Support', 'Aimeos\Shop\Base\Shop',
			'Aimeos\Shop\Command\AccountCommand', 'Aimeos\Shop\Command\CacheCommand',
			'Aimeos\Shop\Command\SetupCommand', 'Aimeos\Shop\Command\JobsCommand',
		);
	}

}