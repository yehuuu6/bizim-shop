import { ProfilePage } from "../user.js";

// Directly gets response and displays the message. Use this if you don't need to do stuff with response.
export function getApiResponse(panelObject, url, formData, scrollTo) {
    panelObject.sendApiRequest(url, formData).then((data) => {
        if (JSON.parse(data)[0] === "success" && panelObject == ProfilePage) clearAvatarInput();
        panelObject.showMessage(data);
        scrollToElement(scrollTo);
    });

}

export function instantiateModal(ModalObject) {
    const modal = ModalObject.modal;
    const modalText = ModalObject.text;
    const modalBtn = ModalObject.button;

    return { modal, modalText, modalBtn };
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

export function addImageInput(addImageBtn, imageCount) {
    const template = `
      <div class="form-item" data-type="image-input">
        <div class="width-100 flex-display gap-10">
          <button type="button" title="${imageCount}. Resmi Sil" id="remove-pic-${imageCount}" class="btn delete-btn small-btn"><i class="fa-solid fa-minus"></i></button>
          <label class="btn edit-btn" id="image-label-${imageCount}" for="product-image-${imageCount}">${imageCount}. Resim</label>
        </div>
        <p id="image-text-${imageCount}" class="display-file">Dosya seçilmedi.</p>
        <input type="file" id="product-image-${imageCount}" name="product-image-${imageCount}" accept="image/*" />
        <img id="image-preview-${imageCount}" src="#" alt="Resim Önizleme" style="width: 100px;height:100px; display: none; object-fit:cover;" />
      </div>
    `;
  
    addImageBtn.parentElement.insertAdjacentHTML("beforebegin", template);

    imageCount++;
  
    const fileInput = document.querySelector(`#product-image-${imageCount}`);
    const imagePreview = document.querySelector(`#image-preview-${imageCount}`);
    const imageText = document.querySelector(`#image-text-${imageCount}`);
  
    fileInput.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        imagePreview.style.display = "block";
        const reader = new FileReader();
        reader.onload = function (e) {
          imagePreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
        imageText.textContent = file.name;
      } else {
        imagePreview.style.display = "none";
        imageText.textContent = "Dosya seçilmedi.";
      }
    });
  }