import { ProfilePage } from "../user.js";

export function getApiResponse(panelObject, formData, scrollTo) {
    panelObject.sendApiRequest(formData).then((data) => {
        if (JSON.parse(data)[0] === "success" && panelObject == ProfilePage) clearAvatarInput();
        panelObject.showMessage(data);
        scrollToElement(scrollTo);
    });

}

export function clearAvatarInput() {
    document.querySelector("#avatar-input").value = "";
    document.querySelector("#avatar-input-displayer").innerText = "Dosya seçilmedi.";
}

export function scrollToElement(element) {
    element.scrollIntoView({
        behavior: "smooth",
    });
}

export function trimSentence(sentence, maxLength) {
    if (sentence.length > maxLength) {
        sentence = sentence.substring(0, maxLength - 3) + "...";
    }
    return sentence;
}
  
export function getDate(raw) {
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