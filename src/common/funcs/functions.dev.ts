import { imageCount, isEditMode } from '@/pages/control-center/dashboard';
import { trimSentence } from './functions.usr';
import axios from 'axios';

export function setStatus(status: string) {
  let statusText = '';
  switch (status) {
    case '1':
      statusText = 'Listeleniyor';
      break;
    case '0':
      statusText = 'Arşivlendi';
      break;
  }
  return statusText;
}

const subCatSelector = document.querySelector(
  '#product-sub-category'
) as HTMLSelectElement;

export async function setSubCategories(
  selectedCategoryId: string | null = null
) {
  // If subCatSelector is already filled, don't make a request
  if (subCatSelector.options.length > 1) return;
  const response = await axios({
    url: '/api/dashboard/category/subcategories.php',
    method: 'post',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'multipart/form-data',
    },
  });
  const subCategories = response.data;
  subCatSelector.innerHTML = "<option value='0'>Kategori Seçiniz</option>";
  subCategories.forEach((subCat: any) => {
    if (selectedCategoryId && selectedCategoryId === subCat.id) {
      subCatSelector.innerHTML += `<option value="${subCat.id}" selected>${subCat.name}</option>`;
    } else {
      subCatSelector.innerHTML += `<option value="${subCat.id}">${subCat.name}</option>`;
    }
  });
}

/**
 * This function is used to exit edit mode and clean the form
 */
export function quitEditMode() {
  cleanForm(document.querySelector('#create-form') as HTMLFormElement);
  const button = document.querySelector('#create-product') as HTMLButtonElement;
  const title = document.querySelector('#create-product-title') as HTMLElement;
  const paragraph = document.querySelector(
    '#create-product-text'
  ) as HTMLParagraphElement;
  isEditMode.value = false;
  title.innerText = 'Markete Ürün Ekle';
  paragraph.innerText = 'Yanında (*) olan alanlar zorunludur.';
  button.innerText = 'Ürünü Ekle';
  if (document.querySelector("[name='product-id']")) {
    (
      document.querySelector("[name='product-id']") as HTMLInputElement
    ).remove();
  }
  (
    document.querySelector('#exit-edit-mode') as HTMLButtonElement
  ).classList.add('none-display');
  (document.querySelector('#exit-edit-mode') as HTMLButtonElement).disabled =
    true;
  (
    document.querySelector('button[name="add-image"]') as HTMLButtonElement
  ).disabled = false;
  (
    document.querySelector('button[name="add-image"]') as HTMLButtonElement
  ).className = 'dashboard-btn small-btn add-image-btn';
}

export function addImageInput(addImageBtn: HTMLButtonElement) {
  const template = `
          <div class="form-item" data-type="image-input">
            <div class="width-100 flex-display gap-10">
              <button type="button" title="${imageCount.value}. Resmi Sil" id="remove-pic-${imageCount.value}" class="dashboard-btn delete-btn small-btn"><i class="fa-solid fa-minus"></i></button>
              <label class="dashboard-btn edit-btn" id="image-label-${imageCount.value}" for="product-image-${imageCount.value}">${imageCount.value}. Resim</label>
            </div>
            <p id="image-text-${imageCount.value}" class="display-file">Dosya seçilmedi.</p>
            <input type="file" id="product-image-${imageCount.value}" name="product-image-${imageCount.value}" accept="image/*" />
            <img id="image-preview-${imageCount.value}" src="#" alt="Resim Önizleme" style="width: 100px;height:100px; display: none; object-fit:cover;" />
          </div>
        `;

  addImageBtn?.parentElement?.insertAdjacentHTML('beforebegin', template);

  const fileInput: HTMLInputElement = document.querySelector(
    `#product-image-${imageCount.value}`
  )!;
  const imagePreview: HTMLImageElement = document.querySelector(
    `#image-preview-${imageCount.value}`
  )!;
  const imageText: HTMLParagraphElement = document.querySelector(
    `#image-text-${imageCount.value}`
  )!;

  fileInput.addEventListener('change', function () {
    if (this.files && this.files.length > 0) {
      const file = this.files[0];
      if (file) {
        imagePreview.style.display = 'block';
        const reader = new FileReader();
        reader.onload = function (e) {
          if (e.target && e.target.result) {
            imagePreview.src = e.target.result.toString();
          }
        };
        reader.readAsDataURL(file);
        imageText.title = file.name;
        imageText.textContent = trimSentence(file.name, 20);
      }
    } else {
      imagePreview.style.display = 'none';
      imageText.textContent = 'Dosya seçilmedi.';
    }
  });
  imageCount.value++;
}

export function cleanForm(form: HTMLFormElement) {
  form.reset();
  const imageInputs: HTMLInputElement[] = Array.from(
    document.querySelectorAll("[data-type='image-input']")
  ) as HTMLInputElement[];
  const addImageBtn: HTMLButtonElement = document.querySelector(
    'button[name="add-image"]'
  )!;
  imageInputs.forEach((input) => {
    const button = input.querySelector('button') as HTMLButtonElement;
    if (!button.hasAttribute('data-image')) {
      imageCount.value--;
      input.remove();
    }
  });
  if (imageCount.value <= 6) {
    addImageBtn.disabled = false;
    addImageBtn.className = 'dashboard-btn small-btn add-image-btn';
  }
}
