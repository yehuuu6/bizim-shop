import { setCartItemCount, initCartBtnListeners } from "../common/cartBtns";
import { getProductsById } from "../products/getProducts";

let cartItems: string[] = JSON.parse(localStorage.getItem("cartItems") || "[]");
const shoppingCartItemCounter = document.querySelector(
  "#cart-item-counter"
) as HTMLSpanElement;
shoppingCartItemCounter.innerText = cartItems.length.toString();

const cartContainer = document.querySelector(
  ".shopping-cart .products"
) as HTMLDivElement;

/**
 * Initializes shopping cart by getting products from localStorage.
 */
export default function initShoppingCart() {
  const inCartIds = JSON.parse(localStorage.getItem("cartItems") || "[]");
  const formData = new FormData();
  formData.append("product-ids", inCartIds);
  formData.append("product-type", "in-cart");
  getProductsById(formData)
    .then((products) => {
      if (products.length < 1) {
        cartContainer.innerHTML += "<p>Sepetinizde ürün bulunmamaktadır.</p>";
      } else {
        products.forEach((product: string) => {
          cartContainer.innerHTML += product;
        });
      }
    })
    .finally(() => {
      controlRemoveCartBtns();
      calculateTotalPrice();
    });
}

function controlRemoveCartBtns() {
  const products = cartContainer.querySelectorAll(
    ".product-in-cart"
  ) as NodeListOf<HTMLDivElement>;
  setRemoveFromCartBtns(products);
}

export function calculateTotalPrice() {
  const products = cartContainer.querySelectorAll(
    ".product-in-cart"
  ) as NodeListOf<HTMLDivElement>;

  const cartItemCounter = document.querySelector(
    "#cart-item-counter"
  ) as HTMLSpanElement;

  cartItemCounter.innerText = `(${products.length} ürün)`;

  let totalProductPrice = 0;
  let totalShippingPrice = 0;
  let totalFeePrice = 0;
  let totalPrice = 0;

  products.forEach((product) => {
    const productPrice = product.querySelector(
      ".product-price"
    ) as HTMLSpanElement;
    const productShippingPrice = product.querySelector(
      ".shipping-cost"
    ) as HTMLSpanElement;
    const productFeePrice = product.querySelector(
      ".fee-cost"
    ) as HTMLSpanElement;

    // Get values from data-value attribute
    const productPriceValue = parseFloat(productPrice.dataset.value as string);
    const productShippingPriceValue = parseFloat(
      productShippingPrice.dataset.value as string
    );
    const productFeePriceValue = parseFloat(
      productFeePrice.dataset.value as string
    );

    // Calculate total price
    totalProductPrice += productPriceValue;
    totalShippingPrice += productShippingPriceValue;
    totalFeePrice += productFeePriceValue;
    totalPrice +=
      productPriceValue + productShippingPriceValue + productFeePriceValue;
  });

  // Set values to DOM
  const cartDetailsContainer = document.querySelector(
    ".cart-details"
  ) as HTMLDivElement;
  const valueHolders = cartDetailsContainer.querySelectorAll(
    "[data-type]"
  ) as NodeListOf<HTMLSpanElement>;
  valueHolders.forEach((element) => {
    const type = element.dataset.type as string;
    switch (type) {
      case "products":
        element.innerHTML = "₺" + totalProductPrice.toFixed(2);
        break;
      case "shipment":
        element.innerHTML = "₺" + totalShippingPrice.toFixed(2);
        break;
      case "fee":
        element.innerHTML = "₺" + totalFeePrice.toFixed(2);
        break;
      case "total":
        element.innerHTML = "₺" + totalPrice.toFixed(2);
        break;
    }
  });
}

function setRemoveFromCartBtns(products: NodeListOf<HTMLDivElement>) {
  const likedProductsContainer = document.querySelector(
    ".liked-products"
  ) as HTMLDivElement;
  const cartContainer = document.querySelector(
    ".shopping-cart .products"
  ) as HTMLDivElement;
  products.forEach((product) => {
    const productId = product.dataset.id as string;
    const removeProductBtn = product.querySelector(
      ".remove-product-cart"
    ) as HTMLSpanElement;
    removeProductBtn.addEventListener("click", () => {
      let cartItems: string[] = JSON.parse(
        localStorage.getItem("cartItems") || "[]"
      );
      cartItems = cartItems.filter((id) => id !== productId);
      localStorage.setItem("cartItems", JSON.stringify(cartItems));
      shoppingCartItemCounter.innerText = cartItems.length.toString();
      product.remove();
      setCartItemCount();
      if (cartItems.length < 1) {
        cartContainer.innerHTML += "<p>Sepetinizde ürün bulunmamaktadır.</p>";
      }
      calculateTotalPrice();
      initCartBtnListeners(likedProductsContainer);
    });
  });
}
