<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * Aimeos controller for the JSON REST API
 *
 * @package laravel
 * @subpackage Controller
 */
class JsonadmController extends Controller
{
	use AuthorizesRequests;


	/**
	 * Deletes the resource object or a list of resource objects
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function deleteAction( Request $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$status = 500;
		$header = $request->headers->all();

		$client = $this->createClient();
		$result = $client->delete( $request->getContent(), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Returns the requested resource object or list of resource objects
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function getAction( Request $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$status = 500;
		$header = $request->headers->all();

		$client = $this->createClient();
		$result = $client->get( $request->getContent(), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Updates a resource object or a list of resource objects
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function patchAction( Request $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$status = 500;
		$header = $request->headers->all();

		$client = $this->createClient();
		$result = $client->patch( $request->getContent(), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Creates a new resource object or a list of resource objects
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function postAction( Request $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$status = 500;
		$header = $request->headers->all();

		$client = $this->createClient();
		$result = $client->post( $request->getContent(), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Creates or updates a single resource object
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function putAction( Request $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$status = 500;
		$header = $request->headers->all();

		$client = $this->createClient();
		$result = $client->put( $request->getContent(), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Returns the available HTTP verbs and the resource URLs
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function optionsAction( Request $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$status = 500;
		$header = $request->headers->all();

		$client = $this->createClient();
		$result = $client->options( $request->getContent(), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Returns the JsonAdm client
	 *
	 * @return \Aimeos\Admin\JsonAdm\Iface JsonAdm client
	 */
	protected function createClient()
	{
		$site = Route::input( 'site', Input::get( 'site', 'default' ) );
		$lang = Input::get( 'lang', config( 'app.locale', 'en' ) );
		$resource = Route::input( 'resource' );

		$aimeos = app( '\Aimeos\Shop\Base\Aimeos' )->get();
		$templatePaths = $aimeos->getCustomPaths( 'admin/jsonadm/templates' );

		$context = app( '\Aimeos\Shop\Base\Context' )->get( false );
		$context = $this->setLocale( $context, $site, $lang );

		$view = app( '\Aimeos\Shop\Base\View' )->create( $context->getConfig(), $templatePaths, $lang );
		$context->setView( $view );

		return \Aimeos\Admin\JsonAdm\Factory::createClient( $context, $templatePaths, $resource );
	}


	/**
	 * Creates a new response object
	 *
	 * @param string $content Body of the HTTP response
	 * @param integer $status HTTP status
	 * @param array $header List of HTTP headers
	 * @return \Illuminate\Http\Response HTTP response object
	 */
	protected function createResponse( $content, $status, array $header )
	{
		$response = Response::make( $content, $status );

		foreach( $header as $key => $value ) {
			$response->header( $key, $value );
		}

		return $response;
	}


	/**
	 * Sets the locale item in the given context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @param string $sitecode Unique site code
	 * @param string $lang ISO language code, e.g. "en" or "en_GB"
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function setLocale( \Aimeos\MShop\Context\Item\Iface $context, $sitecode, $lang )
	{
		$localeManager = \Aimeos\MShop\Factory::createManager( $context, 'locale' );

		try
		{
			$localeItem = $localeManager->bootstrap( $sitecode, '', '', false );
			$localeItem->setLanguageId( null );
			$localeItem->setCurrencyId( null );
		}
		catch( \Aimeos\MShop\Locale\Exception $e )
		{
			$localeItem = $localeManager->createItem();
		}

		$context->setLocale( $localeItem );
		$context->setI18n( app('\Aimeos\Shop\Base\I18n')->get( array( $lang ) ) );

		return $context;
	}
}
