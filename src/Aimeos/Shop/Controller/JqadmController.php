<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015
 * @package laravel-package
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * Aimeos controller for the JQuery admin interface
 *
 * @package laravel-package
 * @subpackage Controller
 */
class JqadmController extends Controller
{
	use AuthorizesRequests;


	/**
	 * Returns the HTML code for a copy of a resource object
	 *
	 * @param string Resource location, e.g. "product"
	 * @param string $sitecode Unique site code
	 * @param integer $id Unique resource ID
	 * @return string Generated output
	 */
	public function copyAction( $site = 'default', $resource, $id )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$cntl = $this->createClient( $site, $resource );
		$content = $cntl->copy( $id );

		$url = route( 'aimeos_shop_jsonadm_options', ['site' => $site, 'resource' => $resource] );
		return \View::make('shop::admin.jqadm', array( 'content' => $content, 'jsonadmurl' => $url ) );
	}


	/**
	 * Returns the HTML code for a new resource object
	 *
	 * @param string Resource location, e.g. "product"
	 * @param string $sitecode Unique site code
	 * @return string Generated output
	 */
	public function createAction( $site = 'default', $resource )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$cntl = $this->createClient( $site, $resource );
		$content = $cntl->create();

		$url = route( 'aimeos_shop_jsonadm_options', ['site' => $site, 'resource' => $resource] );
		return \View::make('shop::admin.jqadm', array( 'content' => $content, 'jsonadmurl' => $url ) );
	}


	/**
	 * Deletes the resource object or a list of resource objects
	 *
	 * @param string Resource location, e.g. "product"
	 * @param string $sitecode Unique site code
	 * @param integer $id Unique resource ID
	 * @return string Generated output
	 */
	public function deleteAction( $site = 'default', $resource, $id )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$cntl = $this->createClient( $site, $resource );
		$content = $cntl->delete( $id ) . $cntl->search();

		$url = route( 'aimeos_shop_jsonadm_options', ['site' => $site, 'resource' => $resource] );
		return \View::make('shop::admin.jqadm', array( 'content' => $content, 'jsonadmurl' => $url ) );
	}


	/**
	 * Returns the HTML code for the requested resource object
	 *
	 * @param string Resource location, e.g. "product"
	 * @param string $sitecode Unique site code
	 * @param integer $id Unique resource ID
	 * @return string Generated output
	 */
	public function getAction( $site = 'default', $resource, $id )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$cntl = $this->createClient( $site, $resource );
		$content = $cntl->get( $id );

		$url = route( 'aimeos_shop_jsonadm_options', ['site' => $site, 'resource' => $resource] );
		return \View::make('shop::admin.jqadm', array( 'content' => $content, 'jsonadmurl' => $url ) );
	}


	/**
	 * Saves a new resource object
	 *
	 * @param string Resource location, e.g. "product"
	 * @param string $sitecode Unique site code
	 * @return string Generated output
	 */
	public function saveAction( $site = 'default', $resource )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$cntl = $this->createClient( $site, $resource );
		$content = ( $cntl->save() ? : $cntl->search() );

		$url = route( 'aimeos_shop_jsonadm_options', ['site' => $site, 'resource' => $resource] );
		return \View::make('shop::admin.jqadm', array( 'content' => $content, 'jsonadmurl' => $url ) );
	}


	/**
	 * Returns the HTML code for a list of resource objects
	 *
	 * @param string Resource location, e.g. "product"
	 * @param string $sitecode Unique site code
	 * @return string Generated output
	 */
	public function searchAction( $site = 'default', $resource )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin' );
		}

		$cntl = $this->createClient( $site, $resource );
		$content = $cntl->search();

		$url = route( 'aimeos_shop_jsonadm_options', ['site' => $site, 'resource' => $resource] );
		return \View::make('shop::admin.jqadm', array( 'content' => $content, 'jsonadmurl' => $url ) );
	}


	/**
	 * Returns the resource controller
	 *
	 * @param string $sitecode Unique site code
	 * @return \Aimeos\MShop\Context\Item\Iface Context item
	 */
	protected function createClient( $sitecode, $resource )
	{
		$lang = \Input::get( 'lang', config( 'app.locale', 'en' ) );

		$aimeos = app( '\Aimeos\Shop\Base\Aimeos' )->get();
		$templatePaths = $aimeos->getCustomPaths( 'client/jqadm/templates' );

		$context = app( '\Aimeos\Shop\Base\Context' )->get( false );
		$context = $this->setLocale( $context, $sitecode, $lang );

		$view = app( '\Aimeos\Shop\Base\View' )->create( $context->getConfig(), $templatePaths, $lang );
		$context->setView( $view );

		return \Aimeos\Client\JQAdm\Factory::createClient( $context, $templatePaths, $resource );
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
