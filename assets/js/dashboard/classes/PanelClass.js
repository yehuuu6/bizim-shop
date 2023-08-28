export default class PanelClass {
  constructor(logger, loader) {
    this.logger = logger;
    this.loader = loader;
    this.timer = null;
    this.timer2 = null;
  }

  showMessage(data) {
    clearTimeout(this.timer);

    try {
      var response = JSON.parse(data);
      var [messageType, message, cause] = response;
    } catch (e) {
      // DANGER This is a security risk. Do not use this in production.
      var [messageType, message, cause] = ["error", data, "none"];
    }

    const iconPath =
      messageType === "success"
        ? "success.png"
        : messageType === "error"
        ? "error.png"
        : messageType === "warning"
        ? "info.png"
        : "";

    const className = `logger ${messageType}`;
    const imageTag = `<span><img src='/assets/imgs/static/content/${iconPath}'/></span>`;

    this.logger.className = className;
    this.logger.innerHTML = `${imageTag} ${message}`;

    if (cause !== "none") {
      clearTimeout(this.timer2);

      let element = document.querySelector(`[name=${cause}]`)
        ? document.querySelector(`[name=${cause}]`)
        : document.querySelector(`[id=${cause}]`);
      element.style.border = "1px solid red";

      this.timer2 = setTimeout(() => {
        element.style = "";
      }, 2000);
    }

    this.timer = setTimeout(() => {
      this.logger.className = "logger";
      this.logger.innerHTML = "";
    }, 8000);
  }

  async sendApiRequest(url, formData) {
    this.loader.style.display = "flex";

    return new Promise((resolve, reject) => {
      $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: (data) => {
          resolve(data);
        },
        error: (error) => {
          reject(error);
        },
      });
    }).finally(() => {
      this.loader.style.display = "none";
    });
  }
}
