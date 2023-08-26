<?php
define('FILE_ACCESS', TRUE);
$PAGE_TITLE = "İkinci El Eşyaları Al & Sat - Bizim Shop";
require_once("{$_SERVER['DOCUMENT_ROOT']}/components/Navbar/Navbar.php");
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
<?php require_once("{$_SERVER['DOCUMENT_ROOT']}/components/Footer/Footer.php"); ?>