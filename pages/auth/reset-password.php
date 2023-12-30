<?php
require_once './header.php';
if (isset($_GET['password-token'])) {
  $passwordToken = get_safe_value($con, $_GET['password-token']);
  reset_password($passwordToken);
}
?>
<!DOCTYPE html>
<html lang="tr" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/dist/auth/rs5f0f0e1h08v35w6a2u3.css">
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
          <label htmlFor="password_confirm">Şifreyi Onayla</label>
          <i class="fa-solid fa-lock"></i>
        </div>
        <input placeholder="********" maxlenght="16" type="password" name="password_confirm">
      </div>
      <div class="formGroup">
        <button class="superiorBtn" type="submit" name="reset-password-btn">Gönder</button>
      </div>
    </form>
  </div>
  <?php require_once './footer.php'; ?>