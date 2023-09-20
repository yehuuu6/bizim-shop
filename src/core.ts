import { setNavbarWishItemCount } from "./common/controllers/shop/wishlistBtns";
import { setNavbarCartItemCount } from "./common/controllers/shop/cartBtns";

import "./core.css";
import "./common/utils/utils.css";

setNavbarWishItemCount();
setNavbarCartItemCount();

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
