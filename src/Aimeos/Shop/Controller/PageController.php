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
 * Aimeos controller for support page request.
 *
 * @package laravel-bundle
 * @subpackage Controller
 */
class PageController extends Controller
{
	/**
	 * Returns the html for the privacy policy page.
	 *
	 * @return Response Response object containing the generated output
	 */
	public function privacyAction()
	{
		return \View::make('shop::page.privacy');
	}


	/**
	 * Returns the html for the terms and conditions page.
	 *
	 * @return Response Response object containing the generated output
	 */
	public function termsAction()
	{
		return \View::make('shop::page.terms');
	}
}