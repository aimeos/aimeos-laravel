<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Command
 */


namespace Aimeos\Shop\Command;


/**
 * Command for clearing the content cache
 * @package laravel
 * @subpackage Command
 */
class ClearCommand extends AbstractCommand
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'aimeos:clear
		{site? : Site codes to clear the Aimeos content cache for like "default unittest" (none for all)}
	';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Clears the content cache';


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$context = $this->getLaravel()->make( 'Aimeos\Shop\Base\Context' )->get( false, 'command' );
		$context->setEditor( 'aimeos:clear' );

		$fcn = function( \Aimeos\MShop\Context\Item\Iface $lcontext )
		{
			$cache = new \Aimeos\MAdmin\Cache\Proxy\Standard( $lcontext );
			$lcontext->setCache( $cache );

			$this->info( sprintf( 'Clearing Aimeos cache for site "%1$s"', $lcontext->getLocale()->getSiteItem()->getCode() ), 'v' );

			\Aimeos\MAdmin::create( $lcontext, 'cache' )->getCache()->clear();
		};

		$this->exec( $context, $fcn, $this->argument( 'site' ) );
	}
}
