const modalObject = ConfirmationModal();

const modal = modalObject.modal;
const modalText = modalObject.text;
const modalBtn = modalObject.button;

// VARIABLES START

// product storage
let currentProducts = [];

let isEditMode = false;
let productSearchInterval;

// Manage product Page
const productTable = document.querySelector("#products-table tbody");
const productMore = document.querySelector("#load-more-products");
const productRefreshBtn = document.querySelector("#refresh-products");
const cleanProductForm = document.querySelector("#clean-create-form");
const productLoad = document.querySelector("#loader-products");
const productLogger = document.querySelector("#logger-products");
const addNewProduct = document.querySelector("#add-new-product");

// Configure Store Page
const storeLoader = document.querySelector("#loader-store");
const storeLogger = document.querySelector("#logger-store");

// Create product Page
const createLoad = document.querySelector("#loader-create");
const createLogger = document.querySelector("#logger-create");

// VARIABLES END

// FUNCTIONS START

const getCategory = (id) => {
  let category = "";
  // Turn id to integer
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
};

const getPerm = (id) => {
  let perm = "";
  // Turn id to integer
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
};

function setStatus(status) {
  let statusText = "";
  switch (status) {
    case "1":
      statusText = "Listeleniyor";
      break;
    case "0":
      statusText = "Listelenmiyor";
      break;
  }
  return statusText;
}

const deleteProduct = (product) => {
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
  // Set to default
  currentProducts = [];

  productLogger.className = "logger";
  productLogger.innerHTML = "";

  productMore.classList.remove("disabled");
  productMore.disabled = false;

  productTable.innerHTML = "";

  productLoad.style.display = "flex";
  $.ajax({
    url: "/api/dashboard/product/load-products.php",
    type: "POST",
    data: {
      start: 0,
    },
    success: function (data) {
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
      productLoad.style.display = "none";
    },
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

function cleanForm(form) {
  form.reset();
  clearImageInputs(form);
}

// FUNCTIONS END

cleanProductForm.addEventListener("click", () => {
  ShowMessage(createLogger, "Form temizlendi.", "success", "none");
  cleanForm(document.querySelector("#create-form"));
  $("html, body").animate({ scrollTop: $(document).height() }, 1000);
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
    loadFirstProducts();
    document.getElementById("search-pr").value = "";
    document.querySelector("#start-val-products").value = 5;
  });

  loadFirstProducts();
  $("#load-products").submit(function (e) {
    e.preventDefault();
    const startVal = document.querySelector("#start-val-products");
    productLoad.style.display = "flex";
    const formData = new FormData(this);
    $.ajax({
      url: "/api/dashboard/product/load-products.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (data) {
        productLoad.style.display = "none";
        let products = JSON.parse(data);
        for (let i = 0; i < products.length; i++) {
          let product = products[i];
          currentProducts.push(product);
          productTable.append(CreateProductTable(product));
        }
        ShowMessage(
          productLogger,
          "5 ürün başarıyla yüklendi.",
          "success",
          "none"
        );
        // Scroll to load-more button
        $("html, body").animate(
          {
            scrollTop: $(productMore).offset().top,
          },
          1000
        );
        // Disable load-more button if no more products
        if (products.length < 5) {
          productMore.disabled = true;
          productMore.classList.add("disabled");
          ShowMessage(
            productLogger,
            "Daha fazla ürün bulunamadı.",
            "error",
            "none"
          );
          startVal.value = parseInt(startVal.value) - 5;
        }
      },
    });
    // Increment start and end values
    startVal.value = parseInt(startVal.value) + 5;
  });
  $("#create-form").submit(function (e) {
    e.preventDefault();
    createLoad.style.display = "flex";
    let formData = new FormData(this);
    formData.append("image-count", imageCount);
    formData.append("edit-mode", isEditMode ? "true" : "false");
    $.ajax({
      url: "/api/dashboard/product/upload-product.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (data) {
        $("html, body").animate({ scrollTop: $(document).height() }, 1000);
        try {
          let phpArray = JSON.parse(data);
          let status = phpArray[0];
          let message = phpArray[1];
          let cause = phpArray[2];
          ShowMessage(createLogger, message, status, cause);
        } catch (e) {
          ShowMessage(createLogger, data, "error", "none");
        }
        createLoad.style.display = "none";
      },
    });
  });
});
