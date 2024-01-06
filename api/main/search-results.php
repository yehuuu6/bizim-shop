<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Product\Cards\InSearch;

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    $query = get_safe_value($con, $_POST['search_query']);

    $product_data = get_products($con, [
        'search' => $query,
        'limit' => '10',
    ]);

    $result = [];

    foreach ($product_data as $product) {
        $result[] = new InSearch($product);
    }

    echo json_encode($result);
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
