<?php
namespace web;

function serve($data) {
	\app\run('configuration', 'connect');
    echo "it works, new way";
}