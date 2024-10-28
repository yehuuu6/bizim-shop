<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Layout\Meta\Top;
use Components\Layout\Meta\Bottom;
use Components\Layout\Custom\Navbar;
use Components\Layout\Custom\Footer;
use Components\Utility\Banners\TopBanner;
use Components\Utility\Slider;

// Promotions

use Components\Utility\Promotions\Card1;
use Components\Utility\Promotions\Card2;
use Components\Utility\Promotions\Card3;

// Catalog

use Components\Categories\Catalog;
use Components\Categories\Links;

new Top();
new TopBanner();
new Navbar();
?>
<div class="categories-container">
    <ul class="categories">
        <?php new Links(); ?>
    </ul>
</div>
<?php
?>
<section class="page-content" id="landing-page">
    <div class="circle dynamic-content">
        <img class="note-img" src="/global/imgs/icons/note.svg" alt="">
        <h1 class="hero-text">YATA YATA MÜZİK İÇİN</h1>
        <button onclick="scrollToCategories()" class="hero-btn">Alışveriş Yap</button>
        <img class="hero-img" src="/global/imgs/astronaut.svg" alt="">
    </div>
</section>
<section class="page-content" id="info">
    <div class="cont">
        <div class="info-box">
            <div class="icon"><img src="/global/imgs/icons/truck.svg" alt=""></div>
            <h1>Hızlı Teslimat</h1>
            <p>Adresinize en kısa sürede teslim garantisi ile!</p>
        </div>
        <div class="info-box">
            <div class="icon"><img src="/global/imgs/icons/fix.svg" alt=""></div>
            <h1>Bakım ve Onarım</h1>
            <p>Elinizdeki ürünlerin bakım ve onarımı için bize ulaşın!</p>
        </div>
        <div class="info-box">
            <div class="icon"><img src="/global/imgs/icons/discount.svg" alt=""></div>
            <h1>Düzenli İndirimler</h1>
            <p>Ürünlerimizde düzenli olarak indirimler yapmaktayız!</p>
        </div>
        <div class="info-box">
            <div class="icon"><img src="/global/imgs/icons/trade.svg" alt=""></div>
            <h1>Bize Satın</h1>
            <p>Kullanmadığınız ürünleri bize satabilirsiniz!</p>
        </div>
    </div>
</section>
<?php new Slider([
    new Card1($con),
    new Card2($con),
    new Card3()
]);
new Catalog();
new Footer();
?>
<script>
    function scrollToCategories() {
        document.getElementById('categories').scrollIntoView({
            behavior: 'smooth'
        });
    }
    document.addEventListener("DOMContentLoaded", function() {

        let e = 1,
            t;

        function n() {
            e = e % 3 + 1, document.getElementById(`slide${e}`).checked = !0
        }

        function d() {
            t = setInterval(n, 5e3)
        }
        d(), document.getElementById("slider").addEventListener("mouseover", function e() {
            clearInterval(t)
        }), document.getElementById("slider").addEventListener("mouseout", d)
    });
</script>

<?php
new Bottom();
?>