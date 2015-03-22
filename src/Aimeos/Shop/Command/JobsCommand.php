<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015
 */


namespace Aimeos\Shop\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class JobsCommand extends AbstractCommand
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'aimeos:jobs';

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
	public function fire()
	{
		$aimeos = $this->getLaravel()->make( '\Aimeos\Shop\Base\Aimeos' )->get();
		$context = $this->getContext();

		$jobs = explode( ' ', $this->argument( 'jobs' ) );
		$localeManager = \MShop_Locale_Manager_Factory::createManager( $context );

		foreach( $this->getSiteItems( $context, $this->argument( 'site' ) ) as $siteItem )
		{
			$localeItem = $localeManager->bootstrap( $siteItem->getCode(), 'en', '', false );
			$context->setLocale( $localeItem );

			$this->info( sprintf( 'Executing the Aimeos jobs for "%s"', $siteItem->getCode() ) );

			foreach( $jobs as $jobname ) {
				\Controller_Jobs_Factory::createController( $context, $aimeos, $jobname )->run();
			}
		}
	}


	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array( 'jobs', InputArgument::REQUIRED, 'One or more job controller names like "admin/job customer/email/watch"' ),
			array( 'site', InputArgument::OPTIONAL, 'Site codes to execute the jobs for like "default unittest" (none for all)' ),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}


	/**
	 * Returns a context object
	 *
	 * @return \MShop_Context_Item_Default Context object
	 */
	protected function getContext()
	{
		$lv = $this->getLaravel();

		$tmplPaths = $lv->make( '\Aimeos\Shop\Base\Aimeos' )->get()->getCustomPaths( 'controller/jobs/layouts' );
		$context = $lv->make( '\Aimeos\Shop\Base\Context' )->get( $tmplPaths, false );
		$view = $lv->make( '\Aimeos\Shop\Base\View' )->create( $context->getConfig(), $tmplPaths );

		$langManager = \MShop_Locale_Manager_Factory::createManager( $context )->getSubManager( 'language' );
		$langids = array_keys( $langManager->searchItems( $langManager->createSearch( true ) ) );
		$i18n = $lv->make( '\Aimeos\Shop\Base\I18n' )->get( $langids );

		$context->setEditor( 'aimeos:jobs' );
		$context->setView( $view );
		$context->setI18n( $i18n );

		return $context;
	}
}
