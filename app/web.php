<?php
namespace web;

function serve() {
	$config = run('configuration', 'load');
    echo "it works, new way";
}