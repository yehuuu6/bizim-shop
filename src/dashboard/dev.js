import PanelClass from "./classes/PanelClass.js";
import ConfirmationModal from "./models/Modal.js";
import CreateProductTable from "./models/ProductTable.js";
import { getApiResponse, scrollToElement } from "./utils/functions.usr.js";
import { addImageInput, runSearch, cleanForm } from "./utils/functions.dev.js";
import { setPageContent } from "./routing.js";

const { modal, modalText, modalBtn } = ConfirmationModal();

const currentProducts = {
  value: [],
};
const isEditMode = {
  value: false,
};
const imageCount = {
  value: 1,
};

let startVal = 5;

const cleanProductForm = document.querySelector("#clean-create-form");
const addNewProduct = document.querySelector("#add-new-product");
const productRefreshBtn = document.querySelector("#refresh-products");
const productLogger = document.querySelector("#logger-products");
const productLoad = document.querySelector("#loader-products");
const productMore = document.querySelector("#load-more-products");
const productTable = document.querySelector("#products-table tbody");
const searchInput = document.querySelector("#search-pr");

const createLogger = document.querySelector("#logger-create");
const createLoad = document.querySelector("#loader-create");

const addImageBtn = document.querySelector('button[name="add-image"]');
const maxImages = 6;

const ManageProductsPage = new PanelClass(productLogger, productLoad);
const CreateProductPage = new PanelClass(createLogger, createLoad);

// VARIABLES END

// FUNCTIONS START

function getSearchProduct() {
  const search = searchInput.value.trim().toLowerCase();

  productTable.innerHTML = ""; // Clear the table

  if (search.length > 0) {
    const matchingProducts = currentProducts.value.filter((product) =>
      product["name"].toLowerCase().includes(search)
    );

    if (matchingProducts.length === 0) {
      productTable.innerHTML = `
        <tr>
          <td colspan="7">Hiçbir ürün bulunamadı</td>
        </tr>
      `;
    } else {
      matchingProducts.forEach((product) => {
        productTable.appendChild(CreateProductTable(product));
      });
    }
  } else {
    currentProducts.value.forEach((product) => {
      productTable.appendChild(CreateProductTable(product));
    });
  }
}

async function loadFirstProducts() {
  currentProducts.value = [];
  productMore.classList.remove("disabled");
  productMore.disabled = false;
  productTable.innerHTML = "";

  const formData = new FormData();
  formData.append("start", 0);
  const response = await ManageProductsPage.sendApiRequest(
    "/api/dashboard/product/load-products.php",
    formData
  );

  const products = JSON.parse(response);

  if (products.length === 0) {
    const tr = document.createElement("tr");
    const td = document.createElement("td");
    td.innerText = "Hiçbir ürün bulunamadı";
    td.setAttribute("colspan", "7");
    tr.appendChild(td);
    productTable.appendChild(tr);
  } else {
    products.forEach((product) => {
      currentProducts.value.push(product);
      productTable.appendChild(CreateProductTable(product));
    });
  }
}

runSearch();

function refreshProducts() {
  loadFirstProducts();
  productLogger.innerHTML = "";
  productLogger.className = "logger";
  searchInput.value = "";
  startVal = 5;
}

$(document).ready(function () {
  productRefreshBtn.addEventListener("click", () => {
    refreshProducts();
  });

  document
    .querySelector('div[data-name="products"]')
    .addEventListener("click", () => {
      refreshProducts();
    });
  document
    .querySelector('div[data-name="add-product"]')
    .addEventListener("click", () => {
      cleanForm(document.querySelector("#create-form"));
      isEditMode.value = false;
      document.querySelector("#exit-edit-mode").classList.add("none-display");
      document.querySelector("#exit-edit-mode").disabled = true;
      createLogger.innerHTML = "";
      createLogger.className = "logger";
    });

  loadFirstProducts();

  // Load 5 more products on click
  $("#load-more-products").click(function (e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append("start", startVal);
    ManageProductsPage.sendApiRequest(
      "/api/dashboard/product/load-products.php",
      formData
    ).then((data) => {
      let products = JSON.parse(data);
      if (products.length === 0) {
        productMore.classList.add("disabled");
        productMore.disabled = true;
        ManageProductsPage.showMessage(
          JSON.stringify(["error", "Daha fazla ürün bulunamadı.", "none"])
        );
      }
      for (let i = 0; i < products.length; i++) {
        let product = products[i];
        currentProducts.push(product);
        productTable.append(CreateProductTable(product));
        ManageProductsPage.showMessage(
          JSON.stringify(["success", "5 ürün başarıyla yüklendi.", "none"])
        );
      }
      startVal += 5;
      scrollToElement(productLogger);
    });
  });

  // Save product to database
  $("#create-form").submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append("image-count", imageCount.value);
    formData.append("edit-mode", isEditMode.value ? "true" : "false");
    getApiResponse(
      CreateProductPage,
      "/api/dashboard/product/upload-product.php",
      formData,
      createLogger
    );
  });
});

function removeAndReorderImages(imageInput) {
  imageInput.remove();

  const imageInputs = document.querySelectorAll('[data-type="image-input"]');
  imageInputs.forEach((input, index) => {
    const newIndex = index + 1;

    const button = input.querySelector("button");
    const label = input.querySelector("label");
    const image = input.querySelector("input");
    const imageText = input.querySelector("p");
    const imagePreview = input.querySelector("img");

    button.id = `remove-pic-${newIndex}`;
    button.title = `${newIndex}. Resmi Sil`;
    button.hasAttribute("data-image")
      ? (button.innerText = `${newIndex}. Resmi Kaldır`)
      : (button.innerHTML = `<i class="fa-solid fa-minus"></i>`);
    label.id = `image-label-${newIndex}`;
    label.title = `${newIndex}. Resmi Sil`;
    label.htmlFor = `product-image-${newIndex}`;
    label.textContent = `${newIndex}. Resim`;
    image.id = `product-image-${newIndex}`;
    image.name = `product-image-${newIndex}`;
    imageText.id = `image-text-${newIndex}`;
    imagePreview.id = `image-preview-${newIndex}`;
  });

  addImageBtn.disabled = false;
  addImageBtn.className = "btn primary-btn small-btn";
  imageCount.value--;
}

// Deleting and reordering image inputs
document.addEventListener("click", function (e) {
  const clickedButton = e.target.closest("button");

  if (clickedButton && clickedButton.id.startsWith("remove-pic-")) {
    e.preventDefault();
    const imageInput = clickedButton.closest('[data-type="image-input"]');
    const imageName = clickedButton.getAttribute("data-image");
    const imageNumber = clickedButton.id.split("-")[2];
    if (isEditMode.value == true && imageName !== null) {
      document.body.append(modal);
      modalText.innerText = `${imageName} isimli resmi silmek istediğinize emin misiniz?`;
      modalBtn.onclick = function () {
        const formData = new FormData();
        formData.append("image", imageName);
        formData.append(
          "product-id",
          document.querySelector("[name='product-id']").value
        );
        formData.append("image-number", imageNumber);
        CreateProductPage.sendApiRequest(
          "/api/dashboard/product/delete-image.php",
          formData
        ).then((data) => {
          CreateProductPage.showMessage(data);
          scrollToElement(createLogger);
          if (JSON.parse(data)[0] === "success") {
            removeAndReorderImages(imageInput);
          }
        });
        modal.remove();
      };
    } else {
      removeAndReorderImages(imageInput);
    }
  }
});

// CREATE PRODUCT PAGE START

addImageBtn.addEventListener("click", function (e) {
  e.preventDefault();

  if (imageCount.value > maxImages) {
    CreateProductPage.showMessage(
      JSON.stringify(["error", "En fazla 6 resim yükleyebilirsiniz", "none"])
    );
    addImageBtn.disabled = true;
    addImageBtn.className = "btn small-btn disabled";
    scrollToElement(createLogger);
    return;
  }

  addImageInput(addImageBtn);
});

addNewProduct.addEventListener("click", () => {
  setPageContent("hash", document.getElementById("add-product"));
  cleanForm(document.querySelector("#create-form"));
  isEditMode.value = false;
  document.querySelector("#exit-edit-mode").classList.add("none-display");
  document.querySelector("#exit-edit-mode").disabled = true;
  createLogger.innerHTML = "";
  createLogger.className = "logger";
});

cleanProductForm.addEventListener("click", () => {
  cleanForm(document.querySelector("#create-form"));
  CreateProductPage.showMessage(
    JSON.stringify(["success", "Form başarıyla temizlendi.", "none"])
  );
  scrollToElement(createLogger);
});

// CREATE PRODUCT PAGE END

// Exports

export {
  currentProducts,
  isEditMode,
  imageCount,
  ManageProductsPage,
  CreateProductPage,
  getSearchProduct,
};
