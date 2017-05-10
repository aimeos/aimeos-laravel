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
		$params = app( '\Aimeos\Shop\Base\Page' )->getSections( 'basket-index' );
		return Response::view('shop::basket.index', $params)->header('Cache-Control', 'no-store');
	}
}