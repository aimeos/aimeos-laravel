<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


/**
 * Service providing the context objects
 *
 * @package laravel
 * @subpackage Base
 */
class Context
{
	/**
	 * @var \MShop_Context_Item_Interface
	 */
	private static $context;

	/**
	 * @var \Illuminate\Contracts\Config\Repository
	 */
	private $config;

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
	 * @param \Illuminate\Contracts\Config\Repository $config Configuration object
	 * @param \Illuminate\Session\Store $session Laravel session object
	 */
	public function __construct( \Illuminate\Contracts\Config\Repository $config, \Illuminate\Session\Store $session )
	{
		$this->config = $config;
		$this->session = $session;
	}


	/**
	 * Returns the current context
	 *
	 * @param array $templatePaths List of base path names with relative template paths as key/value pairs
	 * @param boolean $locale True to add locale object to context, false if not
	 * @return \MShop_Context_Item_Interface Context object
	 */
	public function get( array $templatePaths, $locale = true )
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
			$langid = $localeItem->getLanguageId();

			$context->setLocale( $localeItem );
			$context->setI18n( app('\Aimeos\Shop\Base\I18n')->get( array( $langid ) ) );

			$cache = new \MAdmin_Cache_Proxy_Default( $context );
			$context->setCache( $cache );
		}

		$session = new \MW_Session_Laravel4( $this->session );
		$context->setSession( $session );

		$this->addUser( $context );

		return $context;
	}


	/**
	 * Adds the user ID and name if available
	 *
	 * @param \MShop_Context_Item_Interface $context Context object
	 */
	protected function addUser( \MShop_Context_Item_Interface $context )
	{
		if( ( $userid = \Auth::id() ) !== null ) {
			$context->setUserId( $userid );
		}

		if( ( $user = \Auth::user() ) !== null ) {
			$context->setEditor( $user->name );
		}
	}


	/**
	 * Creates a new configuration object.
	 *
	 * @return \MW_Config_Interface Configuration object
	 */
	protected function getConfig()
	{
		$conf = $this->config->get( 'shop' );

		$configPaths = app( '\Aimeos\Shop\Base\Aimeos' )->get()->getConfigPaths( 'mysql' );
		$config = new \MW_Config_Array( $conf, $configPaths );

		if( function_exists( 'apc_store' ) === true && $this->config->get( 'shop.apc_enabled', false ) == true ) {
			$config = new \MW_Config_Decorator_APC( $config, $this->config->get( 'shop.apc_prefix', 'laravel:' ) );
		}

		return $config;
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
			$site = \Route::input( 'site', 'default' );
			$lang = \Route::input( 'locale', '' );
			$currency = \Route::input( 'currency', '' );

			$disableSites = $this->config->has( 'shop.disableSites' );

			$localeManager = \MShop_Locale_Manager_Factory::createManager( $context );
			$this->locale = $localeManager->bootstrap( $site, $lang, $currency, $disableSites );
		}

		return $this->locale;
	}
}
