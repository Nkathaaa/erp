<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$autoload['packages'] = array();

$autoload['libraries'] = array('database', 'session', 'form_validation', 'Rememberme', 'user_agent', );

//$autoload['libraries'] = array('database', 'session', 'form_validation', 'Rememberme', 'user_agent', 'PHPMailer', 'Excel','PHPExcel');
$autoload['helper'] = array('cookie', 'url', 'file');

$autoload['config'] = array('Rememberme');

$autoload['language'] = array();

$autoload['model'] = array('Admin_model');

/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| These classes are located in system/libraries/ or in your
| application/libraries/ directory, but are also placed inside their
| own subdirectory and they extend the CI_Driver_Library class. They
| offer multiple interchangeable driver options.
|
| Prototype:
|
|	$autoload['drivers'] = array('cache');
|
| You can also supply an alternative property name to be assigned in
| the controller:
|
|	$autoload['drivers'] = array('cache' => 'cch');
|
*/
$autoload['drivers'] = array();