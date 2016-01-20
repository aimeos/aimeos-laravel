<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
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
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function countAction()
	{
		$params = app( '\Aimeos\Shop\Base\Page' )->getSections( 'catalog-count' );
		$contents = \View::make('shop::catalog.count', $params);

		$response = \Response::make($contents, 200);
		$response->header('Content-Type', 'application/javascript');

		return $response;
	}


	/**
	 * Returns the html for the catalog detail page.
	 *
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function detailAction()
	{
		$params = app( 'Aimeos\Shop\Base\Page' )->getSections( 'catalog-detail' );
		return View::make('shop::catalog.detail', $params);
	}


	/**
	 * Returns the html for the catalog list page.
	 *
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function listAction()
	{
		$params = app( 'Aimeos\Shop\Base\Page' )->getSections( 'catalog-list' );
		return View::make('shop::catalog.list', $params);
	}


	/**
	 * Returns the html body part for the catalog stock page.
	 *
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function stockAction()
	{
		$params = app( 'Aimeos\Shop\Base\Page' )->getSections( 'catalog-stock' );
		$contents = View::make('shop::catalog.stock', $params);

		$response = \Response::make($contents, 200);
		$response->header('Content-Type', 'application/javascript');

		return $response;
	}


	/**
	 * Returns the view for the XHR response with the product information for the search suggestion.
	 *
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function suggestAction()
	{
		$params = app( 'Aimeos\Shop\Base\Page' )->getSections( 'catalog-suggest' );
		$contents = View::make('shop::catalog.suggest', $params);

		$response = Response::make($contents, 200);
		$response->header('Content-Type', 'application/json');

		return $response;
	}
}