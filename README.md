CakePHP Environment class
================

This class is used to set the correct Configuration settings for multiple Environments.

## Requirements

* CakePHP 2.x
* PHP 5.3.0 or greater.

## Installation

* Place the `environment.php.default`, `database.php.default` and `email.php.default` to your `app/Config` folder (without the .default of course)
* Every Configuration setting for your application can be done threw this file
* Set your settings
* Load the plugin inside your bootstrap file, with also loading the bootstrap of the plugin:

```php
CakePlugin::load('CakeEnvironment', array('bootstrap' => true));
```

* You don't have to adjust `database.php` and `email.php` anymore, all the settings will be set for you, if you use all the files inside the repository.

## Documentation

By default the correct Configuration will be used according to the CAKE_ENV environment variable and has fallback to the 'default' configuration.

It is also possible to check on hostname instead of CAKE_ENV variable. You can do that by passing a type to your environment, with as value "hostname" and a hostname key with the value of your hostname.

The Database and E-mail settings has to be modified in this class and nog in de Config/database.php or Config/email.php

Every setting will be put in the Cake Configuration with Configure::write();

Every environment is a static class attribute, $default is as it is called the default configuration and must always be present.
When you have a custom Configuration for example CAKE_ENV=marcjan or hostname is "marcjan". Then the class attribute will be:

```php
public static $marcjan = array(...);
```

### Example

Imagine the following Environment Config:

```php
public static $default = array(
	'Database' => array(
		'default' => array(
			'datasource'	=> 'Database/Mysql',
			'persistent'	=> false,
			'host'			=> 'localhost',
			'login'			=> 'user',
			'password'		=> 'password',
			'database'		=> 'database_name',
			'prefix'		=> '',
		)
	)
);

public static $marcjan = array(
	'Database' => array(
		'default' => array(
			'login' => 'marc-jan',
			'password' => '****'
		)
	)
);
```

When the CAKE_ENV environment variable is set to marcjan, the Environment class checks if there is a custom config for it (`$marcjan`). If so it merges that config with the `$default` config.

If you want to check for the hostname instead of CAKE_ENV, simply add the 'type' key:

```php
public static $marcjan = array(
	'type' => 'hostname',
	'hostname' => 'marcjan',
	'Database' => array(
		'default' => array(
			'login' => 'marc-jan',
			'password' => '****'
		)
	)
);
```

## License
GNU General Public License, version 3 (GPL-3.0)
http://opensource.org/licenses/GPL-3.0