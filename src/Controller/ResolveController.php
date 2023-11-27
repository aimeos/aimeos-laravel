<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2023
 */


namespace Aimeos\Shop\Controller;

use Aimeos\Shop\Facades\Shop;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;


/**
 * Aimeos controller for dispatching requests.
 */
class ResolveController extends Controller
{
	private static $fcn = [];


	/**
	 * Register a new resolver function.
	 *
	 * @param string $name Name of the resolver function
	 * @param \Closure $fcn Resolver function
	 */
	public static function register( string $name, \Closure $fcn )
	{
		self::$fcn[$name] = $fcn;
	}


	/**
	 * Initializes the object.
	 */
	public function __construct()
	{
		self::$fcn['product'] = function( \Aimeos\MShop\ContextIface $context, string $path ) {
			return $this->product( $context, $path );
		};

		self::$fcn['catalog'] = function( \Aimeos\MShop\ContextIface $context, string $path ) {
			return $this->catalog( $context, $path );
		};
	}


	/**
	 * Returns the html of the resolved URLs.
	 *
	 * @param \Illuminate\Http\Request $request Laravel request object
	 * @return \Illuminate\Http\Response Laravel response object containing the generated output
	 */
	public function indexAction( \Illuminate\Http\Request $request )
	{
		if( ( $path = $request->route( 'path', $request->input( 'path' ) ) ) === null ) {
			abort( 404 );
		}

		$context = app( 'aimeos.context' )->get( true );

		foreach( self::$fcn as $name => $fcn )
		{
			try {
				return $fcn( $context, $path );
			} catch( \Exception $e ) {} // not found
		}

		abort( 404 );
	}


	/**
	 * Returns the category page if the give path can be resolved to a category.
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @param string $path URL path to resolve
	 * @return Response Response object
	 */
	protected function catalog( \Aimeos\MShop\ContextIface $context, string $path ) : ?\Illuminate\Http\Response
	{
		$item = \Aimeos\Controller\Frontend::create( $context, 'catalog' )->resolve( $path );
		$view = Shop::view();

		$params = ( Route::current() ? Route::current()->parameters() : [] ) + Request::all();
		$params += ['path' => $path, 'f_name' => $path, 'f_catid' => $item->getId(), 'page' => 'page-catalog-tree'];

		$helper = new \Aimeos\Base\View\Helper\Param\Standard( $view, $params );
		$view->addHelper( 'param', $helper );

		foreach( app( 'config' )->get( 'shop.page.catalog-tree' ) as $name )
		{
			$client = Shop::get( $name );

			$params['aiheader'][$name] = $client->header();
			$params['aibody'][$name] = $client->body();
		}

		return Response::view( Shop::template( 'catalog.tree' ), $params )
			->header( 'Cache-Control', 'private, max-age=' . config( 'shop.cache_maxage', 30 ) );
	}


	/**
	 * Returns the CMS page if the give path can be resolved to a CMS page.
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @param string $path URL path to resolve
	 * @return Response Response object
	 */
	protected function cms( \Aimeos\MShop\ContextIface $context, string $path ) : ?\Illuminate\Http\Response
	{
		$item = \Aimeos\Controller\Frontend::create( $context, 'cms' )->resolve( $path );
		$view = Shop::view();

		$params = ( Route::current() ? Route::current()->parameters() : [] ) + Request::all();
		$params += ['path' => $path, 'page' => 'page-index'];

		$helper = new \Aimeos\Base\View\Helper\Param\Standard( $view, $params );
		$view->addHelper( 'param', $helper );

		foreach( app( 'config' )->get( 'shop.page.cms' ) as $name )
		{
			$client = Shop::get( $name );

			$params['aiheader'][$name] = $client->header();
			$params['aibody'][$name] = $client->body();
		}

		return Response::view( Shop::template( 'page.index' ), $params )
			->header( 'Cache-Control', 'private, max-age=' . config( 'shop.cache_maxage', 30 ) );
	}


	/**
	 * Returns the product page if the give path can be resolved to a product.
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @param string $path URL path to resolve
	 * @return Response Response object
	 */
	protected function product( \Aimeos\MShop\ContextIface $context, string $path ) : ?\Illuminate\Http\Response
	{
		$item = \Aimeos\Controller\Frontend::create( $context, 'product' )->resolve( $path );
		$view = Shop::view();

		$params = ( Route::current() ? Route::current()->parameters() : [] ) + Request::all();
		$params += ['path' => $path, 'd_name' => $path, 'd_prodid' => $item->getId(), 'page' => 'page-catalog-detail'];

		$helper = new \Aimeos\Base\View\Helper\Param\Standard( $view, $params );
		$view->addHelper( 'param', $helper );

		foreach( app( 'config' )->get( 'shop.page.catalog-detail' ) as $name )
		{
			$client = Shop::get( $name );

			$params['aiheader'][$name] = $client->header();
			$params['aibody'][$name] = $client->body();
		}

		return Response::view( Shop::template( 'catalog.detail' ), $params )
			->header( 'Cache-Control', 'private, max-age=' . config( 'shop.cache_maxage', 30 ) );
	}
}