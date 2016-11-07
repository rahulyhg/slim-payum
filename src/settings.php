<?php
return [
	'settings' => [
		'displayErrorDetails' => true,
		'addContentLengthHeader' => false, // Allow the web server to send the content-length header
		// Renderer settings
		'renderer' => [
			'folders' => [
				'theme' => APP_PATH . '/themes/app-main',
			],
			'ext' => 'twig',
		],

		// Monolog settings
		'logger' => [
			'name' => 'slim-payum',
			'path' => APP_PATH . '/logs/app.log',
		],
		'session' => [
			'namespace' => 'slimdash__',
		],
		'db' => [
			'driver' => getenv('DB_DRIVER'),
			'host' => getenv('DB_HOST'),
			'database' => getenv('DB_DATABASE'),
			'username' => getenv('DB_USERNAME'),
			'password' => getenv('DB_PASSWORD'),
			'charset' => getenv('DB_CHARSET'),
			'collation' => getenv('DB_COLLATION'),
			'prefix' => getenv('DB_PREFIX'),
		],
		'modules_dir' => APP_PATH . '/modules/',
		'appmodule' => '\\AppMain\\AppMainModule',
		'paymentModelName' => 'AppMain\\Model\\PaymentModel',
	],
];