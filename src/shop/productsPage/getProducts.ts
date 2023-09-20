import axios from "axios";
import { setWishlistBtns } from "@/common/controllers/shop/wishlistBtns";
import { setAddToCartBtns } from "@/common/controllers/shop/cartBtns";

export const sqlOffset = {
  value: 0,
};
const productLimit = {
  value: 50,
};

const productsContainer = document.querySelector(
  ".product-container"
) as HTMLDivElement;

export async function getProducts(formData: FormData) {
  const response = await axios({
    url: "/api/main/load-products.php",
    method: "post",
    data: formData,
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "multipart/form-data",
    },
  });
  return response.data;
}

/**
 * Sets product container content to products from database
 */
export function setProducts(form: HTMLFormElement) {
  const formData = new FormData(form);
  productsContainer.classList.add("dynamic-content");
  formData.append("offset", sqlOffset.value.toString());
  formData.append("limit", productLimit.value.toString());
  getProducts(formData)
    .then((products) => {
      if (products.length == 0) {
        productsContainer.style.display = "flex";
        productsContainer.style.justifyContent = "center";
        productsContainer.style.alignItems = "center";
        productsContainer.innerHTML = `<div class="no-products"><h2><i class="fa-solid fa-magnifying-glass"></i> Aradığınız ürün bulunamadı.</h2></div>`;
      } else {
        // Resset products container style
        productsContainer.style.display = "";
        productsContainer.style.justifyContent = "";
        productsContainer.style.alignItems = "";
        sqlOffset.value += productLimit.value;
        products.forEach((product: string) => {
          productsContainer.innerHTML += product;
        });
      }
    })
    .finally(() => {
      const productElements = productsContainer.querySelectorAll(
        ".product"
      ) as NodeListOf<HTMLDivElement>;

      setWishlistBtns(productElements);
      setAddToCartBtns(productElements);
      setTimeout(() => {
        productsContainer.classList.remove("dynamic-content");
      }, 600);
    });
}

/**
 * Gets products from database by their ids
 * @param formData Must contain product-ids and product-type or limit
 * @returns Promise
 */
export async function getProductsById(formData: FormData) {
  const response = await axios({
    url: "/api/main/load-products-by-id.php",
    method: "post",
    data: formData,
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "multipart/form-data",
    },
  });
  return response.data;
}
