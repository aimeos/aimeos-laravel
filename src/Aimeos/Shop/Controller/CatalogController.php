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
		foreach( app( 'config' )->get( 'shop.page.catalog-count', ['catalog/count'] ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->getHeader();
			$params['aibody'][$name] = Shop::get( $name )->getBody();
		}

		return Response::view('shop::catalog.count', $params)
			->header('Content-Type', 'application/javascript');
	}


	/**
	 * Returns the html for the catalog detail page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function detailAction()
	{
		$default = ['basket/mini','catalog/stage','catalog/detail','catalog/session'];

		foreach( app( 'config' )->get( 'shop.page.catalog-detail', $default ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->getHeader();
			$params['aibody'][$name] = Shop::get( $name )->getBody();
		}

		return Response::view('shop::catalog.detail', $params);
	}


	/**
	 * Returns the html for the catalog list page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function listAction()
	{
		$default = ['basket/mini','catalog/filter','catalog/lists'];

		foreach( app( 'config' )->get( 'shop.page.catalog-list', $default ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->getHeader();
			$params['aibody'][$name] = Shop::get( $name )->getBody();
		}

		return Response::view('shop::catalog.list', $params);
	}


	/**
	 * Returns the html body part for the catalog stock page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function stockAction()
	{
		foreach( app( 'config' )->get( 'shop.page.catalog-stock', ['catalog/stock'] ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->getHeader();
			$params['aibody'][$name] = Shop::get( $name )->getBody();
		}

		return Response::view('shop::catalog.stock', $params)
			->header('Content-Type', 'application/javascript');
	}


	/**
	 * Returns the view for the XHR response with the product information for the search suggestion.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function suggestAction()
	{
		foreach( app( 'config' )->get( 'shop.page.catalog-suggest', ['catalog/suggest'] ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->getHeader();
			$params['aibody'][$name] = Shop::get( $name )->getBody();
		}

		return Response::view('shop::catalog.suggest', $params)
			->header('Content-Type', 'application/json');
	}


	/**
	 * Returns the html for the catalog tree page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function treeAction()
	{
		$default = ['basket/mini','catalog/filter','catalog/stage','catalog/lists'];

		foreach( app( 'config' )->get( 'shop.page.catalog-tree', $default ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->getHeader();
			$params['aibody'][$name] = Shop::get( $name )->getBody();
		}

		return Response::view('shop::catalog.tree', $params);
	}
}