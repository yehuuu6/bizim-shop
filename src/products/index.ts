import { setProducts, sqlOffset } from "./getProducts";

import "./products.css";

// Get products

const productsContainer = document.querySelector(
  ".product-container"
) as HTMLDivElement;

const filterForm = document.querySelector("#filters") as HTMLFormElement;

/**
 * Everytime filter form changes, gets new products from database
 */
filterForm.addEventListener("submit", function (e) {
  e.preventDefault();
  sqlOffset.value = 0;
  productsContainer.innerHTML = "";
  setProducts(filterForm);
});

setProducts(filterForm);
