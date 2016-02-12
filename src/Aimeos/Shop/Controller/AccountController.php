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
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function indexAction()
	{
		$params = app( '\Aimeos\Shop\Base\Page' )->getSections( 'account-index' );
		return View::make('shop::account.index', $params);
	}


	/**
	 * Returns the html for the "My account" download page.
	 *
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function downloadAction()
	{
		$params = app( '\Aimeos\Shop\Base\Page' )->getSections( 'account-download' );
		return View::make('shop::account.download', $params);
	}
}