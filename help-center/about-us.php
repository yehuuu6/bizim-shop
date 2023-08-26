<?php
$PAGE_TITLE = "Hakkımızda - Gazi Unite";
require_once("{$_SERVER['DOCUMENT_ROOT']}/components/Navbar/navbar.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/components/HelpCenterItem/helpcenteritem.php");
$props = [
    "id" => "about-us",
    "title" => "Hakkımızda",
];
?>

<?= HelpCenterItem($props) ?>

<?php require_once("{$_SERVER['DOCUMENT_ROOT']}/components/Footer/footer.php"); ?>