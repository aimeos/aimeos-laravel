<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 */


namespace Aimeos\Shop;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
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
		$basedir = dirname( __DIR__, 2 ) . $ds;

		$this->loadRoutesFrom( $basedir . 'routes.php' );
		$this->loadViewsFrom( $basedir . 'views', 'shop' );

		$this->publishes( [$basedir . 'config/shop.php' => config_path( 'shop.php' )], 'config' );
		$this->publishes( [dirname( $basedir ) . $ds . 'public' => public_path( 'vendor/shop' )], 'public' );

		if( file_exists( $basepath = base_path( 'ext' ) ) )
		{
			foreach( new \DirectoryIterator( $basepath ) as $entry )
			{
				if( $entry->isDir() && !$entry->isDot() && file_exists( $entry->getPathName() . '/client/html/themes' ) ) {
					$this->publishes( [$entry->getPathName() . '/client/html/themes' => public_path( 'vendor/shop/themes' )], 'public' );
				}
			}
		}

		$class = '\Composer\InstalledVersions';

		if( class_exists( $class ) && method_exists( $class, 'getInstalledPackagesByType' ) )
		{
			$extdir = base_path( 'ext' );
			$packages = \Composer\InstalledVersions::getInstalledPackagesByType( 'aimeos-extension' );

			foreach( $packages as $package )
			{
				$path = realpath( \Composer\InstalledVersions::getInstallPath( $package ) );

				if( strncmp( $path, $extdir, strlen( $extdir ) ) && file_exists( $path . '/client/html/themes' ) ) {
					$this->publishes( [$path . '/client/html/themes' => public_path( 'vendor/shop/themes' )], 'public' );
				}
			}
		}
	}


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom( dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'default.php', 'shop' );

		$this->app->singleton( 'aimeos', function( $app ) {
			return new \Aimeos\Shop\Base\Aimeos( $app['config'] );
		});

		$this->app->singleton( 'aimeos.config', function( $app ) {
			return new \Aimeos\Shop\Base\Config( $app['config'], $app['aimeos'] );
		});

		$this->app->singleton( 'aimeos.i18n', function( $app ) {
			return new \Aimeos\Shop\Base\I18n( $this->app['config'], $app['aimeos'] );
		});

		$this->app->singleton( 'aimeos.locale', function( $app ) {
			return new \Aimeos\Shop\Base\Locale( $app['config'] );
		});

		$this->app->singleton( 'aimeos.context', function( $app ) {
			return new \Aimeos\Shop\Base\Context( $app['session.store'], $app['aimeos.config'], $app['aimeos.locale'], $app['aimeos.i18n'] );
		});

		$this->app->singleton( 'aimeos.support', function( $app ) {
			return new \Aimeos\Shop\Base\Support( $app['aimeos.context'], $app['aimeos.locale'] );
		});

		$this->app->singleton( 'aimeos.view', function( $app ) {
			return new \Aimeos\Shop\Base\View( $app['config'], $app['aimeos.i18n'], $app['aimeos.support'] );
		});

		$this->app->singleton( 'aimeos.shop', function( $app ) {
			return new \Aimeos\Shop\Base\Shop( $app['aimeos'], $app['aimeos.context'], $app['aimeos.view'] );
		});


		$this->commands( array(
			'Aimeos\Shop\Command\AccountCommand',
			'Aimeos\Shop\Command\ClearCommand',
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
			'Aimeos\Shop\Command\AccountCommand', 'Aimeos\Shop\Command\ClearCommand',
			'Aimeos\Shop\Command\SetupCommand', 'Aimeos\Shop\Command\JobsCommand',
		);
	}

}