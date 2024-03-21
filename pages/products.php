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

$category_id = $category_data[0] ?? 0;

$sql = "SELECT id,name,slug FROM subcats WHERE slug = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 's', $sub_category_slug);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$sub_category_data = mysqli_fetch_row($res) ?? null;

$title_text = $sub_category_data[1] ?? $category_data[1] ?? "Ürün bulunamadı";
$title = "{$title_text} - Bizim Shop";

$description = "Bizim Shop'ta {$title_text} kategorisindeki ürünleri inceleyin.";

$keywords = "bizim shop, {$title_text}, ürünler, kategoriler";

new Top([
    "title" => $title,
    "styles" => $styles,
    "description" => $description,
    "keywords" => $keywords
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
    ?>
    <div class="product-container">
        <div class="products">
        </div>
        <div class="page-numbers">
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