import axios from "axios";

interface PanelClassInterface {
  logger: HTMLParagraphElement;
  loader: HTMLDivElement;
  timer: any;
  timer2: any;
}

export default class PanelClass implements PanelClassInterface {
  logger: HTMLParagraphElement;
  loader: HTMLDivElement;
  timer: any;
  timer2: any;

  constructor(logger: HTMLParagraphElement, loader: HTMLDivElement) {
    this.logger = logger;
    this.loader = loader;
    this.timer = null;
    this.timer2 = null;
  }

  showMessage(data: Array<any>) {
    clearTimeout(this.timer);

    const [messageType, message, cause] = data;

    const iconPath =
      messageType === "success"
        ? "success.png"
        : messageType === "error"
        ? "error.png"
        : messageType === "warning"
        ? "info.png"
        : "";

    const className = `logger ${messageType}`;
    const imageTag = `<span><img src='/global/imgs/${iconPath}'/></span>`;

    this.logger.className = className;
    this.logger.innerHTML = `${imageTag} ${message}`;

    if (cause !== "none") {
      clearTimeout(this.timer2);

      const element = document.querySelector(`[name=${cause}]`) as HTMLElement ||
               document.querySelector(`[id=${cause}]`) as HTMLElement;

      if (element) {
        element.style.border = "1px solid red";

        this.timer2 = setTimeout(() => {
          element.style.removeProperty('border'); // Remove the "border" property
        }, 2000);
      }
    }

    this.timer = setTimeout(() => {
      this.logger.className = "logger";
      this.logger.innerHTML = "";
    }, 8000);
  }

  async sendApiRequest(url: string, formData: FormData) {
    this.loader.style.display = "flex";

    try {
      const response = await axios({
        url: url,
        method: "post",
        data: formData,
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          "Content-Type": "multipart/form-data",
        },
      });

      return response.data;
    } catch (error) {
      throw error;
    } finally {
      this.loader.style.display = "none";
    }
  }
}
