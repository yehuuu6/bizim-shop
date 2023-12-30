import axios from "axios";
import { setNavbarWishItemCount } from "../common/controllers/shop/wishlistBtns";
import { setNavbarCartItemCount } from "../common/controllers/shop/cartBtns";
import { searchProducts } from "@/shop/home/searchProduct";

import "./core.css";
import "@/common/utils/utils.css";

setNavbarWishItemCount();
setNavbarCartItemCount();

searchProducts();

// Cookie consent

const cookieContainer = document.querySelector(
  ".cookie-container"
) as HTMLDivElement;
const cookieButton = document.querySelector(".cookie-btn") as HTMLButtonElement;
const scrollPosition = parseInt(
  sessionStorage.getItem("scrollPosition") || "0"
);

// Hide cookie banner if user has already accepted cookies
cookieButton.addEventListener("click", () => {
  cookieContainer.classList.remove("active");
  localStorage.setItem("cookies", "true");
});

// Set cookie to active immediately if user is changing page
if (!isNaN(scrollPosition)) {
  if (!localStorage.getItem("cookies")) {
    cookieContainer.classList.add("active");
  }
} else {
  // Set cookie to active after 2 seconds if user loads page for the first time
  setTimeout(() => {
    if (!localStorage.getItem("cookies")) {
      cookieContainer.classList.add("active");
    }
  }, 2000);
}

function isInViewport(element: HTMLElement) {
  const rect = element.getBoundingClientRect();
  return (
    rect.bottom > 0 &&
    rect.right > 0 &&
    rect.left < (window.innerWidth || document.documentElement.clientWidth) &&
    rect.top < (window.innerHeight || document.documentElement.clientHeight)
  );
}

window.addEventListener("scroll", function () {
  const targetDiv = document.querySelector(
    ".maintenance-info"
  ) as HTMLDivElement;
  const placeHolder = document.querySelector(".placeholder") as HTMLDivElement;
  if (placeHolder && targetDiv && !isInViewport(placeHolder)) {
    targetDiv.classList.add("fixed");
    targetDiv.style.display = "flex";
  }
  if (placeHolder && targetDiv && window.scrollY === 0) {
    targetDiv.classList.remove("fixed");
    targetDiv.style.display = "none";
  }
});

// TEST ZONE

const monitor = document.querySelector("#monitor") as HTMLDivElement;
const placeOrderBtn = document.querySelector(
  "#place-order-btn"
) as HTMLButtonElement;

if (placeOrderBtn) {
  placeOrderBtn.addEventListener("click", () => {
    const response = axios({
      url: "/api/utility/place-order.php",
      method: "post",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        "Content-Type": "multipart/form-data",
      },
      data: {
        user_id: 9,
        product_id: 31,
      },
    });
    response.then((res) => {
      const [type, message, cause] = res.data;
      console.log(res.data);
      monitor.innerHTML = `<strong>${type}</strong> | <p>${message}</p> | <p>${cause}</p>`;
    });
  });
}
