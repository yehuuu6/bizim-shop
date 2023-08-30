<?php
define('FILE_ACCESS', TRUE);
require 'vendor/autoload.php';

use Components\Navbar\Navbar;
use Components\Footer\Footer;

$Navbar = new Navbar();
?>
<section id="custom-page" class="page-content">
    <div class="content white-text">
        <h1 class="header-title">Etkinlik Adı Buraya Geliyor</h1>
        <p class="header-sub-text">Etkinlik açıklaması buraya geliyor.</p>
        <a href="/" class="no-decoration btn white-text secondary-btn m-t-10">Ana Sayfa</a>
    </div>
</section>
<?php $Footer = new Footer(); ?>