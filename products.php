<?php
define('FILE_ACCESS', TRUE);
require 'vendor/autoload.php';

use Components\Super\Head;
use Components\Navbar\Navbar;
use Components\Footer\Footer;
use Components\Product\Filters;
use Components\Banners\TopBanner;
use Components\Super\Legs;

require_once 'includes/auth.inc.php';

$styles = [
    "/dist/core/dr50hzx.css",
    "/dist/products/g5120x.css"
];

$head = new Head([
    "title" => "Ürünler - Bizim Shop",
    "styles" => $styles,
]);
$top_banner = new TopBanner();
$navbar = new Navbar();

?>
<section id="featured" class="page-content">
    <?php
    $filters = new Filters();
    ?>
    <div class="product-container">
    </div>
</section>
<script src="/dist/products/g5120x.js"></script>
<?php
$footer = new Footer();
$legs = new Legs();
?>