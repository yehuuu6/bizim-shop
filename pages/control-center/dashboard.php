<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/auth.inc.php';

use Components\Utility\Loader;
use Components\Product\OrderDetails;

if (!isset($_SESSION['id'])) {
  header('location: ' . DOMAIN . '/auth/login');
  exit();
}

if ($_SESSION['verified'] == 0) {
  header("location: /auth/verify");
  die();
}

authorize_user();

$power = $_SESSION['membership'];
$perm_content = get_permission($power);

$sub_cat_query = "SELECT id, cid, name FROM subcats";
$sub_cat_query_result = mysqli_query($con, $sub_cat_query);
$sub_cat_count = mysqli_num_rows($sub_cat_query_result);

// Send sub category list to client
if ($sub_cat_count > 0) {
  while ($row = mysqli_fetch_assoc($sub_cat_query_result)) {
    // Skip Uncategorized category
    if ($row['id'] == 0) {
      continue;
    }
    $sub_cats[] = $row;
  }
}

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
  <link rel="stylesheet" href="/dist/control-center/dashboard/p2w4z9o5y8v3q6i1r7.css" />
  <script src="/global/plugins/icons.js"></script>
  <link rel="shortcut icon" href="/global/imgs/logo.png" type="image/x-icon">
  <title>İstatistikler - Bizim Shop Kontrol Merkezi</title>
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
            <img class="user-avatar" src="<?= PRODUCT_USER_SITE_PATH . $row['profile_image'] ?>?timestamp=<?= time() ?>" alt="Profil Resmi" onerror="this.src='http://bizimshop.test/global/imgs/nopp.png'" />
          </div>
        </div>
      </div>
    </nav>
    <div class="left-bar hidden-menu">
      <ul>
        <li>
          <div class="menu-controller">
            <h3>Bizim Shop</h3>
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
          <div class="menu-btn" data-name="manage-site">
            Siteyi Yönet <i class="fa-solid fa-store"></i>
          </div>
        </li>
        <li>
          <div class="menu-btn" data-name="manage-categories">
            Kategoriler <i class="fa-solid fa-list"></i>
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
        <li>
          <div class="menu-btn" data-name="questions">
            Sorular <i class="fa-solid fa-question"></i>
          </div>
        </li>
      </ul>
    </div>
    <div class="main-page">
      <section id="statistics" data-url="statistics" data-title="İstatistikler" class="page-content wide-page" style="display:block;">
        <div class="content-header">
          <div class="item">
            <h2 class="header">İstatistikler</h2>
            <p>Burada sitenizin verilerini görebilirsiniz.</p>
          </div>
          <div class="item">
            <div class="controls">
              <div class="c-container">
                <button title="Yenile" class="dashboard-btn success-btn small-btn" id="refresh-statistics">
                  <i class="fa-solid fa-rotate-right"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="container flex-display flex-column gap-10">
          <div class="management-team">
            <div class="team">
              <div class="member">
                <div class="member-image">
                  <img src="/global/imgs/nopp.png" alt="Üye Resmi" />
                </div>
                <div class="member-info">
                  <h3 class="member-name">Harun Aydın</h3>
                  <p class="member-role">Kurucu</p>
                </div>
              </div>
              <div class="member">
                <div class="member-image">
                  <?php
                  $img_src = PRODUCT_USER_SITE_PATH . $row['profile_image'] . "?timestamp=" . time();
                  ?>
                  <img src="<?= $img_src ?>" alt="Üye Resmi" />
                </div>
                <div class="member-info">
                  <h3 class="member-name">Eren Aydın</h3>
                  <p class="member-role">CEO & Geliştirici</p>
                </div>
              </div>
              <div class="member">
                <div class="member-image">
                  <img src="/global/imgs/nopp.png" alt="Üye Resmi" />
                </div>
                <div class="member-info">
                  <h3 class="member-name">Memnune Aydın</h3>
                  <p class="member-role">İnsan Kaynakları</p>
                </div>
              </div>
            </div>
          </div>
          <div class="statistics-monitors">
            <div class="monitor">
              <h3 class="title">Kullanıcılar</h3>
              <span class="value" id="total-users">783</span>
              <div class="increase">
                <i class="fa-solid fa-arrow-trend-up"></i>
                <span class="amount" id="total-users-increase">+12%</span>
              </div>
            </div>
            <div class="monitor">
              <h3 class="title">Siparişler</h3>
              <span class="value" id="total-orders">385</span>
              <div class="increase">
                <i class="fa-solid fa-arrow-trend-up"></i>
                <span class="amount" id="total-orders-increase">+23%</span>
              </div>
            </div>
            <div class="monitor">
              <h3 class="title">Yorumlar</h3>
              <span class="value" id="total-reviews">1,476</span>
              <div class="increase">
                <i class="fa-solid fa-arrow-trend-up"></i>
                <span class="amount" id="total-reviews-increase">+54%</span>
              </div>
            </div>
            <div class="monitor">
              <h3 class="title">Hasılat</h3>
              <span class="value" id="total-revenue">₺19,493</span>
              <div class="increase">
                <i class="fa-solid fa-arrow-trend-up"></i>
                <span class="amount" id="total-revenue-increase">+290%</span>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="manage-site" data-title="Siteyi Yönet" data-url="manage-site" class="page-content narrow-page">
        <div id="loader-site-options" class="loader">
          <?php new Loader(); ?>
        </div>
        <div class="content-header">
          <div class="item">
            <h2 class="header">Mağazayı Yönet</h2>
            <p>Burada siteyi bakıma alabilir veya daha fazla ayar yapabilirsiniz.</p>
          </div>
          <div class="item">
            <div class="controls">
              <div class="c-container">
                <button style="padding:0.45rem 1rem;" id="maintenance-btn" class="dashboard-btn status-btn">
                  <?php if ($_SESSION['maintenance'] === "false") : ?>
                    Bakım Moduna Al
                  <?php else : ?>
                    Bakım Modundan Çık
                  <?php endif; ?>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="edit-promotion-modal-container" style="display: none;">
          <form class="edit-promotion" id="edit-promotion">
            <button class="close-edit-promotion">
              <i class="fa-solid fa-times"></i>
            </button>
            <h3 style="margin: 0; color:var(--text-color)">Promosyonu Düzenle</h3>
            <div class="edit-promotion-content">
              <div class="group">
                <input type="text" name="promotion-title" id="promotion-title" placeholder="Başlık" />
              </div>
              <div class="group">
                <input type="text" name="promotion-desc" id="promotion-desc" placeholder="Açıklama" />
              </div>
              <div class="group">
                <label for="promotion-image" class="dashboard-btn add-image-btn">
                  Resim Ekle
                </label>
                <input hidden type="file" name="promotion-image" id="promotion-image" accept="image/*" />
              </div>
            </div>
            <div class="edit-promotion-content">
              <div class="group" style="width: 100%;">
                <input type="text" name="promotion-redirect-first" id="promotion-redirect-first" placeholder="Ana hedef" />
              </div>
              <div class="group" style="width: 100%;">
                <input type="text" name="promotion-redirect-second" id="promotion-redirect-second" placeholder="İkincil hedef" />
              </div>
            </div>
            <div class="group-hor">
              <button class="dashboard-btn success-btn" id="save-promotion">
                Kaydet
              </button>
              <button class="dashboard-btn status-btn" id="delete-promotion">
                Önizleme
              </button>
            </div>
          </form>
        </div>
        <div class="container">
          <div class="form-content">
            <h3 class="bottom-header" style="margin: 0;">Promosyonlar</h3>
            <hr style="margin: 0;">
            <div class="control-promotions">
              <div class="promotion dynamic content">
                <div class="promotion-image" style="background-image: radial-gradient(circle farthest-corner at 10% 20%,rgba(166, 239, 253, 1) 0%,rgba(97, 186, 255, 1) 90.1%);">
                  <img src="/global/imgs/promotions/showcase-product.png" alt="Promosyon" />
                </div>
                <div class="promotion-info">
                  <h3 class="promotion-title">WH-1000XM3</h3>
                  <p class="promotion-description">Sony Gürültü Önleyici Kulaklık</p>
                  <button data-num="1" class="dashboard-btn edit-btn">Düzenle</button>
                </div>
              </div>
              <div class="promotion dynamic content">
                <div class="promotion-image" style="background-image: radial-gradient(circle farthest-corner at 22.4% 21.7%, rgba(4, 189, 228, 1) 0%, rgba(2, 83, 185, 1) 100.2%);">
                  <img src="/global/imgs/promotions/fixing.png" alt="Promosyon" />
                </div>
                <div class="promotion-info">
                  <h3 class="promotion-title">Yardım mı lazım?</h3>
                  <p class="promotion-description">Bozuk Cihazınızı Tamir Edebiliriz!</p>
                  <button data-num="2" class="dashboard-btn edit-btn">Düzenle</button>
                </div>
              </div>
              <div class="promotion dynamic content">
                <div class="promotion-image" style="background-image: linear-gradient(90.5deg, rgba(255, 207, 139, 0.5) 1.1%, rgba(255, 207, 139, 1) 81.3%)">
                  <img src="/global/imgs/promotions/buying.png" alt="Promosyon" />
                </div>
                <div class="promotion-info">
                  <h3 class="promotion-title">Kullanmadığınız cihaz mı var?</h3>
                  <p class="promotion-description">Onları Bize Satın!</p>
                  <button data-num="3" class="dashboard-btn edit-btn">Düzenle</button>
                </div>
              </div>
            </div>
          </div>
          <div class="form-content">
            <h3 class="bottom-header" style="margin: 0;">Panolar</h3>
            <hr style="margin: 0;">
          </div>
        </div>
      </section>
      <section id="manage-categories" data-title="Kategorileri Yönet" data-url="manage-categories" class="page-content narrow-page">
        <div id="loader-categories" class="loader">
          <?php new Loader(); ?>
        </div>
        <div class="content-header">
          <div class="item">
            <h2 class="header">Kategoriler</h2>
            <p>Burada sitenizde bulunan kategorileri kontrol edebilir ve düzenleyebilirsiniz.</p>
          </div>
          <div class="item">
            <div class="controls">
              <input type="text" placeholder="Yeni kategori oluştur" name="new-category-name" id="new-category-name" spellcheck="false" autocomplete="off" required maxlength="20" />
              <div class="c-container">
                <button title="Kategori oluştur" class="dashboard-btn success-btn small-btn" id="add-category-btn">
                  <i class="fa-solid fa-plus"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="form-content">
            <h3 class="bottom-header" style="margin: 0;">Mevcut Kategoriler</h3>
            <hr style="margin: 0;">
            <div class="item-wrapper">
              <div class="form-item">
                <div class="category-wrapper">
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="manage-products" data-url="products" data-title="Ürünler" class="page-content narrow-page">
        <div id="loader-products" class="loader">
          <?php new Loader(); ?>
        </div>
        <div class="content-header">
          <div class="item">
            <h2 class="header">Ürünleri Yönet</h2>
            <p>Burada ürünleri düzenleyebilir veya silebilirsiniz.</p>
          </div>
          <div class="item">
            <div class="controls">
              <div class="c-container">
                <button title="Ürün Ekle" class="dashboard-btn add-image-btn small-btn" id="add-new-product">
                  <i class="fa-solid fa-plus"></i>
                </button>
                <button title="Sayfanın en altına git" class="dashboard-btn edit-btn small-btn" onclick="window.scrollTo(0, document.body.scrollHeight)">
                  <i class="fa-solid fa-arrow-down"></i>
                </button>
                <button title="Filtreler" class="dashboard-btn status-btn small-btn" id="product-filters-btn" onclick="document.querySelector('.filter-container').style.display = 'flex'">
                  <i class="fa-solid fa-filter"></i>
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
          <div class="filter-container">
            <form class="filters">
              <button class="close-filters">
                <i class="fa-solid fa-times"></i>
              </button>
              <div class="filter-group">
                <div class="filter-item">
                  <label for="filter-sort">Sıralama</label>
                  <select name="filter-sort" id="filter-sort">
                    <option value="id ASC">En Eski</option>
                    <option value="id DESC">En Yeni</option>
                    <option value="price ASC">Fiyat (Artan)</option>
                    <option value="price DESC">Fiyat (Azalan)</option>
                  </select>
                </div>
                <div class="filter-item">
                  <label for="filter-category">Kategori</label>
                  <select name="filter-category" id="filter-category">
                    <option value="">Hepsi</option>
                    <option value="0">Kategorisiz</option>
                    <?php
                    foreach ($sub_cats as $sub_cat) {
                      echo "<option value='{$sub_cat['id']}'>{$sub_cat['name']}</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="filter-group">
                <div class="filter-item">
                  <label for="filter-featured">Öne Çıkan</label>
                  <select name="filter-featured" id="filter-featured">
                    <option value="">Hepsi</option>
                    <option value="1">Evet</option>
                    <option value="0">Hayır</option>
                  </select>
                </div>
                <div class="filter-item">
                  <label for="filter-shipment">Ücretsiz Kargo</label>
                  <select name="filter-shipment" id="filter-shipment">
                    <option value="">Hepsi</option>
                    <option value="1">Evet</option>
                    <option value="0">Hayır</option>
                  </select>
                </div>
              </div>
              <div class="filter-item">
                <label for="filter-status">Durum</label>
                <select name="filter-status" id="filter-status">
                  <option value="">Hepsi</option>
                  <option value="0">Arşivlenen</option>
                  <option value="1">Listelenen</option>
                </select>
              </div>
              <div class="filter-item">
                <label for="filter-price-min">Fiyat Aralığı</label>
                <div class="filter-group">
                  <input type="number" name="filter-price-min" id="filter-price-min" placeholder="Min" />
                  <input type="number" name="filter-price-max" id="filter-price-max" placeholder="Max" />
                </div>
              </div>
              <div class="filter-group">
                <button class="dashboard-btn success-btn" id="apply-filters">
                  Uygula
                </button>
                <button class="dashboard-btn edit-btn gap-5" id="clear-filters" title="Filtreleri Temizle">
                  <i class="fa-solid fa-broom"></i> Temizle
                </button>
              </div>
            </form>
          </div>
          <table id="products-table">
            <thead>
              <tr>
                <th width="1%">#</th>
                <th width="7%">Ad</th>
                <th width="5%">Kategori</th>
                <th width="5%">Fiyat <small>(KDV dahil)</small></th>
                <th width="5%">Durum</th>
                <th width="5%">Eylemler</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <button class="dashboard-btn success-btn" id="load-more-products" style="margin-top:10px;">
          Daha fazla yükle
        </button>
      </section>
      <section id="add-product" data-url="add-product" data-title="Ürün Ekle" class="page-content narrow-page">
        <div id="loader-create" class="loader">
          <?php new Loader(); ?>
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
            <div class="form-content">
              <h3 class="bottom-header" style="margin: 0;">Genel Bilgiler</h3>
              <hr style="margin: 0;">
              <div class="item-wrapper">
                <div class="form-item">
                  <label for="product-name">Ürün Adı *</label>
                  <input autocomplete="off" name="product-name" type="text" id="product-name" spellcheck="false" />
                </div>
                <div class="form-item">
                  <label for="product-sub-category">Ürün Kategorisi *</label>
                  <select name="product-sub-category" id="product-sub-category">
                  </select>
                </div>
                <div class="form-item">
                  <label for="product-tags">Ürün Etiketleri *</label>
                  <input autocomplete="off" name="product-tags" type="text" id="product-tags" spellcheck="false" />
                </div>
              </div>
              <label for="product-description">Ürün Açıklaması *</label>
              <textarea name="product-description" type="text" id="product-description" spellcheck="false"></textarea>
              <h3 class="bottom-header" style="margin: 0;">Fiyat Bilgileri</h3>
              <hr style="margin: 0;">
              <div class="item-wrapper">
                <div class="form-item">
                  <label for="product-price">Ürün Ücreti *</label>
                  <input name="product-price" step="0.01" type="number" id="product-price" autocomplete="off" />
                </div>
                <div class="form-item">
                  <label for="shipping-cost">Kargo Ücreti *</label>
                  <input name="shipping-cost" step="0.01" type="number" id="shipping-cost" />
                </div>
              </div>
              <h3 class="bottom-header" style="margin: 0;">Diğer Bilgiler</h3>
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
          <?php new Loader(); ?>
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
                <th width="3%">Kullanıcı</th>
                <th width="5%">E Posta</th>
                <th width="5%">Telefon</th>
                <th width="5%">Eylemler</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <button class="dashboard-btn success-btn" name="load-more" id="load-more-users" style="margin-top:10px;">
          Daha fazla yükle
        </button>
      </section>
      <section id="manage-orders" data-url="orders" data-title="Siparişler" class="page-content narrow-page">
        <div id="loader-orders" class="loader">
          <?php new Loader(); ?>
        </div>
        <div class="content-header">
          <div class="item">
            <h2 class="header">Siparişleri Yönet</h2>
            <p>Burada verilen siparişleri yönetebilirsiniz.</p>
          </div>
          <div class="item">
            <div class="controls">
              <div class="c-container">
                <button title="Yenile" class="dashboard-btn success-btn small-btn" id="refresh-orders">
                  <i class="fa-solid fa-rotate-right"></i>
                </button>
              </div>
              <input autocomplete="off" type="text" placeholder="Sipariş ara" name="search-order" id="search-order" spellcheck="false" />
            </div>
          </div>
        </div>
        <div class="container">
          <table id="orders-table">
            <thead>
              <tr>
                <th width="1%">#</th>
                <th width="5%">Alıcı</th>
                <th width="20%">Ürün</th>
                <th width="5%">Tutar</th>
                <th width="5%">Durum</th>
                <th width="5%">Tarih</th>
                <th width="10%">Eylemler</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <button class="dashboard-btn success-btn" name="load-more" id="load-more-orders" style="margin-top:10px;">
          Daha fazla yükle
        </button>
      </section>
      <section id="manage-questions" data-url="questions" data-title="Sorular" class="page-content narrow-page">
        <div id="loader-questions" class="loader">
          <?php new Loader(); ?>
        </div>
        <div class="content-header">
          <div class="item">
            <h2 class="header">Soruları Gözden Geçir</h2>
            <p>Burada ürünlere gelen soruları görebilir ve yanıtlayabilirsiniz.</p>
          </div>
          <div class="item">
            <div class="controls">
              <div class="c-container">
                <button title="Yenile" class="dashboard-btn success-btn small-btn" id="refresh-questions">
                  <i class="fa-solid fa-rotate-right"></i>
                </button>
              </div>
              <input autocomplete="off" type="text" placeholder="Soru ara" name="search-question" id="search-question" spellcheck="false" />
            </div>
          </div>
        </div>
        <div class="container">
          <table id="questions-table">
            <thead>
              <tr>
                <th width="1%">#</th>
                <th width="8%">Soran</th>
                <th width="10%">Ürün</th>
                <th width="7%">Tarih</th>
                <th width="7%">Durum</th>
                <th width="10%">Eylemler</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <button class="dashboard-btn success-btn" name="load-more" id="load-more-questions" style="margin-top:10px;">
          Daha fazla yükle
        </button>
      </section>
    </div>
    <footer>
      <div class="copyright-section">
        <span>Tüm hakları saklıdır
        </span>
        <p>© 2024 Bizim Shop</p>
      </div>
    </footer>
    <div class="logger">
      <span class="flex-display justify-center align-center">
        <img src="/global/imgs/icons/info.png" alt="Status" />
      </span>
      <p>{message}</p>
      <button id="close-logger">
        <i class="fa-solid fa-times"></i>
      </button>
    </div>
    <div id="main-loader" class="loader" style="display:flex;">
      <?php new Loader(); ?>
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
                <img src="/global/imgs/dashboard/light.png" alt="">
              </div>
              <div class="theme-info">
                <input type="radio" id="light-theme">
                <label class="theme-title">Açık Tema</label>
              </div>
            </div>
            <div class="theme-item" data-theme="dark">
              <div class="theme-img">
                <img src="/global/imgs/dashboard/dark.png" alt="">
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
  <script src="/dist/control-center/dashboard/p2w4z9o5y8v3q6i1r7.js"></script>
</body>

</html>