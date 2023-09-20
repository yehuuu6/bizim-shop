// Define a function to update the wishlist button for a single product
function updateWishlistButton(product: HTMLDivElement) {
  const btn = product.querySelector(".add-wishlist") as HTMLSpanElement;
  const id = product.dataset.id as string;

  function updateBtnContent(btn: HTMLSpanElement, isInWishlist: boolean) {
    btn.innerHTML = isInWishlist
      ? '<i class="fa-solid fa-heart-broken"></i>'
      : '<i class="fa-solid fa-heart"></i>';
    btn.title = isInWishlist ? "Favorilerden Çıkar" : "Favorilere Ekle";
  }

  btn.addEventListener("click", () => {
    let wishlistItems: string[] = JSON.parse(
      localStorage.getItem("wishlist") || "[]"
    );
    const isInWishlist = wishlistItems.includes(id);
    if (isInWishlist) {
      // Remove the item from the wishlist
      wishlistItems = wishlistItems.filter((item) => item !== id);

      // Update the button and store the wishlist items in local storage
      localStorage.setItem("wishlist", JSON.stringify(wishlistItems));
      setNavbarWishItemCount();
      updateBtnContent(btn, false);
    } else {
      // Add the item to the wishlist
      wishlistItems.push(id);

      // Update the button and store the wishlist items in local storage
      localStorage.setItem("wishlist", JSON.stringify(wishlistItems));
      setNavbarWishItemCount();
      updateBtnContent(btn, true);
    }
  });

  // Initialize the button state
  const wishlistItems: string[] = JSON.parse(
    localStorage.getItem("wishlist") || "[]"
  );
  const isInWishlist = wishlistItems.includes(id);
  updateBtnContent(btn, isInWishlist);
}

export function setWishlistBtns(products: NodeListOf<HTMLDivElement>) {
  products.forEach((product) => {
    updateWishlistButton(product);
  });
}

export function setNavbarWishItemCount() {
  const items = JSON.parse(localStorage.getItem("wishlist") || "[]");
  const count = document.querySelector(
    "#navbar-wishlist-count"
  ) as HTMLSpanElement;
  count.innerText = `${items.length}`;
}
