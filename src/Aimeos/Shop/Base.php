<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015
 */


namespace Aimeos\Shop;


/**
 * Base class for Aimeos Laravel package
 */
class Base
{
	/**
	 * @var \MShop_Context_Item_Interface
	 */
	private static $context;

	/**
	 * @var \Arcavias
	 */
	private $aimeos;

	/**
	 * @var array
	 */
	private $i18n = array();

	/**
	 * @var \MShop_Locale_Item_Interface
	 */
	private $locale;

	/**
	 * @var \Illuminate\Session\Store
	 */
	private $session;


	/**
	 * Initializes the object
	 *
	 * @param \Illuminate\Session\Store $session Laravel session object
	 */
	public function __construct( \Illuminate\Session\Store $session )
	{
		$this->session = $session;
	}


	/**
	 * Returns the Arcavias object
	 *
	 * @return \Arcavias Arcavias object
	 */
	public function getAimeos()
	{
		if( $this->aimeos === null )
		{
			$extDirs = (array) \Config::get( 'shop::extdir', array() );
			$this->aimeos = new \Arcavias( $extDirs, false );
		}

		return $this->aimeos;
	}


	/**
	 * Returns the current context
	 *
	 * @param array $templatePaths List of base path names with relative template paths as key/value pairs
	 * @param boolean $locale True to add locale object to context, false if not
	 * @return \MShop_Context_Item_Interface Context object
	 */
	public function getContext( array $templatePaths, $locale = true )
	{
		if( self::$context === null )
		{
			$context = new \MShop_Context_Item_Default();

			$config = $this->getConfig();
			$context->setConfig( $config );

			$dbm = new \MW_DB_Manager_PDO( $config );
			$context->setDatabaseManager( $dbm );

			$cache = new \MW_Cache_None();
			$context->setCache( $cache );

			$mail = new \MW_Mail_Swift( \Mail::getSwiftMailer() );
			$context->setMail( $mail );

			$logger = \MAdmin_Log_Manager_Factory::createManager( $context );
			$context->setLogger( $logger );

			self::$context = $context;
		}

		$context = self::$context;

		if( $locale === true )
		{
			$localeItem = $this->getLocale( $context );

			$context->setLocale( $localeItem );
			$context->setI18n( $this->getI18n( $context, array( $localeItem->getLanguageId() ) ) );

			$cache = new \MAdmin_Cache_Proxy_Default( $context );
			$context->setCache( $cache );
		}

		$session = new \MW_Session_Laravel4( $this->session );
		$context->setSession( $session );

		$view = $this->createView( $context, $templatePaths, $locale );
		$context->setView( $view );

		$this->addUser( $context );

		return $context;
	}


	/**
	 * Returns the body and header sections created by the clients configured for the given page name.
	 *
	 * @param string $name Name of the configured page
	 * @return array Associative list with body and header output separated by client name
	 */
	public function getPageSections( $pageName )
	{
		$aimeos = $this->getAimeos();
		$tmplPaths = $aimeos->getCustomPaths( 'client/html' );
		$context = $this->getContext( $tmplPaths );

		$pagesConfig = \Config::get( 'shop::config.page', array() );
		$result = array( 'aibody' => array(), 'aiheader' => array() );

		if( isset( $pagesConfig[$pageName] ) )
		{
			foreach( (array) $pagesConfig[$pageName] as $clientName )
			{
				$client = \Client_Html_Factory::createClient( $context, $tmplPaths, $clientName );
				$client->setView( $context->getView() );
				$client->process();

				$result['aibody'][$clientName] = $client->getBody();
				$result['aiheader'][$clientName] = $client->getHeader();
			}
		}

		return $result;
	}


	/**
	 * Adds the user ID and name if available
	 *
	 * @param \MShop_Context_Item_Interface $context Context object
	 */
	protected function addUser( \MShop_Context_Item_Interface $context )
	{
		$username = '';

		\Auth::id();
		$context->setEditor( $username );
	}


	/**
	 * Creates the view object for the HTML client.
	 *
	 * @param \MShop_Context_Item_Interface $context Context object
	 * @param array $templatePaths List of base path names with relative template paths as key/value pairs
	 * @param boolean $locale True to add locale object to context, false if not
	 * @return \MW_View_Interface View object
	 */
	protected function createView( \MShop_Context_Item_Interface $context, array $templatePaths, $locale )
	{
		$params = $fixed = array();
		$config = $context->getConfig();

		if( $locale === true )
		{
			$params = \Route::current()->parameters() + \Input::all();
			$params['target'] = \Route::currentRouteName();

			$fixed = $this->getFixedParams();

			$langid = $context->getLocale()->getLanguageId();
			$i18n = $this->getI18n( $context, array( $langid ) );

			$translation = $i18n[$langid];
		}
		else
		{
			$translation = new \MW_Translation_None( 'en' );
		}


		$view = new \MW_View_Default();

		$helper = new \MW_View_Helper_Translate_Default( $view, $translation );
		$view->addHelper( 'translate', $helper );

		$helper = new \MW_View_Helper_Url_Laravel4( $view, \App::make('url'), $fixed );
		$view->addHelper( 'url', $helper );

		$helper = new \MW_View_Helper_Partial_Default( $view, $config, $templatePaths );
		$view->addHelper( 'partial', $helper );

		$helper = new \MW_View_Helper_Parameter_Default( $view, $params );
		$view->addHelper( 'param', $helper );

		$helper = new \MW_View_Helper_Config_Default( $view, $config );
		$view->addHelper( 'config', $helper );

		$sepDec = $config->get( 'client/html/common/format/seperatorDecimal', '.' );
		$sep1000 = $config->get( 'client/html/common/format/seperator1000', ' ' );
		$helper = new \MW_View_Helper_Number_Default( $view, $sepDec, $sep1000 );
		$view->addHelper( 'number', $helper );

		$helper = new \MW_View_Helper_FormParam_Default( $view, array() );
		$view->addHelper( 'formparam', $helper );

		$helper = new \MW_View_Helper_Encoder_Default( $view );
		$view->addHelper( 'encoder', $helper );

		return $view;
	}


	/**
	 * Creates a new configuration object.
	 *
	 * @return \MW_Config_Interface Configuration object
	 */
	protected function getConfig()
	{
		$conf = \Config::get( 'shop::config' );
		$conf['resource']['db']['host'] = \Config::get( 'database.connections.mysql.host' );
		$conf['resource']['db']['database'] = \Config::get( 'database.connections.mysql.database' );
		$conf['resource']['db']['username'] = \Config::get( 'database.connections.mysql.username' );
		$conf['resource']['db']['password'] = \Config::get( 'database.connections.mysql.password' );

		$configPaths = $this->getAimeos()->getConfigPaths( 'mysql' );
		$config = new \MW_Config_Array( $conf, $configPaths );

		if( function_exists( 'apc_store' ) === true && \Config::get( 'shop::config.apc_enabled', false ) == true ) {
			$config = new \MW_Config_Decorator_APC( $config, \Config::get( 'shop::config.apc_prefix', 'laravel:' ) );
		}

		return $config;
	}


	/**
	 * Creates new translation objects.
	 *
	 * @param \MShop_Context_Item_Interface $context Context object including config
	 * @param array $languageIds List of two letter ISO language IDs
	 * @return \MW_Translation_Interface[] List of translation objects
	 */
	protected function getI18n( \MShop_Context_Item_Interface $context, array $languageIds )
	{
		$i18nPaths = $this->getAimeos()->getI18nPaths();

		foreach( $languageIds as $langid )
		{
			if( !isset( $this->i18n[$langid] ) )
			{
				$conf = $context->getConfig();
				$i18n = new \MW_Translation_Zend2( $i18nPaths, 'gettext', $langid, array( 'disableNotices' => true ) );

				if( function_exists( 'apc_store' ) === true && \Config::get( 'shop::config.apc_enabled', false ) == true ) {
					$i18n = new \MW_Translation_Decorator_APC( $i18n, \Config::get( 'shop::config.apc_prefix', 'laravel:' ) );
				}

				if( \Config::has( 'shop::i18n.' . $langid ) ) {
					$i18n = new \MW_Translation_Decorator_Memory( $i18n, \Config::get( 'shop::config.i18n.' . $langid ) );
				}

				$this->i18n[$langid] = $i18n;
			}
		}

		return $this->i18n;
	}


	/**
	 * Returns the locale item for the current request
	 *
	 * @param \MShop_Context_Item_Interface $context Context object
	 * @return \MShop_Locale_Item_Interface Locale item object
	 */
	protected function getLocale( \MShop_Context_Item_Interface $context )
	{
		if( $this->locale === null )
		{
			$currency = \Route::input( 'currency', 'EUR' );
			$site = \Route::input( 'site', 'default' );
			$lang = \Route::input( 'locale', 'en' );

			$disableSites = \Config::has( 'shop::config.disableSites' );

			$localeManager = \MShop_Locale_Manager_Factory::createManager( $context );
			$this->locale = $localeManager->bootstrap( $site, $lang, $currency, $disableSites );
		}

		return $this->locale;
	}


	/**
	 * Returns the fixed parameters that should be included in every URL
	 *
	 * @return array Associative list of site, language and currency if available
	 */
	protected function getFixedParams()
	{
		$fixed = array();

		if( ( $value = \Route::input( 'site' ) ) !== null ) {
			$fixed['site'] = $value;
		}

		if( ( $value = \Route::input( 'locale' ) ) !== null ) {
			$fixed['locale'] = $value;
		}

		if( ( $value = \Route::input( 'currency' ) ) !== null ) {
			$fixed['currency'] = $value;
		}

		return $fixed;
	}
}
