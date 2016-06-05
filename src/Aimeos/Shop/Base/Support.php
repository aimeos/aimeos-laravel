<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


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
	 * Initializes the object
	 *
	 * @param \Aimeos\Shop\Base\Context $context Context object
	 */
	public function __construct( \Aimeos\Shop\Base\Context $context )
	{
		$this->context = $context;
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
		$groupItems = $this->getGroups( (array) $groupcodes );
		$manager = \Aimeos\MShop\Factory::createManager( $this->context->get(), 'customer/lists' );

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


	/**
	 * Returns the groups items for the given codes
	 *
	 * @param array $codes List of group codes
	 * @return array Associative list of group IDs as keys and \Aimeos\MShop\Customer\Item\Group\Iface as values
	 */
	protected function getGroups( array $codes )
	{
		$manager = \Aimeos\MShop\Factory::createManager( $this->context->get(), 'customer/group' );

		$search = $manager->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.group.code', $codes ) );

		return $manager->searchItems( $search );
	}
}