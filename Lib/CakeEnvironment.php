<?php
/**
 * Environment class
 *
 * @author Marc-Jan Barnhoorn <github-bradcrumb@marc-jan.nl>
 * @copyright 2013 (c), Marc-Jan Barnhoorn
 * @license http://opensource.org/licenses/GPL-3.0 GNU GENERAL PUBLIC LICENSE
 *
 * This class is used to set the correct Configuration settings for multiple Environments.
 * By default the correct Configuration will be used according to the CAKE_ENV environment variable and
 * has fallback to the 'default' configuration.
 *
 * It is also possible to check on hostname instead of CAKE_ENV variable.
 * You can do that by passing a type to your environment, with as value "hostname" and a hostname key with the value of your hostname.
 *
 * The Database and E-mail settings has to be modified in this class and nog in de Config/database.php or Config/email.php
 *
 * Every setting will be put in the Cake Configuration with Configure::write();
 *
 * Every environment is a static class attribute, $default is as it is called the default configuration and must always be present.
 * When you have a custom Configuration for example CAKE_ENV=marcjan or hostname is "marcjan". Then the class attribute will be:
 *
 * @example
 * public static $marcjan = array(...);
 */
class CakeEnvironment {

/**
 * Default configuration
 *
 * When the first keys are "Database" or "Email", these setting will be inserted in "database.php" and "email.php"
 *
 * @var array
 */
	public static $default = array(
		'type' => 'env', //Default check Environment variable CAKE_ENV
		'Database' => array(
			'default' => array(
				'datasource'	=> 'Database/Mysql',
				'persistent'	=> false,
				'host'			=> 'localhost',
				'login'			=> 'user',
				'password'		=> 'password',
				'database'		=> 'database_name',
				'prefix'		=> '',
				//'encoding'	=> 'utf8'
			),
			'test' => array(
				'datasource'	=> 'Database/Mysql',
				'persistent'	=> false,
				'host'			=> 'localhost',
				'login'			=> 'user',
				'password'		=> 'password',
				'database'		=> 'database_name',
				'prefix'		=> '',
				//'encoding'	=> 'utf8'
			)
		),
		'Email' => array(
			'default' => array(
				'transport'			=> 'Mail',
				'from'				=> 'you@localhost',
				//'charset'			=> 'utf-8',
				//'headerCharset'	=> 'utf-8'
			),
			'smtp' => array(
				'transport'			=> 'Smtp',
				'from'				=> array('site@localhost' => 'My Site'),
				'host'				=> 'localhost',
				'port'				=> 25,
				'timeout'			=> 30,
				'username'			=> 'user',
				'password'			=> 'secret',
				'client'			=> null,
				'log'				=> false,
				//'charset'			=> 'utf-8',
				//'headerCharset'	=> 'utf-8'
			)
		)
	);

/**
 * Check the CAKE_ENV environment variable or hostname and merge the settings with the default
 * and write them to the Cake Configuration
 *
 * @return void
 */
	public static function load() {
		$items = static::$default;

		$env = getenv('CAKE_ENV');

		//Strip spaces and dashes so we get a variable name
		$hostName = gethostname();

		if (!empty($env) && isset(static::${$env}) && (!isset(static::${$env}['type']) || static::${$env}['type'] == 'env')) {
			$items = array_replace_recursive($items, static::${$env});
		} elseif (!empty($hostName) && $hostEnv = self::__findEnvByHostName($hostName)) {
			$items = array_replace_recursive($items, $hostEnv);
		}

		Configure::write($items);
	}

/**
 * Search for an environment according to a hostname
 *
 * @param String $hostName A hostname to search for
 *
 * @return array The founded Environment
 */
	private static function __findEnvByHostName($hostName) {
		$envs = get_class_vars('Environment');

		foreach ($envs as $env) {
			if (isset($env['type']) && $env['type'] == 'hostname' && $env['hostname'] == $hostName) {
				return $env;
			}
		}

		return null;
	}
}
