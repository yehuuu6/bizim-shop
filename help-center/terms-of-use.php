<?php
$PAGE_TITLE = "Kullanım Şartları - Gazi Unite";
require_once("{$_SERVER['DOCUMENT_ROOT']}/components/Navbar/navbar.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/components/HelpCenterItem/helpcenteritem.php");
$props = [
    "id" => "terms-of-use",
    "title" => "Kullanım Şartları",
];
?>

<?= HelpCenterItem($props) ?>
<?php require_once("{$_SERVER['DOCUMENT_ROOT']}/components/Footer/footer.php"); ?>