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
 * Aimeos controller for checkout related functionality.
 *
 * @package laravel
 * @subpackage Controller
 */
class CheckoutController extends Controller
{
	/**
	 * Returns the html for the checkout confirmation page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function confirmAction()
	{
		foreach( app( 'config' )->get( 'shop.page.checkout-confirm' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'checkout.confirm' ), $params )
			->header( 'Cache-Control', 'no-store, max-age=0' );
	}


	/**
	 * Returns the html for the standard checkout page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function indexAction()
	{
		foreach( app( 'config' )->get( 'shop.page.checkout-index' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'checkout.index' ), $params )
			->header( 'Cache-Control', 'no-store, max-age=0' );
	}


	/**
	 * Returns the view for the order update page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function updateAction()
	{
		foreach( app( 'config' )->get( 'shop.page.checkout-update' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'checkout.update' ), $params )
			->header( 'Cache-Control', 'no-store, max-age=0' );
	}
}