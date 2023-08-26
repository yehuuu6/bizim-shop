// Create modal to handle confirmations
const modal = document.createElement("div");
modal.classList.add("delete-modal");
const delCon = document.createElement("div");
const modTitle = document.createElement("h1");
modTitle.innerText = "Uyarı!";
modTitle.classList.add("delete-modal-title");
const lineBreak = document.createElement("hr");
lineBreak.classList.add("delete-modal-line");
delCon.classList.add("delete-modal-content");
const delModText = document.createElement("p");
const delModWarn = document.createElement("strong");
delModWarn.innerText = "BU EYLEM GERİ ALINAMAZ.";
delModWarn.classList.add("warn");
const delModBtns = document.createElement("div");
const delSpan = document.createElement("span");
delModBtns.classList.add("delete-modal-btns");
const delModCan = document.createElement("button");
delModCan.classList.add("btn", "success-btn");
delSpan.innerText = "Devam et?";
delModCan.innerText = "Hayır";
const delModCon = document.createElement("button");
delModCon.classList.add("btn", "delete-btn");
delModCon.innerText = "Evet";
delModBtns.append(delModCon, delModCan);
delCon.append(
  modTitle,
  lineBreak.cloneNode(),
  delModText,
  lineBreak.cloneNode(),
  delModWarn,
  lineBreak.cloneNode(),
  delSpan,
  delModBtns
);
modal.append(delCon);

// Close delete modal when cancel button or outside of modal is clicked
delModCan.addEventListener("click", () => {
  modal.remove();
});
modal.addEventListener("click", (e) => {
  if (e.target === modal) {
    modal.remove();
  }
});

// Variables

const profileInput = document.querySelector("#avatar-input");
const profileImage = document.querySelector("#profile-image");
const userLoad = document.querySelector("#loader-profile");
const userLogger = document.querySelector("#logger-profile");

// FUNCTIONS START

let errorTimeout;

function ShowMessage(logger, message, messageType, cause) {
  clearTimeout(errorTimeout);
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

  logger.className = className;
  logger.innerHTML = `${imageTag} ${message}`;

  if (cause !== "none") {
    let element = document.querySelector(`#${cause}`);
    element.style.border = "1px solid red";
    setTimeout(() => {
      element.style = "";
    }, 2000);
  }

  errorTimeout = setTimeout(() => {
    logger.className = "logger";
    logger.innerHTML = "";
  }, 8000);
}

function trimSentence(sentence, maxLength) {
  if (sentence.length > maxLength) {
    sentence = sentence.substring(0, maxLength - 3) + "...";
  }
  return sentence;
}

function get_date(raw) {
  const [year, month_t, day] = raw.split("-");
  const month_names = [
    "Jan",
    "Feb",
    "March",
    "April",
    "May",
    "June",
    "July",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ];
  const month = month_names[Number(month_t) - 1];
  const day_trimmed = Number(day).toString();
  return `${month} ${day_trimmed}, ${year}`;
}

// FUNCTIONS END

$(document).ready(function () {
  $("#profile-form").submit(function (e) {
    e.preventDefault();
    userLoad.style.display = "flex";
    let formData = new FormData(this);
    $.ajax({
      url: "/api/dashboard/users/edit-profile.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (data) {
        $("html, body").animate({ scrollTop: $(document).height() }, 1000);
        let phpArray = JSON.parse(data);
        let status = phpArray[0];
        let message = phpArray[1];
        let cause = phpArray[2];
        if (status == "success") {
          $("#avatar-input").val("");
          profileInput.parentElement.querySelector(".display-file").innerText =
            "Dosya seçilmedi.";
        }
        ShowMessage(userLogger, message, status, cause);
        userLoad.style.display = "none";
      },
    });
  });
  $("#password-reset").click(function (e) {
    e.preventDefault();
    userLoad.style.display = "flex";
    $.ajax({
      url: "/api/dashboard/users/reset-password.php",
      type: "POST",
      processData: false,
      contentType: false,
      success: function (data) {
        let phpArray = JSON.parse(data);
        let status = phpArray[0];
        let message = phpArray[1];
        ShowMessage(userLogger, message, status, "none");
        $("html, body").animate({ scrollTop: $(document).height() }, 1000);
        userLoad.style.display = "none";
      },
    });
  });
});

// Profile image stuff

removeBtn.addEventListener("click", () => {
  document.body.append(modal);
  delModText.innerText = `Profil resminizi kaldırmak üzeresiniz.`;
  delModCon.onclick = () => {
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    $.ajax({
      url: "/api/dashboard/users/delete-avatar.php",
      type: "POST",
      processData: false,
      contentType: false,
      success: function (data) {
        let phpArray = JSON.parse(data);
        let status = phpArray[0];
        let message = phpArray[1];
        if (status == "success") {
          profileImage.src = "/assets/imgs/dynamic/users/nopp.png";
          document.querySelector("#avatar-input-displayer").innerText =
            "Dosya seçilmedi.";
          removeBtn.remove();
        }
        ShowMessage(userLogger, message, status, "none");
        userLoad.style.display = "none";
      },
    });
    modal.remove();
  };
});
