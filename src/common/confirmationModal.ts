export default function ConfirmationModal() {
  const modal = document.createElement("div");
  modal.classList.add("delete-modal");
  const delCon = document.createElement("div");
  delCon.classList.add("delete-modal-content");
  const modTitle = document.createElement("h1");
  modTitle.innerText = "Uyarı!";
  modTitle.classList.add("delete-modal-title");
  const lineBreak = document.createElement("hr");
  lineBreak.classList.add("delete-modal-line");
  const delModText = document.createElement("p");
  const delModWarn = document.createElement("strong");
  delModWarn.innerText = "BU EYLEM GERİ ALINAMAZ.";
  delModWarn.classList.add("warn");
  const delSpan = document.createElement("span");
  delSpan.innerText = "Devam et?";
  const delModBtns = document.createElement("div");
  delModBtns.classList.add("delete-modal-btns");
  const delModCan = document.createElement("button");
  delModCan.classList.add("dashboard-btn", "success-btn");
  delModCan.innerText = "Hayır";
  const delModCon = document.createElement("button");
  delModCon.classList.add("dashboard-btn", "delete-btn");
  delModCon.innerText = "Evet";

  delModCan.addEventListener("click", () => {
    modal.remove();
  });

  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.remove();
    }
  });

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

  return {
    modal: modal,
    modalText: delModText,
    modalBtn: delModCon,
  };
}
