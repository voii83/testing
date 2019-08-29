<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));

spl_autoload_register( function($classname){
    require_once( ROOT. '/components/' .  $classname . '.php');
} );

$router = new Router();
$router->run();