import "./product.css";
import { setAddToCartBtns } from "@/common/controllers/cartBtns";
import { setWishlistBtns } from "@/common/controllers/wishlistBtns";

const products = document.querySelectorAll(
  ".product-container"
) as NodeListOf<HTMLDivElement>;

setAddToCartBtns(products);
setWishlistBtns(products);
