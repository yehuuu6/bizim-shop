import axios from "axios";

import IAuthController from "@/common/interfaces/controllers/IAuthController";

export class AuthController implements IAuthController {
  form: HTMLFormElement;
  logger: HTMLParagraphElement;
  loader: HTMLDivElement;
  url: string;
  returnUrl: string;
  goBackTime: number;
  timer: any;
  timer2: any;
  oldLoggerText: string | undefined;

  constructor(
    form: HTMLFormElement,
    logger: HTMLParagraphElement,
    loader: HTMLDivElement,
    url: string,
    returnUrl: string,
    goBackTime = 3000
  ) {
    this.form = form;
    this.logger = logger;
    this.loader = loader;
    this.url = url;
    this.returnUrl = returnUrl;
    this.goBackTime = goBackTime;
    this.timer = null;
    this.timer2 = null;
  }

  showMessage(message: string, messageType: string, cause: string) {
    clearTimeout(this.timer);

    const iconPath = messageType === "success" ? "success.png" : "error.png";
    const className = `logger ${messageType}`;
    const imageTag = `<span><img src='/global/imgs/icons/${iconPath}'/></span>`;

    this.logger.className = className;
    this.logger.innerHTML = `${imageTag} ${message}`;

    if (cause !== "none") {
      clearTimeout(this.timer2);

      const element =
        (document.querySelector(`[name=${cause}]`) as HTMLElement) ||
        (document.querySelector(`[id=${cause}]`) as HTMLElement);
      element.style.border = "1px solid red";

      this.timer2 = setTimeout(() => {
        element.style.border = "1px solid #dadada";
      }, 2000);
    }

    this.timer = setTimeout(() => {
      this.logger.className = "logger";
      this.logger.innerHTML = "";
    }, 8000);
  }

  showCountdown() {
    let i = this.goBackTime / 1000;
    this.logger.innerHTML += `<span> ${i}</span>`;
    const timer = setInterval(() => {
      i--;
      (this.logger.lastElementChild as HTMLSpanElement).textContent = String(i); // Update the span's text content
      if (i === -1) {
        clearInterval(timer);
      }
    }, 1000);
  }

  sendApiRequest() {
    this.loader.style.display = "flex";

    axios({
      url: this.url,
      method: "post",
      data: new FormData(this.form),
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    })
      .then((response) => {
        //console.log(response); Enable this when error occurs
        this.loader.style.display = "none";
        const [status, message, cause] = response.data;
        this.showMessage(message, status, cause);

        if (status === "success") {
          this.oldLoggerText === undefined ? this.showCountdown() : null;
          setTimeout(() => {
            window.location.href = this.returnUrl;
          }, this.goBackTime);
        }
      })
      .catch((error) => {
        // Handle error here DANGER Security issue
        this.showMessage(error.message, "error", "none");
      });
  }
}

export class SpecialAuthController extends AuthController {
  constructor(
    form: HTMLFormElement,
    logger: HTMLParagraphElement,
    loader: HTMLDivElement,
    url: string,
    returnUrl: string,
    goBackTime = 2000,
    oldLoggerText: string
  ) {
    super(form, logger, loader, url, returnUrl, goBackTime);
    this.oldLoggerText = oldLoggerText;
  }

  showMessage(message: string, messageType: string, cause: string) {
    super.showMessage(message, messageType, cause);

    clearTimeout(this.timer);

    this.timer = setTimeout(() => {
      this.logger.className = "logger warning";
      this.logger.innerHTML = this.oldLoggerText!;
    }, 8000);
  }
}
