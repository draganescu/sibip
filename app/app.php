<?php
namespace app;

function run($action = null, $command = null, $data = null) {

    if (is_null($action) && is_null($command) && is_null($data)) {
        if (run('input', 'get', 'api')) {
            run ('api', 'handle');
        } else {
            run('web', 'serve');
        }
    }
    
    if (!function_exists("\$action\$command")) {
        if (is_file('../app/'.$action.'.php')) {
            require '../app/'.$action.'.php';
        } else {
            die('Undefined action '.$action);
        }
    }

    if (function_exists("\$action\$command")) {
        "\\".$action."\\".$command($data);
    } else {
        die('Undefined command '.$command);
    }

}