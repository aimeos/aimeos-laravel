<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015
 */


namespace Aimeos\Shop;

use Illuminate\Support\ServiceProvider;


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

		if (method_exists($this,'package')) {
			$this->package('aimeos/shop');
		}

		if (method_exists($this,'loadViewsFrom')) {
			$this->loadViewsFrom($basedir.'views', 'shop');
		}

		if (method_exists($this,'publishes')) {
			$this->publishes(array(
				$basedir.'config/config.php' => config_path('shop.php'),
				$basedir.'database/migrations' => base_path('database/migrations'),
				$basedir.'views' => base_path('resources/views/vendor/aimeos/shop'),
				dirname($basedir).DIRECTORY_SEPARATOR.'public' => public_path('packages/aimeos/shop'),
			));
		}

		require_once $basedir.'routes.php';
		require_once $basedir.'routes_admin.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['command.aimeos.cache'] = $this->app->share(function($app) {
			return new Command\CacheCommand();
		});

		$this->commands('command.aimeos.cache');

		$this->app['command.aimeos.jobs'] = $this->app->share(function($app) {
			return new Command\JobsCommand();
		});

		$this->commands('command.aimeos.jobs');

		$this->app['command.aimeos.setup'] = $this->app->share(function($app) {
			return new Command\SetupCommand();
		});

		$this->commands('command.aimeos.setup');

		if (method_exists($this,'mergeConfigFrom')) {
			$this->mergeConfigFrom(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.'config/config.php', 'shop::config');
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('command.aimeos.cache', 'command.aimeos.jobs', 'command.aimeos.setup');
	}

}