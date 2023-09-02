import $ from "jquery";

export default function ConfirmationModal() {
  const modal = $('<div class="delete-modal"></div>');
  const delCon = $('<div class="delete-modal-content"></div>');
  const modTitle = $('<h1 class="delete-modal-title">Uyarı!</h1>');
  const lineBreak = $('<hr class="delete-modal-line">');
  const delModText = $("<p></p>");
  const delModWarn = $('<strong class="warn">BU EYLEM GERİ ALINAMAZ.</strong>');
  const delSpan = $("<span>Devam et?</span>");
  const delModBtns = $('<div class="delete-modal-btns"></div>');
  const delModCan = $('<button class="btn success-btn">Hayır</button>');
  const delModCon = $('<button class="btn delete-btn">Evet</button>');

  const modalElement = modal[0] as HTMLDivElement;
  const delConElement = delCon[0];
  const modTitleElement = modTitle[0];
  const lineBreakElement = lineBreak[0];
  const delModTextElement = delModText[0] as HTMLParagraphElement;
  const delModWarnElement = delModWarn[0];
  const delSpanElement = delSpan[0];
  const delModBtnsElement = delModBtns[0];
  const delModConElement = delModCon[0] as HTMLButtonElement;
  const delModCanElement = delModCan[0];

  delModCanElement.addEventListener("click", () => {
    modal.remove();
  });

  modalElement.addEventListener("click", (e) => {
    if (e.target === modalElement) {
      modal.remove();
    }
  });

  delModBtns.append(delModCon, delModCan);
  delCon.append(
    modTitleElement,
    (lineBreakElement.cloneNode() as HTMLElement), // Cast the cloneNode result
    delModTextElement,
    (lineBreakElement.cloneNode() as HTMLElement), // Cast the cloneNode result
    delModWarnElement,
    (lineBreakElement.cloneNode() as HTMLElement), // Cast the cloneNode result
    delSpanElement,
    delModBtnsElement
  );

  modal.append(delConElement);

  return {
    modal: modalElement,
    modalText: delModTextElement,
    modalBtn: delModConElement,
  };
}
