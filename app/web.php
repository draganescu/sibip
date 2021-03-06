<?php
namespace web;
use \RedBeanPHP\R;
use \Mailgun\Mailgun;

function serve($data) {
	\app\run('configuration', 'connect');
    $action = \app\run('input', 'get', 'page');
    if (empty($action)) {
    	$action = 'index';
    }
    $view = view($action);
    render($view);
}

function view($action) {
	$path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'templates';
	$view = $path.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.$action.'.phtml';

	if (!file_exists($view)) {
		$view = $path.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'404.phtml';
	} else {
		$function = "\\web\\".$action.'_page';
		extract($function());
	}

	ob_start();
	include $view;
	return ob_get_clean();
}

function render($view) {
	$path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'templates';
	$layout = $path.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'layout.phtml';
	include $layout;
}

function index_page() {
	$path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'templates';
	$tpl_path = $path.DIRECTORY_SEPARATOR.'email'.DIRECTORY_SEPARATOR;
	$config = \configuration\load();

	$registration = \app\run('input', 'post', 'email');
	if ($registration) {
		$string = \app\run('input', 'generateRandomString', 10);
		$subject = '#'.$string.'#';
		$result = ['code' => '#'.$string.'#'];
		$template  = $tpl_path.'register.phtml';
		\app\run('email', 'send', [$result, $template, $subject]);
	}

	return array(
		'today' => date("Y-m-d")
	);
}