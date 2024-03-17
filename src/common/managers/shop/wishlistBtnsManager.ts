import {
  addToWishlist,
  checkWishlistItem,
  pullMyWishlist,
  removeFromWishlist,
} from '@/common/funcs/functions.likes';

// Define a function to update the wishlist button for a single product
function updateWishlistButton(product: HTMLDivElement) {
  const btn = product.querySelector('.add-wishlist') as HTMLSpanElement;
  const id = product.dataset.id as string;

  function updateBtnContent(btn: HTMLSpanElement, isInWishlist: boolean) {
    btn.innerHTML = isInWishlist
      ? '<i class="fa-solid fa-heart-broken"></i>'
      : '<i class="fa-solid fa-heart"></i>';
    btn.title = isInWishlist ? 'Favorilerden Çıkar' : 'Favorilere Ekle';
  }

  btn.addEventListener('click', () => {
    checkWishlistItem(id).then((response) => {
      const [result, message, cause] = response.data;
      if (result == 'success' && cause == 'in_wishlist') {
        // Means the product is in the wishlist, so remove it
        removeFromWishlist(id).then((response) => {
          const [result, message, cause] = response.data;
          if (result === 'success') {
            updateBtnContent(btn, false);
            setNavbarWishItemCount();
          }
        });
      } else if (result === 'error' && cause === 'login') {
        window.location.href = '/auth/login';
      } else if (result === 'error' && cause === 'not_in_wishlist') {
        // Means the product is not in the wishlist, so add it
        addToWishlist(id).then((response) => {
          const [result, message, cause] = response.data;
          if (result === 'success') {
            updateBtnContent(btn, true);
            setNavbarWishItemCount();
          }
        });
      }
    });
  });

  // Initialize the button state
  // Get wishlist items from pullMyWishlist not from localStorage
  pullMyWishlist().then((response) => {
    const wishlistItems = response.data;
    const isInWishlist = wishlistItems.includes(Number(id));
    updateBtnContent(btn, isInWishlist);
  });
}

export function setWishlistBtns(products: NodeListOf<HTMLDivElement>) {
  products.forEach((product) => {
    updateWishlistButton(product);
  });
}

export function setNavbarWishItemCount() {
  pullMyWishlist().then((response) => {
    const [result, message, cause] = response.data;
    if (result === 'error' && cause === 'login') {
      return;
    }
    const wishlistItems = response.data;
    const count = document.querySelector(
      '#navbar-wishlist-count'
    ) as HTMLSpanElement;
    count.innerText = `${wishlistItems.length}`;
  });
}
