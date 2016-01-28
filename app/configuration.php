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
    extract(\configuration\load());
    if (empty($dsn) || empty($user) || empty($password) || empty($frozen)) {
        die("Please check the configuration\database.php file");
    }
	R::addDatabase('db',$dsn,$user,$password,$frozen);
    R::selectDatabase('db');
}