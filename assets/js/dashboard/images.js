const addImageBtn = document.querySelector('button[name="add-image"]');
const maxImages = 6;
let imageCount = 1;

function addImageInput(imageCount) {
  const template = `
    <div class="form-item" data-type="image-input">
      <div class="width-100 flex-display gap-10">
        <button type="button" title="${imageCount}. Resmi Sil" id="remove-pic-${imageCount}" class="btn delete-btn small-btn"><i class="fa-solid fa-minus"></i></button>
        <label class="btn edit-btn" id="image-label-${imageCount}" for="product-image-${imageCount}">${imageCount}. Resim</label>
      </div>
      <p id="image-text-${imageCount}" class="display-file">Dosya seçilmedi.</p>
      <input type="file" id="product-image-${imageCount}" name="product-image-${imageCount}" accept="image/*" />
      <img id="image-preview-${imageCount}" src="#" alt="Resim Önizleme" style="width: 100px;height:100px; display: none; object-fit:cover;" />
    </div>
  `;

  addImageBtn.parentElement.insertAdjacentHTML("beforebegin", template);

  const fileInput = document.querySelector(`#product-image-${imageCount}`);
  const imagePreview = document.querySelector(`#image-preview-${imageCount}`);
  const imageText = document.querySelector(`#image-text-${imageCount}`);

  fileInput.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      imagePreview.style.display = "block";
      const reader = new FileReader();
      reader.onload = function (e) {
        imagePreview.src = e.target.result;
      };
      reader.readAsDataURL(file);
      imageText.textContent = file.name;
    } else {
      imagePreview.style.display = "none";
      imageText.textContent = "Dosya seçilmedi.";
    }
  });
}

addImageBtn.addEventListener("click", function (e) {
  e.preventDefault();

  if (imageCount > maxImages) {
    // Scroll to bottom using jquery
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    ShowMessage(
      createLogger,
      "En fazla 6 adet resim ekleyebilirsiniz.",
      "error",
      "none"
    );
    addImageBtn.disabled = true;
    addImageBtn.className = "btn small-btn disabled";
    return;
  }

  addImageInput(imageCount);
  imageCount++;
});

function editProduct(product) {
  const _form = document.querySelector("#create-form");
  clearImageInputs(_form);
  const idInput = document.createElement("input");
  idInput.type = "hidden";
  idInput.name = "product-id";
  idInput.value = product["id"];
  _form.appendChild(idInput);
  isEditMode = true;
  ShowMessage(
    createLogger,
    "Ürün düzenleme moduna girdiniz.",
    "warning",
    "none"
  );
  $("html, body").animate({ scrollTop: $(document).height() }, 1000);
  let images = [];
  for (let i = 1; i <= 6; i++) {
    const imageKey = `image${i}`;
    if (product[imageKey] !== "noimg.jpg") {
      images.push(product[imageKey]);
    }
  }

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

  // Create image inputs for each image
  images.forEach(function (image, index) {
    imageCount++;
    addImageInput(index + 1);
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

  exitEditMode.classList.remove("none-display");
  name.value = product["name"];
  price.value = product["price"];
  tags.value = product["tags"];
  description.value = product["description"];
  category.value = product["category"];
  quality.value = product["quality"];
  shipment.value = product["shipment"];
  featured.value = product["featured"];

  setPageContent("hash", createProduct);

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
    isEditMode = false;
    exitEditMode.classList.add("none-display");
    button.innerText = "Ürün Ekle";
    title.innerText = "Markete Ürün Ekle";
    paragraph.innerText = "Yanında (*) olan alanlar zorunludur.";
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
  });
}

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
  imageCount--;
}

document.addEventListener("click", function (e) {
  const clickedButton = e.target.closest("button");

  if (clickedButton && clickedButton.id.startsWith("remove-pic-")) {
    e.preventDefault();
    const imageInput = clickedButton.closest('[data-type="image-input"]');
    const imageName = clickedButton.getAttribute("data-image");
    if (isEditMode && imageName !== null) {
      document.body.append(modal);
      delModText.innerText = `${imageName} isimli resmi silmek istediğinize emin misiniz?`;
      delModCon.onclick = function () {
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
