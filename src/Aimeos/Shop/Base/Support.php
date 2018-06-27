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
	 * @var array
	 */
	private $cache = [];


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
	 * Checks if the user is in the specified group and associatied to the site
	 *
	 * @param \Illuminate\Foundation\Auth\User $user Authenticated user
	 * @param string|array $groupcodes Unique user/customer group codes that are allowed
	 * @return boolean True if user is part of the group, false if not
	 */
	public function checkUserGroup( \Illuminate\Foundation\Auth\User $user, $groupcodes )
	{
		$groups = ( is_array( $groupcodes ) ? implode( ',', $groupcodes ) : $groupcodes );

		if( isset( $this->cache[$user->id][$groups] ) ) {
			return $this->cache[$user->id][$groups];
		}

		$this->cache[$user->id][$groups] = false;
		$context = $this->context->get( false );

		try {
			$site = \Aimeos\MShop\Factory::createManager( $context, 'locale/site' )->getItem( $user->siteid )->getCode();
		} catch( \Exception $e ) {
			$site = ( Route::current() ? Route::input( 'site', Input::get( 'site', 'default' ) ) : 'default' );
		}

		$context->setLocale( $this->locale->getBackend( $context, $site ) );

		foreach( array_reverse( $context->getLocale()->getSitePath() ) as $siteid )
		{
			if( (string) $user->siteid === $siteid ) {
				$this->cache[$user->id][$groups] = $this->checkGroups( $context, $user->id, $groupcodes );
			}
		}

		return $this->cache[$user->id][$groups];
	}


	/**
	 * Checks if the user with the given ID is in the specified group
	 *
	 * @param string $userid Unique user ID
	 * @param string|array $groupcodes Unique user/customer group codes that are allowed
	 * @return boolean True if user is part of the group, false if not
	 * @deprecated Use checkUserGroup() instead
	 */
	public function checkGroup( $userid, $groupcodes )
	{
		$groups = ( is_array( $groupcodes ) ? implode( ',', $groupcodes ) : $groupcodes );

		if( isset( $this->cache[$userid][$groups] ) ) {
			return $this->cache[$userid][$groups];
		}

		$site = ( Route::current() ? Route::input( 'site', Input::get( 'site', 'default' ) ) : 'default' );

		$context = $this->context->get( false );
		$context->setLocale( $this->locale->getBackend( $context, $site ) );

		return $this->cache[$userid][$groups] = $this->checkGroups( $context, $userid, $groupcodes );
	}


	/**
	 * Returns the available group codes
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context item
	 * @return string[] List of group codes
	 */
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


	/**
	 * Checks if one of the groups is associated to the given user ID
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context item
	 * @param string $userid ID of the logged in user
	 * @param string[] $groupcodes List of group codes to check against
	 * @return boolean True if the user is in one of the groups, false if not
	 */
	protected function checkGroups( \Aimeos\MShop\Context\Item\Iface $context, $userid, $groupcodes )
	{
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
}
