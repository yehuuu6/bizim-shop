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