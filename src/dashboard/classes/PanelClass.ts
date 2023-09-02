import axios from "axios";

interface PanelClassInterface {
  logger: HTMLDivElement;
  loader: HTMLDivElement;
  timer: any;
  timer2: any;
}

export default class PanelClass implements PanelClassInterface {
  logger: HTMLDivElement;
  loader: HTMLDivElement;
  timer: any;
  timer2: any;

  constructor(loader: HTMLDivElement) {
    this.loader = loader;
    this.timer = null;
    this.timer2 = null;
    this.logger = document.querySelector(".logger") as HTMLDivElement;
  }

  clearLogger() {
      this.logger.className = "logger";
  }

  showMessage(data: Array<string>) {
    clearTimeout(this.timer);

    const [messageType, message, cause] = data;

    this.logger.className = `logger ${messageType}`;
    const logTitle = this.logger.querySelector("h3") as HTMLHeadingElement;
    const logImage = this.logger.querySelector("img") as HTMLImageElement;
    const logMessage = this.logger.querySelector("p") as HTMLParagraphElement;

    const imageSrc =
      messageType === "success"
        ? "/global/imgs/success.png"
        : messageType === "warning"
        ? "/global/imgs/info.png"
        : "/global/imgs/error.png";

    logTitle.innerText = messageType === "success" ? "Başarılı" : messageType === "warning" ? "Uyarı" : "Hata";
    logImage.src = imageSrc;
    logMessage.innerText = message;

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
      this.clearLogger();
    }, 6000);
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
