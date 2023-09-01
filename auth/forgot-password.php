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
  <link rel="shortcut icon" href="/global/imgs/favicon.svg" type="image/x-icon">
  <script src="/global/plugins/icons.js"></script>
  <title>Şifremi Unuttum - Bizim Shop</title>
</head>

<body>
  <div class="container">
    <form id="forgot-password-form" class="form">
      <div class="header primary-color">Şifremi Unuttum</div>
      <div class="logger warning">
        <span><img src="/global/imgs/info.png" alt=""></span>
        Hesabınızın e-posta adresini girin.
      </div>
      <div class="formGroup">
        <div class="labelContainer">
          <label for="email">E-posta</label>
          <i class="fas fa-envelope"></i>
        </div>
        <input id="email" type="email" name="email" placeholder="ornek@mail.com">
      </div>
      <div class="formGroup">
        <button type="submit" class="superiorBtn" name="forgot-password">Gönder</button>
      </div>
      <div class="formGroup" style="margin-top: 10px;">
        <p class="placeholderText centerText">Hesabınız yok mu? <a class="link" href='register'>Kaydolun</a></p>
        <p class="placeholderText centerText">Zaten bir hesabınız var mı? <a class="link" href='login'>Giriş yapın</a></p>
        <p class="placeholderText centerText">veya</p>
        <a class="primaryText link centerText" href='/'>Ana sayfaya dön</a>
      </div>
    </form>
  </div>
  <?php require_once './footer.php'; ?>