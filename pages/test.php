<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Super\Head;
use Components\Navbar\Navbar;
use Components\Footer\Footer;
use Components\Super\Legs;
use Components\Banners\TopBanner;

$head = new Head();
$top_banner = new TopBanner();
$navbar = new Navbar();
?>
<section class="page-content">
    <div id="monitor"></div>
    <button id="place-order-btn" class="btn primary-btn">Place Order</button>
</section>
<?php
$footer = new Footer();
$legs = new Legs();
?>