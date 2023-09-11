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

authorize_user();

$power = $_SESSION['membership'];
$perm_content = get_permission($power);

$sql = "SELECT name, surname, profile_image FROM users WHERE id = {$_SESSION['id']}";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res);

?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1" />
  <link rel="stylesheet" href="/dist/dashboard/du48gn1.css" />
  <script src="/global/plugins/icons.js"></script>
  <link rel="shortcut icon" href="/global/imgs/favicon.svg" type="image/x-icon">
  <title>İstatistikler - Bizim Shop Panel</title>
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
    <div class="left-bar hidden-menu">
      <ul>
        <li>
          <div class="menu-controller">
            <h3><span class="purple-text">Bizim <span class="blue-text">Shop</span></span> Panel</h3>
            <input id="menu-toggle" type="checkbox">
            <label for="menu-toggle" class="burger" title="Menü">
              <div class="line"></div>
              <div class="line"></div>
              <div class="line"></div>
            </label>
          </div>
        </li>
      </ul>
      <ul>
        <div class="list-title">
          <h3>Yönetici İşlemleri</h3>
          <hr>
        </div>
        <li>
          <div class="menu-btn active" data-name="statistics">
            İstatistikler <i class="fa-solid fa-chart-line"></i>
          </div>
        </li>
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
      </ul>
    </div>
    <div class="main-page">
      <section id="statistics" data-url="statistics" data-title="İstatistikler" class="page-content narrow-page" style="display:block;">
        <div class="content-header">
          <div class="item">
            <h2 class="header">İstatistikler</h2>
            <p>Burada sitenizin verilerini görebilirsiniz.</p>
          </div>
        </div>
        <div class="container">
          <div class="statistics-monitors">
            <div class="monitor">
              <div class="icon">
                <i class="fa-solid fa-users"></i>
              </div>
              <span class="value" id="total-users">17.8k</span>
              <h3 class="title">Kullanıcı</h3>
            </div>
            <div class="monitor">
              <div class="icon">
                <i class="fa-solid fa-boxes-stacked"></i>
              </div>
              <span class="value" id="total-products">5.3k</span>
              <h3 class="title">Ürün</h3>
            </div>
            <div class="monitor">
              <div class="icon">
                <i class="fa-solid fa-truck"></i>
              </div>
              <span class="value" id="total-orders">2.5k</span>
              <h3 class="title">Sipariş</h3>
            </div>
            <div class="monitor">
              <div class="icon">
                <i class="fa-solid fa-money-bill-trend-up"></i>
              </div>
              <span class="value" id="total-earnings">3578 TL</span>
              <h3 class="title">Kazanç</h3>
            </div>
          </div>
          <div class="intro"></div>
        </div>
      </section>
      <section id="manage-products" data-url="products" data-title="Ürünler" class="page-content narrow-page">
        <div id="loader-products" class="loader">
          <?php $loader_1 = new Loader(); ?>
        </div>
        <div class="content-header">
          <div class="item">
            <h2 class="header">Ürünleri Yönet</h2>
            <p>Burada ürünleri düzenleyebilir veya silebilirsiniz.</p>
          </div>
          <div class="item">
            <div class="controls">
              <div class="c-container">
                <button title="Ürün Ekle" class="dashboard-btn edit-btn small-btn" id="add-new-product">
                  <i class="fa-solid fa-plus"></i>
                </button>
                <button title="Yenile" class="dashboard-btn success-btn small-btn" id="refresh-products">
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
          <button class="dashboard-btn success-btn" id="load-more-products">
            Daha fazla yükle
          </button>
        </div>
      </section>
      <section id="add-product" data-url="add-product" data-title="Ürün Ekle" class="page-content narrow-page">
        <div id="loader-create" class="loader">
          <?php $loader_2 = new Loader(); ?>
        </div>
        <div class="content-header">
          <div class="item">
            <h2 id="create-product-title" class="header">Markete Ürün Ekle</h2>
            <p id="create-product-text">Yanında (*) olan alanlar zorunludur.</p>
          </div>
          <div class="item">
            <div class="controls">
              <div class="c-container">
                <button title="Düzenleme Modundan Çık" class="dashboard-btn delete-btn small-btn none-display" id="exit-edit-mode">
                  <i class="fa-solid fa-times"></i>
                </button>
                <button title="Temizle" class="dashboard-btn edit-btn small-btn" id="clean-create-form">
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
                  <button name="add-image" title="Resim Ekle" class="dashboard-btn small-btn add-image-btn">
                    <i class="fa-solid fa-plus"></i>
                  </button>
                </div>
              </div>
              <button class="dashboard-btn success-btn" type="submit" name="create-product" id="create-product">
                Ürünü Ekle
              </button>
            </div>
          </form>
        </div>
      </section>
      <section id="manage-users" data-url="users" data-title="Kullanıcıları Yönet" class="page-content narrow-page">
        <div id="loader-users" class="loader">
        <?php $loader_3 = new Loader(); ?>
        </div>
        <div class="content-header">
          <div class="item">
            <h2 class="header">Kullanıcıları Yönet</h2>
            <p>Burada kullanıcıları yönetebilirsiniz.</p>
          </div>
          <div class="item">
            <div class="controls">
              <div class="c-container">
              <button title="Yenile" class="dashboard-btn success-btn small-btn" id="refresh-users">
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
          <button class="dashboard-btn success-btn" name="load-more" id="load-more-users">
            Daha fazla yükle
          </button>
        </div>
      </section>
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
          <img src="/global/imgs/info.png" alt="Status"/>
        </span>
        <p>{message}</p>
        <div class="logger-btn">
          <button class="btn small-btn" title="Bildirimi sil" id="close-logger">
            <i class="fa-solid fa-times"></i>
          </button>
        </div>
    </div>
    <div id="main-dashboard-loader" class="loader" style="display:flex;">
      <?php $loader_4 = new Loader(); ?>
    </div>
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
  <script type="module" src="/dist/dashboard/du48gn1.js"></script>
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