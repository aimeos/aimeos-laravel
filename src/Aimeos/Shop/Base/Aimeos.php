<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2014
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


/**
 * Service providing the Aimeos object
 *
 * @package laravel
 * @subpackage Base
 */
class Aimeos
{
	private $object;


	/**
	 * Returns the Arcavias object.
	 *
	 * @return \Arcavias Arcavias object
	 */
	public function get()
	{
		if( $this->object === null )
		{
			$extDirs = (array) \Config::get( 'shop::extdir', array() );
			$this->object = new \Arcavias( $extDirs, false );
		}

		return $this->object;
	}
}