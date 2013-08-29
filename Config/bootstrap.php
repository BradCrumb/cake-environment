<?php
App::uses('CakeEnvironment', 'CakeEnvironment.Lib');

/**
 * Include the Environment config and load all the settings of the environment
 */
config('environment');
Environment::load();