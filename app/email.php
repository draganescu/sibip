<?php
namespace email;

function composeHTML($template, $data) {
	if (!is_array($data)) {
		$data = array('data'=>$data);
	}

	if (file_exists($template)) {
		ob_start();
		extract($data);
		include $template;
		$html = ob_get_contents();
		ob_end_clean();
	} else {
		$html = $data['data'];
	}
	return $html;
}

function composeText($data) {
	$text = strip_tags($data);
	return $text;
}

function send($result, $template, $subject = 'sibip') {
	\app\log('sending prep');
	$config = \configuration\load();

	$mailgun = new \Mailgun\Mailgun($config['key']);
	$domain = $config['domain'];

	\app\log('composed');
	$mailgun->sendMessage($domain, 
			array('from'    => 'sibip@code.andreidraganescu.info', 
	                'to'      => \app\run('input', 'post', 'sender'),
                    'subject' => $subject, 
                    'text'    => \email\composeText($result),
                    'html'    => \email\composeHTML($template, $result),
            )
	);
}