import './product.css';
import { setAddToCartBtns } from '@/common/managers/shop/cartBtnsManager';
import { setWishlistBtns } from '@/common/managers/shop/wishlistBtnsManager';
import { initQuestions } from './questions';
import axios from 'axios';

const products = document.querySelectorAll(
  '.product-container'
) as NodeListOf<HTMLDivElement>;

setAddToCartBtns(products);
setWishlistBtns(products);

const currentProduct = products[0];

const productId = currentProduct.dataset.id as string;
// Save the product id in latest viewed products if id does not already exist
if (!localStorage.getItem('lvp')?.includes(productId)) {
  localStorage.setItem(
    'lvp',
    JSON.stringify([
      productId,
      ...JSON.parse(localStorage.getItem('lvp') || '[]'),
    ])
  );
} else {
  // If product id already exists, move it to the front
  const lvp = JSON.parse(localStorage.getItem('lvp') || '[]');
  const index = lvp.indexOf(productId);
  lvp.splice(index, 1);
  localStorage.setItem('lvp', JSON.stringify([productId, ...lvp]));
}

// if length of lvp is greater than 5, remove the last item
if (JSON.parse(localStorage.getItem('lvp') || '[]').length > 5) {
  const lvp = JSON.parse(localStorage.getItem('lvp') || '[]');
  lvp.pop();
  localStorage.setItem('lvp', JSON.stringify(lvp));
}

// Control image showcase

const showcaseImgs = document.querySelectorAll(
  'img[data-img]'
) as NodeListOf<HTMLImageElement>;
const showcase = document.querySelector('.big-image') as HTMLDivElement;

showcaseImgs.forEach((img) => {
  img.addEventListener('click', () => {
    const replace = showcase.querySelector('img') as HTMLImageElement;
    replace.classList.add('dynamic-content');
    replace.src = img.src;
    setTimeout(() => {
      replace.classList.remove('dynamic-content');
    }, 850);
  });
});

const randomProductWrapper = document.querySelector(
  '#random-products'
) as HTMLDivElement;

const randomProducts = axios({
  url: '/api/main/get-random-products.php',
  method: 'POST',
  data: {
    id: productId,
  },
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    'Content-Type': 'multipart/form-data',
  },
});

randomProducts
  .then((res) => {
    const products = res.data;
    for (const product of products) {
      randomProductWrapper.innerHTML += product;
    }
  })
  .finally(() => {
    const products = randomProductWrapper.querySelectorAll(
      '.product'
    ) as NodeListOf<HTMLDivElement>;
    setAddToCartBtns(products);
    setWishlistBtns(products);
  });

initQuestions();

// Sticky window for pictures
window.addEventListener('scroll', () => {
  const pContainer = document.querySelector(
    '.product-container'
  ) as HTMLDivElement;
  const stickyElement = document.querySelector(
    '.product-images'
  ) as HTMLDivElement;
  const stickyPoint = pContainer.offsetTop;
  const bottomLimit = pContainer.offsetTop + pContainer.offsetHeight;

  if (
    window.scrollY >= stickyPoint &&
    window.scrollY + stickyElement.offsetHeight < bottomLimit
  ) {
    stickyElement.classList.add('sticky');
  }
});
