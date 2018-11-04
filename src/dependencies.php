<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};


$container['db'] = function($c) {

	$host = getenv('DB_HOST');

	$username = getenv('DB_USER');

	$password = getenv('DB_PASSWORD');

	$database = getenv('DB_NAME');

	$db = \ParagonIE\EasyDB\Factory::create(
		"mysql:host=$host;dbname=$database",
		$username,
		$password
	);

	return $db;

};