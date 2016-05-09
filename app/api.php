<?php
namespace api;

function handle($data) {
    \api\verify_signature();
    \app\run('configuration', 'connect');
    
    $command = \app\run('command', 'find');
    \app\log($command);
    $user = \app\run('ownership', 'find');
    if (empty($user)) {
        $recipient = \app\run('ownership', 'check');
        if(empty($recipient)) {
            \app\log('Unknown user');
            exit('Unknown user');
        }
    }
    \app\log('calling');
    \app\run('command','call', array($command, $user));
}

function verify_signature() 
{
    $config = \app\run('configuration', 'load');
    $timestamp = \app\run('input', 'post', 'timestamp');
    $token = \app\run('input', 'post', 'token');
    $signature = \app\run('input', 'post', 'signature');
    if (empty($timestamp) || empty($token) || empty($signature)) {
        \app\log('incomplete');
        exit('incomplete');
    }
    $data = $timestamp.$token;
    $code = hash_hmac ( 'sha256', $data, $config['key'] );
    if ($code == $signature) {
        return true;
    }
    \app\log('nope');
    exit('nope');
}