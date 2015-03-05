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
 * Aimeos controller for account related functionality.
 *
 * @package laravel-bundle
 * @subpackage Controller
 */
class AccountController extends Controller
{
	/**
	 * Returns the html for the "My account" page.
	 *
	 * @return Response Response object containing the generated output
	 */
	public function indexAction()
	{
		$params = app( 'Aimeos\Shop\Base' )->getPageSections( 'account-index' );
		return \View::make('shop::account.index', $params);
	}
}