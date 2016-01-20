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
 * Aimeos controller for support page request.
 *
 * @package laravel
 * @subpackage Controller
 */
class PageController extends Controller
{
	/**
	 * Returns the html for the privacy policy page.
	 *
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function privacyAction()
	{
		return View::make('shop::page.privacy');
	}


	/**
	 * Returns the html for the terms and conditions page.
	 *
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function termsAction()
	{
		return View::make('shop::page.terms');
	}
}