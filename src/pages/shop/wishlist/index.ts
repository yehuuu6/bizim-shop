import { getProductsById } from '@/pages/shop/utility/getProducts';
import { setWishlistBtns } from '@/common/managers/shop/wishlistBtnsManager';
import { setAddToCartBtns } from '@/common/managers/shop/cartBtnsManager';
import { pullMyWishlist } from '@/common/funcs/functions.likes';

const wishlistContainer = document.querySelector('.products') as HTMLDivElement;

function initWishlistedProducts() {
  wishlistContainer.classList.add('dynamic-content');
  wishlistContainer.innerHTML = '';
  const formData = new FormData();
  pullMyWishlist().then((response) => {
    if (
      response.data.length > 1 &&
      response.data[0] === 'error' &&
      response.data[2] === 'login'
    ) {
      wishlistContainer.style.display = 'flex';
      wishlistContainer.style.justifyContent = 'center';
      wishlistContainer.style.alignItems = 'center';
      wishlistContainer.innerHTML +=
        '<div class="no-products"><h2><i class="fas fa-heart"></i> Beğendiğiniz ürünleri görebilmek için <a class="link blue-text" href="/auth/login">giriş</a> yapmalısınız.</h2></div>';
      return;
    }
    formData.append('product-ids', response.data);
    formData.append('product-type', 'default');
    getProductsById(formData)
      .then((products) => {
        if (products.length < 1) {
          wishlistContainer.style.display = 'flex';
          wishlistContainer.style.justifyContent = 'center';
          wishlistContainer.style.alignItems = 'center';
          wishlistContainer.innerHTML +=
            '<div class="no-products"><h2><i class="fas fa-heart"></i> Beğendiğiniz ürün bulunmamaktadır.</h2></div>';
        } else {
          products.forEach((product: string) => {
            wishlistContainer.innerHTML += product;
          });
        }
      })
      .finally(() => {
        const products = wishlistContainer.querySelectorAll(
          '.product'
        ) as NodeListOf<HTMLDivElement>;

        setWishlistBtns(products);
        setAddToCartBtns(products);
        setTimeout(() => {
          wishlistContainer.classList.remove('dynamic-content');
        }, 850);
      });
  });
}

initWishlistedProducts();
