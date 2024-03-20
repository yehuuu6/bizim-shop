<?php

if (!defined('FILE_ACCESS')) {
    send_forbidden_response();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load($_SERVER['DOCUMENT_ROOT'] . '/.env');

global $con;
try {
    $con = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
