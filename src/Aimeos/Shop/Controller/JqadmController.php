<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
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
	 * Returns the JS file content
	 *
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function fileAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, ['admin', 'editor', 'viewer']] );
		}

		$contents = '';
		$files = array();
		$aimeos = app( '\Aimeos\Shop\Base\Aimeos' )->get();
		$type = Route::input( 'type', Input::get( 'type', 'js' ) );

		foreach( $aimeos->getCustomPaths( 'admin/jqadm' ) as $base => $paths )
		{
			foreach( $paths as $path )
			{
				$jsbAbsPath = $base . '/' . $path;
				$jsb2 = new \Aimeos\MW\Jsb2\Standard( $jsbAbsPath, dirname( $jsbAbsPath ) );
				$files = array_merge( $files, $jsb2->getFiles( $type ) );
			}
		}

		foreach( $files as $file )
		{
			if( ( $content = file_get_contents( $file ) ) !== false ) {
				$contents .= $content;
			}
		}

		$response = response( $contents );

		if( $type === 'js' ) {
			$response->header( 'Content-Type', 'application/javascript' );
		} elseif( $type === 'css' ) {
			$response->header( 'Content-Type', 'text/css' );
		}

		return $response;
	}


	/**
	 * Returns the HTML code for a copy of a resource object
	 *
	 * @return string Generated output
	 */
	public function copyAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, ['admin', 'editor']] );
		}

		$cntl = $this->createClient();
		return $this->getHtml( $cntl->copy() );
	}


	/**
	 * Returns the HTML code for a new resource object
	 *
	 * @return string Generated output
	 */
	public function createAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, ['admin', 'editor']] );
		}

		$cntl = $this->createClient();
		return $this->getHtml( $cntl->create() );
	}


	/**
	 * Deletes the resource object or a list of resource objects
	 *
	 * @return string Generated output
	 */
	public function deleteAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, ['admin', 'editor']] );
		}

		$cntl = $this->createClient();

		if( ( $html = $cntl->delete() ) == '' ) {
			return $cntl->getView()->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Returns the HTML code for the requested resource object
	 *
	 * @return string Generated output
	 */
	public function getAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, ['admin', 'editor', 'viewer']] );
		}

		$cntl = $this->createClient();
		return $this->getHtml( $cntl->get() );
	}


	/**
	 * Saves a new resource object
	 *
	 * @return string Generated output
	 */
	public function saveAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, ['admin', 'editor']] );
		}

		$cntl = $this->createClient();

		if( ( $html = $cntl->save() ) == '' ) {
			return $cntl->getView()->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Returns the HTML code for a list of resource objects
	 *
	 * @return string Generated output
	 */
	public function searchAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, ['admin', 'editor', 'viewer']] );
		}

		$cntl = $this->createClient();
		return $this->getHtml( $cntl->search() );
	}


	/**
	 * Returns the resource controller
	 *
	 * @return \Aimeos\Admin\JQAdm\Iface JQAdm client
	 */
	protected function createClient()
	{
		$site = Route::input( 'site', Input::get( 'site', 'default' ) );
		$lang = Input::get( 'lang', config( 'app.locale', 'en' ) );
		$resource = Route::input( 'resource' );

		$aimeos = app( '\Aimeos\Shop\Base\Aimeos' )->get();
		$templatePaths = $aimeos->getCustomPaths( 'admin/jqadm/templates' );

		$context = app( '\Aimeos\Shop\Base\Context' )->get( false, 'backend' );
		$context->setI18n( app('\Aimeos\Shop\Base\I18n')->get( array( $lang, 'en' ) ) );
		$context->setLocale( app('\Aimeos\Shop\Base\Locale')->getBackend( $context, $site ) );
		$context->setView( app( '\Aimeos\Shop\Base\View' )->create( $context, $templatePaths, $lang ) );

		return \Aimeos\Admin\JQAdm\Factory::createClient( $context, $templatePaths, $resource );
	}


	/**
	 * Returns the generated HTML code
	 *
	 * @param string $content Content from admin client
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	protected function getHtml( $content )
	{
		$aimeos = app( '\Aimeos\Shop\Base\Aimeos' );
		$extnames = implode( ',', $aimeos->get()->getExtensions() );
		$version = $aimeos->getVersion();

		$site = Route::input( 'site', Input::get( 'site', 'default' ) );
		$content = str_replace( ['{type}', '{version}', '{extensions}'], ['Laravel', $version, $extnames], $content );

		return View::make( 'shop::jqadm.index', array( 'content' => $content, 'site' => $site ) );
	}
}
