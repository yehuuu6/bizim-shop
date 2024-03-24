import PanelClass from '@/classes/PanelController';
import ConfirmationModal from '@/common/modals/confirmation';
import {
  addImageInput,
  quitEditMode,
  cleanForm,
} from '@/common/funcs/functions.dev';
import router from './Router';
import InitStats from './init/InitStats';
import InitCategories from './init/InitCategory';
import InitOrders from '@/pages/control-center/dashboard/init/orders/InitOrders';
import InitMenuManager from '@/pages/control-center/menuManager';
import InitThemeManager from '@/pages/control-center/themeManager';
import InitProducts, { refreshProducts } from './init/products/InitProducts';
import { setSubCategories } from '@/common/funcs/functions.dev';

// CSS
import '../dashboard.css';
import '@/core/utils.css';
import InitUsers from './init/users/InitUsers';

// Settings panel
const settingsBtn = document.querySelector('#settings') as HTMLButtonElement;
// Settings container
const settingsContainer = document.querySelector(
  '.settings-container'
) as HTMLDivElement;

// If clicked something other than .settings, display none
settingsContainer.addEventListener('click', (e) => {
  if (e.target === settingsContainer) {
    settingsContainer.style.display = 'none';
  }
});

// If clicked settings button, display block
settingsBtn.addEventListener('click', () => {
  settingsContainer.style.display = 'flex';
});

const { modal, modalText, modalBtn } = ConfirmationModal();

const isEditMode = {
  value: false,
};
const imageCount = {
  value: 1,
};

const cleanProductForm = document.querySelector(
  '#clean-create-form'
) as HTMLFormElement;
const addNewProduct = document.querySelector(
  '#add-new-product'
) as HTMLButtonElement;
const productRefreshBtn = document.querySelector(
  '#refresh-products'
) as HTMLButtonElement;
const productLoad = document.querySelector(
  '#loader-products'
) as HTMLDivElement;
const productMore = document.querySelector(
  '#load-more-products'
) as HTMLButtonElement;
const productTable = document.querySelector(
  '#products-table tbody'
) as HTMLTableSectionElement;
const searchInput = document.querySelector('#search-pr') as HTMLInputElement;

const createLoad = document.querySelector('#loader-create') as HTMLDivElement;

const addImageBtn = document.querySelector(
  'button[name="add-image"]'
) as HTMLButtonElement;
const maxImages = 6;

const ManageProductsPage = new PanelClass(productLoad);
const CreateProductPage = new PanelClass(createLoad);

// Delete notification

const deleteNotificationBtn = document.querySelector(
  '#close-logger'
) as HTMLButtonElement;

deleteNotificationBtn.addEventListener('click', () => {
  ManageProductsPage.clearLogger();
});

// VARIABLES END

// Save product to database
(document.getElementById('create-form') as HTMLFormElement).addEventListener(
  'submit',
  function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('image-count', imageCount.value.toString());
    formData.append('edit-mode', isEditMode.value ? 'true' : 'false');
    CreateProductPage.sendApiRequest(
      '/api/dashboard/product/upload-product.php',
      formData
    ).then((data) => {
      CreateProductPage.showMessage(data);
      if (data[0] === 'success') {
        quitEditMode();
        router.setPageContent(
          'hash',
          document.querySelector('#manage-products') as HTMLElement
        );
        refreshProducts();
      }
    });
  }
);

function removeAndReorderImages(imageInput: HTMLInputElement) {
  imageInput.remove();

  const imageInputs = document.querySelectorAll('[data-type="image-input"]');
  imageInputs.forEach((input, index) => {
    const newIndex = index + 1;

    const button = input.querySelector('button') as HTMLButtonElement;
    const label = input.querySelector('label') as HTMLLabelElement;
    const image = input.querySelector('input') as HTMLInputElement;
    const imageText = input.querySelector('p') as HTMLParagraphElement;
    const imagePreview = input.querySelector('img') as HTMLImageElement;

    button.id = `remove-pic-${newIndex}`;
    button.title = `${newIndex}. Resmi Sil`;
    button.hasAttribute('data-image')
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
  addImageBtn.className = 'dashboard-btn small-btn add-image-btn';
  imageCount.value--;
}

// Deleting and reordering image inputs
document.addEventListener('click', function (e) {
  const clickedButton = (e.target as HTMLElement).closest('button');

  if (clickedButton && clickedButton.id.startsWith('remove-pic-')) {
    e.preventDefault();
    const imageInput = clickedButton.closest(
      '[data-type="image-input"]'
    ) as HTMLInputElement;
    const imageName: string = clickedButton.getAttribute('data-image')!;
    const imageNumber: string = clickedButton.id.split('-')[2];
    if (isEditMode.value == true && imageName !== null) {
      document.body.append(modal);
      modalText.innerText = `${imageName} isimli resmi silmek istediğinize emin misiniz?`;
      modalBtn.onclick = function () {
        const formData = new FormData();
        formData.append('image', imageName);
        formData.append(
          'product-id',
          (document.querySelector("[name='product-id']") as HTMLInputElement)
            .value
        );
        formData.append('image-number', imageNumber);
        CreateProductPage.sendApiRequest(
          '/api/dashboard/product/delete-image.php',
          formData
        ).then((data) => {
          CreateProductPage.showMessage(data);
          if (data[0] === 'success') {
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

addImageBtn.addEventListener('click', function (e) {
  e.preventDefault();

  if (imageCount.value > maxImages) {
    CreateProductPage.showMessage([
      'error',
      'En fazla 6 resim yükleyebilirsiniz',
      'none',
    ]);
    addImageBtn.disabled = true;
    addImageBtn.className = 'dashboard-btn small-btn disabled';
    return;
  }

  addImageInput(addImageBtn);
});

addNewProduct.addEventListener('click', () => {
  const destination = document.querySelector('#add-product') as HTMLElement;
  router.loadPage('hash', destination.dataset.url!);
  quitEditMode();
});

cleanProductForm.addEventListener('click', () => {
  cleanForm(document.querySelector('#create-form') as HTMLFormElement);
  CreateProductPage.showMessage([
    'success',
    'Form başarıyla temizlendi.',
    'none',
  ]);
});

document.addEventListener('DOMContentLoaded', () => {
  setSubCategories(); // This is needed because at the first page load, if you edit a product, its sub category wont be selected without this.
  InitStats();
  InitCategories();
  InitMenuManager();
  InitThemeManager();
  InitOrders();
  InitProducts();
  InitUsers();
});

// CREATE PRODUCT PAGE END

// Maintenance mode controller

const maintenanceBtn = document.querySelector(
  '#maintenance-btn'
) as HTMLButtonElement;

maintenanceBtn.addEventListener('click', () => {
  const formData = new FormData();
  ManageProductsPage.sendApiRequest(
    '/api/dashboard/maintenance.php',
    formData
  ).then((data) => {
    const maintenanceStatus = data[1];
    const msg =
      maintenanceStatus === 'true'
        ? 'Bakım moduna alındı.'
        : 'Bakım modundan çıkıldı.';
    ManageProductsPage.showMessage(['success', msg, 'none']);
    // Update the maintenance button
    maintenanceBtn.innerText =
      maintenanceStatus === 'true' ? 'Bakım Modundan Çık' : 'Bakım Moduna Al';
  });
});

// Category controller

// Exports

export { isEditMode, imageCount, ManageProductsPage, CreateProductPage };
