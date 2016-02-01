<?php
namespace email;

function composeHTML($template, $data) {
	return $data;
}

function composeText($data) {
	return strip_tags($data);
}

function send($result, $template, $subject = 'sibip') {
	$config = \configuration\load();

	$mg = new Mailgun($config['key']);
	$domain = $config['domain'];

	# Now, compose and send your message.
	$mg->sendMessage($domain, 
			array('from'    => 'sibip@code.andreidraganescu.info', 
	                'to'      => \app\run('input', 'post', 'sender'),
                    'subject' => $subject, 
                    'text'    => \email\composeText($result),
                    'html'    => \email\composeHTML($template, $result),
            ));
}