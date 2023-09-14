const wishlistBtn = document.querySelector(
  "#wishlist-btn"
) as HTMLButtonElement;

const wishlistItemCount = wishlistBtn.querySelector("span") as HTMLSpanElement;

const productsContainer = document.querySelector(
  ".product-container"
) as HTMLDivElement;

let wishlistItems: string[] = JSON.parse(
  localStorage.getItem("wishlistItems") || "[]"
);

/**
 * Sets the count of the wishlist items in the navbar wishlist icon.
 */
export function setWishlistItemCount() {
  let items: string[] = JSON.parse(
    localStorage.getItem("wishlistItems") || "[]"
  );
  wishlistItemCount.innerText = items.length.toString();
}

setWishlistItemCount();

/**
 * Configures add to wishlist buttons on product components on page load.
 * @param products Every product component in the page. NodeListOf HTMLDivElement
 */
export function setWishlistBtns(products: NodeListOf<HTMLDivElement>) {
  products.forEach((product) => {
    const productId = product.dataset.id as string;
    const wishlistBtn = product.querySelector(
      ".add-wishlist"
    ) as HTMLSpanElement;
    if (wishlistItems.includes(productId)) {
      wishlistBtn.innerHTML = '<i class="fa-solid fa-heart-broken"></i>';
      wishlistBtn.title = "Favorilerden Çıkar";
    } else {
      wishlistBtn.innerHTML = '<i class="fa-regular fa-heart"></i>';
      wishlistBtn.title = "Favorilere Ekle";
    }
  });
}

/**
 * Initializes add to wishlist button listeners.
 */
export function initWishlistBtnListeners(container: HTMLDivElement) {
  const addWishlistBtns = container.querySelectorAll(
    ".add-wishlist"
  ) as NodeListOf<HTMLSpanElement>;
  addWishlistBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const productElement = btn.closest(".product") as HTMLDivElement;
      const productId = productElement.dataset.id as string;
      const wishlistBtn = productElement.querySelector(
        ".add-wishlist"
      ) as HTMLSpanElement;
      // Add to wishlistItems array if it doesn't exist, remove if it does
      if (wishlistItems.includes(productId)) {
        wishlistItems = wishlistItems.filter((id) => id !== productId);
        wishlistBtn.innerHTML = '<i class="fa-regular fa-heart"></i>';
        wishlistBtn.title = "Favorilere Ekle";
      } else {
        wishlistItems.push(productId);
        wishlistBtn.innerHTML = '<i class="fa-solid fa-heart-broken"></i>';
        wishlistBtn.title = "Favorilerden Çıkar";
      }
      localStorage.setItem("wishlistItems", JSON.stringify(wishlistItems));
      wishlistItemCount.innerText = wishlistItems.length.toString();
    });
  });
}
