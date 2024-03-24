import PanelClass from '@/classes/PanelController';
import IProduct from '@/common/interfaces/utility/IProduct';
import {
  createProductTable,
  rowNumberProducts,
  clearImageInputs,
} from './ProductTable';
import { quitEditMode, setSubCategories } from '@/common/funcs/functions.dev';
import { debounce } from '@/common/funcs/functions.usr';

export const currentProducts: { value: IProduct[] } = {
  value: [],
};

let sqlOffset = 0;
let productLimit = 30;

const productMore = document.querySelector(
  '#load-more-products'
) as HTMLButtonElement;
const productTable = document.querySelector(
  '#products-table tbody'
) as HTMLTableSectionElement;
const productLoader = document.querySelector(
  '#loader-products'
) as HTMLDivElement;
const productRefreshBtn = document.querySelector(
  '#refresh-products'
) as HTMLButtonElement;
const searchInput = document.querySelector('#search-pr') as HTMLInputElement;

const ManageProductsPage = new PanelClass(productLoader);

let oldSearch = '';

function runSearchProducts(searchProductInput: HTMLInputElement) {
  let productSearchInterval: any = null;
  // Set interval on focus to search input and clear it when it's not focused
  searchProductInput.addEventListener('focus', () => {
    if (!productSearchInterval) {
      productSearchInterval = setInterval(() => {
        getSearchProduct();
      }, 300); // Throttle the calls to every 300 milliseconds
    }
  });

  searchProductInput.addEventListener('blur', () => {
    clearInterval(productSearchInterval);
    productSearchInterval = null; // Reset the interval variable
  });

  searchProductInput.addEventListener(
    'input',
    debounce(() => {
      getSearchProduct();
    }, 300)
  ); // Debounce the input event to trigger after the user stops typing
}

function getSearchProduct() {
  const search = searchInput.value.trim().toLowerCase();

  if (search === oldSearch) {
    return;
  } else if (search.length <= 0) {
    loadFirstProducts();
    oldSearch = search;
    return;
  }

  productMore.classList.remove('disabled');
  productMore.disabled = false;

  sqlOffset = 0;

  oldSearch = search;

  const formData = new FormData();
  formData.append('search', search);
  formData.append('offset', '0');
  formData.append('limit', productLimit.toString());

  ManageProductsPage.sendApiRequest(
    '/api/dashboard/product/load-products.php',
    formData
  ).then((response) => {
    const products = response;
    if (products === undefined || products.length === 0) {
      productTable.innerHTML = `
        <tr>
          <td colspan="7">Hiçbir ürün bulunamadı</td>
        </tr>
      `;
      return;
    }

    rowNumberProducts.value = 0;
    currentProducts.value = [];
    productTable.innerHTML = '';

    products.forEach((product: IProduct) => {
      currentProducts.value.push(product);
      productTable.appendChild(createProductTable(product));
    });
  });
}

async function loadFirstProducts() {
  sqlOffset = 0;
  searchInput.value = '';
  rowNumberProducts.value = 0;
  currentProducts.value = [];
  productMore.classList.remove('disabled');
  productMore.disabled = false;
  productTable.innerHTML = '';

  const formData = new FormData();
  formData.append('offset', '0');
  formData.append('limit', productLimit.toString());
  const response = await ManageProductsPage.sendApiRequest(
    '/api/dashboard/product/load-products.php',
    formData
  );

  const products = response;
  if (products === undefined || products.length === 0) {
    productTable.innerHTML = `
        <tr>
          <td colspan="7">Hiçbir ürün bulunamadı</td>
        </tr>
      `;
    return;
  }
  if (products !== undefined || products.length !== 0) {
    products.forEach((product: IProduct) => {
      currentProducts.value.push(product);
      productTable.appendChild(createProductTable(product));
    });
  }
}

export function refreshProducts() {
  loadFirstProducts();
}

productRefreshBtn.addEventListener('click', () => {
  refreshProducts();
});

(
  document.querySelector('div[data-name="products"]') as HTMLDivElement
).addEventListener('click', () => {
  refreshProducts();
});
(
  document.querySelector('div[data-name="add-product"]') as HTMLDivElement
).addEventListener('click', () => {
  quitEditMode();
  setSubCategories();
  clearImageInputs();
});

// Load 30 more products on click
productMore.addEventListener('click', function (e) {
  e.preventDefault();
  sqlOffset += productLimit;
  const formData = new FormData();
  formData.append('search', searchInput.value.trim().toLowerCase());
  formData.append('offset', sqlOffset.toString());
  formData.append('limit', productLimit.toString());
  ManageProductsPage.sendApiRequest(
    '/api/dashboard/product/load-products.php',
    formData
  ).then((response) => {
    let products = response;
    if (products === undefined || products.length === 0) {
      productMore.classList.add('disabled');
      productMore.disabled = true;
      sqlOffset -= productLimit;
      ManageProductsPage.showMessage([
        'error',
        'Daha fazla ürün bulunamadı.',
        'none',
      ]);
    } else {
      for (let i = 0; i < products.length; i++) {
        let product = products[i];
        currentProducts.value.push(product);
        productTable.append(createProductTable(product));
        ManageProductsPage.showMessage([
          'success',
          `${productLimit} ürün başarıyla yüklendi.`,
          'none',
        ]);
        window.scrollTo({
          top: document.body.scrollHeight,
          behavior: 'smooth',
        });
      }
    }
  });
});

export default function InitProducts() {
  runSearchProducts(searchInput);
  loadFirstProducts();
}
