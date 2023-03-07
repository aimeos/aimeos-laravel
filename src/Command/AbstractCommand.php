<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2023
 */


namespace Aimeos\Shop\Command;

use Illuminate\Console\Command;


/**
 * Common base class for all commands
 */
abstract class AbstractCommand extends Command
{
	/**
	 * Executes the function for all given sites
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object
	 * @param \Closure $fcn Function to execute
	 * @param array|string|null $sites Site codes
	 */
	protected function exec( \Aimeos\MShop\ContextIface $context, \Closure $fcn, $sites )
	{
		$process = $context->process();
		$aimeos = $this->getLaravel()->make( 'aimeos' )->get();

		$siteManager = \Aimeos\MShop::create( $context, 'locale/site' );
		$localeManager = \Aimeos\MShop::create( $context, 'locale' );
		$filter = $siteManager->filter();
		$start = 0;

		if( !empty( $sites ) ) {
			$filter->add( ['locale.site.code' => !is_array( $sites ) ? explode( ' ', (string) $sites ) : $sites] );
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

				$tmplPaths = $aimeos->getTemplatePaths( 'controller/jobs/templates', $siteItem->getTheme() );
				$view = $this->getLaravel()->make( 'aimeos.view' )->create( $lcontext, $tmplPaths );
				$lcontext->setView( $view );

				$config = $lcontext->config();
				$config->apply( $siteItem->getConfig() );

				$process->start( $fcn, [$lcontext, $aimeos], false );
			}

			$count = count( $siteItems );
			$start += $count;
		}
		while( $count === $filter->getLimit() );

		$process->wait();
	}
}