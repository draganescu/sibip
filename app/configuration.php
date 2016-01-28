<?php
namespace configuration;

function load() {
    $config = array(); 
    $path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR.'*.php';   
    foreach (glob($path) as $filename) {
        $data = include $filename;
        if(is_array($data)) {
            $config = array_merge($config, $data);
        }
    }
    return $config;   
}

function connect() {
    $config = \configuration\load();
    if (empty($config['dsn']) || empty($config['user']) || empty($config['password'])) {
        die("Please check the configuration\database.php file");
    }
	R::addDatabase('db',$config['dsn'],$config['user'],$config['password'],$config['frozen']);
    R::selectDatabase('db');
}