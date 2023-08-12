<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019-2023
 */


namespace Aimeos\Shop\Facades;


/**
 * Returns the basket frontend controller
 */
class Basket extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new basket frontend controller object
	 *
	 * @return \Aimeos\Controller\Frontend\Basket\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return 'aimeos.frontend.basket';
	}
}
