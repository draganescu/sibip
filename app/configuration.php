<?php
namespace configuration;

function load() {
    $config = array();    
    foreach (glob('../configuration/*.php') as $filename) {
        $config = array_merge($config, require_once $filename);
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