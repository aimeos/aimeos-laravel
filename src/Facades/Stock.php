<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019-2023
 */


namespace Aimeos\Shop\Facades;


/**
 * Returns the stock frontend controller
 */
class Stock extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new stock frontend controller object
	 *
	 * @return \Aimeos\Controller\Frontend\Stock\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return 'aimeos.frontend.stock';
	}
}
