<?php
$PAGE_TITLE = "İletişim - Gazi Unite";
require_once("{$_SERVER['DOCUMENT_ROOT']}/components/Navbar/navbar.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/components/HelpCenterItem/helpcenteritem.php");
$props = [
    "id" => "contact-us",
    "title" => "İletişim",
];
?>

<?= HelpCenterItem($props) ?>

<?php require_once("{$_SERVER['DOCUMENT_ROOT']}/components/Footer/footer.php"); ?>