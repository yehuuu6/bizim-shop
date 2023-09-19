import { setNavbarCartItemCount } from "../common/controllers/cartBtns";
import { getProductsById } from "../products/getProducts";

const container = document.querySelector(".shopping-cart") as HTMLDivElement;

const cartContainer = container.querySelector(".products") as HTMLDivElement;

const emptyCartBtn = document.querySelector(
  "#empty-shopping-cart"
) as HTMLButtonElement;

/**
 * Initializes shopping cart by getting products from localStorage.
 */
export default function initShoppingCart() {
  cartContainer.innerHTML = "<h4>Seçilen Ürünler</h4>";
  const inCartIds = JSON.parse(localStorage.getItem("cart") || "[]");
  const formData = new FormData();
  formData.append("product-ids", inCartIds);
  formData.append("product-type", "in-cart");
  getProductsById(formData)
    .then((products) => {
      if (products.length < 1) {
        cartContainer.innerHTML +=
          '<div class="empty-cart"><h2><i class="fas fa-shopping-cart"></i> Sepetinizde ürün bulunmamaktadır.</h2></div>';
      } else {
        products.forEach((product: string) => {
          cartContainer.innerHTML += product;
        });
      }
    })
    .finally(() => {
      calculateTotalPrice();
      setRemoveFromCartBtns();
    });
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
        element.innerHTML =
          totalProductPrice.toFixed(2) +
          ' <span class="product-currency">TL</span>';
        break;
      case "shipment":
        element.innerHTML =
          totalShippingPrice.toFixed(2) +
          ' <span class="product-currency">TL</span>';
        break;
      case "fee":
        element.innerHTML =
          totalFeePrice.toFixed(2) +
          ' <span class="product-currency">TL</span>';
        break;
      case "total":
        element.innerHTML =
          totalPrice.toFixed(2) + ' <span class="product-currency">TL</span>';
        break;
    }
  });
}

function setRemoveFromCartBtns() {
  const removeFromCartBtns = cartContainer.querySelectorAll(
    ".remove-from-cart"
  ) as NodeListOf<HTMLButtonElement>;

  removeFromCartBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      const productId = (btn.closest(".product-in-cart") as HTMLDivElement)
        .dataset.id as string;
      const productElement = document.querySelector(
        `.product-in-cart[data-id="${productId}"]`
      ) as HTMLDivElement;
      productElement.remove();
      calculateTotalPrice();
      removeFromLocalStorage(productId);
    });
  });
}

function removeFromLocalStorage(productId: string) {
  const cartItems = JSON.parse(localStorage.getItem("cart") || "[]");
  const index = cartItems.indexOf(productId);
  if (index > -1) {
    cartItems.splice(index, 1);
  }
  localStorage.setItem("cart", JSON.stringify(cartItems));

  // Update shopping cart
  if (cartItems.length < 1) {
    cartContainer.innerHTML +=
      '<div class="empty-cart"><h2><i class="fas fa-shopping-cart"></i> Sepetinizde ürün bulunmamaktadır.</h2></div>';
  }

  setNavbarCartItemCount();

  // Update the cart button

  const container = document.querySelector(".liked-products") as HTMLDivElement;
  const productElement = container.querySelector(
    `.product[data-id="${productId}"]`
  ) as HTMLDivElement;
  if (productElement) {
    const btn = productElement.querySelector(
      "#product-cart-btn"
    ) as HTMLButtonElement;
    btn.innerText = "Sepete Ekle";
    btn.className = "add-cart";
    btn.disabled = false;
  }
}

function emptyShoppingCart() {
  const productIds = JSON.parse(localStorage.getItem("cart") || "[]");
  productIds.forEach((id: string) => {
    removeFromLocalStorage(id);
  });
  initShoppingCart();
}

emptyCartBtn.addEventListener("click", emptyShoppingCart);
