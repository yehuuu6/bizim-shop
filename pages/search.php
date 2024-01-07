<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

use Components\Layout\Meta\Top;
use Components\Layout\Meta\Bottom;
use Components\Layout\Custom\Navbar;
use Components\Layout\Custom\Footer;
use Components\Utility\Banners\TopBanner;
use Components\Categories\Links;

use Components\Product\Filters\SFilter;

// Set stylesheets
$styles = [
    "/dist/shop/products/m1l5d9y6b3r2n7o8c0s.css"
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

$keywords = "{$query}, ürünler, arama, ara, bul, bizim, shop, bizim shop, bizimshop, bizimshop.com";
$description = "Bizim Shop'ta aradığınız ürünü bulun. {$query} araması için sonuçlar.";

new Top([
    "keywords" => $keywords,
    "title" => $title,
    "styles" => $styles,
    "description" => $description
]);
new TopBanner();
new Navbar();

$encoded_query = urlencode(urlencode($query));

?>

<div class="categories-container">
    <ul class="categories">
        <?php new Links(); ?>
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
    <?php new SFilter($query); ?>
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
<?php
new Footer();
?>
<script src="/dist/shop/search/s2a3g8g3n7k5x1p0vqj.js"></script>
<?php
new Bottom();
?>