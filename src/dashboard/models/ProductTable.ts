import { scrollToElement } from "../utils/functions.usr";
import {
  currentProducts,
  CreateProductPage,
  ManageProductsPage,
  isEditMode,
  imageCount,
} from "../dev";
import ConfirmationModal from "./Modal";
import {
  getCategory,
  setStatus,
  addImageInput,
  cleanForm,
} from "../utils/functions.dev";
import { setPageContent } from "../routing";

const { modal, modalText, modalBtn } = ConfirmationModal();

const productLogger= document.querySelector("#logger-products") as HTMLParagraphElement;
const createLogger = document.querySelector("#logger-create") as HTMLParagraphElement;
const addImageBtn =  document.querySelector('button[name="add-image"]') as HTMLButtonElement;

export interface ProductInterface {
  id: string;
  name: string;
  category: string;
  price: string;
  status: string;
  image1: string;
  image2: string;
  image3: string;
  image4: string;
  image5: string;
  image6: string;
  root_name: string;
  tags: string;
  description: string;
  quality: string;
  shipment: string;
  featured: string;
  [key: string]: string;
}

export function createProductTable(product: ProductInterface) {
  // Create table row
  const tr = document.createElement("tr");
  tr.innerHTML = `
    <td>${product.id}</td>
    <td>${product.name}</td>
    <td>${getCategory(product.category)}</td>
    <td>₺${product.price}</td>
    <td data-mission="status">${setStatus(product.status)}</td>
    <td class="table-form-td">
      <form class="table-form" data-id="${product.id}">
        <button data-action="status" class="btn ${
          product.status === "1" ? "status-btn" : "success-btn"
        }">${product.status === "1" ? "Satıldı" : "Satışta"}</button>
        <button data-action="edit" class="btn edit-btn">Düzenle</button>
        <button data-action="delete" class="btn delete-btn">Sil</button>
      </form>
    </td>
  `;

  const tableForm = tr.querySelector(".table-form") as HTMLElement;

  tableForm.addEventListener("click", async (e) => {
    e.preventDefault();
    const id = (e.currentTarget as HTMLElement).dataset.id!;
    const clickedAction = (e.target as HTMLElement).dataset.action;

    const selectedProduct: ProductInterface = currentProducts.value.find((p: ProductInterface) => p.id === id)!;
    if (clickedAction === "edit") {
      editProduct(selectedProduct);
    } else if (clickedAction === "delete") {
      deleteProduct(selectedProduct);
    } else if (clickedAction === "status") {
      const newStatus = product.status === "1" ? "0" : "1";

      const formData = new FormData();
      formData.append("id", id);
      formData.append("status", newStatus);

      const response = await ManageProductsPage.sendApiRequest(
        "/api/dashboard/product/change-status.php",
        formData
      );
      scrollToElement(productLogger);

      if (response[0] === "success") {
        product.status = newStatus;
        (e.target as HTMLElement).innerText = newStatus === "1" ? "Satıldı" : "Satışta";
        (tr.querySelector("[data-mission='status']") as HTMLElement).innerText =
          setStatus(newStatus);
        (e.target as HTMLElement).className = `btn ${
          newStatus === "1" ? "status-btn" : "success-btn"
        }`;
      }

      ManageProductsPage.showMessage(response);
    }
  });

  return tr;
}

function deleteProduct(product: ProductInterface) {
  document.body.appendChild(modal);
  modalText.innerText = `"${product.name}" isimli ürünü silmek üzeresiniz.`;

  modalBtn.onclick = async () => {
    const formData = new FormData();
    formData.append("id", product.id);

    try {
      const response = await CreateProductPage.sendApiRequest(
        "/api/dashboard/product/delete-product.php",
        formData
      );

      ManageProductsPage.showMessage(response);
      scrollToElement(productLogger);

      if (response[0] === "success") {
        // Delete the product from the currentProducts array
        currentProducts.value = currentProducts.value.filter(
          (p: ProductInterface) => p.id !== product.id
        );

        const child = document.querySelector(`[data-id="${product.id}"]`);
        if (child) {
          ((child.parentElement as HTMLElement).parentElement as HTMLElement).remove();
        }
      }
    } catch (e) {
      ManageProductsPage.showMessage(["error", "Bir hata oluştu.", "none"]);
    } finally {
      modal.remove();
    }
  };
}

function editProduct(product: ProductInterface) {
  scrollToElement(createLogger);
  const form = document.querySelector("#create-form") as HTMLFormElement;
  setPageContent("hash", document.getElementById("add-product") as HTMLElement);
  clearImageInputs(
    addImageBtn,
    form
  );

  const inputId = document.createElement("input");
  inputId.type = "hidden";
  inputId.name = "product-id";
  inputId.value = product.id;
  form.appendChild(inputId);

  isEditMode.value = true;
  CreateProductPage.showMessage([
    "warning",
    "Ürün düzenleme moduna girdiniz.",
    "none",
  ]);

  const exitEditMode = document.querySelector("#exit-edit-mode") as HTMLButtonElement;
  const button = document.querySelector("#create-product") as HTMLButtonElement;
  const title = document.querySelector("#create-product-title") as HTMLElement;
  const paragraph = document.querySelector("#create-product-text") as HTMLParagraphElement;
  button.innerText = "Değişiklikleri Kaydet";
  title.innerText = `${product.name} Ürününü Düzenliyorsunuz.`;
  paragraph.innerText = `Düzenleme modundan çıkmak için yanda bulunan X butonuna basabilirsiniz.`;

  const elements = [
    { element: document.querySelector("#product-name"), key: "name" },
    { element: document.querySelector("#product-price"), key: "price" },
    { element: document.querySelector("#product-tags"), key: "tags" },
    {
      element: document.querySelector("#product-description"),
      key: "description",
    },
    { element: document.querySelector("#product-category"), key: "category" },
    { element: document.querySelector("#quality"), key: "quality" },
    { element: document.querySelector("#shipment"), key: "shipment" },
    { element: document.querySelector("#featured"), key: "featured" },
  ];

  exitEditMode.classList.remove("none-display");
  exitEditMode.disabled = false;

  elements.forEach((item) => ((item.element as HTMLInputElement).value = product[item.key]));

  const images: string[] = [];
  for (let i = 1; i <= 6; i++) {
    const imageKey = `image${i}`;
    if (product[imageKey] !== "noimg.jpg") {
      images.push(product[imageKey]);
    }
  }

  images.forEach((image, index) => {
    addImageInput(addImageBtn);
    const deleteImageBtn = document.querySelector(
      `button[id="remove-pic-${index + 1}"]`
    ) as HTMLButtonElement;
    deleteImageBtn.dataset.image = image;
    deleteImageBtn.classList.remove("small-btn");
    deleteImageBtn.innerHTML = `${index + 1}. Resmi Kaldır`;
    const imagePreview = document.querySelector(`#image-preview-${index + 1}`) as HTMLImageElement;
    const imageText = document.querySelector(`#image-text-${index + 1}`) as HTMLParagraphElement;
    const imageLabel = document.querySelector(`#image-label-${index + 1}`) as HTMLLabelElement;
    const imageInput = document.querySelector(`#product-image-${index + 1}`) as HTMLInputElement;
    const hostname = window.location.origin;
    // Hide imageLabel and imageInput
    imageLabel.style.display = "none";
    imageInput.style.display = "none";
    imageInput.disabled = true;
    imagePreview.style.display = "block";
    imageText.textContent = product[`image${index + 1}`];
    imagePreview.src = `${hostname}/assets/imgs/product/${
      product["root_name"]
    }/${image}?timestamp=${Date.now()}`;
  });

  exitEditMode.addEventListener("click", () => {
    CreateProductPage.showMessage([
      "warning",
      "Ürün düzenleme modundan çıktınız.",
      "none",
    ]);
    cleanForm(form);
    scrollToElement(createLogger);
    isEditMode.value = false;
    inputId.remove();
    exitEditMode.classList.add("none-dislplay");
    exitEditMode.disabled = true;
    imageCount.value = 1;
    addImageBtn.disabled = false;
    addImageBtn.className =
      "btn primary-btn small-btn block-display";
  });
}

function clearImageInputs(addImageBtn: HTMLButtonElement, form: HTMLFormElement) {
  imageCount.value = 1;

  const imageInputs = form.querySelectorAll("[data-type='image-input']");
  imageInputs.forEach((input) => input.remove());

  addImageBtn.className = "btn primary-btn small-btn block-display";
  addImageBtn.disabled = false;
}
