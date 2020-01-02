<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Base
 */

namespace Aimeos\Shop\Base;


/**
 * Service providing the internationalization objects
 *
 * @package laravel
 * @subpackage Base
 */
class I18n
{
	/**
	 * @var \Aimeos\Shop\Base\Aimeos
	 */
	private $aimeos;

	/**
	 * @var \Illuminate\Contracts\Config\Repository
	 */
	private $config;

	/**
	 * @var array
	 */
	private $i18n = [];


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
	 * Creates new translation objects.
	 *
	 * @param array $languageIds List of two letter ISO language IDs
	 * @return \Aimeos\MW\Translation\Iface[] List of translation objects
	 */
	public function get( array $languageIds ) : array
	{
		$i18nPaths = $this->aimeos->get()->getI18nPaths();

		foreach( $languageIds as $langid )
		{
			if( !isset( $this->i18n[$langid] ) )
			{
				$i18n = new \Aimeos\MW\Translation\Gettext( $i18nPaths, $langid );

				if( $this->config->get( 'shop.apc_enabled', false ) == true ) {
					$i18n = new \Aimeos\MW\Translation\Decorator\APC( $i18n, $this->config->get( 'shop.apc_prefix', 'laravel:' ) );
				}

				if( $this->config->has( 'shop.i18n.' . $langid ) ) {
					$i18n = new \Aimeos\MW\Translation\Decorator\Memory( $i18n, $this->config->get( 'shop.i18n.' . $langid ) );
				}

				$this->i18n[$langid] = $i18n;
			}
		}

		return $this->i18n;
	}
}