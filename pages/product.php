<?php
define('FILE_ACCESS', TRUE);
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.inc.php';

use Components\Layout\Meta\Top;
use Components\Layout\Meta\Bottom;
use Components\Layout\Custom\Navbar;
use Components\Layout\Custom\Footer;
use Components\Utility\Banners\TopBanner;
use Components\Categories\Links;
use Components\Questions\AskInput;

$name = isset($_GET['name']) ? get_safe_value($con, urldecode($_GET['name'])) : "";

if (!$name) {
    header("HTTP/1.1 404 Not Found");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/404.php');
    exit;
}

$name = convert_name($name);

$products_data = get_products($con, ['slug' => $name]);

if (!$products_data) {
    header("HTTP/1.1 404 Not Found");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/404.php');
    exit;
}

$title = "{$products_data[0]['name']} - Bizim Shop";
$tags = "{$products_data[0]['tags']}";
$description = htmlspecialchars($products_data[0]['description']);
$styles = [
    "/dist/shop/product/9k25c1l2zki6a0e1n7q6.css"
];

new Top([
    "title" => $title,
    "description" => "{$description} - Bizim Shop",
    "keywords" => $tags,
    "styles" => $styles,
]);
new TopBanner();
new Navbar();

$product = $products_data[0];

$fee_cost = $product['price'] * 0.18;
$fee_cost = number_format($fee_cost, 2, '.', '');

$total_price = (float)$product['price'] + (float)$fee_cost;

// Convert the total price to a readable number.
$price = readable_num($total_price);

$error_src = PRODUCT_IMAGE_SITE_PATH . "noimg.jpg";

function render_thumbnail(array $product)
{
    $image = $product['image1'];

    if ($image === 'noimg.jpg') {
        $src = PRODUCT_IMAGE_SITE_PATH . "noimg.jpg";
    } else {
        $src = PRODUCT_IMAGE_SITE_PATH . "{$product['root_name']}/{$image}";
    }
    global $error_src;
    return "<img src='{$src}' alt='Urun resmi' onerror='this.src=\"{$error_src}\"' />";
}

function render_showcase_items(array $product)
{
    $images = [
        $product['image1'],
        $product['image2'],
        $product['image3'],
        $product['image4'],
        $product['image5'],
        $product['image6']
    ];

    $valid_images = [];

    foreach ($images as $image) {
        if ($image != 'noimg.jpg') {
            array_push($valid_images, $image);
        }
    }

    $html = '';
    global $error_src;
    foreach ($valid_images as $image) {
        $src = PRODUCT_IMAGE_SITE_PATH . "{$product['root_name']}/{$image}";
        $html .= "<img data-img src='{$src}' alt='Urun resmi' onerror='this.src=\"{$error_src}\"' />";
    }

    return $html;
}

function render_questions($connection, $product)
{
    // Get the count of questions
    $sql = "SELECT COUNT(*) as count FROM questions WHERE pid = ?";
    try {
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $product['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
    } catch (Exception $e) {
        $count = 0;
    }

    return "<div class='question-indicator'><i class='fa-regular fa-circle-question'></i> <strong>{$count}</strong> Soru & Cevap</div>";
}

function render_likes($connection, $product)
{
    // Get the count of likes
    $sql = "SELECT COUNT(*) as count FROM likes WHERE pid = ?";
    try {
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $product['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
    } catch (Exception $e) {
        $count = 0;
    }

    return "<div class='like-indicator'><i class='fa-regular fa-heart'></i> <strong>{$count}</strong> Favori</div>";
}

function render_badges(array $product)
{
    $badges = [];

    // Featured
    if ($product['featured'] == 1) {
        $body_featured = <<<HTML
        <div class="item">
            <div class="badge">
                <i class="fa-solid fa-star"></i>
            </div>
            <h3>Öne çıkan ürün</h3>
        </div>
        HTML;
    } else {
        $body_featured = '';
    }

    $shipping_cost = $product['shipping_cost'];
    // Shipment
    if ($product['shipment'] == 0) {
        $body_shipment = <<<HTML
        <div class="item">
            <div class="badge">
                <i class="fa-solid fa-truck"></i>
            </div>
            <h3>Kargo: {$shipping_cost} <span class="currency">TL</span></h3>
        </div>
        HTML;
    } else {
        $body_shipment = <<<HTML
        <div class="item">
            <div class="badge">
                <i class="fa-solid fa-truck"></i>
            </div>
            <h3>Ücretsiz kargo</h3>
        </div>
        HTML;
    }

    // Quality
    if ($product['quality'] == 0) {
        $body_quality = <<<HTML
        <div class="item">
            <div class="badge">
                <i class="fa-solid fa-check"></i>
            </div>
            <h3>İyi durumda</h3>
        </div>
        HTML;
    } elseif ($product['quality'] == 1) {
        $body_quality = <<<HTML
        <div class="item">
            <div class="badge">
                <i class="fa-solid fa-recycle"></i>
            </div>
            <h3>Bazı özellikler çalışmıyor / eksik</h3>
        </div>
        HTML;
    } else {
        $body_quality = <<<HTML
        <div class="item">
            <div class="badge">
                <i class="fa-solid fa-skull"></i>
            </div>
            <h3>Hurda (Tamamen bozuk)</h3>
        </div>
        HTML;
    }
    array_push($badges, $body_featured);
    array_push($badges, $body_shipment);
    array_push($badges, $body_quality);

    $html = '';

    foreach ($badges as $badge) {
        $html .= $badge;
    }

    return $html;
}

?>

<div class="categories-container">
    <ul class="categories">
        <?php new Links(); ?>
    </ul>
</div>

<section id="product-page" class="page-content">
    <div class="product-container dynamic-content" data-id="<?= $product['id'] ?>">
        <div class="product-images">
            <div class="big-image">
                <?= render_thumbnail($product) ?>
            </div>
            <div class="showcase">
                <?= render_showcase_items($product) ?>
            </div>
        </div>
        <div class="product-details">
            <div class="detail">
                <div class="product-title">
                    <h1><?= $product['name'] ?></h1>
                    <div class="product-summary">
                        <?= render_questions($con, $product) ?>
                        <i style="font-size: 4px; color: #131313;" class="fa-solid fa-square"></i>
                        <?= render_likes($con, $product) ?>
                    </div>
                </div>
            </div>
            <div class="detail">
                <div class="product-category">
                    <a href="/products/<?= get_category_slug($product['category']) ?>"><?= get_category_name($product['category']) ?></a>
                    >
                    <a href="/products/<?= get_category_slug($product['category']) . '/' . get_sub_category_slug($product['subcategory']) ?>"><?= get_sub_category_name($product['subcategory']) ?></a>
                </div>
            </div>
            <div class="detail">
                <div class="product-price">
                    <span class="price"><?= $price ?> <span class="currency">TL</span>
                        <span class="fee-cost">KDV dahil</span>
                </div>
            </div>
            <div class="detail">
                <article class="product-description">
                    <?= nl2br($description) ?>
                </article>
            </div>
            <div class="detail badges">
                <?= render_badges($product) ?>
            </div>
            <hr />
            <div class="detail">
                <div class="btns">
                    <button id="product-cart-btn" class="add-cart">Sepete Ekle</button>
                    <button class="add-wishlist">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header">
        <h2>Soru & Cevap</h2>
        <i class="fa-solid fa-comments"></i>
    </div>
    <section class="questions-wrapper">
        <?php new AskInput(); ?>
        <div class="see-questions dynamic-content">
            <div class="questions">
                <div class="question" id="no-question">
                    <h3>Henüz hiç soru sorulmamış.</h3>
                    <p>İlk soruyu siz sorun!</p>
                </div>
            </div>
            <button style="display:none" class="load-more-questions">Daha fazla soru gör</button>
        </div>
    </section>
    <div class="content-header">
        <h2>Rastgele Ürünler</h2>
        <i class="fa-solid fa-random"></i>
    </div>
    <div id="random-products" class="product-showcase">
    </div>
</section>
<?php
new Footer();
?>
<script src="/dist/shop/product/9k25c1l2zki6a0e1n7q6.js"></script>
<?php
new Bottom();
?>