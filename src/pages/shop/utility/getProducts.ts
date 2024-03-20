import axios from 'axios';
import { setWishlistBtns } from '@/common/managers/shop/wishlistBtnsManager';
import { setAddToCartBtns } from '@/common/managers/shop/cartBtnsManager';

// Get page number from url
const url = new URL(window.location.href);
const page = parseInt(url.searchParams.get('page') as string) || 0;

export const sqlOffset = {
  value: 0,
};

if (page > 1) {
  sqlOffset.value = (page - 1) * 16;
}

const productLimit = {
  value: 16,
};

const productsContainer = document.querySelector('.products') as HTMLDivElement;

export async function getProducts(formData: FormData) {
  const response = await axios({
    url: '/api/main/load-products.php',
    method: 'post',
    data: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'multipart/form-data',
    },
  });
  return response.data;
}

/**
 * When we go to a new page, filter form resets, we need to save the filter form data so we can use it again. FIX THIS
 */
function initPageButtons(
  total_product_count: number,
  slug: string,
  sub_category_slug: string,
  page_num: number
): void {
  // Get the current page from url (products or search)
  const url = new URL(window.location.href);
  const currentPageLink = url.pathname.split('/').slice(+1)[0];

  const pageCount: number = Math.ceil(total_product_count / 16);
  const pageNumbersDiv: HTMLDivElement | null =
    document.querySelector('.page-numbers');

  if (!pageNumbersDiv) return; // Ensure the pageNumbersDiv is not null

  pageNumbersDiv.innerHTML = ''; // Clear the div

  const sub_slug: string = sub_category_slug ? `${sub_category_slug}` : '';

  let hrefStart = '';
  if (currentPageLink === 'search') {
    const query = url.searchParams.get('q');
    hrefStart = `/search?q=${query}&page=`;
  } else {
    hrefStart = `/products/${slug}/${sub_slug}?page=`;
  }

  for (let page: number = 1; page <= pageCount; page++) {
    const a: HTMLAnchorElement = document.createElement('a');
    a.href = `${hrefStart}${page}`;
    a.textContent = page.toString();
    if (page === page_num || (page === 1 && page_num === 0)) {
      a.classList.add('active');
    }
    pageNumbersDiv.appendChild(a);
  }
}

function getProductCount(formData: FormData) {
  return axios({
    url: '/api/main/get-product-count.php',
    method: 'post',
    data: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'multipart/form-data',
    },
  });
}

/**
 * Sets product container content to products from database
 */
export function setProducts(form: HTMLFormElement) {
  const url = new URL(window.location.href);
  const page = parseInt(url.searchParams.get('page') as string) || 0;
  const category_slug = url.pathname.split('/')[2];
  const sub_category_slug = url.pathname.split('/')[3];
  const formData = new FormData(form);
  productsContainer.classList.add('dynamic-content');
  formData.append('offset', sqlOffset.value.toString());
  formData.append('limit', productLimit.value.toString());
  getProducts(formData)
    .then((products) => {
      if (products.length == 0) {
        productsContainer.style.display = 'flex';
        productsContainer.style.justifyContent = 'center';
        productsContainer.style.alignItems = 'center';
        productsContainer.innerHTML = `<div class="no-products"><h2><i class="fa-solid fa-magnifying-glass"></i> Aradığınız ürün bulunamadı.</h2></div>`;
      } else {
        // Reset products container style
        productsContainer.style.display = '';
        productsContainer.style.justifyContent = '';
        productsContainer.style.alignItems = '';
        sqlOffset.value += productLimit.value;
        products.forEach((product: string) => {
          productsContainer.innerHTML += product;
        });
        getProductCount(formData).then((response) => {
          const productCount = response.data;
          initPageButtons(productCount, category_slug, sub_category_slug, page);
        });
      }
    })
    .finally(() => {
      const productElements = productsContainer.querySelectorAll(
        '.product'
      ) as NodeListOf<HTMLDivElement>;

      setWishlistBtns(productElements);
      setAddToCartBtns(productElements);

      setTimeout(() => {
        productsContainer.classList.remove('dynamic-content');
      }, 850);
    });
}

/**
 * Gets products from database by their ids
 * @param formData Must contain product-ids and product-type or limit
 * @returns Promise
 */
export async function getProductsById(formData: FormData) {
  const response = await axios({
    url: '/api/main/load-products-by-id.php',
    method: 'post',
    data: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'multipart/form-data',
    },
  });
  return response.data;
}
