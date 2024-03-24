import { getProductsById } from '@/pages/shop/utility/getProducts';
import { setWishlistBtns } from '@/pages/shop/wishlist/wishlistBtnsManager';
import { setAddToCartBtns } from '@/pages/shop/cart/cartBtnsManager';
import initShoppingCart from './cartManager';
import { resetShowcases } from '.';

import '@/pages/shop/products/products.css';

const lvpContainer = document.querySelector(
  '#last-viewed-products'
) as HTMLDivElement;

/**
 * Initializes latest viewed products by getting products from localStorage.
 */
export default function initLatestProducts() {
  lvpContainer.innerHTML = '';
  const lvpProducts = JSON.parse(localStorage.getItem('lvp') || '[]');

  getProductsById(createFormData(lvpProducts))
    .then((products) => {
      if (products.length < 1) {
        lvpContainer.innerHTML +=
          '<div class="no-products"><h2><i class="fa-solid fa-magnifying-glass"></i> Son görüntülenen ürün bulunamadı.</h2></div>';
      } else {
        products.forEach((product: string) => {
          lvpContainer.innerHTML += product;
        });
      }
    })
    .finally(() => {
      const productElements = lvpContainer.querySelectorAll(
        '.product'
      ) as NodeListOf<HTMLDivElement>;

      // Set wishlist buttons
      setWishlistBtns(productElements);
      // Set add to cart buttons
      setAddToCartBtns(productElements);

      const cartBtns = lvpContainer.querySelectorAll(
        '.product #product-cart-btn'
      ) as NodeListOf<HTMLButtonElement>;

      cartBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
          // Refresh the shopping cart and showcases
          const id = (btn.closest('.product') as HTMLDivElement).dataset
            .id as string;
          initShoppingCart();
          resetShowcases(id, 'cart');
        });
      });

      const wishlistBtns = lvpContainer.querySelectorAll(
        "span[class^='add-wishlist']"
      ) as NodeListOf<HTMLSpanElement>;

      wishlistBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
          const id = (btn.closest('.product') as HTMLDivElement).dataset
            .id as string;
          resetShowcases(id, 'wishlist');
        });
      });
    });
}

function createFormData(lvpProducts: string) {
  const formData = new FormData();
  formData.append('product-ids', lvpProducts);
  formData.append('product-type', 'default');
  formData.append('limit', '5');
  return formData;
}
