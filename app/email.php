<?php
namespace email;

function composeHTML($command, $command_type, $data) {
	return $data;
}

function composeText($data) {
	return strip_tags($data);
}

function send($result, $command, $command_type) {
	$config = \configuration\load();

	$mg = new Mailgun($config['key']);
	$domain = $config['domain'];

	# Now, compose and send your message.
	$mg->sendMessage($domain, 
			array('from'    => 'sibip@code.andreidraganescu.info', 
	                'to'      => \app\run('input', 'post', 'sender'),
                    'subject' => 'sibip#status', 
                    'text'    => \email\composeText($result),
                    'html'    => \email\composeHTML($command, $command_type, $result),
            ));
}