<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Layout\Meta\Top;
use Components\Layout\Meta\Bottom;
use Components\Layout\Custom\Navbar;
use Components\Layout\Custom\Footer;
use Components\Utility\Banners\TopBanner;
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

<section class="page-content">
    <div id="monitor"></div>
    <button id="place-order-btn" class="btn primary-btn">Place Order</button>
</section>
<?php
new Footer();
new Bottom();
?>