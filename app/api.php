<?php
namespace api;

function handle($data) {
    \api\verify_signature();
    \app\run('configuration', 'connect');
    
    $command = \app\run('command', 'find');
    $user = \app\run('ownership', 'find'); // check if from or to is a user
    if (!empty($user) && empty($command)) {
        $command = 'store';
    }
    \app\run('command','call', array($command, $user));
}

function verify_signature() 
{
    $config = \app\run('configuration', 'load');
    $timestamp = \app\run('input', 'post', 'timestamp');
    $token = \app\run('input', 'post', 'token');
    $signature = \app\run('input', 'post', 'signature');
    if (empty($timestamp) || empty($token) || empty($signature)) {
        exit('incomplete');
    }
    $data = $timestamp.$token;
    $code = hash_hmac ( 'sha256', $data, $config['key'] );
    if ($code == $signature) {
        return true;
    }
    exit('nope');
}