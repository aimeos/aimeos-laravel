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
		$this->package('aimeos/shop');

		require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'routes.php';
		require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'routes_admin.php';
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