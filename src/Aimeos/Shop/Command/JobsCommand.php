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
 * Command for executing the Aimeos job controllers
 * @package laravel
 * @subpackage Command
 */
class JobsCommand extends AbstractCommand
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'aimeos:jobs
		{jobs : One or more job controller names like "admin/job customer/email/watch"}
		{site? : Site codes to execute the jobs for like "default unittest" (none for all)}
	';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Executes the job controllers';


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$jobs = $this->argument( 'jobs' );
		$jobs = !is_array( $jobs ) ? explode( ' ', (string) $jobs ) : $jobs;

		$fcn = function( \Aimeos\MShop\Context\Item\Iface $lcontext, \Aimeos\Bootstrap $aimeos ) use ( $jobs )
		{
			$jobfcn = function( $context, $aimeos, $jobname ) {
				\Aimeos\Controller\Jobs::create( $context, $aimeos, $jobname )->run();
			};

			$process = $lcontext->getProcess();
			$site = $lcontext->getLocale()->getSiteItem()->getCode();

			foreach( $jobs as $jobname )
			{
				$this->info( sprintf( 'Executing Aimeos jobs "%s" for "%s"', $jobname, $site ), 'v' );
				$process->start( $jobfcn, [$lcontext, $aimeos, $jobname], false );
			}

			$process->wait();
		};

		$this->exec( $this->getContext(), $fcn, $this->argument( 'site' ) );
	}


	/**
	 * Returns a context object
	 *
	 * @return \Aimeos\MShop\Context\Item\Iface Context object
	 */
	protected function getContext() : \Aimeos\MShop\Context\Item\Iface
	{
		$lv = $this->getLaravel();
		$context = $lv->make( 'aimeos.context' )->get( false, 'command' );

		$langManager = \Aimeos\MShop::create( $context, 'locale/language' );
		$langids = $langManager->search( $langManager->filter( true ) )->keys()->toArray();
		$i18n = $lv->make( 'aimeos.i18n' )->get( $langids );

		$context->setEditor( 'aimeos:jobs' );
		$context->setI18n( $i18n );

		return $context;
	}
}
