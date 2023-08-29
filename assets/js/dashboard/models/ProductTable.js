import { scrollToElement } from "../utils/functions.usr.js";
import {
  currentProducts,
  CreateProductPage,
  ManageProductsPage,
  isEditMode,
  imageCount,
} from "../dev.js";
import ConfirmationModal from "./Modal.js";
import {
  getCategory,
  setStatus,
  addImageInput,
  cleanForm,
} from "../utils/functions.dev.js";

const { modal, modalText, modalBtn } = ConfirmationModal();

const productLogger = document.querySelector("#logger-products");
const createLogger = document.querySelector("#logger-create");

export default function CreateProductTable(product) {
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

  const tableForm = tr.querySelector(".table-form");

  tableForm.addEventListener("click", async (e) => {
    e.preventDefault();
    const id = e.currentTarget.dataset.id;
    const clickedAction = e.target.dataset.action;

    if (clickedAction === "edit") {
      const selectedProduct = currentProducts.value.find((p) => p.id === id);
      editProduct(selectedProduct);
    } else if (clickedAction === "delete") {
      const selectedProduct = currentProducts.value.find((p) => p.id === id);
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

      if (JSON.parse(response)[0] === "success") {
        product.status = newStatus;
        e.target.innerText = newStatus === "1" ? "Satıldı" : "Satışta";
        tr.querySelector("[data-mission='status']").innerText =
          setStatus(newStatus);
        e.target.className = `btn ${
          newStatus === "1" ? "status-btn" : "success-btn"
        }`;
      }

      ManageProductsPage.showMessage(response);
    }
  });

  return tr;
}

function deleteProduct(product) {
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

      const responseData = JSON.parse(response);
      ManageProductsPage.showMessage(response);
      scrollToElement(productLogger);

      if (responseData[0] === "success") {
        // Delete the product from the currentProducts array
        currentProducts.value = currentProducts.value.filter(
          (p) => p.id !== product.id
        );

        const child = document.querySelector(`[data-id="${product.id}"]`);
        if (child) {
          child.parentElement.parentElement.remove();
        }
      }
    } catch (e) {
      ManageProductsPage.showMessage(
        JSON.stringify(["error", "Bir hata oluştu.", "none"])
      );
    } finally {
      modal.remove();
    }
  };
}

function editProduct(product) {
  $("html, body").animate({ scrollTop: $(document).height() }, 1000);
  setPageContent("hash", createProduct);
  clearImageInputs(
    document.querySelector('button[name="add-image"]'),
    document.querySelector("#create-form")
  );

  const inputId = document.createElement("input");
  inputId.type = "hidden";
  inputId.name = "product-id";
  inputId.value = product.id;
  document.querySelector("#create-form").appendChild(inputId);

  isEditMode.value = true;
  CreateProductPage.showMessage(
    JSON.stringify(["warning", "Ürün düzenleme moduna girdiniz.", "none"])
  );

  const exitEditMode = document.querySelector("#exit-edit-mode");
  const button = document.querySelector("#create-product");
  const title = document.querySelector("#create-product-title");
  const paragraph = document.querySelector("#create-product-text");
  button.innerText = "Değişiklikleri Kaydet";
  title.innerText = `${product.name} Ürününü Düzenliyorsunuz.`;
  paragraph.innerText = `Düzenleme modundan çıkmak için yanda bulunan X butonuna basabilirsiniz.`;

  const form = document.querySelector("#create-form");
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
  elements.forEach((item) => (item.element.value = product[item.key]));

  const images = [];
  for (let i = 1; i <= 6; i++) {
    const imageKey = `image${i}`;
    if (product[imageKey] !== "noimg.jpg") {
      images.push(product[imageKey]);
    }
  }

  images.forEach((image, index) => {
    addImageInput(document.querySelector('button[name="add-image"]'));
    const deleteImageBtn = document.querySelector(
      `button[id="remove-pic-${index + 1}"]`
    );
    deleteImageBtn.dataset.image = image;
    deleteImageBtn.classList.remove("small-btn");
    deleteImageBtn.innerHTML = `${index + 1}. Resmi Kaldır`;
    const imagePreview = document.querySelector(`#image-preview-${index + 1}`);
    const imageText = document.querySelector(`#image-text-${index + 1}`);
    const imageLabel = document.querySelector(`#image-label-${index + 1}`);
    const imageInput = document.querySelector(`#product-image-${index + 1}`);
    const hostname = window.location.origin;
    // Hide imageLabel and imageInput
    imageLabel.style.display = "none";
    imageInput.style.display = "none";
    imageInput.disabled = true;
    imagePreview.style.display = "block";
    imageText.textContent = product[`image${index + 1}`];
    imagePreview.src = `${hostname}/assets/imgs/dynamic/product/${
      product["root_name"]
    }/${image}?timestamp=${Date.now()}`;
  });

  exitEditMode.addEventListener("click", () => {
    CreateProductPage.showMessage(
      JSON.stringify(["warning", "Ürün düzenleme modundan çıktınız.", "none"])
    );
    cleanForm(form);
    scrollToElement(createLogger);
    isEditMode.value = false;
    inputId.remove();
    exitEditMode.classList.add("none-display");
    imageCount.value = 1;
    document.querySelector('button[name="add-image"]').disabled = false;
    document.querySelector('button[name="add-image"]').className =
      "btn primary-btn small-btn block-display";
  });
}

function clearImageInputs(addImageBtn, form) {
  imageCount.value = 1;

  const imageInputs = form.querySelectorAll("[data-type='image-input']");
  imageInputs.forEach((input) => input.remove());

  addImageBtn.className = "btn primary-btn small-btn block-display";
  addImageBtn.disabled = false;
}
