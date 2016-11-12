<?php
require_once 'prepare.php';

$app = new \SlimDash\Core\SlimDashApp($appSettings);
session_start();

$app->initModules();
$app->run();
