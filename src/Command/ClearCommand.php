<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2023
 */


namespace Aimeos\Shop\Command;


/**
 * Command for clearing the content cache
 */
class ClearCommand extends AbstractCommand
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'aimeos:clear';

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
		$this->info( 'Clearing Aimeos cache', 'v' );

		$context = $this->getLaravel()->make( 'aimeos.context' )->get( false, 'command' );
		$context->setEditor( 'aimeos:clear' );

		\Aimeos\MAdmin::create( $context, 'cache' )->getCache()->clear();
	}
}
