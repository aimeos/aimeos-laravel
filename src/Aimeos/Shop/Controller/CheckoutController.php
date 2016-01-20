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
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function confirmAction()
	{
		$params = app( '\Aimeos\Shop\Base\Page' )->getSections( 'checkout-confirm' );
		return View::make('shop::checkout.confirm', $params);
	}


	/**
	 * Returns the html for the standard checkout page.
	 *
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function indexAction()
	{
		$params = app( '\Aimeos\Shop\Base\Page' )->getSections( 'checkout-index' );
		return View::make('shop::checkout.index', $params);
	}


	/**
	 * Returns the view for the order update page.
	 *
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function updateAction()
	{
		$params = app( '\Aimeos\Shop\Base\Page' )->getSections( 'checkout-update' );
		return View::make('shop::checkout.update', $params);
	}
}