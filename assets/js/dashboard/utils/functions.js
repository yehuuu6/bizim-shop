import { ProfilePage } from "../user.js";
import { getSearchProduct, imageCount } from "../dev.js";

// Directly gets response and displays the message. Use this if you don't need to do stuff with response.
export function getApiResponse(panelObject, url, formData, scrollTo) {
  panelObject.sendApiRequest(url, formData).then((data) => {
    try {
      var response = JSON.parse(data);
    } catch (e) {
      panelObject.showMessage(
        JSON.stringify[
          ("error", "Bir hata oluştu. Lütfen tekrar deneyin.", "none")
        ]
      );
    }
    if (panelObject == ProfilePage && response[0] === "success")
      clearAvatarInput();
    panelObject.showMessage(data);
    scrollToElement(scrollTo);
  });
}

export function runSearch() {
  let productSearchInterval = null;
  const searchProductInput = document.querySelector("#search-pr");
  // Set interval on focus to search input and clear it when it's not focused
  searchProductInput.addEventListener("focus", () => {
    if (!productSearchInterval) {
      productSearchInterval = setInterval(() => {
        getSearchProduct();
      }, 300); // Throttle the calls to every 300 milliseconds
    }
  });

  searchProductInput.addEventListener("blur", () => {
    clearInterval(productSearchInterval);
    productSearchInterval = null; // Reset the interval variable
  });

  searchProductInput.addEventListener(
    "input",
    debounce(() => {
      getSearchProduct();
    }, 300)
  ); // Debounce the input event to trigger after the user stops typing

  // Debounce function to delay execution
  function debounce(callback, delay) {
    let timer;
    return function () {
      clearTimeout(timer);
      timer = setTimeout(callback, delay);
    };
  }
}

export function cleanForm(form) {
  form.reset();
  const button = document.querySelector("#create-product");
  const title = document.querySelector("#create-product-title");
  const paragraph = document.querySelector("#create-product-text");
  const imageInputs = document.querySelectorAll("[data-type='image-input']");
  const addImageBtn = document.querySelector('button[name="add-image"]');
  imageInputs.forEach((input) => input.remove());
  addImageBtn.disabled = false;
  addImageBtn.className = "btn primary-btn small-btn";
  imageCount.value = 1;
  button.innerText = "Ürün Ekle";
  title.innerText = "Markete Ürün Ekle";
  paragraph.innerText = "Yanında (*) olan alanlar zorunludur.";
}

export function clearAvatarInput() {
  document.querySelector("#avatar-input").value = "";
  document.querySelector("#avatar-input-displayer").innerText =
    "Dosya seçilmedi.";
}

export function scrollToElement(element) {
  window.scrollTo({
    top: element.offsetTop,
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
}

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
}

export function setStatus(status) {
  let statusText = "";
  switch (status) {
    case "1":
      statusText = "Satılık";
      break;
    case "0":
      statusText = "Satıldı";
      break;
  }
  return statusText;
}

export function addImageInput(addImageBtn) {
  const template = `
      <div class="form-item" data-type="image-input">
        <div class="width-100 flex-display gap-10">
          <button type="button" title="${imageCount.value}. Resmi Sil" id="remove-pic-${imageCount.value}" class="btn delete-btn small-btn"><i class="fa-solid fa-minus"></i></button>
          <label class="btn edit-btn" id="image-label-${imageCount.value}" for="product-image-${imageCount.value}">${imageCount.value}. Resim</label>
        </div>
        <p id="image-text-${imageCount.value}" class="display-file">Dosya seçilmedi.</p>
        <input type="file" id="product-image-${imageCount.value}" name="product-image-${imageCount.value}" accept="image/*" />
        <img id="image-preview-${imageCount.value}" src="#" alt="Resim Önizleme" style="width: 100px;height:100px; display: none; object-fit:cover;" />
      </div>
    `;

  addImageBtn.parentElement.insertAdjacentHTML("beforebegin", template);

  const fileInput = document.querySelector(
    `#product-image-${imageCount.value}`
  );
  const imagePreview = document.querySelector(
    `#image-preview-${imageCount.value}`
  );
  const imageText = document.querySelector(`#image-text-${imageCount.value}`);

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
  imageCount.value++;
}
