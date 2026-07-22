<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2026
 */


namespace Aimeos\Shop\Mcp;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;


/**
 * Laravel MCP server exposing the Aimeos administration tools
 */
class Server extends \Laravel\Mcp\Server
{
	protected string $name = 'Aimeos Admin';
	protected string $version = '1.0.0';
	protected string $instructions = 'Manage the Aimeos shop using the available administrative tools.';


	/**
	 * Initializes the Aimeos context and tool catalog for the current request.
	 */
	protected function boot() : void
	{
		if( config( 'shop.authorize', true ) ) {
			Gate::authorize( 'admin', [Server::class, array_merge( config( 'shop.roles', ['admin', 'editor'] ), ['api'] )] );
		}

		$site = Request::route( 'site' ) ?? Request::get( 'site', config( 'shop.mshop.locale.site', 'default' ) );
		$lang = Request::get( 'locale', config( 'app.locale', 'en' ) );

		$context = app( 'aimeos.context' )->get( false, 'backend' );
		$context->setI18n( app( 'aimeos.i18n' )->get( [$lang, 'en'] ) );
		$context->setLocale( app( 'aimeos.locale' )->getBackend( $context, $site ) );
		$context->config()->apply( $context->locale()->getSiteItem()->getConfig() );
		$context->setView( app( 'aimeos.view' )->create( $context, [], $lang ) );

		$this->tools = array_map(
			fn( \Aimeos\Admin\Mcp\Tool $tool ) => new Tool( $tool ),
			array_values( \Aimeos\Admin\Mcp\Tools::create( $context ) )
		);
	}
}
