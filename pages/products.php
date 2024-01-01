<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

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
global $con;

// If slug is not set, go back.
if (!isset($_GET['category'])) {
    header("Location: /");
    exit;
}

// Get category from URL
$slug = isset($_GET['category']) ? get_safe_value($con, $_GET['category']) : "0";

// Get sub category from URL
$sub_category_slug = isset($_GET['sub-category']) ? get_safe_value($con, $_GET['sub-category']) : "Tümünü Göster";

$page_num = $_GET['page'] ?? 1;

$total_product_count = 0;

$sql = "SELECT id,name,slug FROM categories WHERE slug = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 's', $slug);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$category_data = mysqli_fetch_row($res) ?? null;

# 0 => id
# 1 => name
# 2 => slug
# for the category

if ($category_data === null) {
    $sql = "SELECT COUNT(*) FROM product";
    $stmt = mysqli_prepare($con, $sql);
    $category_id = '0';
} else {
    $sql = "SELECT COUNT(*) FROM product WHERE category = ?";
    $stmt = mysqli_prepare($con, $sql);
    $stmt->bind_param('i', $category_data[0]);
    $category_id = $category_data[0];
}
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$total_product_count = mysqli_fetch_row($res)[0];

$title = $category_data[1] ?? 'Tüm Ürünler';
$title = "{$title} - Bizim Shop";

$head = new Head([
    "title" => $title,
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

<div class="router">
    <a href="/">Ana Sayfa</a>
    <?php if ($category_data !== null) : ?>
        <a href="/products/<?= $category_data[2] ?>">> <?= $category_data[1] ?></a>
    <?php endif; ?>
</div>
<section id="product-lister" class="page-content">
    <?php
    $filters = new Filters($slug, $category_id, $sub_category_slug);
    $encoded_sub_category_slug = urlencode(urlencode($sub_category_slug));
    ?>
    <div class="product-container">
        <div class="products">
        </div>
        <div class="page-numbers">
            <!---- Page buttons does not update when filters applied, FIX IT -->
            <?php foreach (range(1, ceil($total_product_count / 50)) as $page) : ?>
                <?php if ($page != 0) : ?>
                    <a href="/products<?= $slug !== "" ? "/{$slug}" : '' ?><?= $sub_category_slug !== "" ? "/{$encoded_sub_category_slug}" : '' ?>?page=<?= $page ?>" class="page-number <?= $page == $page_num ? 'active' : '' ?>"><?= $page ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<script src="/dist/products/m1l5d9y6b3r2n7o8c0s.js"></script>
<?php
$footer = new Footer();
$legs = new Legs();
?>