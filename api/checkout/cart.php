<?php
define('FILE_ACCESS', TRUE);
require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

function validate_action($action)
{
    $valid_actions = ['checkLogin', 'finishCart'];
    return in_array($action, $valid_actions);
}

function validate_address()
{
    // TODO: Implement address validation
    return true;
}

function confirm_shopping_cart(mysqli $con, array $products, bool $did_confirm_address)
{
    if (!$did_confirm_address) {
        send_error_response('Adresinizi onaylamadan ödeme yapamazsınız.', 'custom-box');
    }
    if (validate_address()) {
        send_success_response('Ödemeniz başarıyla alındı. Teşekkür ederiz.');
    }
}

$action = get_safe_value($con, $_POST['action']);

if (!validate_action($action)) {
    send_forbidden_response();
}

$products = isset($_POST['products']) ? json_decode($_POST['products']) : [];
$did_confirm_address = isset($_POST['confirm-address']) ? get_safe_value($con, $_POST['confirm-address']) : false;

switch ($action) {
    case 'checkLogin':
        $is_logged_in = isset($_SESSION['id']);
        echo json_encode($is_logged_in);
        break;
    case 'finishCart':
        $safe_products = array_map(function ($product) use ($con) {
            return get_safe_value($con, $product);
        }, $products);
        confirm_shopping_cart($con, $safe_products, $did_confirm_address);
        break;
    default:
        send_forbidden_response();
}
