<?php
namespace web;

function serve($data) {
	\app\run('configuration', 'connect');
    
    render();
}

function render() {
	$path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'templates';
	$layout = $path.DIRECTORY_SEPARATOR.'layout.phtml';   
	
	include $layout;  
}