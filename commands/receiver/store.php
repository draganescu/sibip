<?php
namespace command;
use \RedBeanPHP\R;

function store() {
	$email = R::dispense('email');
	foreach (\app\run('input', 'keys', 'post') as $key) {
		$element = str_replace('-', '_', $key);
		$email->$element = \app\run('input', 'post', $key);
	}
	R::store($email);
	return null;
}