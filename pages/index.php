<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Super\Head;
use Components\Navbar\Navbar;
use Components\Categories\Categories;
use Components\Footer\Footer;
use Components\Super\Legs;
use Components\Banners\TopBanner;

// Promotions

use Components\Promotions\PromotionTheme1;
use Components\Promotions\PromotionTheme2;
use Components\Promotions\PromotionTheme3;

$head = new Head();
$top_banner = new TopBanner();
$navbar = new Navbar();

?>

<div class="categories-container">
    <ul class="categories">
        <?php $categories = new Categories(); ?>
    </ul>
</div>

<?php $promotion1 = new PromotionTheme1(); ?>
<?php $promotion3 = new PromotionTheme3(); ?>
<?php $promotion2 = new PromotionTheme2(); ?>
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
$legs = new Legs();
?>