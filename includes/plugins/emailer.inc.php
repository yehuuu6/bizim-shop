<?php
if (!defined('FILE_ACCESS')) {
	header("HTTP/1.1 403 Forbidden");
	include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
	exit;
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/consts.inc.php';

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

$transport = Transport::fromDsn('smtp://' . EMAIL . ':' . PASSWORD . '@smtp.gmail.com:587');
$mailer = new Mailer($transport);

function send_verification_mail($userEmail, $token)

{
	global $mailer;
	$body =  <<<HTML
    <!DOCTYPE html>
	<html lang="tr">
	<head>
		<style>
		@import url("https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Nunito+Sans:opsz,wght@6..12,200;6..12,400&family=Orbitron&display=swap");
		</style>
	</head>
	<body
		style="
		margin: 0;
		padding: 0;
		background-color: #f3f3f3;
		font-family: 'Nunito Sans', Helvetica, Arial, sans-serif;
		"
	>
		<table
		align="center"
		border="0"
		cellpadding="0"
		cellspacing="0"
		width="100%"
		style="max-width: 600px"
		>
		<tr>
			<td align="center">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
				<td style="padding: 25px 0; text-align: center">
					<a
					href="http://localhost/main/"
					style="
						color: #6200ff;
						text-decoration: none;
						font-size: 16px;
						font-weight: bold;
					"
					>Bizim Shop</a
					>
				</td>
				</tr>
				<tr>
				<td
					style="
					background-color: #fff;
					border-radius: 5px;
					border: 2px solid #dadada;
					margin: 20px auto;
					"
				>
					<table
					align="center"
					width="100%"
					cellpadding="0"
					cellspacing="0"
					>
					<tr>
						<td style="padding: 35px">
						<h1
							style="
							color: #6200ff;
							font-size: 24px;
							margin-bottom: 20px;
							"
						>
							Hoş Geldiniz!
						</h1>
						<p>
							Bizim Shop'a hoş geldiniz!<br />E-posta adresinizi
							onaylayarak kaydınızı tamamlayabilirsiniz.
						</p>
						<p>
							<a
							href="http://localhost/auth/verify?token={$token}"
							style="
								color: #fff;
								text-decoration: none;
								background-color: #22bc66;
								border: 2px solid #22bc66;
								border-radius: 3px;
								padding: 10px 18px;
								display: inline-block;
								box-shadow: 0 2px 3px rgba(0, 0, 0, 0.2);
							"
							>Onayla</a
							>
						</p>
						<p>
							İyi günler dileriz,<br />Eğer buton çalışmıyorsa
							aşağıdaki linki tarayıcınızda açınız.
						</p>
						<a
							href="http://localhost/auth/verify?token={$token}"
							>http://localhost/auth/verify?token={$token}</a
						>
						</td>
					</tr>
					</table>
				</td>
				</tr>
				<tr>
				<td style="text-align: center">
					<p style="color: #131313; margin-top: 25px; padding-top: 25px">
					&copy; 2023 <strong>Bizim Shop</strong>. Tüm hakları saklıdır.
					</p>
				</td>
				</tr>
			</table>
			</td>
		</tr>
		</table>
	</body>
	</html>
HTML;

	$email = (new Email())
		->from(EMAIL)
		->to($userEmail)
		->subject('E-posta adresinizi onaylayın')
		->html($body);

	$mailer->send($email);
}

function send_password_reset_link($userEmail, $token)
{

	global $mailer;



	$body = <<<HTML
    <!DOCTYPE html>
<html lang="tr">
  <head>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Nunito+Sans:opsz,wght@6..12,200;6..12,400&family=Orbitron&display=swap");
    </style>
  </head>
  <body
    style="
      margin: 0;
      padding: 0;
      background-color: #f3f3f3;
      font-family: 'Nunito Sans', Helvetica, Arial, sans-serif;
    "
  >
    <table
      align="center"
      border="0"
      cellpadding="0"
      cellspacing="0"
      width="100%"
      style="max-width: 600px"
    >
      <tr>
        <td align="center">
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td style="padding: 25px 0; text-align: center">
                <a
                  href="http://localhost/main/"
                  style="
                    color: #6200ff;
                    text-decoration: none;
                    font-size: 16px;
                    font-weight: bold;
                  "
                  >Bizim Shop</a
                >
              </td>
            </tr>
            <tr>
              <td
                style="
                  background-color: #fff;
                  border-radius: 5px;
                  border: 2px solid #dadada;
                  margin: 20px auto;
                "
              >
                <table
                  align="center"
                  width="100%"
                  cellpadding="0"
                  cellspacing="0"
                >
                  <tr>
                    <td style="padding: 35px">
                      <h1
                        style="
                          color: #6200ff;
                          font-size: 24px;
                          margin-bottom: 20px;
                        "
                      >
                        Şifre Sıfırlama Talebi
                      </h1>
                      <p>
                        Bizim Shop hesabınıza şifre sıfırlama talebinde
                        bulundunuz.<br />
                        Şifrenizi sıfırlamak için aşağıdaki linke
                        tıklayabilirsiniz.
                      </p>
                      <p>
                        <a
                          href="http://localhost/auth/reset-password?password-token={$token}"
                          style="
                            color: #fff;
                            text-decoration: none;
                            background-color: #22bc66;
                            border: 2px solid #22bc66;
                            border-radius: 3px;
                            padding: 10px 18px;
                            display: inline-block;
                            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.2);
                          "
                          >Şifre Sıfırla</a
                        >
                      </p>
                      <p>
                        Eğer buton çalışmıyorsa aşağıdaki linki tarayıcınızda
                        açınız.
                      </p>
                      <a
                        href="http://localhost/auth/reset-password?password-token={$token}"
                        >http://localhost/auth/reset-password?password-token={$token}</a
                      >
                      <br />
                      <small>
                        Bu işlemi siz yapmadıysanız gönül rahatlığıyla bu
                        e-postayı silebilirsiniz.
                      </small>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td style="text-align: center">
                <p style="color: #131313; margin-top: 25px; padding-top: 25px">
                  &copy; 2023 <strong>Bizim Shop</strong>. Tüm hakları saklıdır.
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>


HTML;

	$email = (new Email())
		->from(EMAIL)
		->to($userEmail)
		->subject('Şifre sıfırlama talebi')
		->html($body);

	$mailer->send($email);
}
