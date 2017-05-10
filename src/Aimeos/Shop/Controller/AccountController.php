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
		$params = app( '\Aimeos\Shop\Base\Page' )->getSections( 'account-index' );
		return Response::view('shop::account.index', $params)->header('Cache-Control', 'private, max-age=300');
	}


	/**
	 * Returns the html for the "My account" download page.
	 *
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function downloadAction()
	{
		$context = app( '\Aimeos\Shop\Base\Context' )->get();
		$langid = $context->getLocale()->getLanguageId();

		$view = app( '\Aimeos\Shop\Base\View' )->create( $context, array(), $langid );
		$context->setView( $view );

		$client = \Aimeos\Client\Html\Factory::createClient( $context, array(), 'account/download' );
		$client->setView( $view );
		$client->process();

		$response = $view->response();
		return Response::make( (string) $response->getBody(), $response->getStatusCode(), $response->getHeaders() )
			->header('Cache-Control', 'private, max-age=300', false);
	}
}