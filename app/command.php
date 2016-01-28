<?php
namespace command;

function find() {
	$action = null;
	$subject = \app\run('input', 'post', 'subject');
	$tokens = explode(" ", $subject);
	foreach ($actions as $key => $action) {
		foreach ($tokens as $key => $token) {
			if ($token == $action) {
				return $action;
			}
		}
	}
	return $action;
}

function store() {
	$email = R::dispense('email');
	foreach (\app\run('input', 'keys', 'post') as $key) {
		$element = str_replace('-', '_', $key);
		$email->$element = \app\run('input', 'post', $key);
	}
	R::store($email);
}

function call($command, $user) {

}