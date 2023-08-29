<?php
require_once './header.php';
if (isset($_SESSION['id'])) {
  header('location: /');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/assets/css/auth.css">
  <link rel="shortcut icon" href="/global/imgs/favicon.svg" type="image/x-icon">
  <script src="/global/plugins/icons.js"></script>
  <script src="/global/plugins/jquery.js"></script>
  <title>Kayıt Ol - Bizim Shop</title>
</head>

<body>
  <div class="container">
    <form id="register-form" class="form">
      <div class="header primary-color">Kayıt Ol</div>
      <p class="placeholderText centerText">Aşağıdaki formu doldurarak kayıt olabilirsiniz.</p>
      <p class="logger"></p>
      <div class="formTogether">
        <div class="formGroup">
          <div class="labelContainer">
            <label htmlFor="name">Adı</label>
            <i class="fa-solid fa-user"></i>
          </div>
          <input type="text" name="name" placeholder="John">
        </div>
        <div class="formGroup">
          <div class="labelContainer">
            <label htmlFor="surname">Soyadı</label>
            <i class="fa-solid fa-user"></i>
          </div>
          <input type="text" name="surname" placeholder="Doe">
        </div>
      </div>
      <div class="formGroup">
        <div class="labelContainer">
          <label htmlFor="email">E-posta</label>
          <i class="fa-solid fa-envelope"></i>
        </div>
        <input type="email" name="email" placeholder="ornek@mail.com">
      </div>
      <div class="formGroup">
        <div class="labelContainer">
          <label htmlFor="password">Şifre</label>
          <i class="fa-solid fa-lock"></i>
        </div>
        <input maxlenght="16" type="password" placeholder="********" name="password">
      </div>
      <div class="formGroup">
        <div class="labelContainer">
          <label htmlFor="passwordConf">Şifreyi Onayla</label>
          <i class="fa-solid fa-lock"></i>
        </div>
        <input maxlenght="16" type="password" placeholder="********" name="passwordConf">
      </div>
      <div class="formGroup">
        <button type="submit" class="superiorBtn" name="signup-btn">Gönder</button>
      </div>
      <div class="formGroup" style="margin-top: 10px;">
        <p class="placeholderText centerText">Zaten bir hesabınız var mı? <a class="link" href='login'>Giriş yapın</a></p>
        <p class="placeholderText centerText">veya</p>
        <a class="primaryText link centerText" href='/'>Ana sayfaya dön</a>
      </div>
    </form>
  </div>
  <?php require_once './footer.php'; ?>