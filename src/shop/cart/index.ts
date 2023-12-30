import initShoppingCart from "./cartManager";
import initLikedProducts from "./initLiked";
import initLatestProducts from "./initLastViewed";

import "./cart.css";

initShoppingCart();
initLatestProducts();
initLikedProducts();

/**
 * Updates product buttons in showcases.
 * @param productId ID of the product to be updated in showcases
 * @param type Type of the showcase to be updated (cart, wishlist)
 */
export function resetShowcases(productId: string, type: string) {
  const inCart = localStorage.getItem("cart") || "[]";
  const inWishlist = localStorage.getItem("wishlist") || "[]";
  const showcases = document.querySelectorAll(
    ".product-showcase"
  ) as NodeListOf<HTMLDivElement>;
  showcases.forEach((showcase) => {
    const productElement = showcase.querySelector(
      `.product[data-id="${productId}"]`
    ) as HTMLDivElement;
    function updateCartBtns() {
      const btn = productElement.querySelector(
        "#product-cart-btn"
      ) as HTMLButtonElement;
      if (inCart.includes(productId)) {
        btn.className = "in-cart";
        btn.innerText = "Sepette";
        btn.disabled = true;
      } else {
        btn.className = "add-cart";
        btn.innerText = "Sepete Ekle";
        btn.disabled = false;
      }
    }
    function updateWishlistBtns() {
      const btn = productElement.querySelector(
        ".add-wishlist"
      ) as HTMLButtonElement;
      if (inWishlist.includes(productId)) {
        btn.innerText = "Favorilerden Çıkar";
        btn.innerHTML = '<i class="fa-solid fa-heart-broken"></i>';
      } else {
        btn.innerText = "Favorilere Ekle";
        btn.innerHTML = '<i class="fa-solid fa-heart"></i>';
      }
    }
    if (productElement && type === "cart") {
      updateCartBtns();
    } else if (productElement && type === "wishlist") {
      updateWishlistBtns();
    }
  });
}
