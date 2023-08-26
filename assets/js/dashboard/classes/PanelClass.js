export class PanelClass{
    constructor(form, logger, loader, url) {
        this.form = form;
        this.logger = logger;
        this.loader = loader;
        this.url = url;
        this.timer = null;
        this.timer2 = null;
    }

    showMessage(data) {
        clearTimeout(this.timer);

        const response = JSON.parse(data);
        const [messageType, message, cause] = response;

        this.logger.className = `logger ${messageType}`;
        this.logger.innerHTML = message;

        if (cause !== "none") {
            clearTimeout(this.timer2);

            let element = document.querySelector(`[name=${cause}]`);
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

    sendApiRequest() {
        this.loader.style.display = "flex";

        $.ajax({
            url: this.url,
            type: "POST",
            data: new FormData(this.form),
            processData: false,
            contentType: false,
            success: (data) => {
                this.loader.style.display = "none";
                return data;
            },
        });
    }
}