<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    $action = get_safe_value($con, $_POST['action']);

    // If user is at step 1 (checkLogin), then they don't send the array of products
    if (!isset($_POST['products']) && $action !== 'checkLogin') {
        header("HTTP/1.1 403 Forbidden");
        include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
        exit;
    } else {
        $products = json_decode($_POST['products']);
    }

    // If user is at step 1 (checkLogin), then they don't send the input for confirm-address
    if (!isset($_POST['confirm-address']) && $action !== 'checkLogin') {
        header("HTTP/1.1 403 Forbidden");
        include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
        exit;
    } else {
        $did_confirm_address = get_safe_value($con, $_POST['confirm-address']);
    }

    $valid_actions = ['checkLogin', 'finishCart'];

    $safe_products = array();

    function validate_address(): mixed
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

    if (in_array($action, $valid_actions)) {
        switch ($action) {
            case 'checkLogin':
                $is_logged_in = isset($_SESSION['id']);
                echo json_encode($is_logged_in);
                break;
            case 'finishCart':
                foreach ($products as $product) {
                    $product = get_safe_value($con, $product);
                    array_push($safe_products, $product);
                }
                confirm_shopping_cart($con, $safe_products, $did_confirm_address);
                break;
            default:
                header("HTTP/1.1 403 Forbidden");
                include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
                exit;
        }
    } else {
        header("HTTP/1.1 403 Forbidden");
        include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
        exit;
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
