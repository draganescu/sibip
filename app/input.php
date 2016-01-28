<?php
namespace input;

function get($name) {
	return $_GET[$name];
}


function post($name) {
	return $_POST[$name];
}


function session($name) {
	return $_SESSION[$name];
}

function keys($of) {
	if ($of == 'post') {
		return array_keys($_POST);
	}
	if ($of == 'get') {
		return array_keys($_GET);
	}
	if ($of == 'session') {
		return array_keys($_SESSION);
	}
}