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

<?php new Slider([
    new Card1(),
    new Card2(),
    new Card3()
]);
new Catalog();
?>
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
                    <img src="http://localhost/images/users/nopp.png" alt="user">
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
new Footer();
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
new Bottom();
?>