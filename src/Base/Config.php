<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2023
 */

namespace Aimeos\Shop\Base;


/**
 * Service providing the config object
 */
class Config
{
	/**
	 * @var \Aimeos\Shop\Base\Config[]
	 */
	private $objects = [];

	/**
	 * @var \Aimeos\Shop\Base\Aimeos
	 */
	private $aimeos;

	/**
	 * @var \Illuminate\Contracts\Config\Repository
	 */
	private $config;


	/**
	 * Initializes the object
	 *
	 * @param \Illuminate\Contracts\Config\Repository $config Configuration object
	 * @param \Aimeos\Shop\Base\Aimeos $aimeos Aimeos object
	 */
	public function __construct( \Illuminate\Contracts\Config\Repository $config, \Aimeos\Shop\Base\Aimeos $aimeos )
	{
		$this->aimeos = $aimeos;
		$this->config = $config;
	}


	/**
	 * Creates a new configuration object.
	 *
	 * @param string $type Configuration type ("frontend" or "backend")
	 * @return \Aimeos\Base\Config\Iface Configuration object
	 */
	public function get( string $type = 'frontend' ) : \Aimeos\Base\Config\Iface
	{
		if( !isset( $this->objects[$type] ) )
		{
			$configPaths = $this->aimeos->get()->getConfigPaths();
			$cfgfile = dirname( dirname( __DIR__ ) ) . '/config/default.php';

			$config = new \Aimeos\Base\Config\PHPArray( require $cfgfile, $configPaths );

			if( $this->config->get( 'shop.apc_enabled', false ) == true ) {
				$config = new \Aimeos\Base\Config\Decorator\APC( $config, $this->config->get( 'shop.apc_prefix', 'laravel:' ) );
			}

			$config = new \Aimeos\Base\Config\Decorator\Memory( $config, $this->config->get( 'shop' ) );

			if( ( $conf = $this->config->get( 'shop.' . $type, array() ) ) !== array() ) {
				$config = new \Aimeos\Base\Config\Decorator\Memory( $config, $conf );
			}

			$this->objects[$type] = $config;
		}

		return $this->objects[$type];
	}
}
