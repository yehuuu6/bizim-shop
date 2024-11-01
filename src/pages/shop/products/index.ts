import { setProducts, sqlOffset } from '@/pages/shop/utility/getProducts';

import './products.css';

// Get products

const loadMoreProductsBtn = document.querySelector(
  '.see-more-products'
) as HTMLButtonElement;

const filterForm = document.querySelector('#filters') as HTMLFormElement;

const productsContainer = document.querySelector('.products') as HTMLDivElement;

const router = document.querySelector('.router') as HTMLDivElement;

const subCatSelector = filterForm.querySelector(
  '#p-sub-category'
) as HTMLSelectElement;

loadMoreProductsBtn.addEventListener('click', function () {
  setProducts(filterForm);
});

function updateRouter() {
  // Reset router text
  const slugLink = router.querySelector(
    '[data-type="slug-link"]'
  ) as HTMLAnchorElement;
  if (slugLink) {
    slugLink.remove();
  }
  // Get category slug from url
  const url = new URL(window.location.href);
  const subCatSlug = decodeURIComponent(
    decodeURIComponent(url.pathname.split('/')[3])
  );
  // Set sub category selector to category slug
  const subCategoryOption = subCatSelector.querySelector(
    `[data-slug="${subCatSlug}"]`
  ) as HTMLOptionElement;

  // Divide url pathname into three parts
  const pathName = url.pathname.split('/').slice(0, 3).join('/');
  // Get target url
  const targetUrl = `${pathName}/${encodeURIComponent(
    encodeURIComponent(subCatSlug)
  )}`;

  // Update router text
  if (subCategoryOption) {
    router.innerHTML += ` <a data-type="slug-link" href="${targetUrl}"> > ${subCategoryOption.innerText}</a>`;
  }
}

updateRouter();

/**
 * Everytime filter form changes, gets new products from database
 */
filterForm.addEventListener('submit', function (e) {
  e.preventDefault();
  loadMoreProductsBtn.disabled = false;
  sqlOffset.value = 0;
  const url = new URL(window.location.href);
  const pathName = url.pathname.split('/').slice(0, 3).join('/');
  const subCatSlug = subCatSelector.options[subCatSelector.selectedIndex]
    .dataset.slug as string;
  // Add sub category slug to url directly
  if (subCatSlug) {
    url.pathname = `${pathName}/${encodeURIComponent(
      encodeURIComponent(subCatSlug)
    )}`;
  } else {
    url.pathname = `${pathName}`;
  }
  window.history.replaceState({}, '', url.href);
  productsContainer.classList.add('dynamic-content');
  productsContainer.innerHTML = '';
  setProducts(filterForm);
  updateRouter();
  setTimeout(() => {
    productsContainer.classList.remove('dynamic-content');
  }, 850);
});

setProducts(filterForm);
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
