<?php
define('FILE_ACCESS', TRUE);

require 'vendor/autoload.php';

use Components\Navbar\Navbar;
use Components\Footer\Footer;
use Components\Product\Product;

require_once 'includes/auth.inc.php';

$Navbar = new Navbar();
?>

<section id="home" class="page-content">
    <div class="content white-text light-text">
        <h1 class="flex-display gap-10 header-title bold-text">Bizim <div class="blue-text">Shop</div>
        </h1>
        <p class="header-text text-bg text-bg-p-1">İkinci el eşyalarınızı alıp satabileceğiniz bir platform.</p>
        <p class="header-sub-text m-t-10"> Aradığınızı bulmak hiç bu kadar kolay olmamıştı.</p>
        <a class="no-decoration btn white-text primary-btn m-t-10" href="custom-page">Hemen Başla</a>
    </div>
</section>
<section id="featured" class="page-content">

    <?php
    $raw_products = get_products($con, [
        'order_type' => 'ASC',
        'limit' => 3,
        'desc_cut_val' => 50,
    ]);
    foreach ($raw_products as $p) {
        $Product = new Product($p);
    }
    ?>

</section>

<?php $Footer = new Footer(); ?>