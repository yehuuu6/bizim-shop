<?php
define('FILE_ACCESS', TRUE);
require 'vendor/autoload.php';

use Components\Super\Head;
use Components\Navbar\Navbar;
use Components\Footer\Footer;
use Components\Banners\TopBanner;
use Components\Super\Legs;

require_once 'includes/auth.inc.php';

$styles = [
    "/dist/core/r9k2p4i7h0o1g5w6a2u3.css",
    "/dist/cart/v8x3q6t9j2s5f0e1n7z4.css"
];

$head = new Head([
    "title" => "Sepetim - Bizim Shop",
    "styles" => $styles,
]);
$top_banner = new TopBanner();
$navbar = new Navbar();

?>

<section id="cart" class="page-content flex-column">
    <div class="content-header">
        <h2>Sepetim <span id="cart-item-counter">(0 ürün)</span></h2>
        <button id="empty-shopping-cart" class="content-btn">
            Sepeti boşalt
        </button>
    </div>
    <div class="shopping-cart">
        <div class="products">
            <h4>Seçilen Ürünler</h4>
        </div>
        <div class="cart-details">
            <h4>Sipariş Özeti</h4>
            <div class="cart-detail">
                <span class="cart-detail-title">Ürünler:</span>
                <span data-type="products" class="cart-detail-value">0.00 TL</span>
            </div>
            <div class="cart-detail">
                <span class="cart-detail-title">Kargo:</span>
                <span data-type="shipment" class="cart-detail-value">0.00 TL</span>
            </div>
            <div class="cart-detail">
                <span class="cart-detail-title">KDV:</span>
                <span data-type="fee" class="cart-detail-value">0.00 TL</span>
            </div>
            <div class="cart-detail">
                <span class="cart-detail-title">Genel Toplam:</span>
                <span data-type="total" class="cart-detail-value">0.00 TL</span>
            </div>
            <div class="cart-detail">
                <a class="return-shopping" href="/products">Alışverişe devam et</a>
                <button class="cart-detail-confirm">Sepeti onayla</button>
            </div>
        </div>
    </div>
    <div class="content-header">
        <h2>Beğendiklerim <span id="liked-item-counter">(0 ürün)</span></h2>
        <a href="/wishlist" class="content-btn">
            Hepsini gör
        </a>
    </div>
    <div class="liked-products">
    </div>
</section>
<script src="/dist/cart/v8x3q6t9j2s5f0e1n7z4.js"></script>
<?php
$footer = new Footer();
$legs = new Legs();
?>