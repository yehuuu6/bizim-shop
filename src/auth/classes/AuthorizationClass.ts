import axios from "axios";
import $ from "jquery";

interface AuthorizationClassInterface {
  form: JQuery<HTMLFormElement>;
  logger: JQuery<HTMLParagraphElement>;
  loader: JQuery<HTMLDivElement>;
  url: string;
  returnUrl: string;
  goBackTime: number;
  timer: any;
  timer2: any;
}

export class AuthorizationClass implements AuthorizationClassInterface {
  form: JQuery<HTMLFormElement>;
  logger: JQuery<HTMLParagraphElement>;
  loader: JQuery<HTMLDivElement>;
  url: string;
  returnUrl: string;
  goBackTime: number;
  timer: any;
  timer2: any;
  oldLoggerText: string | undefined;

  constructor(form: JQuery<HTMLFormElement>, logger: JQuery<HTMLParagraphElement>, loader: JQuery<HTMLDivElement>,
    url: string, returnUrl: string, goBackTime = 3000) {
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
    const imageTag = `<span><img src='/global/imgs/${iconPath}'/></span>`;

    this.logger.attr("class", className);
    this.logger.html(imageTag + message);

    if (cause !== "none") {
      clearTimeout(this.timer2);

      let element = $(`[name="${cause}"]`);
      element.css("border", "1px solid red");

      this.timer2 = setTimeout(() => {
        element.css("border", "1px solid #dadada");
      }, 2000);
    }

    this.timer = setTimeout(() => {
      this.logger.attr("class", "logger");
      this.logger.html("");
    }, 8000);
  }

  showCountdown() {
    let i = this.goBackTime / 1000;
    this.logger.append(`<span> ${i}</span>`);

    const timer = setInterval(() => {
      i--;
      this.logger.children().last().text(i);
      if (i === 0) {
        clearInterval(timer);
      }
    }, 1000);
  }

  sendApiRequest() {
    this.loader.css("display", "flex");

    axios({
      url: this.url,
      method: "post",
      data: new FormData(this.form[0]),
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    })
      .then((response) => {
        this.loader.css("display", "none");
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

export class SpecialAuthorizationClass extends AuthorizationClass {
  constructor(
    form: JQuery<HTMLFormElement>,
    logger: JQuery<HTMLParagraphElement>,
    loader: JQuery<HTMLDivElement>,
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
      this.logger.attr("class", "logger warning");
      this.logger.html(this.oldLoggerText!);
    }, 8000);
  }
}
