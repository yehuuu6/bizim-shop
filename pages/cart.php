<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Layout\Meta\Top;
use Components\Layout\Meta\Bottom;
use Components\Layout\Custom\Navbar;
use Components\Layout\Custom\Footer;
use Components\Utility\Banners\TopBanner;
use Components\Categories\Links;
use Components\Forms\AddressForm;

$styles = [
    "/dist/shop/cart/v8x3q6t9j2s5f0e1n7z4.css"
];

new Top([
    "title" => "Sepetim - Bizim Shop",
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
        <?php
        if (isset($_SESSION['id'])) {
            new AddressForm($con);
        }
        ?>
        <div class="checkout flex-display flex-column gap-20">
            <div class="cart-details">
                <h4>Sipariş Özeti</h4>
                <div class="cart-detail dynamic-content">
                    <span class="cart-detail-title">Ürünler:</span>
                    <span data-type="products" class="cart-detail-value">0.00 TL</span>
                </div>
                <div class="cart-detail dynamic-content">
                    <span class="cart-detail-title">Kargo:</span>
                    <span data-type="shipment" class="cart-detail-value">0.00 TL</span>
                </div>
                <div class="cart-detail dynamic-content">
                    <span class="cart-detail-title">KDV:</span>
                    <span data-type="fee" class="cart-detail-value">0.00 TL</span>
                </div>
                <div class="cart-detail dynamic-content">
                    <span class="cart-detail-title">Genel Toplam:</span>
                    <span data-type="total" class="cart-detail-value">0.00 TL</span>
                </div>
                <label id="confirm-address-box" for="confirm-address" class="dynamic-content">
                    <span class="confirm-text">Adresin doğru olduğunu onaylıyorum.</span>
                    <input type="checkbox" name="confirm-address" id="confirm-address">
                    <span id="custom-box" class="confirm-checkbox"></span>
                </label>
                <div class="cart-detail">
                    <button class="cart-detail-confirm">Sepeti onayla</button>
                    <a class="return-shopping" href="/">Alışverişe devam et</a>
                </div>
            </div>
            <div class="error-logger">
                <span class="error-icon"><img src="/global/imgs/icons/error.png" alt=""></span>
                <span class="error-text"></span>
            </div>
        </div>
    </div>
    <div class="content-header">
        <h2>Son baktıklarım</h2>
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>
    <div id="last-viewed-products" class="product-showcase">
    </div>
    <div class="content-header">
        <h2>Beğendiklerim <span id="liked-item-counter">(0 ürün)</span></h2>
        <a href="/wishlist" class="content-btn">
            Hepsini gör
        </a>
    </div>
    <div id="liked-products" class="product-showcase">
    </div>
</section>

<?php
new Footer();
?>
<script src="/dist/shop/cart/v8x3q6t9j2s5f0e1n7z4.js"></script>
<?php
new Bottom();
?>