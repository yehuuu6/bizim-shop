export class AuthorizationClass {
    constructor(form, logger, loader, url, returnUrl, goBackTime = 2000) {
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
        const imageTag = `<span><img src='/assets/imgs/static/content/${iconPath}'/></span>`;
        
        this.logger.className = className;
        this.logger.innerHTML = `${imageTag} ${message}`;
        
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
                const response = JSON.parse(data);
                const [status, message, cause] = response;
                this.showMessage(message, status, cause);
                
                if (status === "success") {
                    setTimeout(() => {
                        window.location.href = this.returnUrl;
                    }, this.goBackTime);
                }
            },
        });
    }
}

export class SpecialAuthorizationClass extends AuthorizationClass {
    constructor(form, logger, loader, url, returnUrl, goBackTime = 2000, oldLoggerText) {
        super(form, logger, loader, url, returnUrl, goBackTime);
        this.oldLoggerText = oldLoggerText;
    }

    showMessage(message, messageType, cause) {
        super.showMessage(message, messageType, cause);

        clearTimeout(this.timer);

        this.timer = setTimeout(() => {
            this.logger.className = "logger warning";
            this.logger.innerHTML = this.oldLoggerText;
        }, 8000);
    }
}
