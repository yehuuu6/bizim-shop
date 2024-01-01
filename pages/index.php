<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Super\Head;
use Components\Navbar\Navbar;
use Components\Footer\Footer;
use Components\Super\Legs;
use Components\Banners\TopBanner;
use Components\Slider\Slider;

// Promotions

use Components\Promotions\PromotionTheme1;
use Components\Promotions\PromotionTheme2;
use Components\Promotions\PromotionTheme3;

$head = new Head();
$top_banner = new TopBanner();
$navbar = new Navbar();

?>

<?php $slider = new Slider([
    new PromotionTheme1(),
    new PromotionTheme2(),
    new PromotionTheme3()
]); ?>
<section class="home-page-featured" id="categories">
    <div class="category-card card-wide">
        <div class="category-card-image dynamic-content">
            <img src="http://localhost/global/imgs/categories/electronic.jpg" alt="category" loading="lazy">
        </div>
        <a href="/products/elektronik">Elektronik</a>
    </div>
    <div class="category-card card-tall">
        <div class="category-card-image dynamic-content">
            <img src="http://localhost/global/imgs/categories/pets.jpg" alt="category" loading="lazy">
        </div>
        <a href="/products/evcil-hayvan">Evcil Hayvan</a>
    </div>
    <div class="category-card">
        <div class="category-card-image dynamic-content">
            <img src="http://localhost/global/imgs/categories/instrument.jpg" alt="category" loading="lazy">
        </div>
        <a href="/products/enstruman">Enstrüman</a>
    </div>
    <div class="category-card">
        <div class="category-card-image dynamic-content">
            <img src="http://localhost/global/imgs/categories/sneakers.jpg" alt="category" loading="lazy">
        </div>
        <a href="/products/moda">Moda</a>
    </div>
</section>
<section class="home-page-featured" id="brands">
    <ul class="dynamic-content">
        <li>
            <img src="http://localhost/global/imgs/brands/sony.jpg" alt="sony">
        </li>
        <li>
            <img src="http://localhost/global/imgs/brands/philips.jpg" alt="philips">
        </li>
        <li>
            <img src="http://localhost/global/imgs/brands/samsung.jpg" alt="samsung">
        </li>
        <li>
            <img src="http://localhost/global/imgs/brands/apple.jpg" alt="apple">
        </li>
        <li>
            <img src="http://localhost/global/imgs/brands/lenovo.jpg" alt="lenovo">
        </li>
        <li>
            <img src="http://localhost/global/imgs/brands/hp.jpg" alt="hp">
        </li>
    </ul>
</section>
<section class="home-page-featured" id="featured">
    <ul>
        <li>
            <div class="review">
                <div class="user">
                    <img src="http://localhost/images/users/nopp.png" alt="user">
                    <p>John Doe</p>
                </div>
            </div>
            <div class="comment">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                </p>
            </div>
        </li>
        <li>
            <div class="review">
                <div class="user">
                    <img src="http://localhost/images/users/eren_aydin_avatar_yfh5fpnr0v.jpeg?timestamp=1704040183" alt="user">
                    <p>John Doe</p>
                </div>
            </div>
            <div class="comment">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, adipisci alias asperiores
                    aspernatur atqu.
                </p>
            </div>
        </li>
        <li>
            <div class="review">
                <div class="user">
                    <img src="http://localhost/images/users/nopp.png" alt="user">
                    <p>John Doe</p>
                </div>
            </div>
            <div class="comment">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, adipisci alias asperiores
                    aspernatur atque autem blanditiis.
                </p>
            </div>
        </li>
    </ul>
</section>
<?php
$footer = new Footer();
?>
<script>
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
$legs = new Legs();
?>