<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015
 * @package laravel-package
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * Aimeos controller for the JQuery admin interface
 *
 * @package laravel-package
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
	 * @param string $site
	 * @param string $content
	 */
	protected function getHtml( $site, $content )
	{
		$content = str_replace( ['{type}', '{version}'], ['Laravel', $this->getVersion()], $content );
		$params = array( 'site' => $site, 'content' => $content );

		return View::make('shop::admin.jqadm', $params );
	}
}
