<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2017
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Factory\Psr17Factory;


/**
 * Aimeos controller for the JSON REST API
 *
 * @package laravel
 * @subpackage Controller
 */
class JsonapiController extends Controller
{
	/**
	 * Deletes the resource object or a list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function deleteAction( ServerRequestInterface $request )
	{
		return $this->createClient()->delete( $request, ( new Psr17Factory )->createResponse() );
	}


	/**
	 * Returns the requested resource object or list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function getAction( ServerRequestInterface $request )
	{
		return $this->createClient()->get( $request, ( new Psr17Factory )->createResponse() );
	}


	/**
	 * Updates a resource object or a list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function patchAction( ServerRequestInterface $request )
	{
		return $this->createClient()->patch( $request, ( new Psr17Factory )->createResponse() );
	}


	/**
	 * Creates a new resource object or a list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function postAction( ServerRequestInterface $request )
	{
		return $this->createClient()->post( $request, ( new Psr17Factory )->createResponse() );
	}


	/**
	 * Creates or updates a single resource object
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function putAction( ServerRequestInterface $request )
	{
		return $this->createClient()->put( $request, ( new Psr17Factory )->createResponse() );
	}


	/**
	 * Returns the available HTTP verbs and the resource URLs
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function optionsAction( ServerRequestInterface $request )
	{
		return $this->createClient()->options( $request, ( new Psr17Factory )->createResponse() );
	}


	/**
	 * Returns the JsonAdm client
	 *
	 * @return \Aimeos\Client\JsonApi\Iface JsonApi client
	 */
	protected function createClient() : \Aimeos\Client\JsonApi\Iface
	{
		$resource = Route::input( 'resource' );
		$related = Route::input( 'related', Request::get( 'related' ) );

		$aimeos = app( 'aimeos' )->get();
		$tmplPaths = $aimeos->getTemplatePaths( 'client/jsonapi/templates' );

		$context = app( 'aimeos.context' )->get();
		$langid = $context->getLocale()->getLanguageId();

		$context->setView( app( 'aimeos.view' )->create( $context, $tmplPaths, $langid ) );

		return \Aimeos\Client\JsonApi::create( $context, $resource . '/' . $related );
	}
}
