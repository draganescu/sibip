<?php
namespace email;

function composeHTML($template, $data) {

	if (!is_array($data)) {
		$data = ['data'=>$data];
	}

	if (file_exists($template)) {
		ob_start();
		extract($data);
		include $template;
		$html = ob_get_contents();
		ob_end_clean();
	} else {
		$html = $data;
	}
	return $html;
}

function composeText($data) {
	$text = strip_tags($data);
	return $text;
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