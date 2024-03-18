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

use Components\Product\Filters\CFilter;

// Set stylesheets
$styles = [
    "/dist/shop/products/m1l5d9y6b3r2n7o8c0s.css"
];

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

$sql = "SELECT id,name,slug FROM subcats WHERE slug = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 's', $sub_category_slug);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$sub_category_data = mysqli_fetch_row($res) ?? null;

if ($category_data === null) {
    $sql = "SELECT COUNT(*) FROM product";
    $stmt = mysqli_prepare($con, $sql);
    $category_id = '0';
} else if ($sub_category_data !== null) {
    $sql = "SELECT COUNT(*) FROM product WHERE subcategory = ? AND category = ?";
    $stmt = mysqli_prepare($con, $sql);
    $stmt->bind_param('ii', $sub_category_data[0], $category_data[0]);
    $category_id = $category_data[0];
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

new Top([
    "title" => $title,
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
    <?php if ($category_data !== null) : ?>
        <a href="/products/<?= $category_data[2] ?>">> <?= $category_data[1] ?></a>
    <?php endif; ?>
</div>
<section id="product-lister" class="page-content">
    <?php
    new CFilter($slug, $category_id, $sub_category_slug);
    $encoded_sub_category_slug = urlencode(urlencode($sub_category_slug));
    ?>
    <div class="product-container">
        <div class="products">
        </div>
        <div class="page-numbers">
            <!---- Page buttons does not update when filters applied, FIX IT -->
            <!---- We must render page buttons in javascript -->
            <?php foreach (range(1, ceil($total_product_count / 16)) as $page) : ?>
                <?php if ($page != 0) : ?>
                    <a href="/products<?= $slug !== "" ? "/{$slug}" : '' ?><?= $sub_category_slug !== "" ? "/{$encoded_sub_category_slug}" : '' ?>?page=<?= $page ?>" class="page-number <?= $page == $page_num ? 'active' : '' ?>"><?= $page ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
new Footer();
?>
<script src="/dist/shop/products/m1l5d9y6b3r2n7o8c0s.js"></script>
<?php
new Bottom();
?>