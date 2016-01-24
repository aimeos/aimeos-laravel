<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * Aimeos controller for the JQuery admin interface
 *
 * @package laravel
 * @subpackage Controller
 */
class JqadmController extends AdminController
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
		return $this->getHtml( $site, $cntl->copy( $id ) );
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
		return $this->getHtml( $site, $cntl->create() );
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
		return $this->getHtml( $site, $cntl->delete( $id ) . $cntl->search() );
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
		return $this->getHtml( $site, $cntl->get( $id ) );
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
		return $this->getHtml( $site, ( $cntl->save() ? : $cntl->search() ) );
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
		return $this->getHtml( $site, $cntl->search() );
	}


	/**
	 * Returns the resource controller
	 *
	 * @param string $sitecode Unique site code
	 * @return \Aimeos\MShop\Context\Item\Iface Context item
	 */
	protected function createClient( $sitecode, $resource )
	{
		$lang = Input::get( 'lang', config( 'app.locale', 'en' ) );

		$aimeos = app( '\Aimeos\Shop\Base\Aimeos' )->get();
		$templatePaths = $aimeos->getCustomPaths( 'admin/jqadm/templates' );

		$context = app( '\Aimeos\Shop\Base\Context' )->get( false );
		$context = $this->setLocale( $context, $sitecode, $lang );

		$view = app( '\Aimeos\Shop\Base\View' )->create( $context->getConfig(), $templatePaths, $lang );
		$context->setView( $view );

		return \Aimeos\Admin\JQAdm\Factory::createClient( $context, $templatePaths, $resource );
	}


	/**
	 * Returns the generated HTML code
	 *
	 * @param string $site Unique site code
	 * @param string $content Content from admin client
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	protected function getHtml( $site, $content )
	{
		$version = app( '\Aimeos\Shop\Base\Aimeos' )->getVersion();
		$content = str_replace( ['{type}', '{version}'], ['Laravel', $version], $content );

		return View::make( 'shop::jqadm.index', array( 'content' => $content ) );
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
