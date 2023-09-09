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
