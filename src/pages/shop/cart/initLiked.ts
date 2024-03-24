import { getProductsById } from '@/pages/shop/utility/getProducts';
import { setWishlistBtns } from '@/pages/shop/wishlist/wishlistBtnsManager';
import { setAddToCartBtns } from '@/pages/shop/cart/cartBtnsManager';
import initShoppingCart from './cartManager';
import { resetShowcases } from '.';
import { pullMyWishlist } from '@/common/funcs/functions.likes';

import '@/pages/shop/products/products.css';

const likedProductsContainer = document.querySelector(
  '#liked-products'
) as HTMLDivElement;

const likedItemCounter = document.querySelector(
  '#liked-item-counter'
) as HTMLSpanElement;

/**
 * Initializes liked products by pulling the wishlist from db and rendering the products.
 */
export default function initLikedProducts() {
  likedProductsContainer.innerHTML = '';
  pullMyWishlist().then((response) => {
    if (
      response.data.length > 1 &&
      response.data[0] === 'error' &&
      response.data[2] === 'login'
    ) {
      likedProductsContainer.innerHTML +=
        '<div class="no-products"><h2><i class="fa-solid fa-heart"></i> Beğendiğiniz ürünleri görebilmek için <a class="link blue-text" href="/auth/login">giriş</a> yapmalısınız.</h2></div>';
      return;
    }
    const likedProducts = response.data;
    getProductsById(createFormData(likedProducts))
      .then((products) => {
        if (products.length < 1) {
          likedProductsContainer.innerHTML +=
            '<div class="no-products"><h2><i class="fa-solid fa-heart-broken"></i> Beğendiğiniz ürün bulunmamaktadır.</h2></div>';
        } else {
          products.forEach((product: string) => {
            likedProductsContainer.innerHTML += product;
          });
        }
      })
      .finally(() => {
        const productElements = likedProductsContainer.querySelectorAll(
          '.product'
        ) as NodeListOf<HTMLDivElement>;

        // Set liked item counter
        const productCount = productElements.length;
        likedItemCounter.innerText = `(${likedProducts.length} ürün, ${productCount} tane gösteriliyor)`;

        // Set wishlist buttons
        setWishlistBtns(productElements);
        // Set add to cart buttons
        setAddToCartBtns(productElements);

        const cartBtns = likedProductsContainer.querySelectorAll(
          '.product #product-cart-btn'
        ) as NodeListOf<HTMLButtonElement>;

        cartBtns.forEach((btn) => {
          btn.addEventListener('click', () => {
            // Refresh the shopping cart and showcases
            initShoppingCart();
            const id = (btn.closest('.product') as HTMLDivElement).dataset
              .id as string;
            resetShowcases(id, 'cart');
          });
        });

        const wishlistBtns = likedProductsContainer.querySelectorAll(
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
  });
}

function createFormData(likedProducts: string) {
  const formData = new FormData();
  formData.append('product-ids', likedProducts);
  formData.append('product-type', 'default');
  formData.append('limit', '5');
  return formData;
}
