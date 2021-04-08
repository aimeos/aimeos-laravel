<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Command
 */


namespace Aimeos\Shop\Command;

use Illuminate\Console\Command;


/**
 * Common base class for all commands
 * @package laravel
 * @subpackage Command
 */
abstract class AbstractCommand extends Command
{
	protected function exec( \Aimeos\MShop\Context\Item\Iface $context, \Closure $fcn, ?string $sites )
	{
		$process = $context->getProcess();
		$aimeos = $this->getLaravel()->make( 'aimeos' )->get();

		$siteManager = \Aimeos\MShop::create( $context, 'locale/site' );
		$localeManager = \Aimeos\MShop::create( $context, 'locale' );
		$filter = $siteManager->filter();
		$start = 0;

		if( $sites ) {
			$filter->add( ['locale.site.code' => explode( ' ', $sites )] );
		}

		do
		{
			$siteItems = $siteManager->search( $filter->slice( $start ) );

			foreach( $siteItems as $siteItem )
			{
				\Aimeos\MShop::cache( true );
				\Aimeos\MAdmin::cache( true );

				$localeItem = $localeManager->bootstrap( $siteItem->getCode(), '', '', false );
				$localeItem->setLanguageId( null );
				$localeItem->setCurrencyId( null );

				$lcontext = clone $context;
				$lcontext->setLocale( $localeItem );
				$config = $lcontext->getConfig();

				foreach( $siteItem->getConfig() as $key => $value ) {
					$config->set( $key, $value );
				}

				$process->start( $fcn, [$lcontext, $aimeos], false );
			}

			$count = count( $siteItems );
			$start += $count;
		}
		while( $count === $filter->getLimit() );

		$process->wait();
	}
}