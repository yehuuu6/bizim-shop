<?php
define('FILE_ACCESS', TRUE);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    if (!isset($_SESSION['id'])) {
        send_error_response('Bu işlem için giriş yapmalısınız.', 'login');
    }

    $action = get_safe_value($con, $_POST['action']);
    if (isset($_POST['product_id'])) {
        $product_id = get_safe_value($con, $_POST['product_id']);
        // Convert the product_id to an integer
        $product_id = (int) $product_id;
    }
    $uid = $_SESSION['id'];

    $valid_actions = ['add', 'remove', 'check', 'pull'];

    if (!in_array($action, $valid_actions)) {
        header("HTTP/1.1 400 Bad Request");
        include($_SERVER['DOCUMENT_ROOT'] . '/errors/400.php');
        exit;
    }

    function pull_my_liked_products()
    {
        global $con;

        $query = "SELECT * FROM likes WHERE uid = ?";
        $stmt = mysqli_prepare($con, $query);
        try {
            mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $products = [];
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($products, $row['pid']);
            }
            return $products;
        } catch (Exception $e) {
            return [];
        }
    }

    function is_in_wishlist(int $id)
    {
        global $con;

        $query = "SELECT * FROM likes WHERE uid = ? AND pid = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['id'], $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        return mysqli_stmt_num_rows($stmt) > 0;
    }

    function add_to_wishlist(int $id)
    {
        global $con;

        $query = "INSERT INTO likes (uid, pid) VALUES (?, ?)";
        $stmt = mysqli_prepare($con, $query);
        try {
            mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['id'], $id);
            mysqli_stmt_execute($stmt);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    function remove_from_wishlist(int $id)
    {
        global $con;

        $query = "DELETE FROM likes WHERE uid = ? AND pid = ?";
        $stmt = mysqli_prepare($con, $query);
        try {
            mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['id'], $id);
            mysqli_stmt_execute($stmt);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    switch ($action) {
        case 'add':
            if (add_to_wishlist($product_id)) {
                send_success_response('Ürün favorilere eklendi.');
            } else {
                send_error_response('Ürün favorilere eklenirken bir hata oluştu.');
            }
            break;
        case 'remove':
            if (remove_from_wishlist($product_id)) {
                send_success_response('Ürün favorilerden kaldırıldı.');
            } else {
                send_error_response('Ürün favorilerden kaldırılırken bir hata oluştu.');
            }
            break;
        case 'check':
            if (is_in_wishlist($product_id)) {
                echo json_encode([
                    'success', 'Ürün favorilerde bulunuyor.', 'in_wishlist'
                ]);
            } else {
                echo json_encode([
                    'error', 'Ürün favorilerde bulunmuyor.', 'not_in_wishlist'
                ]);
            }
            break;
        case 'pull':
            $products = pull_my_liked_products();
            echo json_encode($products);
            break;
        default:
            header("HTTP/1.1 400 Bad Request");
            include($_SERVER['DOCUMENT_ROOT'] . '/errors/400.php');
            exit;
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
