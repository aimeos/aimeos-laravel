<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Command
 */


namespace Aimeos\Shop\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


/**
 * Creates new accounts or resets their passwords
 * @package laravel
 * @subpackage Command
 */
class AccountCommand extends AbstractCommand
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'aimeos:account';

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
	public function fire()
	{
		$code = $this->argument( 'email' );
		if( ( $password = $this->option( 'password' ) ) === null ) {
			$password = $this->secret( 'Password' );
		}

		$context = $this->getLaravel()->make( 'Aimeos\Shop\Base\Context' )->get( false );
		$context->setEditor( 'aimeos:account' );

		$localeManager = \Aimeos\MShop\Locale\Manager\Factory::createManager( $context );
		$context->setLocale( $localeManager->createItem() );

		$user = $this->createCustomerItem( $context, $code, $password );

		if( $this->option( 'admin' ) ) {
			$this->addGroup( $context, $user, 'admin' );
		}

		if( $this->option( 'api' ) ) {
			$this->addGroup( $context, $user, 'api' );
		}

		if( $this->option( 'editor' ) ) {
			$this->addGroup( $context, $user, 'editor' );
		}
	}


	/**
	 * Associates the user to the group by their given IDs
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Aimeos context object
	 * @param string $userid Unique user ID
	 * @param string $groupid Unique group ID
	 */
	protected function addListItem( \Aimeos\MShop\Context\Item\Iface $context, $userid, $groupid )
	{
		$manager = \Aimeos\MShop\Customer\Manager\Factory::createManager( $context )->getSubmanager( 'lists' );
		$typeid = $manager->getSubmanager( 'type' )->findItem( 'default', array(), 'customer/group' )->getId();

		$search = $manager->createSearch();
		$expr = array(
			$search->compare( '==', 'customer.lists.parentid', $userid ),
			$search->compare( '==', 'customer.lists.refid', $groupid ),
			$search->compare( '==', 'customer.lists.domain', 'customer/group' ),
			$search->compare( '==', 'customer.lists.typeid', $typeid ),
		);
		$search->setConditions( $search->combine( '&&', $expr ) );
		$search->setSlice( 0, 1 );

		if( count( $manager->searchItems( $search ) ) === 0 )
		{
			$item = $manager->createItem();
			$item->setDomain( 'customer/group' );
			$item->setParentId( $userid );
			$item->setTypeId( $typeid );
			$item->setRefId( $groupid );
			$item->setStatus( 1 );

			$manager->saveItem( $item, false );
		}
	}


	/**
	 * Adds the group to the given user
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Aimeos context object
	 * @param \Aimeos\MShop\Customer\Item\Iface $user Aimeos customer object
	 * @param string $group Unique customer group code
	 */
	protected function addGroup( \Aimeos\MShop\Context\Item\Iface $context, \Aimeos\MShop\Customer\Item\Iface $user, $group )
	{
		$this->info( sprintf( 'Add "%1$s" group to user "%2$s" for sites', $group, $user->getCode() ) );

		$localeManager = \Aimeos\MShop\Locale\Manager\Factory::createManager( $context );

		foreach( $this->getSiteItems( $context, $this->argument( 'site' ) ) as $siteItem )
		{
			$localeItem = $localeManager->bootstrap( $siteItem->getCode(), '', '', false );

			$lcontext = clone $context;
			$lcontext->setLocale( $localeItem );

			$this->info( '- ' . $siteItem->getCode() );

			$groupItem = $this->getGroupItem( $lcontext, $group );
			$this->addListItem( $lcontext, $user->getId(), $groupItem->getId() );
		}
	}


	/**
	 * Returns the customer item for the given e-mail and set its password
	 *
	 * If the customer doesn't exist yet, it will be created.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Aimeos context object
	 * @param string $email Unique e-mail address
	 * @param string $password New user password
	 * @return \Aimeos\MShop\Customer\Item\Iface Aimeos customer item object
	 */
	protected function createCustomerItem( \Aimeos\MShop\Context\Item\Iface $context, $email, $password )
	{
		$manager = \Aimeos\MShop\Factory::createManager( $context, 'customer' );

		try {
			$item = $manager->findItem( $email );
		} catch( \Aimeos\MShop\Exception $e ) {
			$item = $manager->createItem();
		}

		$item->setCode( $email );
		$item->setLabel( $email );
		$item->getPaymentAddress()->setEmail( $email );
		$item->setPassword( $password );

		$manager->saveItem( $item );

		return $item;
	}


	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array( 'email', InputArgument::REQUIRED, 'E-mail address of the account that should be created' ),
			array( 'site', InputArgument::OPTIONAL, 'Site codes to create accounts for like "default unittest" (none for all)' ),
		);
	}


	/**
	 * Returns the customer group item for the given code
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Aimeos context object
	 * @param string $code Unique customer group code
	 * @return \Aimeos\MShop\Customer\Item\Group\Iface Aimeos customer group item object
	 */
	protected function getGroupItem( \Aimeos\MShop\Context\Item\Iface $context, $code )
	{
		$manager = \Aimeos\MShop\Customer\Manager\Factory::createManager( $context )->getSubmanager( 'group' );

		try
		{
			$item = $manager->findItem( $code );
		}
		catch( \Aimeos\MShop\Exception $e )
		{
			$item = $manager->createItem();
			$item->setLabel( $code );
			$item->setCode( $code );

			$manager->saveItem( $item );
		}

		return $item;
	}


	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array( 'password', null, InputOption::VALUE_REQUIRED, 'Optional password for the account (will ask for if not given)' ),
			array( 'admin', null, InputOption::VALUE_NONE, 'If account should have administrator privileges' ),
			array( 'api', null, InputOption::VALUE_NONE, 'If account should be able to access the APIs' ),
			array( 'editor', null, InputOption::VALUE_NONE, 'If account should have limited editor privileges' ),
		);
	}
}
