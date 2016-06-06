<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2014-2016
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Http\Request;
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
class ExtadmController extends AdminController
{
	use AuthorizesRequests;


	/**
	 * Returns the initial HTML view for the admin interface.
	 *
	 * @param \Illuminate\Http\Request $request Laravel request object
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function indexAction( Request $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [['admin']] );
		}

		$site = Route::input( 'site', Input::get( 'site', 'default' ) );
		$lang = Route::input( 'lang', Input::get( 'lang', config( 'app.locale', 'en' ) ) );
		$tab = Route::input( 'tab', Input::get( 'tab', 0 ) );

		$aimeos = app( '\Aimeos\Shop\Base\Aimeos' );

		$bootstrap = $aimeos->get();
		$cntlPaths = $bootstrap->getCustomPaths( 'controller/extjs' );

		$context = app( '\Aimeos\Shop\Base\Context' )->get( false );
		$context = $this->setLocale( $context, $site, $lang );

		$controller = new \Aimeos\Controller\ExtJS\JsonRpc( $context, $cntlPaths );
		$cssFiles = array();

		foreach( $bootstrap->getCustomPaths( 'admin/extjs' ) as $base => $paths )
		{
			foreach( $paths as $path )
			{
				$jsbAbsPath = $base . '/' . $path;

				if( !is_file( $jsbAbsPath ) ) {
					throw new \Exception( sprintf( 'JSB2 file "%1$s" not found', $jsbAbsPath ) );
				}

				$jsb2 = new \Aimeos\MW\Jsb2\Standard( $jsbAbsPath, dirname( $path ) );
				$cssFiles = array_merge( $cssFiles, $jsb2->getUrls( 'css' ) );
			}
		}

		$jqadmUrl = route( 'aimeos_shop_jqadm_search', array( 'site' => $site, 'resource' => 'product' ) );
		$jsonUrl = route( 'aimeos_shop_extadm_json', array( 'site' => $site, '_token' => csrf_token() ) );
		$adminUrl = route( 'aimeos_shop_extadm', array( 'site' => '<site>', 'lang' => '<lang>', 'tab' => '<tab>' ) );

		$vars = array(
			'lang' => $lang,
			'cssFiles' => $cssFiles,
			'languages' => $this->getJsonLanguages( $context),
			'config' => $this->getJsonClientConfig( $context ),
			'site' => $this->getJsonSiteItem( $context, $site ),
			'i18nContent' => $this->getJsonClientI18n( $bootstrap->getI18nPaths(), $lang ),
			'searchSchemas' => $controller->getJsonSearchSchemas(),
			'itemSchemas' => $controller->getJsonItemSchemas(),
			'smd' => $controller->getJsonSmd( $jsonUrl ),
			'urlTemplate' => str_replace( ['<', '>'], ['{', '}'], urldecode( $adminUrl ) ),
			'uploaddir' => config( 'shop::uploaddir' ),
			'version' => $aimeos->getVersion(),
			'jqadmurl' => $jqadmUrl,
			'activeTab' => $tab,
		);

		return View::make( 'shop::extadm.index', $vars );
	}


	/**
	 * Single entry point for all JSON admin requests.
	 *
	 * @param \Illuminate\Http\Request $request Laravel request object
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function doAction( Request $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [['admin']] );
		}

		$aimeos = app( '\Aimeos\Shop\Base\Aimeos' )->get();
		$cntlPaths = $aimeos->getCustomPaths( 'controller/extjs' );

		$context = app( '\Aimeos\Shop\Base\Context' )->get( false );
		$context->setView( app( '\Aimeos\Shop\Base\View' )->create( $context->getConfig(), array() ) );
		$context = $this->setLocale( $context );

		$controller = new \Aimeos\Controller\ExtJS\JsonRpc( $context, $cntlPaths );

		$response = $controller->process( Input::instance()->request->all(), $request->getContent() );
		return View::make( 'shop::extadm.do', array( 'output' => $response ) );
	}


	/**
	 * Returns the JS file content
	 *
	 * @return \Illuminate\Http\Response Response object containing the generated output
	 */
	public function fileAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [['admin']] );
		}

		$contents = '';
		$jsFiles = array();
		$aimeos = app( '\Aimeos\Shop\Base\Aimeos' )->get();

		foreach( $aimeos->getCustomPaths( 'admin/extjs' ) as $base => $paths )
		{
			foreach( $paths as $path )
			{
				$jsbAbsPath = $base . '/' . $path;
				$jsb2 = new \Aimeos\MW\Jsb2\Standard( $jsbAbsPath, dirname( $jsbAbsPath ) );
				$jsFiles = array_merge( $jsFiles, $jsb2->getFiles( 'js' ) );
			}
		}

		foreach( $jsFiles as $file )
		{
			if( ( $content = file_get_contents( $file ) ) !== false ) {
				$contents .= $content;
			}
		}

		return response( $contents )->header( 'Content-Type', 'application/javascript' );
	}


	/**
	 * Creates a list of all available translations.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return array List of language IDs with labels
	 */
	protected function getJsonLanguages( \Aimeos\MShop\Context\Item\Iface $context )
	{
		$result = array();

		foreach( app( '\Aimeos\Shop\Base\Aimeos' )->get()->getI18nList( 'admin' ) as $id ) {
			$result[] = array( 'id' => $id, 'label' => $id );
		}

		return json_encode( $result );
	}


	/**
	 * Returns the JSON encoded configuration for the ExtJS client.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context item object
	 * @return string JSON encoded configuration object
	 */
	protected function getJsonClientConfig( \Aimeos\MShop\Context\Item\Iface $context )
	{
		$config = $context->getConfig()->get( 'admin/extjs', array() );
		return json_encode( array( 'admin' => array( 'extjs' => $config ) ), JSON_FORCE_OBJECT );
	}


	/**
	 * Returns the JSON encoded translations for the ExtJS client.
	 *
	 * @param array $i18nPaths List of file system paths which contain the translation files
	 * @param string $lang ISO language code like "en" or "en_GB"
	 * @return string JSON encoded translation object
	 */
	protected function getJsonClientI18n( array $i18nPaths, $lang )
	{
		$i18n = new \Aimeos\MW\Translation\Gettext( $i18nPaths, $lang );

		$content = array(
			'admin' => $i18n->getAll( 'admin' ),
			'admin/ext' => $i18n->getAll( 'admin/ext' ),
		);

		return json_encode( $content, JSON_FORCE_OBJECT );
	}


	/**
	 * Returns the JSON encoded site item.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context item object
	 * @param string $site Unique site code
	 * @return string JSON encoded site item object
	 * @throws Exception If no site item was found for the code
	 */
	protected function getJsonSiteItem( \Aimeos\MShop\Context\Item\Iface $context, $site )
	{
		$manager = \Aimeos\MShop\Factory::createManager( $context, 'locale/site' );

		$criteria = $manager->createSearch();
		$criteria->setConditions( $criteria->compare( '==', 'locale.site.code', $site ) );
		$items = $manager->searchItems( $criteria );

		if( ( $item = reset( $items ) ) === false ) {
			throw new \Exception( sprintf( 'No site found for code "%1$s"', $site ) );
		}

		return json_encode( $item->toArray() );
	}


	/**
	 * Sets the locale item in the given context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @param string $sitecode Unique site code
	 * @param string $locale ISO language code, e.g. "en" or "en_GB"
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function setLocale( \Aimeos\MShop\Context\Item\Iface $context, $sitecode = 'default', $locale = null )
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

		return $context;
	}
}