<?php
namespace configuration;

function load() {
    $config = array();
    if (!file_exists('../configuration/database.php')) {
        exit('configuration/database.php is required');
    } else {
        foreach (glob('../configuration/*.php') as $filename) {
            $config = array_merge($config, require_once $filename);
        }
    }
    return $config;
}
