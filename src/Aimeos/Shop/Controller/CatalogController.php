<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

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
		$params = app( '\Aimeos\Shop\Base\Page' )->getSections( 'catalog-count' );

		return Response::view('shop::catalog.count', $params)
			->header('Content-Type', 'application/javascript')
			->header('Cache-Control', 'max-age=43200');
	}


	/**
	 * Returns the html for the catalog detail page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function detailAction()
	{
		$params = app( 'Aimeos\Shop\Base\Page' )->getSections( 'catalog-detail' );
		return Response::view('shop::catalog.detail', $params)->header('Cache-Control', 'max-age=43200');
	}


	/**
	 * Returns the html for the catalog list page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function listAction()
	{
		$params = app( 'Aimeos\Shop\Base\Page' )->getSections( 'catalog-list' );
		return Response::view('shop::catalog.list', $params)->header('Cache-Control', 'max-age=43200');
	}


	/**
	 * Returns the html body part for the catalog stock page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function stockAction()
	{
		$params = app( 'Aimeos\Shop\Base\Page' )->getSections( 'catalog-stock' );

		return Response::view('shop::catalog.stock', $params)
			->header('Content-Type', 'application/javascript')
			->header('Cache-Control', 'max-age=30');
	}


	/**
	 * Returns the view for the XHR response with the product information for the search suggestion.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function suggestAction()
	{
		$params = app( 'Aimeos\Shop\Base\Page' )->getSections( 'catalog-suggest' );

		return Response::view('shop::catalog.suggest', $params)
			->header('Content-Type', 'application/json')
			->header('Cache-Control', 'max-age=43200');
	}
}