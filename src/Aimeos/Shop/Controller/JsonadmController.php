<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;


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
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function deleteAction( ServerRequestInterface $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JsonadmController::class, ['admin', 'api']] );
		}

		return $this->createAdmin()->delete( $request, new Response() );
	}


	/**
	 * Returns the requested resource object or list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function getAction( ServerRequestInterface $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JsonadmController::class, ['admin', 'api', 'editor']] );
		}

		return $this->createAdmin()->get( $request, new Response() );
	}


	/**
	 * Updates a resource object or a list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function patchAction( ServerRequestInterface $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JsonadmController::class, ['admin', 'api']] );
		}

		return $this->createAdmin()->patch( $request, new Response() );
	}


	/**
	 * Creates a new resource object or a list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function postAction( ServerRequestInterface $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JsonadmController::class, ['admin', 'api']] );
		}

		return $this->createAdmin()->post( $request, new Response() );
	}


	/**
	 * Creates or updates a single resource object
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function putAction( ServerRequestInterface $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JsonadmController::class, ['admin', 'api']] );
		}

		return $this->createAdmin()->put( $request, new Response() );
	}


	/**
	 * Returns the available HTTP verbs and the resource URLs
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function optionsAction( ServerRequestInterface $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JsonadmController::class, ['admin', 'api', 'editor']] );
		}

		return $this->createAdmin()->options( $request, new Response() );
	}


	/**
	 * Returns the JsonAdm client
	 *
	 * @return \Aimeos\Admin\JsonAdm\Iface JsonAdm client
	 */
	protected function createAdmin()
	{
		$site = Route::input( 'site', Request::get( 'site', 'default' ) );
		$lang = Request::get( 'locale', config( 'app.locale', 'en' ) );
		$resource = Route::input( 'resource', '' );

		$aimeos = app( 'aimeos' )->get();
		$templatePaths = $aimeos->getCustomPaths( 'admin/jsonadm/templates' );

		$context = app( 'aimeos.context' )->get( false, 'backend' );
		$context->setI18n( app( 'aimeos.i18n' )->get( array( $lang, 'en' ) ) );
		$context->setLocale( app( 'aimeos.locale' )->getBackend( $context, $site ) );
		$context->setView( app( 'aimeos.view' )->create( $context, $templatePaths, $lang ) );

		return \Aimeos\Admin\JsonAdm::create( $context, $aimeos, $resource );
	}
}
