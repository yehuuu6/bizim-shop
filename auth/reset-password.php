<?php
require_once './header.php';
if (isset($_GET['password-token'])) {
  $passwordToken = get_safe_value($con, $_GET['password-token']);
  resetPassword($passwordToken);
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
    <form id="reset-form" class="form">
      <div class="header primary-color">Şifre Sıfırlama</div>
      <p class="placeholderText centerText">Lütfen tahmin edilmesi zor yeni bir şifre belirleyin.</p>
      <p class="logger"></p>
      <div class="formGroup">
        <div class="labelContainer">
          <label htmlFor="password">Yeni Şifre</label>
          <i class="fa-solid fa-lock"></i>
        </div>
        <input placeholder="********" type="password" name="password">
      </div>
      <div class="formGroup">
        <div class="labelContainer">
          <label htmlFor="passwordConf">Şifreyi Onayla</label>
          <i class="fa-solid fa-lock"></i>
        </div>
        <input placeholder="********" maxlenght="16" type="password" name="passwordConf">
      </div>
      <div class="formGroup">
        <button class="superiorBtn" type="submit" name="reset-password-btn">Gönder</button>
      </div>
    </form>
  </div>
  <?php require_once './footer.php'; ?>