<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019-2023
 */


namespace Aimeos\Shop\Facades;


/**
 * Returns the attribute frontend controller
 */
class Attribute extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new attribute frontend controller object
	 *
	 * @return \Aimeos\Controller\Frontend\Attribute\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return 'aimeos.frontend.attribute';
	}
}
