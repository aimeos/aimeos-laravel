<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015
 * @package laravel-bundle
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;


/**
 * Aimeos controller for the JSON REST API
 *
 * @package laravel-bundle
 * @subpackage Controller
 */
class JsonadmController extends Controller
{
	/**
	 * Deletes the resource object or a list of resource objects
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @param string $sitecode Unique site code
	 * @param string Resource location, e.g. "product/stock/wareshouse"
	 * @param integer|null $id Unique resource ID
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function deleteAction( Request $request, $site, $resource, $id = null )
	{
		$status = 500;
		$header = $request->headers->all();

		$cntl = $this->createController( $site, $resource );
		$result = $cntl->delete( $request->getContent(), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Returns the requested resource object or list of resource objects
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @param string $sitecode Unique site code
	 * @param string Resource location, e.g. "product/stock/wareshouse"
	 * @param integer|null $id Unique resource ID
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function getAction( Request $request, $site, $resource, $id = null )
	{
		$status = 500;
		$header = $request->headers->all();

		$cntl = $this->createController( $site, $resource );
		$result = $cntl->get( $request->getContent(), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Updates a resource object or a list of resource objects
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @param string $sitecode Unique site code
	 * @param string Resource location, e.g. "product/stock/wareshouse"
	 * @param integer|null $id Unique resource ID
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function patchAction( Request $request, $site, $resource, $id = null )
	{
		$status = 500;
		$header = $request->headers->all();

		$cntl = $this->createController( $site, $resource );
		$result = $cntl->patch( $request->getContent(), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Creates a new resource object or a list of resource objects
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @param string $sitecode Unique site code
	 * @param string Resource location, e.g. "product/stock/wareshouse"
	 * @param integer $id Unique ID of the resource
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function postAction( Request $request, $site, $resource, $id = null )
	{
		$status = 500;
		$header = $request->headers->all();

		$cntl = $this->createController( $site, $resource );
		$result = $cntl->post( $request->getContent(), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Creates or updates a single resource object
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @param string $sitecode Unique site code
	 * @param string Resource location, e.g. "product/stock/wareshouse"
	 * @param integer|null $id Unique resource ID
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function putAction( Request $request, $site, $resource, $id = null )
	{
		$status = 500;
		$header = $request->headers->all();

		$cntl = $this->createController( $site, $resource );
		$result = $cntl->put( $request->getContent(), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Returns the available HTTP verbs and the resource URLs
	 *
	 * @param \Illuminate\Http\Request $request Request object
	 * @param string $sitecode Unique site code
	 * @param string Resource location, e.g. "product/stock/wareshouse"
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function optionsAction( Request $request, $site = 'default', $resource = '' )
	{
		$status = 500;
		$header = $request->headers->all();

		$cntl = $this->createController( $site, $resource );
		$result = $cntl->options( $request->getContent(), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Returns the resource controller
	 *
	 * @param string $sitecode Unique site code
	 * @return \Aimeos\MShop\Context\Item\Iface Context item
	 */
	protected function createController( $sitecode, $resource )
	{
		$lang = \Input::get( 'lang', 'en' );

		$aimeos = app( '\Aimeos\Shop\Base\Aimeos' )->get();
		$templatePaths = $aimeos->getCustomPaths( 'controller/jsonadm/templates' );

		$context = app( '\Aimeos\Shop\Base\Context' )->get( false );
		$context = $this->setLocale( $context, $sitecode, $lang );

		$view = app( '\Aimeos\Shop\Base\View' )->create( $context->getConfig(), $templatePaths, $lang );
		$context->setView( $view );

		return \Aimeos\Controller\JsonAdm\Factory::createController( $context, $templatePaths, $resource );
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
		$response = \Response::make( $content, $status );

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
