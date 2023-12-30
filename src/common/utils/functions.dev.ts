import {
  getSearchProduct,
  imageCount,
  isEditMode,
} from "@/control-center/dashboard";
import { getSearchUser } from "@/control-center/dashboard/users";
import { getSearchOrder } from "@/control-center/dashboard/orders";
import { trimSentence } from "./functions.usr";
import axios from "axios";

export function runSearchProducts(searchProductInput: HTMLInputElement) {
  let productSearchInterval: any = null;
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
}

export function runSearchOrders(searchOrderInput: HTMLInputElement) {
  let orderSearchInterval: any = null;
  // Set interval on focus to search input and clear it when it's not focused
  searchOrderInput.addEventListener("focus", () => {
    if (!orderSearchInterval) {
      orderSearchInterval = setInterval(() => {
        getSearchOrder();
      }, 300); // Throttle the calls to every 300 milliseconds
    }
  });

  searchOrderInput.addEventListener("blur", () => {
    clearInterval(orderSearchInterval);
    orderSearchInterval = null; // Reset the interval variable
  });

  searchOrderInput.addEventListener(
    "input",
    debounce(() => {
      getSearchOrder();
    }, 300)
  ); // Debounce the input event to trigger after the user stops typing
}

export function runSearchUsers(searchUserInput: HTMLInputElement) {
  let userSearchInterval: any = null;
  // Set interval on focus to search input and clear it when it's not focused
  searchUserInput.addEventListener("focus", () => {
    if (!userSearchInterval) {
      userSearchInterval = setInterval(() => {
        getSearchUser();
      }, 300); // Throttle the calls to every 300 milliseconds
    }
  });

  searchUserInput.addEventListener("blur", () => {
    clearInterval(userSearchInterval);
    userSearchInterval = null; // Reset the interval variable
  });

  searchUserInput.addEventListener(
    "input",
    debounce(() => {
      getSearchUser();
    }, 300)
  ); // Debounce the input event to trigger after the user stops typing
}

function debounce(callback: any, delay: number) {
  let timer: any;
  return function () {
    clearTimeout(timer);
    timer = setTimeout(callback, delay);
  };
}

// 0 = Beklemede, 1 = Hazırlanıyor, 2 = Kargoya Verildi, 3 = Teslim Edildi, 4 = İptal Edildi, 5 = İade Edildi, 6 = Tamamlandı, 7 = Tamamlanmadı
export function setOrderStatus(status: string) {
  let statusText: string | undefined = "Hata";

  switch (status) {
    case "0":
      statusText = "Beklemede";
      break;
    case "1":
      statusText = "Hazırlanıyor";
      break;
    case "2":
      statusText = "Kargoya Verildi";
      break;
    case "3":
      statusText = "Teslim Edildi";
      break;
    case "4":
      statusText = "İptal Edildi";
      break;
    case "5":
      statusText = "İade Edildi";
      break;
    case "6":
      statusText = "Tamamlandı";
      break;
    case "7":
      statusText = "Tamamlanmadı";
      break;
    default:
      statusText = "Hata";
      break;
  }
  return statusText;
}

export function setStatus(status: string) {
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

const subCatSelector = document.querySelector(
  "#product-sub-category"
) as HTMLSelectElement;

export async function setSubCategories() {
  const response = await axios({
    url: "/api/dashboard/category/subcategories.php",
    method: "post",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "multipart/form-data",
    },
  });
  const subCategories = response.data;
  subCatSelector.innerHTML = "<option value='0'>Kategori Seçiniz</option>";
  subCategories.forEach((subCategory: any) => {
    subCatSelector.innerHTML += `<option value="${subCategory.id}">${subCategory.name}</option>`;
  });
}

/**
 * This function is used to exit edit mode and clean the form
 */
export function quitEditMode() {
  cleanForm(document.querySelector("#create-form") as HTMLFormElement);
  const button = document.querySelector("#create-product") as HTMLButtonElement;
  const title = document.querySelector("#create-product-title") as HTMLElement;
  const paragraph = document.querySelector(
    "#create-product-text"
  ) as HTMLParagraphElement;
  isEditMode.value = false;
  title.innerText = "Markete Ürün Ekle";
  paragraph.innerText = "Yanında (*) olan alanlar zorunludur.";
  button.innerText = "Ürünü Ekle";
  if (document.querySelector("[name='product-id']")) {
    (
      document.querySelector("[name='product-id']") as HTMLInputElement
    ).remove();
  }
  (
    document.querySelector("#exit-edit-mode") as HTMLButtonElement
  ).classList.add("none-display");
  (document.querySelector("#exit-edit-mode") as HTMLButtonElement).disabled =
    true;
  (
    document.querySelector('button[name="add-image"]') as HTMLButtonElement
  ).disabled = false;
  (
    document.querySelector('button[name="add-image"]') as HTMLButtonElement
  ).className = "dashboard-btn small-btn add-image-btn";
}

export function addImageInput(addImageBtn: HTMLButtonElement) {
  const template = `
          <div class="form-item" data-type="image-input">
            <div class="width-100 flex-display gap-10">
              <button type="button" title="${imageCount.value}. Resmi Sil" id="remove-pic-${imageCount.value}" class="dashboard-btn delete-btn small-btn"><i class="fa-solid fa-minus"></i></button>
              <label class="dashboard-btn edit-btn" id="image-label-${imageCount.value}" for="product-image-${imageCount.value}">${imageCount.value}. Resim</label>
            </div>
            <p id="image-text-${imageCount.value}" class="display-file">Dosya seçilmedi.</p>
            <input type="file" id="product-image-${imageCount.value}" name="product-image-${imageCount.value}" accept="image/*" />
            <img id="image-preview-${imageCount.value}" src="#" alt="Resim Önizleme" style="width: 100px;height:100px; display: none; object-fit:cover;" />
          </div>
        `;

  addImageBtn?.parentElement?.insertAdjacentHTML("beforebegin", template);

  const fileInput: HTMLInputElement = document.querySelector(
    `#product-image-${imageCount.value}`
  )!;
  const imagePreview: HTMLImageElement = document.querySelector(
    `#image-preview-${imageCount.value}`
  )!;
  const imageText: HTMLParagraphElement = document.querySelector(
    `#image-text-${imageCount.value}`
  )!;

  fileInput.addEventListener("change", function () {
    if (this.files && this.files.length > 0) {
      const file = this.files[0];
      if (file) {
        imagePreview.style.display = "block";
        const reader = new FileReader();
        reader.onload = function (e) {
          if (e.target && e.target.result) {
            imagePreview.src = e.target.result.toString();
          }
        };
        reader.readAsDataURL(file);
        imageText.title = file.name;
        imageText.textContent = trimSentence(file.name, 20);
      }
    } else {
      imagePreview.style.display = "none";
      imageText.textContent = "Dosya seçilmedi.";
    }
  });
  imageCount.value++;
}

export function cleanForm(form: HTMLFormElement) {
  form.reset();
  const imageInputs: HTMLInputElement[] = Array.from(
    document.querySelectorAll("[data-type='image-input']")
  ) as HTMLInputElement[];
  const addImageBtn: HTMLButtonElement = document.querySelector(
    'button[name="add-image"]'
  )!;
  imageInputs.forEach((input) => {
    const button = input.querySelector("button") as HTMLButtonElement;
    if (!button.hasAttribute("data-image")) {
      imageCount.value--;
      input.remove();
    }
  });
  if (imageCount.value <= 6) {
    addImageBtn.disabled = false;
    addImageBtn.className = "dashboard-btn small-btn add-image-btn";
  }
}
