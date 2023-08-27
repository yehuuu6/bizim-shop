import PanelClass from "./classes/PanelClass.js";
import ConfirmationModal from "./models/Modal.js";
import CreateProductTable from "./models/ProductTable.js";
import { getApiResponse, scrollToElement, addImageInput, instantiateModal} from "./utils/functions.js";

const {modal, modalText, modalBtn} = instantiateModal(ConfirmationModal());

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

export const isEditMode = {
  value: true,
};
export const imageCount = {
  value: 1,
};
const addImageBtn = document.querySelector('button[name="add-image"]');
const maxImages = 6;

export const ManageProductsPage = new PanelClass(
  productLogger,
  productLoad
);
export const CreateProductPage = new PanelClass(
  createLogger,
  createLoad
);

// VARIABLES END

// FUNCTIONS START

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
  ManageProductsPage.sendApiRequest("/api/dashboard/product/load-products.php", formData).then((data) => {
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

addImageBtn.addEventListener("click", function (e) {
  e.preventDefault();

  if (imageCount.value > maxImages) {
    scrollToElement(createLogger);
    CreateProductPage.showMessage(
      JSON.stringify(["error", "En fazla 6 resim yükleyebilirsiniz", "none"])
    );
    addImageBtn.disabled = true;
    addImageBtn.className = "btn small-btn disabled";
    return;
  }

  addImageInput(addImageBtn, imageCount.value);
});

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
    ManageProductsPage.sendApiRequest("/api/dashboard/product/load-products.php", formData).then((data) => {
      let products = JSON.parse(data);
      if (products.length === 0) {
        productMore.classList.add("disabled");
        productMore.disabled = true;
        ManageProductsPage.showMessage(JSON.stringify(["error", "Daha fazla ürün bulunamadı.", "none"]));
      }
      for (let i = 0; i < products.length; i++) {
        let product = products[i];
        currentProducts.push(product);
        productTable.append(CreateProductTable(product));
        ManageProductsPage.showMessage(JSON.stringify(["success", "5 ürün başarıyla yüklendi.", "none"]));
      }
      startVal += 5;
      scrollToElement(productLogger);
    });
  });

  $("#create-form").submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append("image-count", imageCount.value);
    formData.append("edit-mode", isEditMode ? "true" : "false");
    getApiResponse(CreateProductPage, "/api/dashboard/product/upload-product.php", formData, createLogger);
  });
});

function removeAndReorderImages(imageInput) {
  imageInput.remove();
  const imageInputs = document.querySelectorAll('[data-type="image-input"]');
  imageInputs.forEach(function (input, index) {
    const newIndex = index + 1;
    input.querySelector("button").id = `remove-pic-${newIndex}`;
    input.querySelector("button").title = `${newIndex}. Resmi Sil`;
    input.querySelector("label").id = `image-label-${newIndex}`;
    input.querySelector("label").title = `${newIndex}. Resmi Sil`;
    input.querySelector("label").htmlFor = `product-image-${newIndex}`;
    input.querySelector("label").textContent = `${newIndex}. Resim`;
    input.querySelector("input").id = `product-image-${newIndex}`;
    input.querySelector("input").name = `product-image-${newIndex}`;
    input.querySelector("p").id = `image-text-${newIndex}`;
    input.querySelector("img").id = `image-preview-${newIndex}`;
  });

  addImageBtn.disabled = false;
  addImageBtn.className = "btn primary-btn small-btn";
  imageCount.value--;
}

document.addEventListener("click", function (e) {
  const clickedButton = e.target.closest("button");

  if (clickedButton && clickedButton.id.startsWith("remove-pic-")) {
    e.preventDefault();
    const imageInput = clickedButton.closest('[data-type="image-input"]');
    const imageName = clickedButton.getAttribute("data-image");
    if (isEditMode && imageName !== null) {
      document.body.append(modal);
      modalText.innerText = `${imageName} isimli resmi silmek istediğinize emin misiniz?`;
      modalBtn.onclick = function () {
        productLoad.style.display = "flex";
        $.ajax({
          url: "/api/dashboard/product/delete-image.php",
          type: "POST",
          data: {
            image: imageName,
          },
          success: function (data) {
            let phpArray = JSON.parse(data);
            let status = phpArray[0];
            let message = phpArray[1];
            // Scroll to logger
            $("html, body").animate(
              {
                scrollTop: $(createLogger).offset().top,
              },
              1000
            );
            if (status == "success") {
              removeAndReorderImages(imageInput);
            }
            ShowMessage(productLogger, message, status, "none");
            productLoad.style.display = "none";
          },
        });
        modal.remove();
      };
    } else {
      removeAndReorderImages(imageInput);
    }
  }
});