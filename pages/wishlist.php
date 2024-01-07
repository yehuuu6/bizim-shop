<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Layout\Meta\Top;
use Components\Layout\Meta\Bottom;
use Components\Layout\Custom\Navbar;
use Components\Layout\Custom\Footer;
use Components\Utility\Banners\TopBanner;
use Components\Categories\Links;

// Set stylesheets
$styles = [
    "/dist/shop/products/m1l5d9y6b3r2n7o8c0s.css"
];

new Top([
    "title" => "Beğendiklerim - Bizim Shop",
    "styles" => $styles,
]);
new TopBanner();
new Navbar();

?>

<div class="categories-container">
    <ul class="categories">
        <?php new Links(); ?>
    </ul>
</div>
<div class="router">
    <a href="/">Ana Sayfa</a>
    <a href="/wishlist">> Beğendiğim Ürünler</a>
</div>
<section id="product-lister" class="page-content">
    <div class="product-container">
        <div class="products"></div>
    </div>
</section>
<?php
new Footer();
?>
<script src="/dist/shop/wishlist/1k2c1l5d6z3r7o8b0s4.js"></script>
<?php
new Bottom();
?>