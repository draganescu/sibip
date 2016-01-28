<?php
namespace configuration;

function load() {
    $config = array();    
    foreach (glob(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR.'*.php') as $filename) {
        echo $filename;
        $data = include $filename;
        var_dump($data);
        if(is_array($data)) {
            $config = array_merge($config, $data);
        }
    }
    return $config;   
}

function connect() {
    extract(\configuration\load());
    var_dump(\configuration\load());
    if (empty($dsn) || empty($user) || empty($password) || empty($frozen)) {
        die("Please check the configuration\database.php file");
    }
	R::addDatabase('db',$dsn,$user,$password,$frozen);
    R::selectDatabase('db');
}