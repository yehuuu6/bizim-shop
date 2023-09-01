import {
  SpecialAuthorizationClass,
  AuthorizationClass,
} from "./classes/AuthorizationClass";

const loader: JQuery<HTMLDivElement> = $(".loader");
const defaultLoggerText = ""

const LoginPage = new AuthorizationClass(
  $("#login-form"),
  $("#login-form .logger"),
  loader,
  "/api/authorization/login.php",
  "/" // return url and default go back time
);
const RegisterPage = new AuthorizationClass(
  $("#register-form"),
  $("#register-form .logger"),
  loader,
  "/api/authorization/register.php",
  "./verify"
);
const forgotPasswordLogger = $("#forgot-password-form .logger") as JQuery<HTMLParagraphElement>;
const ForgotPasswordPage = new SpecialAuthorizationClass(
  $("#forgot-password-form"),
  forgotPasswordLogger,
  loader,
  "/api/authorization/forgot-password.php",
  "./login",
  6000,
  forgotPasswordLogger ? forgotPasswordLogger.html() : defaultLoggerText
);
const ResetPasswordPage = new AuthorizationClass(
  $("#reset-form"),
  $("#reset-form .logger"),
  loader,
  "/api/authorization/reset-password.php",
  "./login",
  6000
);

const verifyLogger = $("#verify-account-form .logger") as JQuery<HTMLParagraphElement>;
const VerifyAccountPage = new SpecialAuthorizationClass(
  $("#verify-account-form"),
  verifyLogger,
  loader,
  "/api/authorization/resend-verify.php",
  "#",
  3000,
  verifyLogger ? verifyLogger.html() : defaultLoggerText
);

$(document).ready(function () {
  $(document).on("submit", "#login-form", function (e) {
    e.preventDefault();
    LoginPage.sendApiRequest();
  });

  $(document).on("submit", "#register-form", function (e) {
    e.preventDefault();
    RegisterPage.sendApiRequest();
  });

  $(document).on("submit", "#forgot-password-form", function (e) {
    e.preventDefault();
    ForgotPasswordPage.sendApiRequest();
  });

  $(document).on("submit", "#reset-form", function (e) {
    e.preventDefault();
    ResetPasswordPage.sendApiRequest();
  });
  $(document).on("click", "#resend-verification", function (e) {
    e.preventDefault();
    VerifyAccountPage.sendApiRequest();
  });
});
