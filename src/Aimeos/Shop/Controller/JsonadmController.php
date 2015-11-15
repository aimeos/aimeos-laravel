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
 * Aimeos controller for the JSON REST API.
 *
 * @package laravel-bundle
 * @subpackage Controller
 */
class JsonadmController extends Controller
{
	/**
	 * Deletes the resource list.
	 *
	 * @param string Resource location, e.g. "product/stock/wareshouse"
	 * @return Response Response object containing the generated output
	 */
	public function deleteAction( $site, $resource, $id = null )
	{
		$status = 500;
		$header = array();

		$cntl = \Aimeos\Controller\JsonAdm\Factory::createController( $this->getContext(), $templatePaths, $resource );
		$result = $cntl->delete( file_get_contents( 'php://input' ), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Returns the requested resource list.
	 *
	 * @param string Resource location, e.g. "product/stock/wareshouse"
	 * @return Response Response object containing the generated output
	 */
	public function getAction( $site, $resource, $id = null )
	{
		$status = 500;
		$header = array();

		$cntl = \Aimeos\Controller\JsonAdm\Factory::createController( $this->getContext(), $templatePaths, $resource );
		$result = $cntl->get( file_get_contents( 'php://input' ), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Returns the requested resource item identified by its unique ID.
	 *
	 * @param string Resource location, e.g. "product/stock/wareshouse"
	 * @param integer $id Unique ID of the resource
	 * @return Response Response object containing the generated output
	 */
	public function postAction( $site, $resource, $id = null )
	{
		$status = 500;
		$header = array();

		$cntl = \Aimeos\Controller\JsonAdm\Factory::createController( $this->getContext(), $templatePaths, $resource );
		$result = $cntl->post( file_get_contents( 'php://input' ), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Creates or updates the resource list.
	 *
	 * @param string Resource location, e.g. "product/stock/wareshouse"
	 * @return Response Response object containing the generated output
	 */
	public function putAction( $site, $resource, $id = null )
	{
		$status = 500;
		$header = array();

		$cntl = \Aimeos\Controller\JsonAdm\Factory::createController( $this->getContext(), $templatePaths, $resource );
		$result = $cntl->put( file_get_contents( 'php://input' ), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Creates or updates the resource item identified by its unique ID.
	 *
	 * @param string Resource location, e.g. "product/stock/wareshouse"
	 * @return Response Response object containing the generated output
	 */
	public function optionsAction( $site = 'default', $resource = '' )
	{
		$status = 500;
		$header = array();

		$cntl = \Aimeos\Controller\JsonAdm\Factory::createController( $this->getContext(), $templatePaths, $resource );
		$result = $cntl->options( file_get_contents( 'php://input' ), $header, $status );

		return $this->createResponse( $result, $status, $header );
	}


	/**
	 * Creates a new response object
	 *
	 * @param string $content Body of the HTTP response
	 * @param integer $status HTTP status
	 * @param array $header List of HTTP headers
	 * @return \Response HTTP response object
	 */
	protected function createResponse( $content, $status, array $header )
	{
		$response = \Response::make( $result, $status );

		foreach( $header as $key => $value ) {
			$response->header( $key, $value );
		}

		return $response;
	}


	/**
	 * Returns the context item populated with the necessary objects
	 *
	 * @return \Aimeos\MShop\Context\Item\Iface Context item
	 */
	protected function getContext()
	{
		$lang = \Input::get( 'lang', 'en' );

		$aimeos = app( '\Aimeos\Shop\Base\Aimeos' )->get();
		$templatePaths = $aimeos->getCustomPaths( 'controller/jsonadm/templates' );

		$context = app( '\Aimeos\Shop\Base\Context' )->get( false );
		$context = $this->setLocale( $context, $site, $lang );

		$view = app( '\Aimeos\Shop\Base\View' )->create( $context->getConfig(), $templatePaths, $lang );
		$context->setView( $view );

		return $context;
	}


	/**
	 * Sets the locale item in the given context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @param string $sitecode Unique site code
	 * @param string $lang ISO language code, e.g. "en" or "en_GB"
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function setLocale( \Aimeos\MShop\Context\Item\Iface $context, $sitecode = 'default', $lang )
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
