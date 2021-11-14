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
use Illuminate\Support\Facades\Request;
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
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$contents = '';
		$files = array();
		$aimeos = app( 'aimeos' )->get();
		$type = Route::input( 'type', Request::get( 'type', 'js' ) );

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
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->copy() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Returns the HTML code for a new resource object
	 *
	 * @return string Generated output
	 */
	public function createAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->create() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Deletes the resource object or a list of resource objects
	 *
	 * @return string Generated output
	 */
	public function deleteAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->delete() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Exports the data for a resource object
	 *
	 * @return string Generated output
	 */
	public function exportAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->export() ) == '' ) {
			return $cntl->response();
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
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->get() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Saves a new resource object
	 *
	 * @return string Generated output
	 */
	public function saveAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->save() ) == '' ) {
			return $cntl->response();
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
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->search() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Returns the resource controller
	 *
	 * @return \Aimeos\Admin\JQAdm\Iface JQAdm client
	 */
	protected function createAdmin() : \Aimeos\Admin\JQAdm\Iface
	{
		$site = Route::input( 'site', Request::get( 'site', 'default' ) );
		$lang = Request::get( 'locale', config( 'app.locale', 'en' ) );
		$resource = Route::input( 'resource' );

		$aimeos = app( 'aimeos' )->get();
		$paths = $aimeos->getTemplatePaths( 'admin/jqadm/templates' );

		$context = app( 'aimeos.context' )->get( false, 'backend' );
		$context->setI18n( app( 'aimeos.i18n' )->get( array( $lang, 'en' ) ) );
		$context->setLocale( app( 'aimeos.locale' )->getBackend( $context, $site ) );

		$view = app( 'aimeos.view' )->create( $context, $paths, $lang );

		$view->aimeosType = 'Laravel';
		$view->aimeosVersion = app( 'aimeos' )->getVersion();
		$view->aimeosExtensions = implode( ',', $aimeos->getExtensions() );

		$context->setView( $view );

		return \Aimeos\Admin\JQAdm::create( $context, $aimeos, $resource );
	}


	/**
	 * Returns the generated HTML code
	 *
	 * @param string $content Content from admin client
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	protected function getHtml( string $content )
	{
		$site = Route::input( 'site', Request::get( 'site', 'default' ) );
		$lang = Request::get( 'locale', config( 'app.locale', 'en' ) );

		return View::make( \Aimeos\Shop\Facades\Shop::template( 'jqadm.index' ), [
			'content' => $content,
			'site' => $site,
			'locale' => $lang,
			'localeDir' => in_array( $lang, ['ar', 'az', 'dv', 'fa', 'he', 'ku', 'ur'] ) ? 'rtl' : 'ltr',
			'theme' => ( $_COOKIE['aimeos_backend_theme'] ?? '' ) == 'dark' ? 'dark' : 'light'
		] );
	}
}
