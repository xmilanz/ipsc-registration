<?php
include "./header.php";

require_once './handlers/_common.php';

$action = $_POST['action'] ?? '';

$handlers = [
    'register_shooter'   => './handlers/register_shooter.php',
    'cancel_shooter'  => './handlers/cancel_shooter.php',
    'change_password' => './handlers/change_password.php',
];

if (isset($handlers[$action])) {
    require $handlers[$action];
} else {
    http_response_code(400);
    exit('Neznámá akce.');
}