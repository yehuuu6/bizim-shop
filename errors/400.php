<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="/global/imgs/logo.png" type="image/x-icon" />
  <title>Hatalı İstek - Bizim Shop</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #f5f5f5;
      font-family: 'Poppins', sans-serif;
    }

    .container {
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 2rem 4rem;
    }

    h3 {
      font-size: 25px;
      font-weight: 500;
      color: #131313;
      margin-bottom: 1rem;
    }

    h1 {
      font-size: 110px;
      font-weight: 900;
      margin: .5rem 0;
      color: #1e6dff;
    }

    p {
      font-size: 18px;
      font-weight: 400;
      color: #131313;
      line-height: 1.5;
      text-align: center;
      width: clamp(300px, 50%, 750px);
    }

    .btns {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 2.5rem;
      gap: 3rem;
    }

    .btns button {
      outline: none;
      border: 1px solid #1e6dff;
      padding: 1rem 3.3rem;
      border-radius: 9999px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      opacity: 1;
      transition: all .3s ease;
    }

    .btns button:hover {
      opacity: 0.8;
    }

    .btns .primary {
      background-color: #1e6dff;
      color: aliceblue;
    }

    .btns .secondary {
      background-color: transparent;
      font-weight: 600;
      color: #1e6dff;
    }

    img {
      width: 100%;
      max-width: 250px;
      margin-top: 8rem;
      -webkit-user-drag: none;
    }
  </style>
</head>

<body>
  <div class="container">
    <h3>bizimshop</h3>
    <h1>400</h1>
    <p>Sanırım yanlış bir şeyler yaptınız. Lütfen tekrar deneyin.</p>
    <div class="btns">
      <button class="primary" onclick="window.location.href = '/'">ANA SAYFA</button>
      <button class="secondary" onclick="window.history.back()">GERİ DÖN</button>
    </div>
    <img src="/global/imgs/astronaut.svg" alt="">
  </div>
</body>

</html>