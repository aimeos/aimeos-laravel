<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2023
 */

namespace Aimeos\Shop\Base;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


/**
 * Service providing the context objects
 */
class Context
{
	/**
	 * @var \Aimeos\MShop\ContextIface
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
	 * @return \Aimeos\MShop\ContextIface Context object
	 */
	public function get( bool $locale = true, string $type = 'frontend' ) : \Aimeos\MShop\ContextIface
	{
		$config = $this->config->get( $type );

		if( $this->context === null )
		{
			$context = new \Aimeos\MShop\Context();
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
			$this->addToken( $context );
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
	 * @param \Aimeos\MShop\ContextIface $context Context object including config
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addCache( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		$cache = \Aimeos\MAdmin::create( $context, 'cache' )->getCache();

		return $context->setCache( $cache );
	}


	/**
	 * Adds the database manager object to the context
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addDatabaseManager( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		$dbm = new \Aimeos\Base\DB\Manager\Standard( $context->config()->get( 'resource', [] ), 'DBAL' );

		return $context->setDatabaseManager( $dbm );
	}


	/**
	 * Adds the filesystem manager object to the context
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addFilesystemManager( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		$config = $context->config()->get( 'resource' );
		$fs = new \Aimeos\Base\Filesystem\Manager\Laravel( app( 'filesystem' ), $config, storage_path( 'aimeos' ) );

		return $context->setFilesystemManager( $fs );
	}


	/**
	 * Adds the logger object to the context
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addLogger( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		$logger = \Aimeos\MAdmin::create( $context, 'log' );

		return $context->setLogger( $logger );
	}



	/**
	 * Adds the mailer object to the context
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addMailer( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		$mail = new \Aimeos\Base\Mail\Laravel( function() { return app( 'mailer' ); } );

		return $context->setMail( $mail );
	}


	/**
	 * Adds the message queue manager object to the context
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addMessageQueueManager( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		$mq = new \Aimeos\Base\MQueue\Manager\Standard( $context->config()->get( 'resource', [] ) );

		return $context->setMessageQueueManager( $mq );
	}


	/**
	 * Adds the nonce value for inline JS to the context
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addNonce( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		return $context->setNonce( base64_encode( random_bytes( 16 ) ) );
	}


	/**
	 * Adds the password hasher object to the context
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addPassword( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		return $context->setPassword( new \Aimeos\Base\Password\Standard() );
	}


	/**
	 * Adds the process object to the context
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addProcess( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		$config = $context->config();
		$max = $config->get( 'pcntl_max', 4 );
		$prio = $config->get( 'pcntl_priority', 19 );

		$process = new \Aimeos\Base\Process\Pcntl( $max, $prio );
		$process = new \Aimeos\Base\Process\Decorator\Check( $process );

		return $context->setProcess( $process );
	}


	/**
	 * Adds the session object to the context
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addSession( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		$session = new \Aimeos\Base\Session\Laravel( $this->session );

		return $context->setSession( $session );
	}


	/**
	 * Adds the session token to the context
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addToken( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		if( ( $token = Session::get( 'token' ) ) === null ) {
			Session::put( 'token', $token = Session::getId() );
		}

		return $context->setToken( $token );
	}


	/**
	 * Adds the user ID and name if available
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addUser( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		$key = collect( config( 'shop.routes' ) )
			->where( 'prefix', optional( Route::getCurrentRoute() )->getPrefix() )
			->keys()->first();
		$guard = data_get( config( 'shop.guards' ), $key, Auth::getDefaultDriver() );

		if( $user = Auth::guard( $guard )->user() ) {
			$context->setEditor( $user->name ?? (string) \Request::ip() );
			$context->setUserId( $user->getAuthIdentifier() );
		} elseif( $ip = \Request::ip() ) {
			$context->setEditor( $ip );
		}

		return $context;
	}


	/**
	 * Adds the group IDs if available
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @return \Aimeos\MShop\ContextIface Modified context object
	 */
	protected function addGroups( \Aimeos\MShop\ContextIface $context ) : \Aimeos\MShop\ContextIface
	{
		$key = collect( config( 'shop.routes' ) )
			->where( 'prefix', optional( Route::getCurrentRoute() )->getPrefix() )
			->keys()->first();
		$guard = data_get( config( 'shop.guards' ), $key, Auth::getDefaultDriver() );

		if( $userid = Auth::guard( $guard )->id() )
		{
			$context->setGroupIds( function() use ( $context, $userid ) {
				try {
					return \Aimeos\MShop::create( $context, 'customer' )->get( $userid, ['group'] )->getGroups();
				} catch( \Exception $e ) {
					return [];
				}
			} );
		}

		return $context;
	}
}
