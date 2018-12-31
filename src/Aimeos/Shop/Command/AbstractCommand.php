<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Command
 */


namespace Aimeos\Shop\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


/**
 * Common base class for all commands
 * @package laravel
 * @subpackage Command
 */
abstract class AbstractCommand extends Command
{
	/**
	 * Returns the enabled site items which may be limited by the input arguments.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context item object
	 * @param string|array $sites Unique site codes
	 * @return \Aimeos\MShop\Locale\Item\Site\Iface[] List of site items
	 */
	protected function getSiteItems( \Aimeos\MShop\Context\Item\Iface $context, $sites )
	{
		$manager = \Aimeos\MShop::create( $context, 'locale/site' );
		$search = $manager->createSearch();

		if( is_scalar( $sites ) && $sites != '' ) {
			$sites = explode( ' ', $sites );
		}

		if( !empty( $sites ) ) {
			$search->setConditions( $search->compare( '==', 'locale.site.code', $sites ) );
		}

		return $manager->searchItems( $search );
	}
}