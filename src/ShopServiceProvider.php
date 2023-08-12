<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2023
 */


namespace Aimeos\Shop;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;


/**
 * Aimeos shop service provider for Laravel
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
		$this->loadViewsFrom( dirname( __DIR__ ) . '/views', 'shop' );
		$this->loadRoutesFrom( dirname( __DIR__ ) . '/routes/aimeos.php' );

		$this->publishes( [dirname( __DIR__ ) . '/config/shop.php' => config_path( 'shop.php' )], 'config' );
		$this->publishes( [dirname( __DIR__ ) . '/public' => public_path( 'vendor/shop' )], 'public' );

		if( file_exists( $basepath = base_path( 'ext' ) ) )
		{
			foreach( new \DirectoryIterator( $basepath ) as $entry )
			{
				if( $entry->isDir() && !$entry->isDot() && file_exists( $entry->getPathName() . '/themes/client/html' ) ) {
					$this->publishes( [$entry->getPathName() . 'themes/client/html/' => public_path( 'vendor/shop/themes' )], 'public' );
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

				if( strncmp( $path, $extdir, strlen( $extdir ) ) && file_exists( $path . '/themes/client/html' ) ) {
					$this->publishes( [$path . '/themes/client/html' => public_path( 'vendor/shop/themes' )], 'public' );
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
		$this->mergeConfigFrom( dirname( __DIR__ ) . '/config/default.php', 'shop' );

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


		$this->app->bind( 'aimeos.frontend.attribute', function( $app ) {
			return \Aimeos\Controller\Frontend::create( $app['aimeos.context'], 'attribute' );
		});

		$this->app->bind( 'aimeos.frontend.basket', function( $app ) {
			return \Aimeos\Controller\Frontend::create( $app['aimeos.context'], 'basket' );
		});

		$this->app->bind( 'aimeos.frontend.catalog', function( $app ) {
			return \Aimeos\Controller\Frontend::create( $app['aimeos.context'], 'catalog' );
		});

		$this->app->bind( 'aimeos.frontend.cms', function( $app ) {
			return \Aimeos\Controller\Frontend::create( $app['aimeos.context'], 'cms' );
		});

		$this->app->bind( 'aimeos.frontend.customer', function( $app ) {
			return \Aimeos\Controller\Frontend::create( $app['aimeos.context'], 'customer' );
		});

		$this->app->bind( 'aimeos.frontend.locale', function( $app ) {
			return \Aimeos\Controller\Frontend::create( $app['aimeos.context'], 'locale' );
		});

		$this->app->bind( 'aimeos.frontend.order', function( $app ) {
			return \Aimeos\Controller\Frontend::create( $app['aimeos.context'], 'order' );
		});

		$this->app->bind( 'aimeos.frontend.product', function( $app ) {
			return \Aimeos\Controller\Frontend::create( $app['aimeos.context'], 'product' );
		});

		$this->app->bind( 'aimeos.frontend.service', function( $app ) {
			return \Aimeos\Controller\Frontend::create( $app['aimeos.context'], 'service' );
		});

		$this->app->bind( 'aimeos.frontend.stock', function( $app ) {
			return \Aimeos\Controller\Frontend::create( $app['aimeos.context'], 'stock' );
		});

		$this->app->bind( 'aimeos.frontend.subscription', function( $app ) {
			return \Aimeos\Controller\Frontend::create( $app['aimeos.context'], 'subscription' );
		});

		$this->app->bind( 'aimeos.frontend.supplier', function( $app ) {
			return \Aimeos\Controller\Frontend::create( $app['aimeos.context'], 'supplier' );
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