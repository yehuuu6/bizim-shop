import { getProductsById } from "@/pages/shop/utility/getProducts";
import { setWishlistBtns } from "@/common/managers/shop/wishlistBtnsManager";
import { setAddToCartBtns } from "@/common/managers/shop/cartBtnsManager";

// Get wishlist products from local storage
const wishlistProducts = JSON.parse(localStorage.getItem("wishlist") || "[]");

const wishlistContainer = document.querySelector(".products") as HTMLDivElement;

function initWishlistedProducts() {
  wishlistContainer.classList.add("dynamic-content");
  wishlistContainer.innerHTML = "";
  const formData = new FormData();
  formData.append("product-ids", wishlistProducts);
  formData.append("product-type", "default");
  getProductsById(formData)
    .then((products) => {
      if (products.length < 1) {
        wishlistContainer.style.display = "flex";
        wishlistContainer.style.justifyContent = "center";
        wishlistContainer.style.alignItems = "center";
        wishlistContainer.innerHTML +=
          '<div class="no-products"><h2><i class="fas fa-heart"></i> Favori listenizde ürün bulunmamaktadır.</h2></div>';
      } else {
        products.forEach((product: string) => {
          wishlistContainer.innerHTML += product;
        });
      }
    })
    .finally(() => {
      const products = wishlistContainer.querySelectorAll(
        ".product"
      ) as NodeListOf<HTMLDivElement>;

      setWishlistBtns(products);
      setAddToCartBtns(products);
      setTimeout(() => {
        wishlistContainer.classList.remove("dynamic-content");
      }, 850);
    });
}

initWishlistedProducts();
