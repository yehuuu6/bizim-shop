import {
  setWishlistBtns,
  initWishlistBtnListeners,
} from "../common/wishlistBtns";
import { setCartBtns, initCartBtnListeners } from "../common/cartBtns";
import { getProductsById } from "../products/getProducts";

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
      // Set liked item counter
      const productCount =
        likedProductsContainer.querySelectorAll(".product").length;
      likedItemCounter.innerText = `(${likedProducts.length} ürün, ${productCount} tane gösteriliyor)`;

      setWishlistBtns(likedProductsContainer.querySelectorAll(".product"));
      initWishlistBtnListeners(likedProductsContainer);

      setCartBtns(likedProductsContainer.querySelectorAll(".product"));
      initCartBtnListeners(likedProductsContainer);
    });
}

function createFormData(likedProducts: string) {
  const formData = new FormData();
  formData.append("product-ids", likedProducts);
  formData.append("product-type", "default");
  formData.append("limit", "5");
  return formData;
}
