<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Command
 */


namespace Aimeos\Shop\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


/**
 * Command for initializing or updating the Aimeos database tables
 * @package laravel
 * @subpackage Command
 */
class SetupCommand extends AbstractCommand
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'aimeos:setup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Initialize or update the Aimeos database tables';


	/**
	 * Loads the requested setup task class
	 *
	 * @param string $classname Name of the setup task class
	 * @return boolean True if class is found, false if not
	 */
	public static function autoload( $classname )
	{
		if( strncmp( $classname, 'Aimeos\\MW\\Setup\\Task\\', 21 ) === 0 )
		{
			$fileName = substr( $classname, 21 ) . '.php';
			$paths = explode( PATH_SEPARATOR, get_include_path() );

			foreach( $paths as $path )
			{
				$file = $path . DIRECTORY_SEPARATOR . $fileName;

				if( file_exists( $file ) === true && ( include_once $file ) !== false ) {
					return true;
				}
			}
		}

		return false;
	}


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$ctx = $this->getLaravel()->make( '\Aimeos\Shop\Base\Context' )->get( false );
		$ctx->setEditor( 'aimeos:setup' );

		$config = $ctx->getConfig();
		$site = $this->argument( 'site' );
		$template = $this->argument( 'tplsite' );

		$config->set( 'setup/site', $site );
		$dbconfig = $this->getDbConfig( $config );
		$this->setOptions( $config );

		$taskPaths = $this->getLaravel()->make( '\Aimeos\Shop\Base\Aimeos' )->get()->getSetupPaths( $template );

		$includePaths = $taskPaths;
		$includePaths[] = get_include_path();

		if( set_include_path( implode( PATH_SEPARATOR, $includePaths ) ) === false ) {
			throw new \Exception( 'Unable to extend include path' );
		}

		spl_autoload_register( '\Aimeos\Shop\Command\SetupCommand::autoload', true );

		$manager = new \Aimeos\MW\Setup\Manager\Multiple( $ctx->getDatabaseManager(), $dbconfig, $taskPaths, $ctx );

		$this->info( sprintf( 'Initializing or updating the Aimeos database tables for site "%1$s"', $site ) );

		if( ( $task = $this->option( 'task' ) ) && is_array( $task ) ) {
			$task = reset( $task );
		}

		switch( $this->option( 'action' ) )
		{
			case 'migrate':
				$manager->migrate( $task );
				break;
			case 'rollback':
				$manager->rollback( $task );
				break;
			case 'clean':
				$manager->clean( $task );
				break;
			default:
				throw new \Exception( sprintf( 'Invalid setup action "%1$s"', $this->option( 'action' ) ) );
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
			array( 'site', InputArgument::OPTIONAL, 'Site for updating database entries', 'default' ),
			array( 'tplsite', InputArgument::OPTIONAL, 'Site used as template for creating the new one', 'default' ),
		);
	}


	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array( 'option', null, InputOption::VALUE_REQUIRED, 'Setup configuration, name and value are separated by ":" like "setup/default/demo:1"', array() ),
			array( 'action', null, InputOption::VALUE_REQUIRED, 'Action name that should be executed, i.e. "migrate", "rollback", "clean"', 'migrate' ),
			array( 'task', null, InputOption::VALUE_REQUIRED, 'Name of the setup task that should be executed', null ),
		);
	}


	/**
	 * Returns the database configuration from the config object.
	 *
	 * @param \Aimeos\MW\Config\Iface $conf Config object
	 * @return array Multi-dimensional associative list of database configuration parameters
	 */
	protected function getDbConfig( \Aimeos\MW\Config\Iface $conf )
	{
		$dbconfig = $conf->get( 'resource', array() );

		foreach( $dbconfig as $rname => $dbconf )
		{
			if( strncmp( $rname, 'db', 2 ) !== 0 ) {
				unset( $dbconfig[$rname] );
			}
		}

		return $dbconfig;
	}


	/**
	 * Extracts the configuration options from the input object and updates the configuration values in the config object.
	 *
	 * @param \Aimeos\MW\Config\Iface $conf Configuration object
	 * @param array Associative list of database configurations
	 * @throws \RuntimeException If the format of the options is invalid
	 */
	protected function setOptions( \Aimeos\MW\Config\Iface $conf )
	{
		foreach( (array) $this->option( 'option' ) as $option )
		{
			list( $name, $value ) = explode( ':', $option );
			$conf->set( $name, $value );
		}
	}
}
