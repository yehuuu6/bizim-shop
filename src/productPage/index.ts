import "./product.css";
import { setAddToCartBtns } from "@/common/controllers/cartBtns";
import { setWishlistBtns } from "@/common/controllers/wishlistBtns";

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
}

// if length of lvp is greater than 5, remove the last item
if (JSON.parse(localStorage.getItem("lvp") || "[]").length > 5) {
  const lvp = JSON.parse(localStorage.getItem("lvp") || "[]");
  lvp.pop();
  localStorage.setItem("lvp", JSON.stringify(lvp));
}
