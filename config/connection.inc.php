<?php

if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load($_SERVER['DOCUMENT_ROOT'] . '/.env');

$con = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']) or die("Connection was not established");

define('DOMAIN', $_ENV['DOMAIN']);
define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT'] . '/images/');
define('SITE_PATH', DOMAIN . '/images/');
define('PRODUCT_IMAGE_SERVER_PATH', SERVER_PATH . 'product/');
define('PRODUCT_USER_SERVER_PATH', SERVER_PATH . 'users/');
define('PRODUCT_USER_SITE_PATH', SITE_PATH . 'users/');
define('PRODUCT_IMAGE_SITE_PATH', SITE_PATH . 'product/');
