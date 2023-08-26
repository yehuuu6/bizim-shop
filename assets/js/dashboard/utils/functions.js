import { ProfilePage } from "../user.js";

// Directly gets response and displays the message. Use this if you don't need to do stuff with response.
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

export function getCategory(id) {
    let category = "";
    id = parseInt(id);
    switch (id) {
        case 1:
        category = "Müzik Seti";
        break;
        case 2:
        category = "Hoparlör";
        break;
        case 3:
        category = "Plak Çalar";
        break;
        case 4:
        category = "Müzik Çalar";
        break;
    }
    return category;
};
  
export function getPerm(id) {
    let perm = "";
    id = parseInt(id);
    switch (id) {
        case 0:
        perm = "Üye";
        break;
        case 1:
        perm = "Yönetici";
        break;
    }
    return perm;
};
  
export function setStatus(status) {
    let statusText = "";
    switch (status) {
        case "1":
        statusText = "Listeleniyor";
        break;
        case "0":
        statusText = "Listelenmiyor";
        break;
    }
    return statusText;
}