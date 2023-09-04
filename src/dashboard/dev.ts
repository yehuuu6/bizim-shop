import PanelClass from "./classes/PanelClass";
import ConfirmationModal from "./models/Modal";
import { ProductInterface, createProductTable, clearImageInputs, rowNumberProducts } from "./models/ProductTable";
import { addImageInput, runSearchProducts, cleanForm, quitEditMode } from "./utils/functions.dev";
import router from "./Router";

const { modal, modalText, modalBtn } = ConfirmationModal();

const currentProducts: { value: ProductInterface[] } = {
  value: [],
};
const isEditMode = {
  value: false,
};
const imageCount = {
  value: 1,
};

let startVal = 0;

const cleanProductForm = document.querySelector("#clean-create-form") as HTMLFormElement;
const addNewProduct = document.querySelector("#add-new-product") as HTMLButtonElement;
const productRefreshBtn = document.querySelector("#refresh-products") as HTMLButtonElement;
const productLoad = document.querySelector("#loader-products") as HTMLDivElement;
const productMore = document.querySelector("#load-more-products") as HTMLButtonElement;
const productTable = document.querySelector("#products-table tbody") as HTMLTableSectionElement;
const searchInput = document.querySelector("#search-pr") as HTMLInputElement;

const createLoad = document.querySelector("#loader-create") as HTMLDivElement;

const addImageBtn = document.querySelector('button[name="add-image"]') as HTMLButtonElement;
const maxImages = 6;

const ManageProductsPage = new PanelClass(productLoad);
const CreateProductPage = new PanelClass(createLoad);

// VARIABLES END

// FUNCTIONS START

function getSearchProduct() {
  rowNumberProducts.value = 0;
  const search = searchInput.value.trim().toLowerCase();
  productTable.innerHTML = "";
  if (search.length > 0) {
    const matchingProducts = currentProducts.value.filter((product: ProductInterface) =>
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
        productTable.appendChild(createProductTable(product));
      });
    }
  } else {
    currentProducts.value.forEach((product) => {
      productTable.appendChild(createProductTable(product));
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
    products.forEach((product: ProductInterface) => {
      currentProducts.value.push(product);
      productTable.appendChild(createProductTable(product));
    });
  }
}

runSearchProducts(searchInput);

function refreshProducts() {
  loadFirstProducts();
  searchInput.value = "";
  startVal = 0;
  rowNumberProducts.value = 0;
}

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
    quitEditMode();
    clearImageInputs();
});

loadFirstProducts();

// Load 5 more products on click
productMore.addEventListener("click", function (e) {
  e.preventDefault();
  startVal += 5;
  const formData = new FormData();
  formData.append("start", startVal.toString());
  ManageProductsPage.sendApiRequest(
    "/api/dashboard/product/load-products.php",
    formData
  ).then((response) => {
    let products = response;
    if (products === undefined || products.length === 0) {
      productMore.classList.add("disabled");
      productMore.disabled = true;
      startVal -= 5;
      ManageProductsPage.showMessage([
        "error",
        "Daha fazla ürün bulunamadı.",
        "none",
      ]);
    } else {
      for (let i = 0; i < products.length; i++) {
        let product = products[i];
        currentProducts.value.push(product);
        productTable.append(createProductTable(product));
        ManageProductsPage.showMessage([
          "success",
          "5 ürün başarıyla yüklendi.",
          "none",
        ]);
        window.scrollTo({
          top: document.body.scrollHeight,
          behavior: 'smooth'
        });
      }
    }
  });
});

// Save product to database
(document.getElementById("create-form") as HTMLFormElement).addEventListener("submit", function (e) {
  e.preventDefault();
  let formData = new FormData(this);
  formData.append("image-count", imageCount.value.toString());
  formData.append("edit-mode", isEditMode.value ? "true" : "false");
  CreateProductPage.sendApiRequest(
    "/api/dashboard/product/upload-product.php",
    formData
  ).then((data) => {
    CreateProductPage.showMessage(data);
    if (data[0] === "success"){
      quitEditMode();
      router.setPageContent("hash", (document.querySelector("#manage-products") as HTMLElement));
      refreshProducts();
    }
  });
});

function removeAndReorderImages(imageInput: HTMLInputElement) {
  imageInput.remove();

  const imageInputs = document.querySelectorAll('[data-type="image-input"]');
  imageInputs.forEach((input, index) => {
    const newIndex = index + 1;

    const button = input.querySelector("button") as HTMLButtonElement;
    const label = input.querySelector("label") as HTMLLabelElement;
    const image = input.querySelector("input") as HTMLInputElement;
    const imageText = input.querySelector("p") as HTMLParagraphElement;
    const imagePreview = input.querySelector("img") as HTMLImageElement;

    button.id = `remove-pic-${newIndex}`;
    button.title = `${newIndex}. Resmi Sil`;
    button.hasAttribute("data-image")
      ? (button.innerText = `${newIndex}. Resmi Sil`)
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
  addImageBtn.className = "btn small-btn";
  imageCount.value--;
}

// Deleting and reordering image inputs
document.addEventListener("click", function (e) {
  const clickedButton = (e.target as HTMLElement).closest("button");

  if (clickedButton && clickedButton.id.startsWith("remove-pic-")) {
    e.preventDefault();
    const imageInput = clickedButton.closest('[data-type="image-input"]') as HTMLInputElement;
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
    return;
  }

  addImageInput(addImageBtn);
});

addNewProduct.addEventListener("click", () => {
  const destination = document.querySelector("#add-product") as HTMLElement;
  router.loadPage("hash", destination.dataset.url!);
  quitEditMode();
});

cleanProductForm.addEventListener("click", () => {
  cleanForm((document.querySelector("#create-form") as HTMLFormElement));
  CreateProductPage.showMessage([
    "success",
    "Form başarıyla temizlendi.",
    "none",
  ]);
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
