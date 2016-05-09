<?php
namespace ownership;
use \RedBeanPHP\R;

function find($data) {
    \app\log('finding');
	$sender = \app\run('input', 'post', 'sender');
    $user  = R::findOne( 'user', ' email = ?', [ $sender ]);
    if (empty($user)) {
        \app\log('not found');
    	return false;
    }
    \app\log('found');
	return $user;
}

function check($data) {
	$recipient = \app\run('input', 'post', 'recipient');
    $user  = R::findOne( 'user', ' email = ?', [ $recipient ]);
    if (empty($user)) {
    	return false;
    }
	return $user;
}