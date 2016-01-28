<?php
namespace api;


function verify_signature() 
{
    $config = \configuration\load();
    $timestamp = \app\run('input', 'post', 'timestamp');
    $token = \app\run('input', 'post', 'token');
    $signaure = \app\run('input', 'post', 'signature');
    if (empty($timestamp) || empty($token) || empty($signature)) {
        exit('nope');
    }
    $data = $timestamp.$token;
    $code = hash_hmac ( 'sha256', $data, $config['key'] );
    if ($code == $signature) {
        return true;
    }
    exit('nope');
}

function handle($data) {
	// \api\verify_signature();
    
    $command = \app\run('command', 'find');
    $user = \app\run('ownership', 'find'); // check if from or to is a user

    if (!empty($user) && empty($command)) {
        \command\store();
    } else {
        \command\call($command, $user);
    }
    
}