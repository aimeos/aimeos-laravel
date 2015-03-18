<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015
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
	/**
	 * @var \Illuminate\Contracts\Config\Repository
	 */
	private $config;

	/**
	 * @var \Arcavias
	 */
	private $object;


	/**
	 * Initializes the object
	 *
	 * @param \Illuminate\Contracts\Config\Repository $config Configuration object
	 */
	public function __construct( \Illuminate\Contracts\Config\Repository $config )
	{
		$this->config = $config;
	}


	/**
	 * Returns the Arcavias object.
	 *
	 * @return \Arcavias Arcavias object
	 */
	public function get()
	{
		if( $this->object === null )
		{
			$extDirs = (array) $this->config->get( 'shop::config.extdir', array() );
			$this->object = new \Arcavias( $extDirs, false );
		}

		return $this->object;
	}
}