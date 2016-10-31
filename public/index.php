<?php

require_once 'prepare.php';

//die(json_encode($settings));
$app = new \SlimDash\Core\SlimDashApp($appSettings);
session_start();

$app->initModules();
$app->run();