import axios from "axios";
import CartModal from "@/common/modals/cartModal";

// Define a function to update the add to cart button for a single product
function updateAddToCartButton(product: HTMLDivElement) {
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

    const currentPage = window.location.pathname;
    if (currentPage !== "/cart") {
      getProduct(id).then((product) => {
        const { modal, modalBtn } = CartModal(product);
        document.body.append(modal);
        modalBtn.addEventListener("click", () => {
          window.location.href = "/cart";
        });
      });
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

async function getProduct(id: string) {
  const response = await axios({
    url: "/api/main/get-product.php",
    method: "post",
    data: { id: id },
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "multipart/form-data",
    },
  });

  return response.data;
}
