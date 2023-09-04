<?php
define('FILE_ACCESS', TRUE);
require_once "config/authenticator.php";

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
$perm_content = getPerm($power);

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
  <link rel="stylesheet" href="/assets/css/utils.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css" />
  <script src="/global/plugins/icons.js"></script>
  <link rel="shortcut icon" href="/global/imgs/favicon.svg" type="image/x-icon">
  <title>Panel - Bizim Shop</title>
</head>

<body>
  <div class="app">
    <nav>
      <div class="header-container">
        <img class="large-svg" src="/global/imgs/favicon.svg" alt="Logo">
        <h2 class="header flex-display gap-5">Bizim <div class="blue-text">Shop</div>
        </h2>
        <input id="menu-toggle" type="checkbox">
        <label for="menu-toggle" class="burger" title="Toggle Menu">
          <div class="line"></div>
          <div class="line"></div>
          <div class="line"></div>
        </label>
      </div>
      <ul>
        <li>
          <a class="nav-link" href="/">Ana Sayfa</a>
        </li>
      </ul>
    </nav>
    <div class="main-page">
      <div class="left-bar hidden-menu">
        <ul>
          <div class="list-title">
            <h3>Kontrol Paneli</h3>
          </div>
          <li>
            <div class="menu-btn active" data-name="home">
              Hoş Geldin <i class="fa-solid fa-hand"></i>
            </div>
          </li>
          <div class="list-title">
            <h3>Kullanıcı İşlemleri</h3>
          </div>
          <li>
            <div class="menu-btn" data-name="profile">
              Hesap Ayarları <i class="fa-solid fa-user"></i>
            </div>
          </li>
          <?php if ($power > 0) : ?>
            <div class="list-title">
              <h3>Yönetici İşlemleri</h3>
            </div>
            <li>
              <div class="menu-btn" data-name="add-product">
                Ürün Ekle <i class="fa-solid fa-plus"></i>
              </div>
            </li>
            <li>
              <div class="menu-btn" data-name="products">
                Ürünler <i class="fa-solid fa-boxes-stacked"></i>
              </div>
            </li>
            <li>
              <div class="menu-btn" data-name="users">
                Kullanıcılar <i class="fa-solid fa-users"></i>
              </div>
            </li>
            <li>
              <div class="menu-btn" data-name="orders">
                Siparişler <i class="fa-solid fa-truck"></i>
              </div>
            </li>
          <?php endif; ?>
        </ul>
      </div>
      <section id="home" data-url="home" data-title="Hoş Geldin" class="page-content narrow-page" style="display: block">
        <div class="container">
          <div class="subcontainer">
            <h1 class="title">Hoş Geldin <?php echo $_SESSION['name'] ?></h1>
            <p class="subtitle">
              Burada etkinlik oluşturabilir, düzenleyebilir veya eski etkinliklerinizi
              görüntüleyebilirsiniz.
            </p>
            <button class="cta-button">Başlayalım</button>
          </div>
        </div>
      </section>
      <section id="change-user-info" data-url="profile" data-title="Profili Düzenle" class="page-content narrow-page">
        <div id="loader-profile" class="loader">
          <?php $loader1 = new Loader(); ?>
        </div>
        <div class="content-header">
          <div class="item">
            <h2 class="header">Hesap Ayarları</h2>
            <p>Burada hesap bilgilerinizi düzenleyebilirsiniz.</p>
          </div>
          <div class="item">
            <button id="password-reset" class="btn edit-btn">Şifre Sıfırlama Maili Gönder</button>
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
                  <label id="avatar-label" class="btn edit-btn" for="avatar-input">Profil Resmi Yükle</label>
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
              <button class="btn success-btn" type="submit" name="save-user" id="save-user">
                Değişiklikleri Kaydet
              </button>
            </div>
          </form>
        </div>
      </section>
      <?php if ($power > 0) : ?>
        <section id="manage-products" data-url="products" data-title="Ürünler" class="page-content narrow-page">
          <div id="loader-products" class="loader">
            <?php $loader2 = new Loader(); ?>
          </div>
          <div class="content-header">
            <div class="item">
              <h2 class="header">Ürünleri Yönet</h2>
              <p>Burada ürünleri düzenleyebilir veya silebilirsiniz.</p>
            </div>
            <div class="item">
              <div class="controls">
                <div class="c-container">
                  <button title="Ürün Ekle" class="btn edit-btn refresh" id="add-new-product">
                    <i class="fa-solid fa-plus"></i>
                  </button>
                  <button title="Yenile" class="btn success-btn refresh" id="refresh-products">
                    <i class="fa-solid fa-rotate-right"></i>
                  </button>
                </div>
                <input autocomplete="off" type="text" placeholder="Ürün ara" name="search-pr" id="search-pr" spellcheck="false" />
              </div>
            </div>
          </div>
          <div class="container">
            <table id="products-table">
              <thead>
                <tr>
                  <th width="1%">#</th>
                  <th width="1%">ID</th>
                  <th width="7%">Ad</th>
                  <th width="5%">Kategori</th>
                  <th width="5%">Fiyat</th>
                  <th width="5%">Durum</th>
                  <th width="5%">Eylemler</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            <button class="btn success-btn" id="load-more-products">
              Daha fazla yükle
            </button>
          </div>
        </section>
        <section id="add-product" data-url="add-product" data-title="Ürün Ekle" class="page-content narrow-page">
          <div id="loader-create" class="loader">
            <?php $loader3 = new Loader(); ?>
          </div>
          <div class="content-header">
            <div class="item">
              <h2 id="create-product-title" class="header">Markete Ürün Ekle</h2>
              <p id="create-product-text">Yanında (*) olan alanlar zorunludur.</p>
            </div>
            <div class="item">
              <div class="controls">
                <div class="c-container">
                  <button title="Düzenleme Modundan Çık" class="btn delete-btn refreshd none-display" id="exit-edit-mode">
                    <i class="fa-solid fa-times"></i>
                  </button>
                  <button title="Temizle" class="btn edit-btn refresh" id="clean-create-form">
                    <i class="fa-solid fa-broom"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <form id="create-form">
              <div class="second">
                <h3 class="bottom-header" style="margin: 0;">Genel Bilgiler</h3>
                <hr style="margin: 0;">
                <div class="item-wrapper">
                  <div class="form-item">
                    <label for="product-name">Ürün Adı *</label>
                    <input name="product-name" type="text" id="product-name" spellcheck="false" />
                  </div>
                  <div class="form-item">
                    <label for="product-price">Ürün Fiyatı *</label>
                    <input name="product-price" type="number" id="product-price" spellcheck="false" />
                  </div>
                </div>
                <div class="item-wrapper">
                  <div class="form-item">
                    <label for="product-category">Ürün Kategorisi *</label>
                    <select name="product-category" id="product-category">
                      <option value="1">Müzik Seti</option>
                      <option value="2">Hoparlör</option>
                      <option value="3">Plak Çalar</option>
                      <option value="4">Müzik Çalar</option>
                    </select>
                  </div>
                  <div class="form-item">
                    <label for="product-tags">Ürün Etiketleri *</label>
                    <input name="product-tags" type="text" id="product-tags" spellcheck="false" />
                  </div>
                </div>
                <label for="product-description">Ürün Açıklaması *</label>
                <textarea name="product-description" type="text" id="product-description" spellcheck="false""></textarea>
              <h3 class=" bottom-header" style="margin: 0;">Diğer Bilgiler</h3>
              <hr style="margin: 0;">
              <div class="item-wrapper">
                <div class="form-item">
                  <label for="shipment">Ücretsiz Kargo *</label>
                  <select name="shipment" id="shipment">
                    <option value="0">Hayır</option>
                    <option value="1">Evet</option>
                  </select>
                </div>
                <div class="form-item">
                  <label for="featured">Öne Çıkar *</label>
                  <select name="featured" id="featured">
                    <option value="0">Hayır</option>
                    <option value="1">Evet</option>
                  </select>
                </div>
                <div class="form-item">
                  <label for="quality">Ürün Durumu *</label>
                  <select name="quality" id="quality">
                    <option value="0">İyi Durumda</option>
                    <option value="1">Bazı Özellikler Çalışmıyor/Eksik</option>
                    <option value="2">Tamamen Bozuk</option>
                  </select>
                </div>
              </div>
              <h3 class="bottom-header" style="margin: 0;">Ürün Resimleri</h3>
              <p>1. Resim kapak resmi olarak kullanılacaktır.</p>
              <hr style="margin: 0;">
              <div class="item-wrapper">
                <div class="form-item">
                  <button name="add-image" title="Resim Ekle" class="btn small-btn block-display">
                    <i class="fa-solid fa-plus"></i>
                  </button>
                </div>
              </div>
              <button class="btn success-btn" type="submit" name="create-product" id="create-product">
                Ürünü Ekle
              </button>
            </div>
          </form>
        </div>
      </section>
      <section id="manage-users" data-url="users" data-title="Kullanıcıları Yönet" class="page-content narrow-page">
        <div id="loader-users" class="loader">
        <?php $loader4 = new Loader(); ?>
        </div>
        <div class="content-header">
          <div class="item">
            <h2 class="header">Kullanıcıları Yönet</h2>
            <p>Burada kullanıcıları yönetebilirsiniz.</p>
          </div>
          <div class="item">
            <div class="controls">
              <div class="c-container">
              <button title="Yenile" class="btn success-btn refresh" id="refresh-users">
                <i class="fa-solid fa-rotate-right"></i>
              </button>
              </div>
              <input autocomplete="off" type="text" placeholder="Kullanıcı ara" name="search-user" id="search-user" spellcheck="false" />
            </div>
          </div>
        </div>
        <div class="container">
          <table id="users-table">
            <thead>
              <tr>
                <th width="1%">#</th>
                <th width="1%">ID</th>
                <th width="3%">Kullanıcı</th>
                <th width="5%">E Posta</th>
                <th width="5%">Telefon</th>
                <th width="5%">Eylemler</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <button class="btn success-btn" name="load-more" id="load-more-users">
            Daha fazla yükle
          </button>
        </div>
      </section>
    <?php endif; ?>
    </div>
    <footer>
      <span class="perm-indicator"><?php echo $perm_content ?> | <?php echo $_SESSION['username'] ?></span>
      <div class="copyright-section">
        <p>© 2023 Bizim Shop</p>
      </div>
    </footer>
    <div class="logger">
      <div class="logger-header">
        <div class="header-item">
          <span class="flex-display justify-center align-center">
            <img src="/global/imgs/info.png" alt="Status"/>
          </span>
        <h3>{title}</h3>
        </div>
        <div class="header-item">
          <button class="btn small-btn" title="Bildirimi sil" id="close-logger">
            <i class="fa-solid fa-times"></i>
          </button>
        </div>
      </div>
      <p>{message}</p>
    </div>
  </div>
  <script src="/dist/d/dm48gfz.js"></script>
  <?php if ($power === 0) : ?>
    <script type="module" src="/dist/d/du48gn1.js"></script>
  <?php endif; ?>
  <?php if ($power > 0) : ?>
    <script type="module" src="/dist/d/da48gn2.js"></script>
  <?php endif; ?>
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