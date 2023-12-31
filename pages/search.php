<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

use Components\Super\Head;
use Components\Navbar\Navbar;
use Components\Footer\Footer;
use Components\Categories\Categories;
use Components\Product\FiltersSearch;
use Components\Banners\TopBanner;
use Components\Super\Legs;

// Set stylesheets
$styles = [
    "/dist/products/m1l5d9y6b3r2n7o8c0s.css"
];
global $con;
// Get the search query from URL
$query = isset($_GET['q']) ? get_safe_value($con, $_GET['q']) : "";

if ($query == "") {
    // Go back.
    header("Location: /");
    exit;
}

$page_num = $_GET['page'] ?? 1;

$total_product_count = 0;

// Get the products from database
if ($query !== "") {
    $query = urldecode(urldecode($query));

    $sql = "SELECT * FROM product WHERE name LIKE '%$query%' OR description LIKE '%$query%' OR tags LIKE '%$query%' ORDER BY id DESC";

    $res = mysqli_query($con, $sql);
    $total_product_count = mysqli_num_rows($res);
} else {
    $sql = "SELECT * FROM product ORDER BY id DESC";

    $res = mysqli_query($con, $sql);
    $total_product_count = mysqli_num_rows($res);
}

$title = $query == "" ? "Ürünler" : "{$query}";
$title = "{$title} - Bizim Shop";

$keywords = `{$query}, ürünler, arama, ara, bul, bizim, shop, bizim shop, bizimshop, bizimshop.com`;
$description = "Bizim Shop'ta aradığınız ürünü bulun. {$query} araması için sonuçlar.";

$head = new Head([
    "keywords" => $keywords,
    "title" => $title,
    "styles" => $styles,
    "description" => $description
]);
$top_banner = new TopBanner();
$navbar = new Navbar();

$encoded_query = urlencode(urlencode($query));

?>

<div class="categories-container">
    <ul class="categories">
        <?php $categories = new Categories(); ?>
    </ul>
</div>

<div class="router">
    <a href="/">Ana Sayfa</a>
    <?php if ($query !== "") : ?>
        >
        <a href="/search?q=<?= $encoded_query ?>">"<?= $query ?>" için arama sonuçları</a>
    <?php endif; ?>
</div>
<section id="product-lister" class="page-content">
    <?php $filters = new FiltersSearch($query); ?>
    <div class="product-container">
        <div class="products">
        </div>
        <div class="page-numbers">
            <!---- Page buttons does not update when filters applied, FIX IT -->
            <?php foreach (range(1, ceil($total_product_count / 50)) as $page) : ?>
                <?php if ($page != 0) : ?>
                    <a href="/search?q=<?= $encoded_query !== "" ? "{$encoded_query}" : '' ?>&?page=<?= $page ?>" class="page-number <?= $page == $page_num ? 'active' : '' ?>"><?= $page ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<script src="/dist/search/s2a3g8g3n7k5x1p0vqj.js"></script>
<?php
$footer = new Footer();
$legs = new Legs();
?>