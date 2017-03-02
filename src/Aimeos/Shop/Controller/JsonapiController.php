<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2017
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;


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
		return $this->createClient()->delete( $request, new Response() );
	}


	/**
	 * Returns the requested resource object or list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function getAction( ServerRequestInterface $request )
	{
		return $this->createClient()->get( $request, new Response() );
	}


	/**
	 * Updates a resource object or a list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function patchAction( ServerRequestInterface $request )
	{
		return $this->createClient()->patch( $request, new Response() );
	}


	/**
	 * Creates a new resource object or a list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function postAction( ServerRequestInterface $request )
	{
		return $this->createClient()->post( $request, new Response() );
	}


	/**
	 * Creates or updates a single resource object
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function putAction( ServerRequestInterface $request )
	{
		return $this->createClient()->put( $request, new Response() );
	}


	/**
	 * Returns the available HTTP verbs and the resource URLs
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function optionsAction( ServerRequestInterface $request )
	{
		return $this->createClient()->options( $request, new Response() );
	}


	/**
	 * Returns the JsonAdm client
	 *
	 * @return \Aimeos\Client\JsonApi\Iface JsonApi client
	 */
	protected function createClient()
	{
		$site = Route::input( 'site', Input::get( 'site', 'default' ) );
		$lang = Input::get( 'lang', config( 'app.locale', 'en' ) );
		$resource = Route::input( 'resource' );

		$tmplPaths = app( '\Aimeos\Shop\Base\Aimeos' )->get()->getCustomPaths( 'client/jsonapi/templates' );

		$context = app( '\Aimeos\Shop\Base\Context' )->get();
		$context->setView( app( '\Aimeos\Shop\Base\View' )->create( $context, $tmplPaths, $lang ) );

		return \Aimeos\Client\JsonApi\Factory::createClient( $context, $tmplPaths, $resource );
	}
}
