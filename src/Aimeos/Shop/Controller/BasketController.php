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
 * Aimeos controller for basket related functionality.
 *
 * @package laravel
 * @subpackage Controller
 */
class BasketController extends Controller
{
	/**
	 * Returns the html for the standard basket page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function indexAction()
	{
		foreach( app( 'config' )->get( 'shop.page.basket-index' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'basket.index' ), $params )
			->header( 'Cache-Control', 'no-store, , max-age=0' );
	}
}