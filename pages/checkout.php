<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Layout\Meta\Top;
use Components\Layout\Meta\Bottom;
use Components\Layout\Custom\Navbar;
use Components\Layout\Custom\Footer;

new Top([
    "title" => "Siparişiniz Alındı - Bizim Shop",
]);
new Navbar();

?>
<section id="checkout-done" class="page-content">
    <div class="checkout-done-container">
        <div class="checkout-done-content">
            <h2 class="blue-text">Siparişiniz Alındı</h2>
            <p class="black-text">Siparişiniz başarıyla alındı. Siparişinizin durumunu <a class="blue-text link" href="/control-center/account#orders">hesabım</a> sayfasından takip edebilirsiniz.</p>
        </div>
    </div>
</section>

<?php
new Footer();
new Bottom();
?>