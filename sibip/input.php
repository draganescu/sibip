<?php

function get($name) {
	return $_GET[$name];
}


function post($name) {
	return $_POST[$name];
}


function session($name) {
	return $_SESSION[$name];
}