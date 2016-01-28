<?php
namespace app;

use '\Mailgun\Mailgun';
use '\RedBeanPHP\R';

function run($action = null, $command = null, $data = null) {

    if (is_null($action) && is_null($command) && is_null($data)) {
        if (run('input', 'get', 'api')) {
            run ('api', 'handle');
        } else {
            run('web', 'serve');
        }

        exit;
    }

    $function = "\\".$action."\\".$command;
    
    if (!function_exists($function)) {
        if (is_file('../app/'.$action.'.php')) {
            require '../app/'.$action.'.php';
        } else {
            die('Undefined action '.$action);
        }
    }

    if (function_exists($function)) {
        $function($data);
    } else {
        die('Undefined command '.$function);
    }

}