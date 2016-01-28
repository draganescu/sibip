<?php
namespace configuration;

$config = null;

function load($data) {
    if (!empty(\configuration\$config)) {
        return \configuration\$config;
    }
    \configuration\$config = array();
    if (!file_exists('../configuration/database.php')) {
        exit('configuration/database.php is required');
    } else {
        foreach (glob('../configuration/*.php') as $filename) {
            \configuration\$config = array_merge(\configuration\$config, require_once $filename);
        }
    }
    return \configuration\$config;
}

function connect($data) {
    extract(\configuration\load());
	R::addDatabase('db',$dsn,$user,$password,$frozen);
    R::selectDatabase('db');
}