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
 * Aimeos controller for account related functionality.
 *
 * @package laravel
 * @subpackage Controller
 */
class AccountController extends Controller
{
	/**
	 * Returns the html for the "My account" page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function indexAction()
	{
		foreach( app( 'config' )->get( 'shop.page.account-index' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->getHeader();
			$params['aibody'][$name] = Shop::get( $name )->getBody();
		}

		return Response::view( Shop::template( 'account.index' ), $params );
	}


	/**
	 * Returns the html for the "My account" download page.
	 *
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function downloadAction()
	{
		$response = Shop::get( 'account/download' )->getView()->response();
		return Response::make( (string) $response->getBody(), $response->getStatusCode(), $response->getHeaders() );
	}
}