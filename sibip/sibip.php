<?php 

function run($action = null, $command = null, $data = null) {

    if (is_null($action) && is_null($command) && is_null($data)) {
        if (run('input', 'get', 'api')) {
            run ('api', 'handle');
        } else {
            run('web', 'serve');
        }
    }

    if (is_file($action.'.php')) {
        require $action.'.php';
    } else {
        die('Undefined file '.$action);
    }

    if (function_exists($command)) {
        $command($data);
    } else {
        die('Undefined command '.$command);
    }

}