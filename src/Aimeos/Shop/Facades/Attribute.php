<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2019
 * @package laravel
 * @subpackage Facades
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
		return \Aimeos\Controller\Frontend::create( app( 'aimeos.context' )->get(), 'attribute' );
	}
}
