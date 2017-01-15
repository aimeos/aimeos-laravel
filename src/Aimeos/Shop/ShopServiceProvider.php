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
		$basedir = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR;
		$confpath = config_path('shop.php');

		$config = array_replace_recursive(
			$this->app['config']->get('shop', []),
			require $basedir.'default.php',
			(file_exists($confpath) ? require $confpath : array())
		);
		$this->app['config']->set('shop', $config);

		$this->loadViewsFrom($basedir.'views', 'shop');


		$this->publishes(array(
			$basedir.'config/shop.php' => config_path('shop.php'),
		), 'config');

		$this->publishes(array(
			$basedir.'views' => base_path('resources/views/vendor/shop'),
		), 'views');

		$this->publishes(array(
			dirname($basedir).DIRECTORY_SEPARATOR.'public' => public_path('packages/aimeos/shop'),
		), 'public');


		require $basedir.'routes.php';
	}


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('\Aimeos\Shop\Base\Aimeos', function($app) {
			return new \Aimeos\Shop\Base\Aimeos($app['config']);
		});

		$this->app->singleton('\Aimeos\Shop\Base\Config', function($app) {
			return new \Aimeos\Shop\Base\Config($app['config'], $app['\Aimeos\Shop\Base\Aimeos']);
		});

		$this->app->singleton('\Aimeos\Shop\Base\I18n', function($app) {
			return new \Aimeos\Shop\Base\I18n($this->app['config'], $app['\Aimeos\Shop\Base\Aimeos']);
		});

		$this->app->singleton('\Aimeos\Shop\Base\Locale', function($app) {
			return new \Aimeos\Shop\Base\Locale($app['config']);
		});

		$this->app->singleton('\Aimeos\Shop\Base\Context', function($app) {
			return new \Aimeos\Shop\Base\Context($app['session.store'], $app['\Aimeos\Shop\Base\Config'], $app['\Aimeos\Shop\Base\Locale'], $app['\Aimeos\Shop\Base\I18n']);
		});

		$this->app->singleton('\Aimeos\Shop\Base\Page', function($app) {
			return new \Aimeos\Shop\Base\Page($app['config'], $app['\Aimeos\Shop\Base\Aimeos'], $app['\Aimeos\Shop\Base\Context'], $app['\Aimeos\Shop\Base\Locale'], $app['\Aimeos\Shop\Base\View']);
		});

		$this->app->singleton('\Aimeos\Shop\Base\Support', function($app) {
			return new \Aimeos\Shop\Base\Support($app['\Aimeos\Shop\Base\Context'], $app['\Aimeos\Shop\Base\Locale']);
		});

		$this->app->singleton('\Aimeos\Shop\Base\View', function($app) {
			return new \Aimeos\Shop\Base\View($app['\Aimeos\Shop\Base\I18n'], $app['\Aimeos\Shop\Base\Support']);
		});


		$this->app['command.aimeos.account'] = $this->app->share(function() {
			return new Command\AccountCommand();
		});

		$this->app['command.aimeos.cache'] = $this->app->share(function() {
			return new Command\CacheCommand();
		});

		$this->app['command.aimeos.jobs'] = $this->app->share(function() {
			return new Command\JobsCommand();
		});

		$this->app['command.aimeos.setup'] = $this->app->share(function() {
			return new Command\SetupCommand();
		});

		$this->commands('command.aimeos.account');
		$this->commands('command.aimeos.cache');
		$this->commands('command.aimeos.setup');
		$this->commands('command.aimeos.jobs');
	}


	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
			'command.aimeos.account', 'command.aimeos.cache', 'command.aimeos.jobs', 'command.aimeos.setup',
			'\Aimeos\Shop\Base\Aimeos', '\Aimeos\Shop\Base\I18n', '\Aimeos\Shop\Base\Context',
			'\Aimeos\Shop\Base\Config', '\Aimeos\Shop\Base\Locale', '\Aimeos\Shop\Base\View',
			'\Aimeos\Shop\Base\Page', '\Aimeos\Shop\Base\Support'
		);
	}

}