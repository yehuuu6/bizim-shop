import "./main.css";
import "./utils/utils.css";

const wishlistBtn = document.querySelector(
  "#wishlist-btn"
) as HTMLButtonElement;
const cartBtn = document.querySelector("#cart-btn") as HTMLButtonElement;

wishlistBtn.addEventListener("click", () => {
  console.log("wishlist");
});

cartBtn.addEventListener("click", () => {
  console.log("cart");
});
