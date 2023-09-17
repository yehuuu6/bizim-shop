<?php
define('FILE_ACCESS', TRUE);
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.inc.php';

use Components\Super\Head;
use Components\Navbar\Navbar;
use Components\Footer\Footer;
use Components\Banners\TopBanner;
use Components\Super\Legs;
use Components\Product\Product;

@$name = get_safe_value($con, $_GET['name']);

if (!$name) {
    header("HTTP/1.1 404 Not Found");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/404.html');
    exit;
}

$name = convert_name($name);

$products_data = get_products($con, ['slug' => $name]);

$title = "{$products_data[0]['name']} - Bizim Shop";

$head = new Head([
    "title" => $title,
]);
$top_banner = new TopBanner();
$navbar = new Navbar();

?>
<section id="product-page" class="page-content">
    <?php
    $product = new Product($products_data[0]);
    $product->render($product->body);
    ?>
</section>
<?php
$footer = new Footer();
$legs = new Legs();
?>