<?php

private function verify_signature() 
{
    if (empty($_POST['timestamp']) || empty($_POST['token']) || empty($_POST['signature'])) {
        exit('fuck off');
    }
    $data = $_POST['timestamp'].$_POST['token'];
    $code = hash_hmac ( 'sha256', $data, config::get('mg-api-key') );
    if ($code == $_POST['signature']) {
        return true;
    }
    die('fuck off');
}

function handle() {
	
}