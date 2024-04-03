import {
  CreateProductPage,
  ManageProductsPage,
  isEditMode,
  imageCount,
} from '../..'; // from index.ts
import ConfirmationModal from '@/common/modals/confirmation';
import {
  setStatus,
  addImageInput,
  quitEditMode,
} from '@/common/funcs/functions.dev';
import router from '@/pages/control-center/dashboard/Router';
import { trimSentence } from '@/common/funcs/functions.usr';

import { currentProducts } from './InitProducts';

import IProduct from '@/common/interfaces/utility/IProduct';

const { modal, modalText, modalBtn } = ConfirmationModal();

const addImageBtn = document.querySelector(
  'button[name="add-image"]'
) as HTMLButtonElement;

export const rowNumberProducts = {
  value: 0,
};

const productsTable = document.querySelector(
  '#products-table'
) as HTMLTableElement;

export function createProductTable(product: IProduct) {
  // Create table row
  const tr = document.createElement('tr');
  let price = parseFloat(product.price);
  // Calculate KDV and add it to the price
  price += price * 0.2;
  let readablePrice = price.toLocaleString('tr-TR', {
    minimumFractionDigits: 2,
  });
  tr.innerHTML = `
    <td>${++rowNumberProducts.value}</td>
    <td><a href="http://localhost/product/${product.link}" target="_blank">${
    product.name
  }</a></td>
    <td>${product.sub_category_name}</td>
    <td>₺${readablePrice}</td>
    <td data-mission="status">${setStatus(product.status)}</td>
    <td class="table-form-td">
      <form class="table-form" data-id="${product.id}">
        <button data-action="status" class="dashboard-btn ${
          product.status === '1' ? 'status-btn' : 'success-btn'
        }">${product.status === '1' ? 'Arşivle' : 'Listele'}</button>
        <button data-action="edit" class="dashboard-btn edit-btn">Düzenle</button>
        <button data-action="delete" class="dashboard-btn delete-btn">Sil</button>
      </form>
    </td>
  `;

  const tableForm = tr.querySelector('.table-form') as HTMLElement;

  tableForm.addEventListener('click', async (e) => {
    e.preventDefault();
    const id = (e.currentTarget as HTMLElement).dataset.id!;
    const clickedAction = (e.target as HTMLElement).dataset.action;

    const selectedProduct: IProduct = currentProducts.value.find(
      (p: IProduct) => p.id === id
    )!;
    if (clickedAction === 'edit') {
      editProduct(selectedProduct);
    } else if (clickedAction === 'delete') {
      deleteProduct(selectedProduct);
    } else if (clickedAction === 'status') {
      const newStatus = product.status === '1' ? '0' : '1';

      const formData = new FormData();
      formData.append('id', id);
      formData.append('status', newStatus);

      const response = await ManageProductsPage.sendApiRequest(
        '/api/dashboard/product/change-status.php',
        formData
      );

      if (response[0] === 'success') {
        product.status = newStatus;
        (e.target as HTMLElement).innerText =
          newStatus === '1' ? 'Arşivle' : 'Listele';
        (tr.querySelector("[data-mission='status']") as HTMLElement).innerText =
          setStatus(newStatus);
        (e.target as HTMLElement).className = `dashboard-btn ${
          newStatus === '1' ? 'status-btn' : 'success-btn'
        }`;
      }

      ManageProductsPage.showMessage(response);
    }
  });

  return tr;
}

function deleteProduct(product: IProduct) {
  document.body.appendChild(modal);
  modalText.innerText = `"${product.name}" isimli ürünü silmek üzeresiniz.`;

  modalBtn.onclick = async () => {
    const formData = new FormData();
    formData.append('id', product.id);

    try {
      const response = await CreateProductPage.sendApiRequest(
        '/api/dashboard/product/delete-product.php',
        formData
      );

      ManageProductsPage.showMessage(response);

      if (response[0] === 'success') {
        // Delete the product from the currentProducts array
        currentProducts.value = currentProducts.value.filter(
          (p: IProduct) => p.id !== product.id
        );

        const child = productsTable.querySelector(`[data-id="${product.id}"]`);
        if (child) {
          (
            (child.parentElement as HTMLElement).parentElement as HTMLElement
          ).remove();
        }
      }
    } catch (e) {
      ManageProductsPage.showMessage(['error', 'Bir hata oluştu.', 'none']);
    } finally {
      modal.remove();
    }
  };
}

function editProduct(product: IProduct) {
  isEditMode.value = true;
  product.description = product.description.replace(/<br>/g, '\n'); // Replace <br> with new line

  if (document.querySelector("[name='product-id']")) {
    (
      document.querySelector("[name='product-id']") as HTMLInputElement
    ).remove();
  }
  const form = document.querySelector('#create-form') as HTMLFormElement;
  const destination = document.querySelector('#add-product') as HTMLElement;
  router.loadPage('hash', destination.dataset.url!);
  clearImageInputs();

  const inputId = document.createElement('input');
  inputId.type = 'hidden';
  inputId.name = 'product-id';
  inputId.value = product.id;
  form.appendChild(inputId);

  CreateProductPage.showMessage([
    'warning',
    `${product.name} isimli ürünü düzenliyorsunuz.`,
    'none',
  ]);

  const exitEditMode = document.querySelector(
    '#exit-edit-mode'
  ) as HTMLButtonElement;
  const button = document.querySelector('#create-product') as HTMLButtonElement;
  const title = document.querySelector('#create-product-title') as HTMLElement;
  const paragraph = document.querySelector(
    '#create-product-text'
  ) as HTMLParagraphElement;
  button.innerText = 'Değişiklikleri Kaydet';
  title.innerText = `${product.name} Ürününü Düzenliyorsunuz.`;
  paragraph.innerText = `Düzenleme modundan çıkmak için yanda bulunan X butonuna basabilirsiniz.`;

  const elements = [
    { element: document.querySelector('#product-name'), key: 'name' },
    { element: document.querySelector('#product-price'), key: 'price' },
    { element: document.querySelector('#shipping-cost'), key: 'shipping_cost' },
    { element: document.querySelector('#product-tags'), key: 'tags' },
    {
      element: document.querySelector('#product-description'),
      key: 'description',
    },
    { element: document.querySelector('#quality'), key: 'quality' },
    { element: document.querySelector('#shipment'), key: 'shipment' },
    { element: document.querySelector('#featured'), key: 'featured' },
    {
      element: document.querySelector('#product-sub-category'),
      key: 'subcategory',
    },
  ];

  exitEditMode.classList.remove('none-display');
  exitEditMode.disabled = false;

  elements.forEach((el) => {
    const input = el.element as HTMLInputElement;
    input.value = product[el.key];
  });

  const images: string[] = [];
  for (let i = 1; i <= 6; i++) {
    const imageKey = `image${i}`;
    if (product[imageKey] !== 'noimg.jpg') {
      images.push(product[imageKey]);
    }
  }

  images.forEach((image, index) => {
    addImageInput(addImageBtn);
    const deleteImageBtn = document.querySelector(
      `button[id="remove-pic-${index + 1}"]`
    ) as HTMLButtonElement;
    deleteImageBtn.dataset.image = image;
    deleteImageBtn.classList.remove('small-btn');
    deleteImageBtn.innerHTML = `${index + 1}. Resmi Sil`;
    const imagePreview = document.querySelector(
      `#image-preview-${index + 1}`
    ) as HTMLImageElement;
    const imageText = document.querySelector(
      `#image-text-${index + 1}`
    ) as HTMLParagraphElement;
    const imageLabel = document.querySelector(
      `#image-label-${index + 1}`
    ) as HTMLLabelElement;
    const imageInput = document.querySelector(
      `#product-image-${index + 1}`
    ) as HTMLInputElement;
    const hostname = window.location.origin;
    // Hide imageLabel and imageInput
    imageLabel.style.display = 'none';
    imageInput.style.display = 'none';
    imageInput.disabled = true;
    imagePreview.style.display = 'block';
    imageText.textContent = trimSentence(product[`image${index + 1}`], 20);
    imageText.title = product[`image${index + 1}`];
    imagePreview.src = `${hostname}/images/product/${
      product['root_name']
    }/${image}?timestamp=${Date.now()}`;
  });

  exitEditMode.addEventListener('click', () => {
    CreateProductPage.showMessage([
      'warning',
      'Ürün düzenleme modundan çıktınız.',
      'none',
    ]);
    clearImageInputs();
    title.innerText = 'Markete Ürün Ekle';
    paragraph.innerText = 'Yanında (*) olan alanlar zorunludur.';
    button.innerText = 'Ürünü Ekle';
    quitEditMode();
  });
}

export function clearImageInputs() {
  imageCount.value = 1;
  const imageInputs = (
    document.querySelector('#create-form') as HTMLFormElement
  ).querySelectorAll("[data-type='image-input']");
  imageInputs.forEach((input) => input.remove());
  const addImageBtn = document.querySelector(
    'button[name="add-image"]'
  ) as HTMLButtonElement;
  addImageBtn.className = 'dashboard-btn small-btn add-image-btn';
  addImageBtn.disabled = false;
}
