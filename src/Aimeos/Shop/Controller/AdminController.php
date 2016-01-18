<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2014-2016
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * Controller providing the ExtJS administration interface
 *
 * @package laravel
 * @subpackage Controller
 */
class AdminController extends Controller
{
	use AuthorizesRequests;


	/**
	 * Returns the initial HTML view for the admin interface.
	 *
	 * @return Response Response object containing the generated output
	 */
	public function indexAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$param = array(
			'resource' => 'product',
			'site' => Route::input( 'site', 'default' ),
			'lang' => Input::get( 'lang', config( 'app.locale', 'en' ) ),
		);

		return redirect()->route( 'aimeos_shop_jqadm_search', $param );
	}


	/**
	 * Returns the version of the Aimeos package
	 *
	 * @return string Version string
	 */
	protected function getVersion()
	{
		if( ( $content = @file_get_contents( base_path( 'composer.lock' ) ) ) !== false
			&& ( $content = json_decode( $content, true ) ) !== null && isset( $content['packages'] )
		) {
			foreach( (array) $content['packages'] as $item )
			{
				if( $item['name'] === 'aimeos/aimeos-laravel' ) {
					return $item['version'];
				}
			}
		}

		return '';
	}


	/**
	 * Sets the locale item in the given context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @param string $sitecode Unique site code
	 * @param string $lang ISO language code, e.g. "en" or "en_GB"
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function setLocale( \Aimeos\MShop\Context\Item\Iface $context, $sitecode = 'default', $lang = null )
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