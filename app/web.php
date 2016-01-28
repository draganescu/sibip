<?php
namespace web;

function serve() {
	$config = \app\run('configuration', 'load');
    echo "it works, new way";
}