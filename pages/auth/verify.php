<?php
require_once './header.php';
if (isset($_GET['token'])) {
  $token = get_safe_value($con, $_GET['token']);
  verify_user($token);
}
if (!isset($_SESSION['id'])) {
  header('location: /');
  exit();
}

if (($_SESSION['verified'] == 1)) {
  header('location: /');
  exit();
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/dist/auth/rs5f0f0e1h08v35w6a2u3.css">
  <link rel="shortcut icon" href="/global/imgs/logo.png" type="image/x-icon">
  <script src="/global/plugins/icons.js"></script>
  <title>E-posta Onayı - Bizim Shop</title>
</head>

<body>
  <div class="container">
    <?php if ($_SESSION['verified'] == 0) : ?>
      <form id="verify-account-form" class="form">
        <div class="header primary-color">Hoş Geldiniz <?php echo $_SESSION['username']; ?></div>
        <div class="logger warning">
          <span><img src="/global/imgs/icons/info.png" alt=""></span>
          <p>Sitede gezinmeden önce e-posta adresinizi onaylamanız gerekiyor. Spam klasörünüzü kontrol edin!
            <strong><?php echo $_SESSION['email']; ?></strong>
          </p>
        </div>
        <div class="formGroup">
          <button id="logout-btn" class="superiorBtn">
            Çıkış Yap
          </button>
        <?php endif; ?>
        </div>
        <div class="formGroup" style="margin-top: 10px;">
          <p class="placeholderText centerText">Doğrulama e-postası almadınız mı? <a class="link" id="resend-verification" href="#">Tekrar gönder</a></p>
        </div>
      </form>
  </div>
  <script>
    document.querySelector("#logout-btn").addEventListener("click", (e) => {
      e.preventDefault();
      window.location.href = "/?logout=1";
    });
  </script>
  <?php require_once './footer.php'; ?>