<?php
namespace app;
set_error_handler('\app\remoteError');

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
            \app\log('Undefined action '.$action);
            die('Undefined action '.$action);
        }
    }

    if (function_exists($function)) {
        if (!is_array($data)) {
            $data = array($data);
        }
        return call_user_func_array($function, $data);
    } else {
        \app\log('Undefined command '.$function);
        die('Undefined command '.$function);
    }

}

function remoteError($errno, $errstr, $errfile, $errline)
{
    $message = '';
    if (!(error_reporting() & $errno)) {
        \app\log('unknown problem');
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
        $message = "<b>My ERROR</b> [$errno] $errstr<br />\n";
        $message .= "  Fatal error on line $errline in file $errfile";
        $message .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        $message .= "Aborting...<br />\n";
        \app\log($message);
        exit(1);
        break;

    case E_USER_WARNING:
        $message = "<b>My WARNING</b> [$errno] $errstr<br />\n";
        \app\log($message);
        break;

    case E_USER_NOTICE:
        $message = "<b>My NOTICE</b> [$errno] $errstr<br />\n";
        \app\log($message);
        break;

    default:
        $message = "Unknown error type: [$errno] $errstr<br />\n";
        \app\log($message);
        break;
    }
    return true;
}

function log($message, $component = "sibip", $program = "app") {
  $config = \configuration\load();
  if (!$config['log_enabled']) {
      return false;
  }
  $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
  foreach(explode("\n", $message) as $line) {
    $syslog_message = "<22>" . date('M d H:i:s ') . $program . ' ' . $component . ': ' . $line;
    socket_sendto($sock, $syslog_message, strlen($syslog_message), 0, $config['log_domain'], $config['log_port']);
  }
  socket_close($sock);
}