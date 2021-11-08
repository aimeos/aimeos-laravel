<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Aimeos\Shop\Facades\Shop;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;


/**
 * Aimeos controller for catalog related functionality.
 *
 * @package laravel
 * @subpackage Controller
 */
class CatalogController extends Controller
{
	/**
	 * Returns the view for the XHR response with the counts for the facetted search.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function countAction()
	{
		foreach( app( 'config' )->get( 'shop.page.catalog-count' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'catalog.count' ), $params )
			->header( 'Content-Type', 'application/javascript' )
			->header( 'Cache-Control', 'public, max-age=300' );
	}


	/**
	 * Returns the html for the catalog detail page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function detailAction()
	{
		foreach( app( 'config' )->get( 'shop.page.catalog-detail' ) as $name )
		{
			try {
				$params['aiheader'][$name] = Shop::get( $name )->header();
				$params['aibody'][$name] = Shop::get( $name )->body();
			} catch( \Exception $e ) {
				if( $e->getCode() === 404 ) { abort( 404 ); }
				throw $e;
			}
		}

		return Response::view( Shop::template( 'catalog.detail' ), $params )
			->header( 'Cache-Control', 'private, max-age=10' );
	}


	/**
	 * Returns the html for the catalog home page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function homeAction()
	{
		foreach( app( 'config' )->get( 'shop.page.catalog-home' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'catalog.home' ), $params )
			->header( 'Cache-Control', 'private, max-age=10' );
	}


	/**
	 * Returns the html for the catalog list page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function listAction()
	{
		foreach( app( 'config' )->get( 'shop.page.catalog-list' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'catalog.list' ), $params )
			->header( 'Cache-Control', 'private, max-age=10' );
	}


	/**
	 * Returns the html for the catalog session page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function sessionAction()
	{
		foreach( app( 'config' )->get( 'shop.page.catalog-session' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'catalog.session' ), $params )
			->header( 'Cache-Control', 'no-cache' );
	}


	/**
	 * Returns the html body part for the catalog stock page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function stockAction()
	{
		foreach( app( 'config' )->get( 'shop.page.catalog-stock' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'catalog.stock' ), $params )
			->header( 'Content-Type', 'application/javascript' )
			->header( 'Cache-Control', 'public, max-age=30' );
	}


	/**
	 * Returns the view for the XHR response with the product information for the search suggestion.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function suggestAction()
	{
		foreach( app( 'config' )->get( 'shop.page.catalog-suggest' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'catalog.suggest' ), $params )
			->header( 'Cache-Control', 'private, max-age=300' )
			->header( 'Content-Type', 'application/json' );
	}


	/**
	 * Returns the html for the catalog tree page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function treeAction()
	{
		foreach( app( 'config' )->get( 'shop.page.catalog-tree' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'catalog.tree' ), $params )
			->header( 'Cache-Control', 'private, max-age=10' );
	}
}
