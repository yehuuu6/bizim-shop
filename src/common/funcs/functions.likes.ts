import axios from 'axios';

export function pullMyWishlist() {
  const response = axios({
    method: 'post',
    url: '/api/main/wishlist.php',
    data: {
      action: 'pull',
    },
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'multipart/form-data',
    },
  });
  return response;
}

export function addToWishlist(id: string) {
  const response = axios({
    method: 'post',
    url: '/api/main/wishlist.php',
    data: {
      action: 'add',
      product_id: id,
    },
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'multipart/form-data',
    },
  });
  return response;
}

export function removeFromWishlist(id: string) {
  const response = axios({
    method: 'post',
    url: '/api/main/wishlist.php',
    data: {
      action: 'remove',
      product_id: id,
    },
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'multipart/form-data',
    },
  });
  return response;
}

export async function checkWishlistItem(id: string) {
  const response = axios({
    method: 'post',
    url: '/api/main/wishlist.php',
    data: {
      action: 'check',
      product_id: id,
    },
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'multipart/form-data',
    },
  });
  return response;
}
