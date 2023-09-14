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
    "/dist/core/r9k2p4i7h0o1g5w6a2u3.css",
    "/dist/products/m1l5d9y6b3r2n7o8c0s.css"
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
<script src="/dist/products/m1l5d9y6b3r2n7o8c0s.js"></script>
<?php
$footer = new Footer();
$legs = new Legs();
?>