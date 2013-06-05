CakePHP Environment class
================

This class is used to set the correct Configuration settings for multiple Environments.

## Requirements

* CakePHP 2.x
* PHP 5.3.0 or greater.

## Installation

* Place the `environment.php`, `database.php` and `email.php` to your `app/Config` folder
* Every Configuration setting for your application can be done threw this file
* Set your settings
* require the file in your bootstrap:

```php
/**
 * Include the Environment class and load all the settings of the environment
 */
require_once dirname(__FILE__) . '/environment.php';
Environment::load();
```

* You don't have to adjust `database.php` and `email.php` anymore, all the settings will be set for you, if you use all the files inside the repository.

## Documentation

The correct Configuration will be used according to the CAKE_ENV environment variable and has fallback to the 'default' configuration.

The Database and E-mail settings has to be modified in this class and nog in de Config/database.php or Config/email.php

Every setting will be put in the Cake Configuration with Configure::write();

Every environment is a static class attribute, $default is as it is called the default configuration and must always be present.
When you have a custom Configuration for example CAKE_ENV=marcjan. Then the class attribute will be:

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

## License
GNU General Public License, version 3 (GPL-3.0)
http://opensource.org/licenses/GPL-3.0