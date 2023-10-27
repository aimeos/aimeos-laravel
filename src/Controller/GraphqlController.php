<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2022-2023
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Aimeos controller for the GraphQL Admin API
 */
class GraphqlController extends Controller
{
	use AuthorizesRequests;


	/**
	 * Creates a new resource object or a list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function indexAction( ServerRequestInterface $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [GraphqlController::class, array_merge( config( 'shop.roles', ['admin', 'editor'] ), ['api'])] );
		}

		$site = Route::input( 'site', Request::get( 'site', config( 'shop.mshop.locale.site', 'default' ) ) );
		$lang = Request::get( 'locale', config( 'app.locale', 'en' ) );

		$context = app( 'aimeos.context' )->get( false, 'backend' );
		$context->setI18n( app( 'aimeos.i18n' )->get( array( $lang, 'en' ) ) );
		$context->setLocale( app( 'aimeos.locale' )->getBackend( $context, $site ) );
		$context->setView( app( 'aimeos.view' )->create( $context, [], $lang ) );

		return \Aimeos\Admin\Graphql::execute( $context, $request );
	}
}
