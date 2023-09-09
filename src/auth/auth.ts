import {
  SpecialAuthorizationClass,
  AuthorizationClass,
} from "./classes/AuthorizationClass";

import "./auth.css";

const loader = document.querySelector(".loader") as HTMLDivElement;
const defaultLoggerText = "";

const LoginPage = new AuthorizationClass(
  document.querySelector("#login-form") as HTMLFormElement,
  document.querySelector("#login-form .logger") as HTMLParagraphElement,
  loader,
  "/api/authorization/login.php",
  "/" // return url and default go back time
);
const RegisterPage = new AuthorizationClass(
  document.querySelector("#register-form") as HTMLFormElement,
  document.querySelector("#register-form .logger") as HTMLParagraphElement,
  loader,
  "/api/authorization/register.php",
  "./verify"
);
const forgotPasswordLogger = document.querySelector(
  "#forgot-password-form .logger"
) as HTMLParagraphElement;
const ForgotPasswordPage = new SpecialAuthorizationClass(
  document.querySelector("#forgot-password-form") as HTMLFormElement,
  forgotPasswordLogger,
  loader,
  "/api/authorization/forgot-password.php",
  "./login",
  6000,
  forgotPasswordLogger ? forgotPasswordLogger.innerHTML : defaultLoggerText
);
const ResetPasswordPage = new AuthorizationClass(
  document.querySelector("#reset-form") as HTMLFormElement,
  document.querySelector("#reset-form .logger") as HTMLParagraphElement,
  loader,
  "/api/authorization/reset-password.php",
  "./login",
  6000
);

const verifyLogger = document.querySelector(
  "#verify-account-form .logger"
) as HTMLParagraphElement;
const VerifyAccountPage = new SpecialAuthorizationClass(
  document.querySelector("#verify-account-form") as HTMLFormElement,
  verifyLogger,
  loader,
  "/api/authorization/resend-verify.php",
  "#",
  3000,
  verifyLogger ? verifyLogger.innerHTML : defaultLoggerText
);

const registerForm = document.querySelector(
  "#register-form"
) as HTMLFormElement;
const loginForm = document.querySelector("#login-form") as HTMLFormElement;
const forgotPasswordForm = document.querySelector(
  "#forgot-password-form"
) as HTMLFormElement;
const resetForm = document.querySelector("#reset-form") as HTMLFormElement;
const resendVerification = document.querySelector(
  "#resend-verification"
) as HTMLAnchorElement;

if (loginForm) {
  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();
    LoginPage.sendApiRequest();
  });
}

if (registerForm) {
  registerForm.addEventListener("submit", (e) => {
    e.preventDefault();
    RegisterPage.sendApiRequest();
  });
}

if (forgotPasswordForm) {
  forgotPasswordForm.addEventListener("submit", (e) => {
    e.preventDefault();
    ForgotPasswordPage.sendApiRequest();
  });
}

if (resetForm) {
  resetForm.addEventListener("submit", (e) => {
    e.preventDefault();
    ResetPasswordPage.sendApiRequest();
  });
}

if (resendVerification) {
  resendVerification.addEventListener("click", (e) => {
    e.preventDefault();
    VerifyAccountPage.sendApiRequest();
  });
}
