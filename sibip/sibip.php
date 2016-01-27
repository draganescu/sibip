<?php 
function run() {

    extract(load_configuration());

    if ($_GET['mailgun'] == 'endpointcall') {
        run_api();
    } else {
        run_web();
    }
}

function load_configuration() {
    if (!file_exists('../configuration/database.php')) {
        exit('configuration/database.php is required');
    } else {
        require 'configuration/database.php';
    }
}

function run_api() {
    require 'api.php';
    handle();
}

function run_web() {
    require 'web.php';
    serve();
}