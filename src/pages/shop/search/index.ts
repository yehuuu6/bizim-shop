import { setProducts, sqlOffset } from '@/pages/shop/utility/getProducts';

import '@/pages/shop/products/products.css';

// Get products

const filterForm = document.querySelector('#filters') as HTMLFormElement;

const productsContainer = document.querySelector('.products') as HTMLDivElement;

const loadMoreProductsBtn = document.querySelector(
  '.see-more-products'
) as HTMLButtonElement;

/**
 * Everytime filter form changes, gets new products from database
 */
filterForm.addEventListener('submit', function (e) {
  e.preventDefault();
  sqlOffset.value = 0;
  loadMoreProductsBtn.disabled = false;
  productsContainer.classList.add('dynamic-content');
  productsContainer.innerHTML = '';
  setProducts(filterForm);
  setTimeout(() => {
    productsContainer.classList.remove('dynamic-content');
  }, 850);
});

// Get products when page loads
setProducts(filterForm);

// Load more products
loadMoreProductsBtn.addEventListener('click', function () {
  setProducts(filterForm);
});

window.addEventListener('scroll', () => {
  const pContainer = document.querySelector(
    '#product-lister'
  ) as HTMLDivElement;
  const stickyElement = document.querySelector('#filters') as HTMLDivElement;
  const stickyPoint = pContainer.offsetTop;
  const bottomLimit = pContainer.offsetTop + pContainer.offsetHeight;

  if (
    window.scrollY >= stickyPoint &&
    window.scrollY + stickyElement.offsetHeight < bottomLimit
  ) {
    stickyElement.classList.add('sticky');
  }
});
