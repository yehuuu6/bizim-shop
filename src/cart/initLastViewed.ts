import { getProductsById } from "../products/getProducts";
import { setWishlistBtns } from "../common/controllers/wishlistBtns";
import { setAddToCartBtns } from "../common/controllers/cartBtns";
import initShoppingCart from "./cartManager";

import "../products/products.css";

const lvpContainer = document.querySelector(
  "#last-viewed-products"
) as HTMLDivElement;

const lvpCounter = document.querySelector("#lvp-counter") as HTMLSpanElement;

/**
 * Initializes latest viewed products by getting products from localStorage.
 */
export default function initLatestProducts() {
  const lvpProducts = JSON.parse(localStorage.getItem("lvp") || "[]");
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
        ".product"
      ) as NodeListOf<HTMLDivElement>;

      // Set latest viewed products counter
      lvpCounter.innerText = `(${lvpProducts.length} ürün)`;

      // Set wishlist buttons
      setWishlistBtns(productElements);
      // Set add to cart buttons
      setAddToCartBtns(productElements);

      const btns = lvpContainer.querySelectorAll(
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

function createFormData(lvpProducts: string) {
  const formData = new FormData();
  formData.append("product-ids", lvpProducts);
  formData.append("product-type", "default");
  formData.append("limit", "5");
  return formData;
}
