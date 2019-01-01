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
		$default = ['basket/standard','basket/related'];

		foreach( app( 'config' )->get( 'shop.page.basket-index', $default ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->getHeader();
			$params['aibody'][$name] = Shop::get( $name )->getBody();
		}

		return Response::view('shop::basket.index', $params)->header('Cache-Control', 'no-store');
	}
}