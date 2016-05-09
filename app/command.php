<?php
namespace command;
use \Mailgun\Mailgun;

function find() {
	$config = \configuration\load();
	$default = 'store';
	$actions = $config['available_commands'];
	$subject = \app\run('input', 'post', 'subject');
	if(!empty($subject)) {
		foreach ($actions as $command) {
			if ($command == $subject) {
				return $command;
			}
		}
	}
	return $default;
}

function call($command, $user) {
	\app\log('calling func');
	if (!empty($user)) {
		$command_type = 'receiver';
	} else {
		$command_type = 'sender';
	}
	$path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'commands';
	$tpl_path = $path.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$command_type;
	$file = $path.DIRECTORY_SEPARATOR.$command_type.DIRECTORY_SEPARATOR.$command.'.php';
	$template = $tpl_path.DIRECTORY_SEPARATOR.$command.'.phtml';

	\app\log($file);

	if (!file_exists($file)) {
		\app\log('Command ' . $command . ' not implemented for '. $command_type);
		exit('Command ' . $command . ' not implemented for '. $command_type);
	}

	include $file;
	\app\log($file);

	$function = "\\command\\".$command;

	$result = $function();
	\app\log($result);

	if (!empty($result)) {
		\app\log('sending');
		\app\run('email', 'send', array($result, $template));
	} else {
		\app\log('nothing to send');
		exit('nothing to send');
	}
}