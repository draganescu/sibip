<?php
namespace app;

function run($action = null, $command = null, $data = null) {

    if (is_null($action) && is_null($command) && is_null($data)) {
        if (run('input', 'get', 'action') == 'api') {
            return run ('api', 'handle');
        } else {
            return run('web', 'serve');
        }
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
        if (!is_array($data)) {
            $data = array($data);
        }
        return call_user_func_array($function, $data);
    } else {
        die('Undefined command '.$function);
    }

}