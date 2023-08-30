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

// Meta Data
define('DEFAULT_PAGE_TITLE', "İkinci El Eşyaları Al & Sat - Bizim Shop");
define('DEFAULT_PAGE_DESCRIPTION', "İkinci el eşyalarınızı alıp satabileceğiniz bir platform.");
define('DEFAULT_PAGE_KEYWORDS', "ikinci el, eşya, al, sat, ikinci el eşya, ikinci el eşya al, ikinci el eşya sat, ikinci el eşya al sat, ikinci el eşya alım satım, ikinci el eşya alım, ikinci el eşya satım, ikinci el eşya al satım, ikinci el eşya al sat, ikinci el eşya alım sat, ikinci el eşya alım satım");
define('DEFAULT_PAGE_AUTHOR', "therenaydin");
define('DEFAULT_PAGE_FAVICON', "/global/imgs/favicon.svg");

// Emailer
define('EMAIL', 'planetofplugins@gmail.com');
define('PASSWORD', $_ENV['EMAIL_PASSWORD']);
