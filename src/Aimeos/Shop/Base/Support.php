<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015
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
	 * @param string $groupcode Unique user/customer group code
	 * @return boolean True if user is part of the group, false if not
	 */
	public function checkGroup( $userid, $groupcode )
	{
		$context = $this->context->get();
		$group = \Aimeos\MShop\Factory::createManager( $context, 'customer/group' )->getItem( $groupcode );
		$manager = \Aimeos\MShop\Factory::createManager( $context, 'customer/lists' );

		$search = $manager->createSearch();
		$expr = array(
			$search->compare( '==', 'customer.lists.parentid', $userid ),
			$search->compare( '==', 'customer.lists.refid', $group->getId() ),
			$search->compare( '==', 'customer.lists.domain', 'customer/group' ),
		);
		$search->setConditions( $search->combine( '&&', $expr ) );
		$search->setSlice( 0, 1 );

		return (bool) count( $manager->searchItems( $search ) );
	}
}