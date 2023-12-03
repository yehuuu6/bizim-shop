<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Super\Head;
use Components\Navbar\Navbar;
use Components\Footer\Footer;
use Components\Categories\Categories;
use Components\Banners\TopBanner;
use Components\Super\Legs;

// Set stylesheets
$styles = [
    "/dist/products/m1l5d9y6b3r2n7o8c0s.css"
];

$head = new Head([
    "title" => "Beğendiklerim - Bizim Shop",
    "styles" => $styles,
]);
$top_banner = new TopBanner();
$navbar = new Navbar();

?>

<div class="categories-container">
    <ul class="categories">
        <?php $categories = new Categories(); ?>
    </ul>
</div>

<section id="liked-products" class="page-content">
    <div class="product-container">
    </div>
</section>
<?php
$footer = new Footer();
$legs = new Legs();
?>