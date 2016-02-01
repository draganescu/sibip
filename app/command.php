<?php
namespace command;
use \Mailgun\Mailgun;

function find() {
	$config = \configuration\load();
	$default = 'store';
	$actions = $config['available_commands'];
	$subject = \app\run('input', 'post', 'subject');
	if(!empty($subject)) {
		foreach ($actions as $akey => $command) {
			if ($command == $subject) {
				return $command;
			}
		}
	}
	return $default;
}

function call($command, $user) {
	if (!empty($user)) {
		$command_type = 'receiver';
	} else {
		$command_type = 'sender';
	}
	$path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'commands';
	$tpl_path = $path.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$command_type;
	$file = $path.DIRECTORY_SEPARATOR.$command_type.DIRECTORY_SEPARATOR.$command.'.php';
	$template = $tpl_path.DIRECTORY_SEPARATOR.$command.'.php';

	if (!file_exists($file)) {
		exit('Command ' . $command . ' not implemented for '. $command_type);
	}

	include $file;

	$function = "\\command\\".$command;

	$result = $function();

	if (!empty($result)) {
		\app\run('email', 'send', [$template, $result]);
	} else {
		exit('nothing to send');
	}
}