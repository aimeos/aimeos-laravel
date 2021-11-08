<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Aimeos\Shop\Facades\Shop;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;


/**
 * Aimeos controller for support page request.
 *
 * @package laravel
 * @subpackage Controller
 */
class PageController extends Controller
{
	/**
	 * Returns the html for the content pages.
	 *
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function indexAction()
	{
		foreach( app( 'config' )->get( 'shop.page.cms', ['cms/page', 'basket/mini'] ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'page.index' ), $params )
			->header( 'Cache-Control', 'private, max-age=10' );
	}


	/**
	 * Returns the html for the privacy policy page.
	 *
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function privacyAction()
	{
		return View::make( Shop::template( 'page.privacy' ) );
	}


	/**
	 * Returns the html for the terms and conditions page.
	 *
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function termsAction()
	{
		return View::make( Shop::template( 'page.terms' ) );
	}
}
