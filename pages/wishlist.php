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
    "/dist/products/m1l5d9y6b3r2n7o8c0s.css"
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

<section id="liked-products" class="page-content">
    <div class="product-container">
    </div>
</section>
<?php
new Footer();
new Bottom();
?>