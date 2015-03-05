<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015
 * @package laravel-bundle
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Routing\Controller;


/**
 * Aimeos controller for checkout related functionality.
 *
 * @package laravel-bundle
 * @subpackage Controller
 */
class CheckoutController extends Controller
{
	/**
	 * Returns the html for the checkout confirmation page.
	 *
	 * @return Response Response object containing the generated output
	 */
	public function confirmAction()
	{
		$params = app( 'Aimeos\Shop\Base' )->getPageSections( 'checkout-confirm' );
		return \View::make('shop::checkout.confirm', $params);
	}


	/**
	 * Returns the html for the standard checkout page.
	 *
	 * @return Response Response object containing the generated output
	 */
	public function indexAction()
	{
		$params = app( 'Aimeos\Shop\Base' )->getPageSections( 'checkout-index' );
		return \View::make('shop::checkout.index', $params);
	}


	/**
	 * Returns the view for the order update page.
	 *
	 * @return Response Response object containing the generated output
	 */
	public function updateAction()
	{
		$params = app( 'Aimeos\Shop\Base' )->getPageSections( 'checkout-update' );
		return \View::make('shop::checkout.update', $params);
	}
}