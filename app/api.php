<?php
namespace api;


function verify_signature() 
{
    if (empty($_POST['timestamp']) || empty($_POST['token']) || empty($_POST['signature'])) {
        exit('fuck off');
    }
    $data = $_POST['timestamp'].$_POST['token'];
    $code = hash_hmac ( 'sha256', $data, config::get('mg-api-key') );
    if ($code == $_POST['signature']) {
        return true;
    }
    die('nope');
}

function handle() {
	\api\verify_signature();
    
    $command = \command\find();
    $user = \ownership\find(); // check if from or to is a user

    if (!empty($user) && empty($command)) {
        \command\store();
    } else {
        \command\call($command, $user);
    }
    
}