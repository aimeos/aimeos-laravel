<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


use Illuminate\Support\Facades\Auth;


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
	 * @param \Aimeos\Shop\Base\I18n $i18n Internationalisation object
	 * @param \Aimeos\Shop\Base\Locale $locale Locale object
	 */
	public function __construct( \Illuminate\Session\Store $session, \Aimeos\Shop\Base\Config $config, \Aimeos\Shop\Base\I18n $i18n, \Aimeos\Shop\Base\Locale $locale )
	{
		$this->session = $session;
		$this->locale = $locale;
		$this->config = $config;
		$this->i18n = $i18n;
	}


	/**
	 * Returns the current context
	 *
	 * @param boolean $locale True to add locale object to context, false if not (deprecated, use \Aimeos\Shop\Base\Locale)
	 * @param string $type Configuration type ("frontend" or "backend")
	 * @return \Aimeos\MShop\Context\Item\Iface Context object
	 */
	public function get( $locale = true, $type = 'frontend' )
	{
		$config = $this->config->get( $type );

		if( $this->context === null )
		{
			$context = new \Aimeos\MShop\Context\Item\Standard();
			$context->setConfig( $config );

			$dbm = new \Aimeos\MW\DB\Manager\DBAL( $config );
			$context->setDatabaseManager( $dbm );

			$fs = new \Aimeos\MW\Filesystem\Manager\Laravel( app( 'filesystem' ), $config, storage_path( 'aimeos' ) );
			$context->setFilesystemManager( $fs );

			$mq = new \Aimeos\MW\MQueue\Manager\Standard( $config );
			$context->setMessageQueueManager( $mq );

			$mail = new \Aimeos\MW\Mail\Swift( function() { return app( 'mailer' )->getSwiftMailer(); } );
			$context->setMail( $mail );

			$logger = \Aimeos\MAdmin\Log\Manager\Factory::createManager( $context );
			$context->setLogger( $logger );

			$cache = new \Aimeos\MAdmin\Cache\Proxy\Standard( $context );
			$context->setCache( $cache );

			$session = new \Aimeos\MW\Session\Laravel5( $this->session );
			$context->setSession( $session );

			$this->context = $context;
		}

		$this->context->setConfig( $config );
		$this->addUser( $this->context );

		if( $locale === true )
		{
			$localeItem = $this->locale->get( $context );
			$context->setLocale( $localeItem );
			$context->setI18n( $this->i18n->get( array( $localeItem->getLanguageId() ) ) );
		}

		return $this->context;
	}


	/**
	 * Adds the user ID and name if available
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 */
	protected function addUser( \Aimeos\MShop\Context\Item\Iface $context )
	{
		if( ( $userid = Auth::id() ) !== null )
		{
			$context->setUserId( $userid );
			$context->setGroupIds( function() use ( $context, $userid )
			{
				$manager = \Aimeos\MShop\Factory::createManager( $context, 'customer' );
				return $manager->getItem( $userid, array( 'customer/group' ) )->getGroups();
			} );
		}

		if( ( $user = Auth::user() ) !== null ) {
			$context->setEditor( $user->name );
		}
	}
}
