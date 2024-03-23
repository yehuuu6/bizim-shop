import initShoppingCart from './cartManager';
import initLikedProducts from './initLiked';
import initLatestProducts from './initLastViewed';

import './cart.css';

initShoppingCart();
initLatestProducts();
initLikedProducts();

window.addEventListener('scroll', () => {
  const cartWrapper = document.querySelector(
    '.shopping-cart'
  ) as HTMLDivElement;
  const stickyPoint = cartWrapper.offsetTop;
  const stickyItem = cartWrapper.querySelector('.checkout') as HTMLDivElement;
  const bottomLimit = cartWrapper.offsetTop + cartWrapper.offsetHeight;

  if (
    window.scrollY >= stickyPoint &&
    window.scrollY + stickyItem.offsetHeight < bottomLimit
  ) {
    stickyItem.classList.add('sticky');
  }
});

/**
 * Updates product buttons in showcases.
 * @param productId ID of the product to be updated in showcases
 * @param type Type of the showcase to be updated (cart, wishlist)
 */
export function resetShowcases(productId: string, type: string) {
  const inCart = JSON.parse(localStorage.getItem('cart') || '[]');
  const showcases = document.querySelectorAll(
    '.product-showcase'
  ) as NodeListOf<HTMLDivElement>;
  showcases.forEach((showcase) => {
    const productElement = showcase.querySelector(
      `.product[data-id="${productId}"]`
    ) as HTMLDivElement;
    function updateCartBtns() {
      const btn = productElement.querySelector(
        '#product-cart-btn'
      ) as HTMLButtonElement;
      if (inCart.includes(productId)) {
        btn.className = 'in-cart';
        btn.innerText = 'Sepette';
        btn.disabled = true;
      } else {
        btn.className = 'add-cart';
        btn.innerText = 'Sepete Ekle';
        btn.disabled = false;
      }
    }
    if (productElement && type === 'cart') {
      updateCartBtns();
    }
  });
}
