import { getCategory, setStatus, scrollToElement, addImageInput, instantiateModal } from "../utils/functions.js";
import { currentProducts, CreateProductPage, ManageProductsPage, isEditMode, imageCount } from "../dev.js";
import ConfirmationModal from "./Modal.js";

const {modal, modalText, modalBtn} = instantiateModal(ConfirmationModal());

const productLogger = document.querySelector("#logger-products");
const createLogger = document.querySelector("#logger-create");

export default function CreateProductTable(product) {
    // Create table form
    const tableForm = document.createElement("form");
    tableForm.classList.add("table-form");
  
    const statusBtn = document.createElement("button");
    statusBtn.setAttribute("data-action", "status");
  
    const editBtn = document.createElement("button");
    editBtn.setAttribute("data-action", "edit");
    editBtn.classList.add("btn", "edit-btn");
    editBtn.innerText = "Düzenle";
  
    const deleteBtn = document.createElement("button");
    deleteBtn.setAttribute("data-action", "delete");
    deleteBtn.classList.add("btn", "delete-btn");
    deleteBtn.innerText = "Sil";
  
    tableForm.append(statusBtn);
    tableForm.append(editBtn);
    tableForm.append(deleteBtn);
    tableForm.setAttribute("data-id", product["id"]);
  
    statusBtn.innerText = product["status"] == "1" ? "Listeleme" : "Listele";
    product["status"] == "1"
      ? (statusBtn.className = "btn status-btn")
      : (statusBtn.className = "btn success-btn");
  
    tableForm.addEventListener("click", (e) => {
      e.preventDefault();
      let id = e.target.parentElement.dataset.id;
      // Get the product from the currentProducts array
      let product = currentProducts.find((product) => product["id"] == id);
      if (e.target.dataset.action == "edit") {
        editProduct(product);
      } else if (e.target.dataset.action == "delete") {
        deleteProduct(product);
      } else if (e.target.dataset.action == "status") {
        const formData = new FormData();
        formData.append("id", product["id"]);
        formData.append("status", product["status"] == "1" ? "0" : "1");
        ManageProductsPage.sendApiRequest("/api/dashboard/product/change-status.php", formData).then((data) => {
          scrollToElement(productLogger);
          if (JSON.parse(data)[0] == "success") {
            product["status"] = product["status"] == "1" ? "0" : "1";
            e.target.innerText =
              product["status"] == "1" ? "Listeleme" : "Listele";
            e.target.parentElement.parentElement.parentElement.querySelector(
              "[data-mission='status']"
            ).innerText = setStatus(product["status"]);
            product["status"] == "1"
              ? (statusBtn.className = "btn status-btn")
              : (statusBtn.className = "btn success-btn");
          }
          ManageProductsPage.showMessage(data);
        });
      }
    });
  
    // Create table row
    const tr = document.createElement("tr");
    const td1 = document.createElement("td");
    const td2 = document.createElement("td");
    const td3 = document.createElement("td");
    const td4 = document.createElement("td");
    td4.dataset.mission = "status";
    const td5 = document.createElement("td");
    const td6 = document.createElement("td");
    td1.innerText = product["id"];
    td2.innerText = product["name"];
    td3.innerText = getCategory(product["category"]);
    td4.innerText = setStatus(product["status"]);
    td6.innerText = `₺${product["price"]}`;
    td5.append(tableForm);
    td5.classList.add("table-form-td");
    tr.append(td1, td2, td3, td6, td4, td5);
  
    return tr;
}

function editProduct(product) {
  setPageContent("hash", createProduct);
  clearImageInputs(document.querySelector('button[name="add-image"]'), document.querySelector("#create-form"));
  const idInput = document.createElement("input");
  idInput.type = "hidden";
  idInput.name = "product-id";
  idInput.value = product["id"];
  document.querySelector("#create-form").appendChild(idInput);
  isEditMode.value = true;
  CreateProductPage.showMessage(
    JSON.stringify(["warning", "Ürün düzenleme moduna girdiniz.", "none"])
  );
  scrollToElement(createLogger);

  const exitEditMode = document.querySelector("#exit-edit-mode");
  const button = document.querySelector("#create-product");
  const title = document.querySelector("#create-product-title");
  button.innerText = "Değişiklikleri Kaydet";
  title.innerText = `${product["name"]} Ürününü Düzenliyorsunuz.`;
  const paragraph = document.querySelector("#create-product-text");
  paragraph.innerText = `Düzenleme modundan çıkmak için yanda bulunan X butonuna basabilirsiniz.`;

  const form = document.querySelector("#create-form");
  const name = document.querySelector("#product-name");
  const price = document.querySelector("#product-price");
  const tags = document.querySelector("#product-tags");
  const description = document.querySelector("#product-description");
  const category = document.querySelector("#product-category");
  const quality = document.querySelector("#quality");
  const shipment = document.querySelector("#shipment");
  const featured = document.querySelector("#featured");

  const hostname = window.location.origin;

  exitEditMode.classList.remove("none-display");
  name.value = product["name"];
  price.value = product["price"];
  tags.value = product["tags"];
  description.value = product["description"];
  category.value = product["category"];
  quality.value = product["quality"];
  shipment.value = product["shipment"];
  featured.value = product["featured"];

  let images = [];
  for (let i = 1; i <= 6; i++) {
    const imageKey = `image${i}`;
    if (product[imageKey] !== "noimg.jpg") {
      images.push(product[imageKey]);
    }
  }

  // Create image inputs for each image
  images.forEach(function (image, index) {
    imageCount.value ++;
    addImageInput(document.querySelector('button[name="add-image"]'), index + 1);
    const deleteImageBtn = document.querySelector(
      `button[id="remove-pic-${index + 1}"]`
    );
    deleteImageBtn.setAttribute(`data-image`, image);
    const imagePreview = document.querySelector(`#image-preview-${index + 1}`);
    const imageText = document.querySelector(`#image-text-${index + 1}`);
    imageText.textContent = image.replace(product["root_name"] + "/", "");
    imagePreview.style.display = "block";
    imagePreview.src = `${hostname}/assets/imgs/dynamic/product/${image}`;
  });

  exitEditMode.addEventListener("click", () => {
    ShowMessage(
      createLogger,
      "Ürün düzenleme modundan çıktınız.",
      "warning",
      "none"
    );
    cleanForm(form);
    try {
      const idInput = document.querySelector("input[name='product-id']");
      idInput.remove();
    } catch (e) {
      // Do nothing
    }
    isEditMode.value = false;
    exitEditMode.classList.add("none-display");
    button.innerText = "Ürün Ekle";
    title.innerText = "Markete Ürün Ekle";
    paragraph.innerText = "Yanında (*) olan alanlar zorunludur.";
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
  });
}

function deleteProduct(product) {
  document.body.append(modal);
  modalText.innerText = `"${product["name"]}" isimli ürünü silmek üzeresiniz.`;
  modalBtn.onclick = () => {
    const formData = new FormData();
    formData.append("id", product["id"]);
    CreateProductPage.sendApiRequest("/api/dashboard/product/delete-product.php", formData).then((data) => {
      ManageProductsPage.showMessage(data);
      scrollToElement(productLogger);
      if (JSON.parse(data)[0] === "success") {
        // Delete this product from the currentProducts array
        currentProducts = currentProducts.filter(
          (p) => p["id"] !== product["id"]
        );
        const child = document.querySelector(`[data-id="${product["id"]}"]`);
        child.parentElement.parentElement.remove();
      }
    });
    modal.remove();
  };
};

function clearImageInputs(addImageBtn, form) {
  imageCount.value = 1;
  // Get all the inputs by data-type="image-input"
  let imageInputs = form.querySelectorAll("[data-type='image-input']");
  // Remove all the inputs
  for (let i = 0; i < imageInputs.length; i++) {
    imageInputs[i].remove();
  }
  addImageBtn.className = "btn primary-btn small-btn block-display";
  addImageBtn.disabled = false;
}