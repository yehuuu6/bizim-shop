import { getProductsById } from "../products/getProducts";
import { setWishlistBtns } from "../common/wishlistBtns";
import { setAddToCartBtns } from "../common/cartBtns";
import initShoppingCart from "./cartManager";

import "../products/products.css";

const likedProductsContainer = document.querySelector(
  ".liked-products"
) as HTMLDivElement;

const likedItemCounter = document.querySelector(
  "#liked-item-counter"
) as HTMLSpanElement;

/**
 * Initializes liked products by getting products from localStorage.
 */
export default function initLikedProducts() {
  const likedProducts = JSON.parse(
    localStorage.getItem("wishlistItems") || "[]"
  );
  getProductsById(createFormData(likedProducts))
    .then((products) => {
      if (products.length < 1) {
        likedProductsContainer.innerHTML +=
          "<p>Beğendiğiniz ürün bulunmamaktadır.</p>";
      } else {
        products.forEach((product: string) => {
          likedProductsContainer.innerHTML += product;
        });
      }
    })
    .finally(() => {
      const productElements = likedProductsContainer.querySelectorAll(
        ".product"
      ) as NodeListOf<HTMLDivElement>;

      // Set liked item counter
      const productCount = productElements.length;
      likedItemCounter.innerText = `(${likedProducts.length} ürün, ${productCount} tane gösteriliyor)`;

      // Set wishlist buttons
      setWishlistBtns(productElements);
      // Set add to cart buttons
      setAddToCartBtns(productElements);

      const btns = likedProductsContainer.querySelectorAll(
        ".product #product-cart-btn"
      ) as NodeListOf<HTMLButtonElement>;

      btns.forEach((btn) => {
        btn.addEventListener("click", () => {
          // Refresh the shopping cart
          initShoppingCart();
        });
      });
    });
}

function createFormData(likedProducts: string) {
  const formData = new FormData();
  formData.append("product-ids", likedProducts);
  formData.append("product-type", "default");
  formData.append("limit", "5");
  return formData;
}
