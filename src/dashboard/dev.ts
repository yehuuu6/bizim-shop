import PanelClass from "./classes/PanelClass";
import ConfirmationModal from "./models/Modal";
import {Product, CreateProductTable} from "./models/ProductTable";
import { getApiResponse, scrollToElement } from "./utils/functions.usr";
import { addImageInput, runSearch, cleanForm } from "./utils/functions.dev";
import { setPageContent } from "./routing";

const { modal, modalText, modalBtn } = ConfirmationModal();

const currentProducts: { value: Product[] } = {
  value: [],
};
const isEditMode = {
  value: false,
};
const imageCount = {
  value: 1,
};

let startVal = 5;

const cleanProductForm: HTMLFormElement = document.querySelector("#clean-create-form")!;
const addNewProduct: HTMLButtonElement = document.querySelector("#add-new-product")!;
const productRefreshBtn: HTMLButtonElement = document.querySelector("#refresh-products")!;
const productLogger: HTMLParagraphElement = document.querySelector("#logger-products")!;
const productLoad: HTMLDivElement = document.querySelector("#loader-products")!;
const productMore: HTMLButtonElement = document.querySelector("#load-more-products")!;
const productTable: HTMLTableSectionElement = document.querySelector("#products-table tbody")!;
const searchInput: HTMLInputElement = document.querySelector("#search-pr")!;
const exitEditModeBtn: HTMLButtonElement = document.querySelector("#exit-edit-mode")!;

const createLogger: HTMLParagraphElement = document.querySelector("#logger-create")!;
const createLoad: HTMLDivElement = document.querySelector("#loader-create")!;

const addImageBtn: HTMLButtonElement = document.querySelector('button[name="add-image"]')!;
const maxImages = 6;

const ManageProductsPage = new PanelClass(productLogger, productLoad);
const CreateProductPage = new PanelClass(createLogger, createLoad);

// VARIABLES END

// FUNCTIONS START

function getSearchProduct() {
  const search = searchInput.value.trim().toLowerCase();

  productTable.innerHTML = "";

  if (search.length > 0) {
    const matchingProducts = currentProducts.value.filter((product: Product) =>
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
  formData.append("start", "0");
  const response = await ManageProductsPage.sendApiRequest(
    "/api/dashboard/product/load-products.php",
    formData
  );

  const products = response;

  if (products !== undefined || products.length !== 0) {
    products.forEach((product: Product) => {
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

  (document
    .querySelector('div[data-name="products"]') as HTMLDivElement)
    .addEventListener("click", () => {
      refreshProducts();
    });
  (document
    .querySelector('div[data-name="add-product"]') as HTMLDivElement)
    .addEventListener("click", () => {
      cleanForm((document.querySelector("#create-form") as HTMLFormElement));
      isEditMode.value = false;
      exitEditModeBtn.classList.add("none-display");
      exitEditModeBtn.disabled = true;
      createLogger.innerHTML = "";
      createLogger.className = "logger";
    });

  loadFirstProducts();

  // Load 5 more products on click
  $("#load-more-products").click(function (e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append("start", startVal.toString());
    ManageProductsPage.sendApiRequest(
      "/api/dashboard/product/load-products.php",
      formData
    ).then((response) => {
      let products = response.data;
      if (products === undefined || products.length === 0) {
        productMore.classList.add("disabled");
        productMore.disabled = true;
        ManageProductsPage.showMessage([
          "error",
          "Daha fazla ürün bulunamadı.",
          "none",
        ]);
      } else {
        for (let i = 0; i < products.length; i++) {
          let product = products[i];
          currentProducts.value.push(product);
          productTable.append(CreateProductTable(product));
          ManageProductsPage.showMessage([
            "success",
            "5 ürün başarıyla yüklendi.",
            "none",
          ]);
        }
      }
      startVal += 5;
      scrollToElement(productLogger);
    });
  });

  // Save product to database
  (document.getElementById("create-form") as HTMLFormElement)!.addEventListener("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append("image-count", imageCount.value.toString());
    formData.append("edit-mode", isEditMode.value ? "true" : "false");
    getApiResponse(
      CreateProductPage,
      "/api/dashboard/product/upload-product.php",
      formData,
      createLogger
    );
  });
});

function removeAndReorderImages(imageInput: HTMLInputElement) {
  imageInput.remove();

  const imageInputs = document.querySelectorAll('[data-type="image-input"]');
  imageInputs.forEach((input, index) => {
    const newIndex = index + 1;

    const button: HTMLButtonElement = input.querySelector("button")!;
    const label: HTMLLabelElement = input.querySelector("label")!;
    const image: HTMLInputElement = input.querySelector("input")!;
    const imageText: HTMLParagraphElement = input.querySelector("p")!;
    const imagePreview: HTMLImageElement = input.querySelector("img")!;

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
  const clickedButton = (e.target as HTMLElement).closest("button");

  if (clickedButton && clickedButton.id.startsWith("remove-pic-")) {
    e.preventDefault();
    const imageInput: HTMLInputElement = clickedButton.closest('[data-type="image-input"]')!;
    const imageName: string = clickedButton.getAttribute("data-image")!;
    const imageNumber: string = clickedButton.id.split("-")[2];
    if (isEditMode.value == true && imageName !== null) {
      document.body.append(modal);
      modalText.innerText = `${imageName} isimli resmi silmek istediğinize emin misiniz?`;
      modalBtn.onclick = function () {
        const formData = new FormData();
        formData.append("image", imageName);
        formData.append(
          "product-id",
          (document.querySelector("[name='product-id']") as HTMLInputElement).value
        );
        formData.append("image-number", imageNumber);
        CreateProductPage.sendApiRequest(
          "/api/dashboard/product/delete-image.php",
          formData
        ).then((data) => {
          CreateProductPage.showMessage(data);
          scrollToElement(createLogger);
          if (data[0] === "success") {
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
    CreateProductPage.showMessage([
      "error",
      "En fazla 6 resim yükleyebilirsiniz",
      "none",
    ]);
    addImageBtn.disabled = true;
    addImageBtn.className = "btn small-btn disabled";
    scrollToElement(createLogger);
    return;
  }

  addImageInput(addImageBtn);
});

addNewProduct.addEventListener("click", () => {
  setPageContent("hash", document.getElementById("add-product") as HTMLElement);
  cleanForm((document.querySelector("#create-form") as HTMLFormElement));
  isEditMode.value = false;
  exitEditModeBtn.classList.add("none-display");
  exitEditModeBtn.disabled = true;
  createLogger.innerHTML = "";
  createLogger.className = "logger";
});

cleanProductForm.addEventListener("click", () => {
  cleanForm((document.querySelector("#create-form") as HTMLFormElement));
  CreateProductPage.showMessage([
    "success",
    "Form başarıyla temizlendi.",
    "none",
  ]);
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
