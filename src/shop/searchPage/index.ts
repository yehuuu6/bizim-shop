import { setProducts, sqlOffset } from "../utility/getProducts";

import "@/shop/productsPage/products.css";

// Get products

const filterForm = document.querySelector("#filters") as HTMLFormElement;

const productsContainer = document.querySelector(".products") as HTMLDivElement;

/**
 * Everytime filter form changes, gets new products from database
 */
filterForm.addEventListener("submit", function (e) {
  e.preventDefault();
  sqlOffset.value = 0;
  // Remove page number from url
  const url = new URL(window.location.href);
  url.searchParams.delete("page");
  productsContainer.classList.add("dynamic-content");
  productsContainer.innerHTML = "";
  setProducts(filterForm);
  setTimeout(() => {
    productsContainer.classList.remove("dynamic-content");
  }, 850);
});

// Get products when page loads
setProducts(filterForm);
