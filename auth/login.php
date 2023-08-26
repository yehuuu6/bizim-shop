<?php
require_once './header.php';
if (isset($_SESSION['id'])) {
  header('location: /');
  exit();
}
?>
<!DOCTYPE html>
<html lang="tr" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/assets/css/auth.css">
  <link rel="shortcut icon" href="/assets/imgs/static/content/favicon.svg" type="image/x-icon">
  <script src="https://kit.fontawesome.com/7eedcf6ee7.js" crossorigin="anonymous"></script>
  <script src="/assets/js/plugins/jquery.js"></script>
  <title>Hesabınıza giriş yapın - Bizim Shop</title>
</head>

<body>
  <div class="container">
    <form id="login-form" class="form">
      <div class="header primary-color">Hesabınıza giriş yapın</div>
      <p class="placeholderText centerText">Tekrar hoş geldiniz! Hesabınıza giriş yapın.</p>
      <p class="logger"></p>
      <div class="formGroup">
        <div class="labelContainer">
          <label htmlFor="email">E-posta</label>
          <i class="fa-solid fa-user"></i>
        </div>
        <input type="email" name="email" placeholder="ornek@mail.com">
      </div>
      <div class="formGroup">
        <div class="labelContainer">
          <label htmlFor="password">Şifre</label>
          <i class="fa-solid fa-lock"></i>
        </div>
        <input type="password" name="password" placeholder="********">
      </div>
      <div class="formGroup">
        <button class="superiorBtn" type="submit" name="login-btn">Gönder</button>
      </div>
      <div class="formGroup" style="margin-top: 10px;">
        <p class="placeholderText centerText">Hesabınız yok mu? <a class="link" href='register'>Kaydolun</a></p>
        <p class="placeholderText centerText">Parolanızı mı unuttunuz? <a class="link" href='forgot-password'>Sıfırlayın</a></p>
        <p class="placeholderText centerText">veya</p>
        <a class="primaryText link centerText" href='/'>Ana sayfaya dön</a>
      </div>
    </form>
  </div>
  <?php require_once './footer.php'; ?>