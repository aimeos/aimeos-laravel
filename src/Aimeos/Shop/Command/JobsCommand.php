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
		$base = $this->getLaravel()->make( 'Aimeos\Shop\Base' );
		$aimeos = $base->getAimeos();

		$tmplPaths = $aimeos->getCustomPaths( 'controller/jobs/layouts' );
		$context = $base->getContext( $tmplPaths, false );

		$context->setI18n( $this->createI18n( $context, $aimeos->getI18nPaths() ) );
		$context->setEditor( 'aimeos:jobs' );

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
	 * Creates new translation objects
	 *
	 * @param MShop_Context_Item_Interface $context Context object
	 * @param array List of paths to the i18n files
	 * @return array List of translation objects implementing MW_Translation_Interface
	 */
	protected function createI18n( \MShop_Context_Item_Interface $context, array $i18nPaths )
	{
		$list = array();
		$translations = \Config::get( 'shop::i18n' );
		$langManager = \MShop_Locale_Manager_Factory::createManager( $context )->getSubManager( 'language' );

		foreach( $langManager->searchItems( $langManager->createSearch( true ) ) as $id => $langItem )
		{
			$i18n = new \MW_Translation_Zend2( $i18nPaths, 'gettext', $id, array( 'disableNotices' => true ) );

			if( isset( $translations[$id] ) ) {
				$i18n = new \MW_Translation_Decorator_Memory( $i18n, $translations[$id] );
			}

			$list[$id] = $i18n;
		}

		return $list;
	}


	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['jobs', InputArgument::REQUIRED, 'One or more job controller names like "admin/job customer/email/watch"'],
			['site', InputArgument::OPTIONAL, 'Site codes to execute the jobs for like "default unittest" (none for all)'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
		];
	}
}
