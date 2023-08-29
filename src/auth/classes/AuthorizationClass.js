export class AuthorizationClass {
  constructor(form, logger, loader, url, returnUrl, goBackTime = 3000) {
    this.form = form;
    this.logger = logger;
    this.loader = loader;
    this.url = url;
    this.returnUrl = returnUrl;
    this.goBackTime = goBackTime;
    this.timer = null;
    this.timer2 = null;
  }

  showMessage(message, messageType, cause) {
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

  sendApiRequest() {
    this.loader.css("display", "flex");

    $.ajax({
      url: this.url,
      type: "POST",
      data: new FormData(this.form[0]),
      processData: false,
      contentType: false,
      success: (data) => {
        this.loader.css("display", "none");
        const response = JSON.parse(data);
        const [status, message, cause] = response;
        this.showMessage(message, status, cause);

        if (status === "success") {
          // If not SpecialAuthorizationClass
          if (this.oldLoggerText === undefined) {
            let i = this.goBackTime / 1000;
            this.logger.append(`<span> ${i}</span>`);

            const timer = setInterval(() => {
              i--;
              this.logger.children().last().text(i); // Update the span's text content
              if (i === 0) {
                clearInterval(timer);
              }
            }, 1000);
          }
          setTimeout(() => {
            window.location.href = this.returnUrl;
          }, this.goBackTime);
        }
      },
    });
  }
}

export class SpecialAuthorizationClass extends AuthorizationClass {
  constructor(
    form,
    logger,
    loader,
    url,
    returnUrl,
    goBackTime = 2000,
    oldLoggerText
  ) {
    super(form, logger, loader, url, returnUrl, goBackTime);
    this.oldLoggerText = oldLoggerText;
  }

  showMessage(message, messageType, cause) {
    super.showMessage(message, messageType, cause);

    clearTimeout(this.timer);

    this.timer = setTimeout(() => {
      this.logger.attr("class", "logger warning");
      this.logger.html(this.oldLoggerText);
    }, 8000);
  }
}
