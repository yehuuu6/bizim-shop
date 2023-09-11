<?php
define('FILE_ACCESS', TRUE);
require 'vendor/autoload.php';

use Components\Navbar\Navbar;
use Components\Footer\Footer;
use Components\Product\Product;
use Components\Product\Filters;
use Components\Loader\Loader;

require_once 'includes/auth.inc.php';

$Navbar = new Navbar();
?>
<section id="featured" class="page-content">
    <?php
    $filters = new Filters();
    ?>
    <div class="product-container">
        <div class="loader">
            <?php
            $loader = new Loader();
            ?>
        </div>
        <?php
        $raw_products = get_products($con, [
            'order_type' => 'ASC',
        ]);
        foreach ($raw_products as $p) {
            $product = new Product($p);
        }
        ?>
    </div>
</section>
<?php $footer = new Footer(); ?>