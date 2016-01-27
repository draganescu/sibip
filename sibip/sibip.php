<?php 
function run() {
    if ($_GET['mailgun'] == 'endpointcall') {
        run_api();
    } else {
        run_web();
    }
}

function load_configuration() {
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

function run_api() {
    require 'api.php';
    handle(load_configuration());
}

function run_web() {
    require 'web.php';
    serve(load_configuration());
}