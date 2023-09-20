import "./product.css";
import { setAddToCartBtns } from "@/common/controllers/shop/cartBtns";
import { setWishlistBtns } from "@/common/controllers/shop/wishlistBtns";

const products = document.querySelectorAll(
  ".product-container"
) as NodeListOf<HTMLDivElement>;

setAddToCartBtns(products);
setWishlistBtns(products);

const currentProduct = products[0];

const productId = currentProduct.dataset.id as string;
// Save the product id in latest viewed products if id does not already exist
if (!localStorage.getItem("lvp")?.includes(productId)) {
  localStorage.setItem(
    "lvp",
    JSON.stringify([
      productId,
      ...JSON.parse(localStorage.getItem("lvp") || "[]"),
    ])
  );
} else {
  // If product id already exists, move it to the front
  const lvp = JSON.parse(localStorage.getItem("lvp") || "[]");
  const index = lvp.indexOf(productId);
  lvp.splice(index, 1);
  localStorage.setItem("lvp", JSON.stringify([productId, ...lvp]));
}

// if length of lvp is greater than 5, remove the last item
if (JSON.parse(localStorage.getItem("lvp") || "[]").length > 5) {
  const lvp = JSON.parse(localStorage.getItem("lvp") || "[]");
  lvp.pop();
  localStorage.setItem("lvp", JSON.stringify(lvp));
}

// Control image showcase

const showcaseImgs = document.querySelectorAll(
  "img[data-img]"
) as NodeListOf<HTMLImageElement>;
const showcase = document.querySelector(".big-image") as HTMLDivElement;

showcaseImgs.forEach((img) => {
  img.addEventListener("click", () => {
    showcase.classList.add("dynamic-content");
    const replace = showcase.querySelector("img") as HTMLImageElement;
    replace.src = img.src;
    setTimeout(() => {
      showcase.classList.remove("dynamic-content");
    }, 600);
  });
});
