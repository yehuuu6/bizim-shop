<?php
define("BYPASS_MAINTENANCE", TRUE);
require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");
?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="/global/imgs/favicon.svg" type="image/x-icon" />
  <title>Bakımdayız - Bizim Shop</title>
  <style>
    body {
      background-color: #f1f1f1;
      font-family: "Poppins", sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      text-align: center;
      box-shadow: 0 0.46875rem 2.1875rem rgba(4, 9, 20, 0.03),
        0 0.9375rem 1.40625rem rgba(4, 9, 20, 0.03),
        0 0.25rem 0.53125rem rgba(4, 9, 20, 0.05),
        0 0.125rem 0.1875rem rgba(4, 9, 20, 0.03);
      background-color: #fff;
      padding: 5rem;
    }

    h1 {
      font-size: 48px;
      margin-bottom: 20px;
    }

    p {
      font-size: 24px;
      margin-bottom: 30px;
    }

    a {
      color: #000;
      text-decoration: underline;
    }

    .btn {
      background-color: #333;
      font-weight: 600;
      color: aliceblue;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      opacity: 0.8;
      transition: opacity 0.3s ease;
    }

    .btn:hover {
      opacity: 1;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>503: Bakımdayız</h1>
    <p>
      Size daha iyi hizmet verebilmek için çalışıyoruz. Lütfen daha sonra
      tekrar deneyin.
    </p>
    <?php if (isset($_SESSION['id'])) : ?>
      <a href="?logout=1" class="btn">Çıkış Yap</a>
    <?php else : ?>
      <a href="/auth/login" class="btn">Giriş Yap</a>
    <?php endif; ?>
  </div>
</body>

</html>