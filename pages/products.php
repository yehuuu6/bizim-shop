<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Super\Head;
use Components\Navbar\Navbar;
use Components\Footer\Footer;
use Components\Categories\Categories;
use Components\Product\Filters;
use Components\Banners\TopBanner;
use Components\Super\Legs;

// Set stylesheets
$styles = [
    "/dist/products/m1l5d9y6b3r2n7o8c0s.css"
];

// Get category from URL
$category = $_GET['category'] ?? null;
$category = htmlspecialchars($category);

$categories = [
    'stereo' => 'Müzik Setleri',
    'speakers' => 'Hoparlörler',
    'turntables' => 'Plak Çalarlar',
    'music-players' => 'Müzik Çalarlar',
    'tapes-records' => 'Kasetler & Plaklar'
];

$title = $categories[$category] ?? 'Ürünler';
$title = "{$title} - Bizim Shop";

$head = new Head([
    "title" => $title,
    "styles" => $styles,
]);
$top_banner = new TopBanner();
$navbar = new Navbar();
$categories = new Categories();

?>
<section id="featured" class="page-content">
    <?php
    $filters = new Filters($category);
    ?>
    <div class="product-container">
    </div>
</section>
<script src="/dist/products/m1l5d9y6b3r2n7o8c0s.js"></script>
<?php
$footer = new Footer();
$legs = new Legs();
?>