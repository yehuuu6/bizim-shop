<?php
$PAGE_TITLE = "Gizlilik Politikası - Gazi Unite";
require_once("{$_SERVER['DOCUMENT_ROOT']}/components/Navbar/navbar.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/components/HelpCenterItem/helpcenteritem.php");
$props = [
    "id" => "privacy-policy",
    "title" => "Gizlilik Politikası",
];
?>

<?= HelpCenterItem($props) ?>
<?php require_once("{$_SERVER['DOCUMENT_ROOT']}/components/Footer/footer.php"); ?>