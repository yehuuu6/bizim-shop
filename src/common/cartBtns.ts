/**
 * Sets the count of the shopping cart items in the navbar cart icon.
 */
export function setCartItemCount() {
  const cartBtn = document.querySelector("#cart-btn") as HTMLButtonElement;
  const cartItemCount = cartBtn.querySelector("span") as HTMLSpanElement;

  let items: string[] = JSON.parse(localStorage.getItem("cartItems") || "[]");
  cartItemCount.innerText = items.length.toString();
}

setCartItemCount();

/**
 * Configures add to cart buttons on product components on page load.
 * @param products Every product component in the page. NodeListOf HTMLDivElement
 */
export function setCartBtns(products: NodeListOf<HTMLDivElement>) {
  let cartItems = JSON.parse(localStorage.getItem("cartItems") || "[]");

  products.forEach((product) => {
    const productId = product.dataset.id as string;
    const productCartBtn = product.querySelector(
      "#product-cart-btn"
    ) as HTMLButtonElement;
    if (cartItems.includes(productId)) {
      productCartBtn.className = "in-cart";
      productCartBtn.innerText = "Sepette";
      productCartBtn.disabled = true;
    } else {
      productCartBtn.className = "add-cart";
      productCartBtn.innerText = "Sepete Ekle";
      productCartBtn.disabled = false;
    }
  });
}

/**
 * Initializes add to cart button listeners.
 */
export function initCartBtnListeners(container: HTMLDivElement) {
  const addCartBtns = container.querySelectorAll(
    ".add-cart"
  ) as NodeListOf<HTMLSpanElement>;

  let cartItems: string[] = JSON.parse(
    localStorage.getItem("cartItems") || "[]"
  );

  addCartBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      console.log("clicked");
      const productElement = btn.closest(".product") as HTMLDivElement;
      const productId = productElement.dataset.id as string;
      const productCartBtn = productElement.querySelector(
        "#product-cart-btn"
      ) as HTMLButtonElement;

      // Add to cartItems array if it doesn't exist, remove if it does
      if (cartItems.includes(productId)) {
        cartItems = cartItems.filter((id) => id !== productId);
        productCartBtn.className = "add-cart";
        productCartBtn.innerText = "Sepete Ekle";
        productCartBtn.disabled = false;
      } else {
        cartItems.push(productId);
        productCartBtn.className = "in-cart";
        productCartBtn.innerText = "Sepette";
        productCartBtn.disabled = true;
      }

      localStorage.setItem("cartItems", JSON.stringify(cartItems));
      setCartItemCount();
    });
  });
}
