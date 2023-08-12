<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019-2023
 */


namespace Aimeos\Shop\Facades;


/**
 * Returns the subscription frontend controller
 */
class Subscription extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new subscription frontend controller object
	 *
	 * @return \Aimeos\Controller\Frontend\Subscription\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return 'aimeos.frontend.subscription';
	}
}
