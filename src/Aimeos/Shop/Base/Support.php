<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;


/**
 * Service providing the supporting functionality
 *
 * @package laravel
 * @subpackage Base
 */
class Support
{
	/**
	 * @var \Aimeos\Shop\Base\Context
	 */
	private $context;

	/**
	 * @var \Aimeos\Shop\Base\Locale
	 */
	private $locale;


	/**
	 * Initializes the object
	 *
	 * @param \Aimeos\Shop\Base\Context $context Context provider
	 * @param \Aimeos\Shop\Base\Locale $locale Locale provider
	 */
	public function __construct( \Aimeos\Shop\Base\Context $context, \Aimeos\Shop\Base\Locale $locale )
	{
		$this->context = $context;
		$this->locale = $locale;
	}


	/**
	 * Checks if the user with the given ID is in the specified group
	 *
	 * @param string $userid Unique user ID
	 * @param string|array $groupcodes Unique user/customer group codes that are allowed
	 * @return boolean True if user is part of the group, false if not
	 */
	public function checkGroup( $userid, $groupcodes )
	{
		$site = ( Route::current() ? Route::input( 'site', Input::get( 'site', 'default' ) ) : 'default' );

		$context = $this->context->get( false );
		$context->setLocale( $this->locale->getBackend( $context, $site ) );


		$manager = \Aimeos\MShop\Factory::createManager( $context, 'customer/group' );

		$search = $manager->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.group.code', (array) $groupcodes ) );
		$groupItems = $manager->searchItems( $search );


		$manager = \Aimeos\MShop\Factory::createManager( $context, 'customer/lists' );

		$search = $manager->createSearch();
		$expr = array(
			$search->compare( '==', 'customer.lists.parentid', $userid ),
			$search->compare( '==', 'customer.lists.refid', array_keys( $groupItems ) ),
			$search->compare( '==', 'customer.lists.domain', 'customer/group' ),
		);
		$search->setConditions( $search->combine( '&&', $expr ) );
		$search->setSlice( 0, 1 );

		return (bool) count( $manager->searchItems( $search ) );
	}


	public function getGroups( \Aimeos\MShop\Context\Item\Iface $context )
	{
		$list = array();
		$manager = \Aimeos\MShop\Factory::createManager( $context, 'customer/group' );

		$search = $manager->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.group.id', $context->getGroupIds() ) );

		foreach( $manager->searchItems( $search ) as $item ) {
			$list[] = $item->getCode();
		}

		return $list;
	}
}