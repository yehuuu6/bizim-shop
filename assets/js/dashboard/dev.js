import PanelClass from "./classes/PanelClass.js";
import ConfirmationModal from "./models/Modal.js";
import CreateProductTable from "./models/ProductTable.js";
import { getApiResponse, scrollToElement } from "./utils/functions.js";

const modalObject = ConfirmationModal();

const modal = modalObject.modal;
const modalText = modalObject.text;
const modalBtn = modalObject.button;

export let currentProducts = [];
let productSearchInterval = null;
let startVal = 5;

const cleanProductForm = document.querySelector("#clean-create-form");
const addNewProduct = document.querySelector("#add-new-product");
const productRefreshBtn = document.querySelector("#refresh-products");
const productLogger = document.querySelector("#logger-products");
const productLoad = document.querySelector("#loader-products");
const productMore = document.querySelector("#load-more-products");
const productTable = document.querySelector("#products-table tbody");

const createLogger = document.querySelector("#logger-create");
const createLoad = document.querySelector("#loader-create");
let isEditMode = false;
let imageCount = 1;

const ManageProductsPage = new PanelClass(
  productLogger,
  productLoad,
  "/api/dashboard/product/load-products.php"
);
const CreateProductPage = new PanelClass(
  createLogger,
  createLoad,
  "/api/dashboard/product/upload-product.php"
);

// VARIABLES END

// FUNCTIONS START

function deleteProduct(product) {
  document.body.append(modal);
  modalText.innerText = `"${product["name"]}" isimli ürünü silmek üzeresiniz.`;
  modalBtn.onclick = () => {
    productLoad.style.display = "flex";
    $.ajax({
      url: "/api/dashboard/product/delete-product.php",
      type: "POST",
      data: {
        id: product["id"],
      },
      success: function (data) {
        let phpArray = JSON.parse(data);
        let status = phpArray[0];
        let message = phpArray[1];
        // Scroll to logger
        $("html, body").animate(
          {
            scrollTop: $(productLogger).offset().top,
          },
          1000
        );
        // Delete this product from the currentProducts array
        currentProducts = currentProducts.filter(
          (p) => p["id"] !== product["id"]
        );
        if (status == "success") {
          const child = document.querySelector(`[data-id="${product["id"]}"]`);
          child.parentElement.parentElement.remove();
        }
        ShowMessage(productLogger, message, status, "none");
        productLoad.style.display = "none";
      },
    });
    modal.remove();
  };
};

function getSearchProduct() {
  let search = document.querySelector("#search-pr").value;
  if (search.length > 0) {
    // Search for product inside currentProducts and remove all other products
    productTable.innerHTML = "";
    for (let i = 0; i < currentProducts.length; i++) {
      let product = currentProducts[i];
      if (product["name"].toLowerCase().includes(search.toLowerCase())) {
        productTable.append(CreateProductTable(product));
      }
    }
    // If no products are found, display a message
    if (productTable.innerHTML === "") {
      let tr = document.createElement("tr");
      let td = document.createElement("td");
      td.innerText = "Hiçbir ürün bulunamadı";
      td.setAttribute("colspan", "7");
      tr.append(td);
      productTable.append(tr);
    }
  } else {
    // Load old products back
    productTable.innerHTML = "";
    for (let i = 0; i < currentProducts.length; i++) {
      let product = currentProducts[i];
      productTable.append(CreateProductTable(product));
    }
  }
}

function loadFirstProducts() {
  currentProducts = [];

  productMore.classList.remove("disabled");
  productMore.disabled = false;

  productTable.innerHTML = "";

  let formData = new FormData();
  formData.append("start", 0);
  ManageProductsPage.sendApiRequest(formData).then((data) => {
    let products = JSON.parse(data);
    if (products.length === 0) {
      let tr = document.createElement("tr");
      let td = document.createElement("td");
      td.innerText = "Hiçbir ürün bulunamadı";
      td.setAttribute("colspan", "7");
      tr.append(td);
      productTable.append(tr);
    }
    for (let i = 0; i < products.length; i++) {
      let product = products[i];
      currentProducts.push(product);
      productTable.append(CreateProductTable(product));
    }
  });
}

function clearImageInputs(form) {
  imageCount = 1;
  // Get all the inputs by data-type="image-input"
  let imageInputs = form.querySelectorAll("[data-type='image-input']");
  // Remove all the inputs
  for (let i = 0; i < imageInputs.length; i++) {
    imageInputs[i].remove();
  }
  addImageBtn.className = "btn primary-btn small-btn block-display";
  addImageBtn.disabled = false;
}

addNewProduct.addEventListener("click", () => {
  setPageContent("hash", createProduct);
});

// Set interval on focus to search input and clear it when it's not focused
document.getElementById("search-pr").addEventListener("focus", () => {
  productSearchInterval = setInterval(() => {
    getSearchProduct();
  }, 100);
});
document.getElementById("search-pr").addEventListener("blur", () => {
  clearInterval(productSearchInterval);
});

$(document).ready(function () {
  productRefreshBtn.addEventListener("click", () => {
    productLogger.innerHTML = "";
    productLogger.className = "logger";
    loadFirstProducts();
    document.getElementById("search-pr").value = "";
    startVal = 5;
  });

  loadFirstProducts();

  $("#load-more-products").click(function (e) {
    e.preventDefault();
    let formData = new FormData();
    formData.append("start", startVal);
    ManageProductsPage.sendApiRequest(formData).then((data) => {
      let products = JSON.parse(data);
      if (products.length === 0) {
        productMore.classList.add("disabled");
        productMore.disabled = true;
        ManageProductsPage.showMessage(JSON.stringify(["error", "Daha fazla ürün bulunamadı", "none"]));
      }
      for (let i = 0; i < products.length; i++) {
        let product = products[i];
        currentProducts.push(product);
        productTable.append(CreateProductTable(product));
        ManageProductsPage.showMessage(JSON.stringify(["success", "5 ürün başarıyla yüklendi", "none"]));
      }
      startVal += 5;
      scrollToElement(productLogger);
    });
  });

  $("#create-form").submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append("image-count", imageCount);
    formData.append("edit-mode", isEditMode ? "true" : "false");
    getApiResponse(CreateProductPage, formData, createLogger);
  });
});
