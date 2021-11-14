<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/**
 * Service providing the context objects
 *
 * @package laravel
 * @subpackage Base
 */
class Context
{
	/**
	 * @var \Aimeos\MShop\Context\Item\Iface
	 */
	private $context;

	/**
	 * @var \Aimeos\Shop\Base\Config
	 */
	private $config;

	/**
	 * @var \Aimeos\Shop\Base\I18n
	 */
	private $i18n;

	/**
	 * @var \Aimeos\Shop\Base\Locale
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
	 * @param \Aimeos\Shop\Base\Config $config Configuration object
	 * @param \Aimeos\Shop\Base\Locale $locale Locale object
	 * @param \Aimeos\Shop\Base\I18n $i18n Internationalisation object
	 */
	public function __construct( \Illuminate\Session\Store $session, \Aimeos\Shop\Base\Config $config, \Aimeos\Shop\Base\Locale $locale, \Aimeos\Shop\Base\I18n $i18n )
	{
		$this->session = $session;
		$this->config = $config;
		$this->locale = $locale;
		$this->i18n = $i18n;
	}


	/**
	 * Returns the current context
	 *
	 * @param bool $locale True to add locale object to context, false if not (deprecated, use \Aimeos\Shop\Base\Locale)
	 * @param string $type Configuration type, i.e. "frontend" or "backend" (deprecated, use \Aimeos\Shop\Base\Config)
	 * @return \Aimeos\MShop\Context\Item\Iface Context object
	 */
	public function get( bool $locale = true, string $type = 'frontend' ) : \Aimeos\MShop\Context\Item\Iface
	{
		$config = $this->config->get( $type );

		if( $this->context === null )
		{
			$context = new \Aimeos\MShop\Context\Item\Standard();
			$context->setConfig( $config );

			$this->addDataBaseManager( $context );
			$this->addFilesystemManager( $context );
			$this->addMessageQueueManager( $context );
			$this->addLogger( $context );
			$this->addCache( $context );
			$this->addMailer( $context );
			$this->addNonce( $context );
			$this->addPassword( $context );
			$this->addProcess( $context );
			$this->addSession( $context );
			$this->addUser( $context );
			$this->addGroups( $context );

			$this->context = $context;
		}

		$this->context->setConfig( $config );

		if( $locale === true )
		{
			$localeItem = $this->locale->get( $this->context );
			$this->context->setLocale( $localeItem );
			$this->context->setI18n( $this->i18n->get( array( $localeItem->getLanguageId() ) ) );

			$config->apply( $localeItem->getSiteItem()->getConfig() );
		}

		return $this->context;
	}


	/**
	 * Adds the cache object to the context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object including config
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function addCache( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Context\Item\Iface
	{
		$cache = new \Aimeos\MAdmin\Cache\Proxy\Standard( $context );

		return $context->setCache( $cache );
	}


	/**
	 * Adds the database manager object to the context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function addDatabaseManager( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Context\Item\Iface
	{
		$dbm = new \Aimeos\MW\DB\Manager\DBAL( $context->getConfig() );

		return $context->setDatabaseManager( $dbm );
	}


	/**
	 * Adds the filesystem manager object to the context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function addFilesystemManager( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Context\Item\Iface
	{
		$config = $context->getConfig();
		$path = storage_path( 'aimeos' );

		$fs = new \Aimeos\MW\Filesystem\Manager\Laravel( app( 'filesystem' ), $config, $path );

		return $context->setFilesystemManager( $fs );
	}


	/**
	 * Adds the logger object to the context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function addLogger( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Context\Item\Iface
	{
		$logger = \Aimeos\MAdmin::create( $context, 'log' );

		return $context->setLogger( $logger );
	}



	/**
	 * Adds the mailer object to the context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function addMailer( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Context\Item\Iface
	{
		$mail = new \Aimeos\MW\Mail\Swift( function() { return app( 'mailer' )->getSwiftMailer(); } );

		return $context->setMail( $mail );
	}


	/**
	 * Adds the message queue manager object to the context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function addMessageQueueManager( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Context\Item\Iface
	{
		$mq = new \Aimeos\MW\MQueue\Manager\Standard( $context->getConfig() );

		return $context->setMessageQueueManager( $mq );
	}


	/**
	 * Adds the nonce value for inline JS to the context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function addNonce( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Context\Item\Iface
	{
		return $context->setNonce( base64_encode( random_bytes( 16 ) ) );
	}


	/**
	 * Adds the password hasher object to the context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function addPassword( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Context\Item\Iface
	{
		return $context->setPassword( new \Aimeos\MW\Password\Standard() );
	}


	/**
	 * Adds the process object to the context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function addProcess( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Context\Item\Iface
	{
		$config = $context->getConfig();
		$max = $config->get( 'pcntl_max', 4 );
		$prio = $config->get( 'pcntl_priority', 19 );

		$process = new \Aimeos\MW\Process\Pcntl( $max, $prio );
		$process = new \Aimeos\MW\Process\Decorator\Check( $process );

		return $context->setProcess( $process );
	}


	/**
	 * Adds the session object to the context
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function addSession( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Context\Item\Iface
	{
		$session = new \Aimeos\MW\Session\Laravel5( $this->session );

		return $context->setSession( $session );
	}


	/**
	 * Adds the user ID and name if available
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function addUser( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Context\Item\Iface
	{
		$key = collect( config( 'shop.routes' ) )->where( 'prefix', optional( Route::getCurrentRoute() )->getPrefix() )->keys()->first();
		$guard = data_get( config( 'shop.guards' ), $key, Auth::getDefaultDriver() );

		if( ( $user = Auth::guard( $guard )->user() ) !== null ) {
			$context->setEditor( $user->name );
			$context->setUserId( $user->id );
		} elseif( $ip = \Request::ip() ) {
			$context->setEditor( $ip );
		}

		return $context;
	}


	/**
	 * Adds the group IDs if available
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 * @return \Aimeos\MShop\Context\Item\Iface Modified context object
	 */
	protected function addGroups( \Aimeos\MShop\Context\Item\Iface $context ) : \Aimeos\MShop\Context\Item\Iface
	{
		$key = collect( config( 'shop.routes' ) )->where( 'prefix', optional( Route::getCurrentRoute() )->getPrefix() )->keys()->first();
		$guard = data_get( config( 'shop.guards' ), $key, Auth::getDefaultDriver() );

		if( ( $userid = Auth::guard( $guard )->id() ) !== null )
		{
			$context->setGroupIds( function() use ( $context, $userid ) {
				$manager = \Aimeos\MShop::create( $context, 'customer' );
				$filter = $manager->filter()->add( 'customer.id', '==', $userid );
				return $manager->search( $filter, ['customer/group'] )->getGroups()->first();
			} );
		}

		return $context;
	}
}
