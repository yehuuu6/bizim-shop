<?php
define('FILE_ACCESS', TRUE);
require_once "includes/auth.inc.php";

require 'vendor/autoload.php';

use Components\Loader\Loader;

if (!isset($_SESSION['id'])) {
    header('location: ' . DOMAIN . 'auth/login');
    exit();
}

if ($_SESSION['verified'] == 0) {
    header("location: /auth/verify");
    die();
}

$power = $_SESSION['membership'];
$perm_content = get_permission($power);

$sql = "SELECT name, surname, email, profile_image, telephone, address, door, apartment, floor FROM users WHERE id = {$_SESSION['id']}";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res);

$address = $row['address'];
$apartment = $row['apartment'];
$floor = $row['floor'];
$door = $row['door'];

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1" />
    <link rel="stylesheet" href="/dist/profile/k7u4h0g3t5s9e1c6q2.css" />
    <script src="/global/plugins/icons.js"></script>
    <link rel="shortcut icon" href="/global/imgs/favicon.svg" type="image/x-icon">
    <title>Profili Düzenle - Bizim Shop</title>
</head>
<noscript>
    <style>
        .no-js {
            font-family: 'Poppins', sans-serif;
        }

        .app {
            display: none;
        }
    </style>
    <div class="no-js">
        <h1>JavaScript Devre Dışı</h1>
        <p>JavaScript devre dışı bırakılmış. Lütfen tarayıcınızın JavaScript desteğini etkinleştirin.</p>
</noscript>

<body>
    <div class="app">
        <nav>
            <h3><span class="purple-text">Bizim <span class="blue-text">Shop</span></span></h3>
            <div class="header-user">
                <div class="user-btn">
                    <a href="/" class="user-btn-item" title="Ana sayfaya dön">
                        <i class="fa-solid fa-home"></i>
                    </a>
                </div>
                <div class="user-btn">
                    <a class="user-btn-item" id="settings" title="Ayarlar" style="font-size: 20px;">
                        <i class="fa-solid fa-gear"></i>
                    </a>
                </div>
                <div class="user-btn">
                    <a href="/?logout=1" class="user-btn-item" title="Çıkış Yap" style="font-size: 20px;">
                        <i class="fa-solid fa-door-open"></i>
                    </a>
                </div>
                <hr>
                <div class="user-info-container">
                    <div class="user-info">
                        <h3 class="username"><?= $row['name'] . " " . $row['surname'] ?></h3>
                        <p class="user-role"><?= $perm_content ?></p>
                    </div>
                    <div class="user-image-container">
                        <img class="user-avatar" src="<?= PRODUCT_USER_SITE_PATH . $row['profile_image'] ?>?timestamp=<?= time() ?>" alt="Profil Resmi" />
                    </div>
                </div>
            </div>
        </nav>
        <div class="main-page">
            <section id="change-user-info" data-url="profile" data-title="Profili Düzenle" class="page-content">
                <div id="profile-loader" class="loader">
                    <?php $loader2 = new Loader(); ?>
                </div>
                <div class="content-header">
                    <div class="item">
                        <h2 class="header">Hesap Ayarları</h2>
                        <p>Burada hesap bilgilerinizi düzenleyebilirsiniz.</p>
                    </div>
                    <div class="item">
                        <button id="password-reset" class="dashboard-btn edit-btn">Şifre Sıfırlama Maili Gönder</button>
                    </div>
                </div>
                <div class="container">
                    <form id="profile-form">
                        <h3 class="bottom-header">Genel Bilgiler</h3>
                        <div class="second">
                            <div class="item-wrapper">
                                <div class="first-item">
                                    <div class="image-container">
                                        <img class="profile-image" id="profile-image" src="<?= PRODUCT_USER_SITE_PATH . $row['profile_image'] ?>?timestamp=<?= time() ?>" alt="Profil Resmi" />
                                    </div>
                                    <label id="avatar-label" class="dashboard-btn edit-btn" for="avatar-input">Profil Resmi Yükle</label>
                                    <p id="avatar-input-displayer" class="display-file">Dosya seçilmedi.</p>
                                    <input type="file" id="avatar-input" name="avatar-input" />
                                </div>
                                <hr>
                                <div class="form-item">
                                    <label for="name">Adı</label>
                                    <input name="name" required type="text" id="name" spellcheck="false" value="<?php echo $row['name'] ?>" />
                                    <label for="surname">Soyadı</label>
                                    <input name="surname" required type="text" id="surname" spellcheck="false" value="<?php echo $row['surname'] ?>" />
                                    <label for="phone">Telefon</label>
                                    <input name="phone" required type="tel" id="phone" placeholder="5001112233" pattern="[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}" spellcheck="false" value="<?php echo $row['telephone'] ?>" />
                                    <label for="email">E-posta</label>
                                    <input name="email" id="email" readonly spellcheck="false" value="<?php echo $row['email'] ?>" />
                                </div>
                            </div>
                            <br>
                            <h3 class="bottom-header">Adres Bilgileri</h3>
                            <div class="item-wrapper">
                                <div class="form-item">
                                    <label for="city">Şehir</label>
                                    <select id="city" name="city">
                                        <option value="">Şehir Seçiniz</option>
                                    </select>
                                </div>
                                <div class="form-item">
                                    <label for="district">İlçe</label>
                                    <select id="district" name="district" disabled>
                                        <option value="">İlçe Seçiniz</option>
                                    </select>
                                </div>
                            </div>
                            <div class="item-wrapper">
                                <div class="form-item">
                                    <label for="apartment">Apartman</label>
                                    <input name="apartment" type="text" id="apartment" spellcheck="false" value="<?php echo $apartment ?>" />
                                </div>
                                <div class="form-item">
                                    <label for="floor">Kat</label>
                                    <input name="floor" type="number" id="floor" spellcheck="false" value="<?php echo $floor ?>" />
                                </div>
                                <div class="form-item">
                                    <label for="door">Daire</label>
                                    <input name="door" type="number" id="door" spellcheck="false" value="<?php echo $door ?>" />
                                </div>
                            </div>
                            <label for="address">Adres Tarifi</label>
                            <textarea spellcheck="false" name="address" id="address" cols="30" rows="10" placeholder="Mahalle, sokak vb."><?php echo $address ?></textarea>
                            <button class="dashboard-btn success-btn" type="submit" name="save-user" id="save-user">
                                Değişiklikleri Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </section>
            <div class="settings-container" style="display:none;">
                <div class="settings">
                    <div class="header">
                        <h2 class="main-title">Ayarlar</h2>
                    </div>
                    <div class="content">
                        <h3 class="title">Kişiselleştirme</h3>
                        <p class="description">Yönetici panelinizin nasıl görüneceğini seçin.</p>
                        <div class="theme-container">
                            <div class="theme-item active-theme" data-theme="light">
                                <div class="theme-img">
                                    <img src="/global/imgs/light_high_contrast_preview.svg" alt="">
                                </div>
                                <div class="theme-info">
                                    <input type="radio" id="light-theme">
                                    <label class="theme-title">Açık Tema</label>
                                </div>
                            </div>
                            <div class="theme-item" data-theme="dark">
                                <div class="theme-img">
                                    <img src="/global/imgs/dark_preview.svg" alt="">
                                </div>
                                <div class="theme-info">
                                    <input type="radio" id="dark-theme">
                                    <label class="theme-title">Koyu Tema</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="copyright-section">
                <span>Tüm hakları saklıdır
                </span>
                <p>© 2023 Bizim Shop</p>
            </div>
        </footer>
        <div class="logger">
            <span class="flex-display justify-center align-center">
                <img src="/global/imgs/info.png" alt="Status" />
            </span>
            <p>{message}</p>
            <div class="logger-btn">
                <button class="btn small-btn" title="Bildirimi sil" id="close-logger">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        </div>
        <div id="main-loader" class="loader" style="display:flex;">
            <?php $loader1 = new Loader(); ?>
        </div>
    </div>
    <script type="module" src="/dist/profile/k7u4h0g3t5s9e1c6q2.js"></script>
</body>
<!--       

    YOU KIIINDA SUS LOOKING AT MY CODE, HUH?
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣠⣴⣶⣿⣿⣷⣶⣄⣀⣀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⣰⣾⣿⣿⡿⢿⣿⣿⣿⣿⣿⣿⣿⣷⣦⡀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⢀⣾⣿⣿⡟⠁⣰⣿⣿⣿⡿⠿⠻⠿⣿⣿⣿⣿⣧⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⣾⣿⣿⠏⠀⣴⣿⣿⣿⠉⠀⠀⠀⠀⠀⠈⢻⣿⣿⣇⠀⠀⠀
⠀⠀⠀⠀⢀⣠⣼⣿⣿⡏⠀⢠⣿⣿⣿⠇⠀⠀⠀⠀⠀⠀⠀⠈⣿⣿⣿⡀⠀⠀
⠀⠀⠀⣰⣿⣿⣿⣿⣿⡇⠀⢸⣿⣿⣿⡀⠀⠀⠀⠀⠀⠀⠀⠀⣿⣿⣿⡇⠀⠀
⠀⠀⢰⣿⣿⡿⣿⣿⣿⡇⠀⠘⣿⣿⣿⣧⠀⠀⠀⠀⠀⠀⢀⣸⣿⣿⣿⠁⠀⠀
⠀⠀⣿⣿⣿⠁⣿⣿⣿⡇⠀⠀⠻⣿⣿⣿⣷⣶⣶⣶⣶⣶⣿⣿⣿⣿⠃⠀⠀⠀
⠀⢰⣿⣿⡇⠀⣿⣿⣿⠀⠀⠀⠀⠈⠻⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠁⠀⠀⠀⠀
⠀⢸⣿⣿⡇⠀⣿⣿⣿⠀⠀⠀⠀⠀⠀⠀⠉⠛⠛⠛⠉⢉⣿⣿⠀⠀⠀⠀⠀⠀
⠀⢸⣿⣿⣇⠀⣿⣿⣿⠀⠀⠀⠀⠀⢀⣤⣤⣤⡀⠀⠀⢸⣿⣿⣿⣷⣦⠀⠀⠀
⠀⠀⢻⣿⣿⣶⣿⣿⣿⠀⠀⠀⠀⠀⠈⠻⣿⣿⣿⣦⡀⠀⠉⠉⠻⣿⣿⡇⠀⠀
⠀⠀⠀⠛⠿⣿⣿⣿⣿⣷⣤⡀⠀⠀⠀⠀⠈⠹⣿⣿⣇⣀⠀⣠⣾⣿⣿⡇⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠹⣿⣿⣿⣿⣦⣤⣤⣤⣤⣾⣿⣿⣿⣿⣿⣿⣿⣿⡟⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠉⠻⢿⣿⣿⣿⣿⣿⣿⠿⠋⠉⠛⠋⠉⠉⠁⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠉⠉⠉⠁   
 ~~~~~~~~~~~~~~~~~~-->

</html>