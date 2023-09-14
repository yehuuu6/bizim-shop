// Define a function to update the add to cart button for a single product
export function updateAddToCartButton(product: HTMLDivElement) {
  const btn = product.querySelector("#product-cart-btn") as HTMLButtonElement;
  const id = product.dataset.id as string;

  function updateBtnContent(btn: HTMLButtonElement, isInCart: boolean) {
    btn.innerText = isInCart ? "Sepette" : "Sepete Ekle";
    btn.className = isInCart ? "in-cart" : "add-cart";
    btn.disabled = isInCart;
  }

  btn.addEventListener("click", () => {
    let cartItems: string[] = JSON.parse(
      localStorage.getItem("cartItems") || "[]"
    );
    const isInCart = cartItems.includes(id);
    if (!isInCart) {
      // Add the item to the cart
      cartItems.push(id);

      // Update the button and store the cart items in local storage
      localStorage.setItem("cartItems", JSON.stringify(cartItems));
      setNavbarCartItemCount();
      updateBtnContent(btn, true);
    }
  });

  // Initialize the button state
  const cartItems: string[] = JSON.parse(
    localStorage.getItem("cartItems") || "[]"
  );
  const isInCart = cartItems.includes(id);
  updateBtnContent(btn, isInCart);
}

export function setAddToCartBtns(products: NodeListOf<HTMLDivElement>) {
  products.forEach((product) => {
    updateAddToCartButton(product);
  });
}

export function setNavbarCartItemCount() {
  const items = JSON.parse(localStorage.getItem("cartItems") || "[]");
  const count = document.querySelector("#navbar-cart-count") as HTMLSpanElement;
  count.innerText = `${items.length}`;
}
