import { ProfilePage } from "..";
import PanelClass from "../classes/PanelClass";

/**
 * Directly gets response and displays the message. Use this if you don't need to do stuff with response.
 * @param panelObject The panel object
 * @param url The url to send the request
 * @param formData The form data to send
 * @returns void
 */
export function getApiResponse(panelObject: PanelClass, url: string, formData: FormData) {
  panelObject.sendApiRequest(url, formData).then((data) => {
    const response = data[0];
    if (panelObject == ProfilePage && response === "success")
      clearAvatarInput();
    panelObject.showMessage(data);
  });
}

export function clearAvatarInput() {
  const avatarInput: HTMLInputElement = document.querySelector("#avatar-input")!;
  avatarInput.value = "";
  const avatarInputDisplayer: HTMLParagraphElement = document.querySelector("#avatar-input-displayer")!;
  avatarInputDisplayer.innerText =
    "Dosya seçilmedi.";
}

export function trimSentence(sentence: string, maxLength: number) {
  if (sentence.length > maxLength) {
    sentence = sentence.substring(0, maxLength - 3) + "...";
  }
  return sentence;
}

export function getDate(raw: string) {
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