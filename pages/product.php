<?php
define('FILE_ACCESS', TRUE);
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.inc.php';

use Components\Super\Head;
use Components\Navbar\Navbar;
use Components\Footer\Footer;
use Components\Categories\Categories;
use Components\Banners\TopBanner;
use Components\Super\Legs;

@$name = get_safe_value($con, $_GET['name']);

if (!$name) {
    header("HTTP/1.1 404 Not Found");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/404.html');
    exit;
}

$name = convert_name($name);

$products_data = get_products($con, ['slug' => $name]);

$title = "{$products_data[0]['name']} - Bizim Shop";
$tags = "{$products_data[0]['tags']}";
$styles = [
    "/dist/product-page/9k25c1l2zki6a0e1n7q6.css"
];

$head = new Head([
    "title" => $title,
    "keywords" => $tags,
    "styles" => $styles,
]);
$top_banner = new TopBanner();
$navbar = new Navbar();
$categories = new Categories();

$product = $products_data[0];

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
                <i style="font-size: 1.1rem" class="fa-solid fa-truck"></i>
            </div>
            <h3>Kargo: {$shipping_cost} <span class="currency">TL</span></h3>
        </div>
        HTML;
    } else {
        $body_shipment = <<<HTML
        <div class="item">
            <div class="badge">
                <i style="font-size: 1.1rem" class="fa-solid fa-truck"></i>
            </div>
            <h3>Ücretsiz Kargo</h3>
        </div>
        HTML;
    }

    // Quality
    if ($product['quality'] == 0) {
        $body_quality = <<<HTML
        <div class="item">
            <div class="badge">
                <i class="fa-solid fa-face-smile"></i>
            </div>
            <h3>İyi Durumda</h3>
        </div>
        HTML;
    } elseif ($product['quality'] == 1) {
        $body_quality = <<<HTML
        <div class="item">
            <div class="badge">
                <i class="fa-solid fa-face-meh"></i>
            </div>
            <h3>Bazı Özellikler Çalışmıyor/Eksik</h3>
        </div>
        HTML;
    } else {
        $body_quality = <<<HTML
        <div class="item">
            <div class="badge">
                <i class="fa-solid fa-face-frown"></i>
            </div>
            <h3>Hurda (Tamamen Bozuk)</h3>
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
                </div>
            </div>
            <div class="detail">
                <div class="product-price">
                    <span class="price"><?= $product['price'] ?> <span class="currency">TL</span>
                        <span class="fee-cost">+ KDV</span></span>
                </div>
            </div>
            <div class="detail">
                <div class="product-description">
                    <?= $product['description'] ?>
                </div>
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
</section>
<script src="/dist/product-page/9k25c1l2zki6a0e1n7q6.js"></script>
<?php
$footer = new Footer();
$legs = new Legs();
?>