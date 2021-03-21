<?php

require './routes.php';

function dd()
{
	echo '<pre>';
	array_map(function ($x) {
		print_r($x);
	}, func_get_args());
		die;
}


define('PROJECT_URL', 'http://localhost:8000');

define('ASSETS_ROOT', PROJECT_URL. DIRECTORY_SEPARATOR . 'assets');

define('VIEW_ROOT', PROJECT_ROOT . DIRECTORY_SEPARATOR . 'app'. DIRECTORY_SEPARATOR . 'Views');

define('TESTS_FILES', PROJECT_ROOT . DIRECTORY_SEPARATOR . 'tests-files');
