<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2023
 */


namespace Aimeos\Shop\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


/**
 * Creates new accounts or resets their passwords
 */
class AccountCommand extends AbstractCommand
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'aimeos:account
		{email? : E-Mail adress of the (admin) user (will ask for if not given)}
		{site? : Site to create account for (will use default value if not given}
		{--password= : Secret password for the account (will ask for if not given)}
		{--super : If account should have super user privileges for all sites}
		{--admin : If account should have site administrator privileges}
		{--editor : If account should have limited editor privileges}
		{--api : If account should be able to access the APIs}
	';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates new (admin) accounts';


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$site = $this->argument( 'site' ) ?: config( 'shop.mshop.locale.site', 'default' );

		if( ( $email = $this->argument( 'email' ) ) === null ) {
			$email = $this->ask( 'E-Mail' );
		}

		if( ( $password = $this->option( 'password' ) ) === null ) {
			$password = $this->secret( 'Password' );
		}

		$context = $this->getLaravel()->make( 'aimeos.context' )->get( false, 'command' );
		$context->setEditor( 'aimeos:account' );

		$localeManager = \Aimeos\MShop::create( $context, 'locale' );
		$localeItem = $localeManager->bootstrap( $site, '', '', false, null, true );
		$context->setLocale( $localeItem );

		$manager = \Aimeos\MShop::create( $context, 'customer' );

		try {
			$item = $manager->find( $email );
		} catch( \Aimeos\MShop\Exception $e ) {
			$item = $manager->create();
		}

		$item = $item->setCode( $email )->setLabel( $email )->setPassword( $password )->setStatus( 1 );
		$item->getPaymentAddress()->setEmail( $email );

		$item = $manager->save( $this->addGroups( $context, $item ) );

		\Illuminate\Foundation\Auth\User::findOrFail( $item->getId() )
			->forceFill( [
				'siteid' => $this->option( 'super' ) ? '' : $item->getSiteId(),
				'superuser' => ( $this->option( 'super' ) ? 1 : 0 ),
				'email_verified_at' => now(),
			] )->save();
	}


	/**
	 * Adds the group to the given user
	 *
	 * @param \Aimeos\MShop\ContextIface $context Aimeos context object
	 * @param \Aimeos\MShop\Customer\Item\Iface $user Aimeos customer object
	 * @return \Aimeos\MShop\Customer\Item\Iface Updated customer object
	 */
	protected function addGroups( \Aimeos\MShop\ContextIface $context,
		\Aimeos\MShop\Customer\Item\Iface $user ) : \Aimeos\MShop\Customer\Item\Iface
	{
		if( $this->option( 'admin' ) ) {
			$user = $this->addGroup( $context, $user, 'admin' );
		}

		if( $this->option( 'editor' ) ) {
			$user = $this->addGroup( $context, $user, 'editor' );
		}

		if( $this->option( 'api' ) ) {
			$user = $this->addGroup( $context, $user, 'api' );
		}

		return $user;
	}


	/**
	 * Adds the group to the given user
	 *
	 * @param \Aimeos\MShop\ContextIface $context Aimeos context object
	 * @param \Aimeos\MShop\Customer\Item\Iface $user Aimeos customer object
	 * @param string $group Unique customer group code
	 */
	protected function addGroup( \Aimeos\MShop\ContextIface $context, \Aimeos\MShop\Customer\Item\Iface $user,
		string $group ) : \Aimeos\MShop\Customer\Item\Iface
	{
		$msg = 'Add "%1$s" group to user "%2$s" for site "%3$s"';
		$site = $this->argument( 'site' ) ?: config( 'shop.mshop.locale.site', 'default' );
		$this->info( sprintf( $msg, $group, $user->getCode(), $site ) );

		$groupId = $this->getGroupItem( $context, $group )->getId();
		return $user->setGroups( array_merge( $user->getGroups(), [$groupId] ) );
	}


	/**
	 * Returns the customer group item for the given code
	 *
	 * @param \Aimeos\MShop\ContextIface $context Aimeos context object
	 * @param string $code Unique customer group code
	 * @return \Aimeos\MShop\Group\Item\Iface Aimeos customer group item object
	 */
	protected function getGroupItem( \Aimeos\MShop\ContextIface $context, string $code ) : \Aimeos\MShop\Group\Item\Iface
	{
		$manager = \Aimeos\MShop::create( $context, 'group' );

		try
		{
			$item = $manager->find( $code );
		}
		catch( \Aimeos\MShop\Exception $e )
		{
			$item = $manager->create();
			$item->setLabel( $code );
			$item->setCode( $code );

			$manager->save( $item );
		}

		return $item;
	}
}
