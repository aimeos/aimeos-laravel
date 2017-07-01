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
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JsonadmController::class, ['admin', 'api', 'editor', 'viewer']] );
		}

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
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JsonadmController::class, ['admin', 'api']] );
		}

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
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JsonadmController::class, ['admin', 'api']] );
		}

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
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JsonadmController::class, ['admin', 'api']] );
		}

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
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JsonadmController::class, ['admin', 'api', 'editor', 'viewer']] );
		}

		return $this->createClient()->options( $request, new Response() );
	}


	/**
	 * Returns the JsonAdm client
	 *
	 * @return \Aimeos\Admin\JsonAdm\Iface JsonAdm client
	 */
	protected function createClient()
	{
		$site = Route::input( 'site', Input::get( 'site', 'default' ) );
		$lang = Input::get( 'locale', config( 'app.locale', 'en' ) );
		$resource = Route::input( 'resource' );

		$aimeos = app( '\Aimeos\Shop\Base\Aimeos' )->get();
		$templatePaths = $aimeos->getCustomPaths( 'admin/jsonadm/templates' );

		$context = app( '\Aimeos\Shop\Base\Context' )->get( false, 'backend' );
		$context->setI18n( app('\Aimeos\Shop\Base\I18n')->get( array( $lang, 'en' ) ) );
		$context->setLocale( app('\Aimeos\Shop\Base\Locale')->getBackend( $context, $site ) );
		$context->setView( app( '\Aimeos\Shop\Base\View' )->create( $context, $templatePaths, $lang ) );

		return \Aimeos\Admin\JsonAdm\Factory::createClient( $context, $templatePaths, $resource );
	}
}
