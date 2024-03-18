import { resetShowcases } from '.';
import { setNavbarCartItemCount } from '@/common/managers/shop/cartBtnsManager';
import { getProductsById } from '@/pages/shop/utility/getProducts';
import axios from 'axios';

const container = document.querySelector('.shopping-cart') as HTMLDivElement;

const confirmShoppingCartBtn = document.querySelector(
  '.cart-detail-confirm'
) as HTMLButtonElement;

const cartContainer = container.querySelector('.products') as HTMLDivElement;

const emptyCartBtn = document.querySelector(
  '#empty-shopping-cart'
) as HTMLButtonElement;

/**
 * Initializes shopping cart by getting products from localStorage.
 */
export default function initShoppingCart() {
  cartContainer.classList.add('dynamic-content');
  cartContainer.innerHTML = '<h4>Seçilen Ürünler</h4>';
  const inCartIds = JSON.parse(localStorage.getItem('cart') || '[]');
  const formData = new FormData();
  formData.append('product-ids', inCartIds);
  formData.append('product-type', 'in-cart');
  getProductsById(formData)
    .then((products) => {
      if (products.length < 1) {
        confirmShoppingCartBtn.disabled = true;
        cartContainer.innerHTML +=
          '<div class="no-products"><h2><i class="fas fa-shopping-cart"></i> Sepetinizde ürün bulunmamaktadır.</h2></div>';
      } else {
        products.forEach((product: string) => {
          cartContainer.innerHTML += product;
        });
      }
    })
    .finally(() => {
      calculateTotalPrice();
      setRemoveFromCartBtns();
      setTimeout(() => {
        cartContainer.classList.remove('dynamic-content');
      }, 850);
    });
}

export function calculateTotalPrice() {
  const products = cartContainer.querySelectorAll(
    '.product-in-cart'
  ) as NodeListOf<HTMLDivElement>;

  const cartItemCounter = document.querySelector(
    '#cart-item-counter'
  ) as HTMLSpanElement;

  cartItemCounter.innerText = `(${products.length} ürün)`;

  let totalProductPrice = 0;
  let totalShippingPrice = 0;
  let totalOldShippingPrice = 0;
  let totalFeePrice = 0;
  let totalPrice = 0;

  products.forEach((product) => {
    const productPrice = product.querySelector(
      '.product-price'
    ) as HTMLSpanElement;
    const productShippingPrice = product.querySelector(
      '.shipping-cost'
    ) as HTMLSpanElement;
    const productFeePrice = product.querySelector(
      '.fee-cost'
    ) as HTMLSpanElement;

    // Get values from data-value attribute
    const productPriceValue = parseFloat(productPrice.dataset.value as string);
    const productShippingPriceValue = parseFloat(
      productShippingPrice.dataset.value as string
    );
    const productOldShippingPriceValue = parseFloat(
      // Get the data set old-value
      productShippingPrice.dataset.oldValue as string
    );
    const productFeePriceValue = parseFloat(
      productFeePrice.dataset.value as string
    );

    // Calculate total price
    totalProductPrice += productPriceValue;
    totalShippingPrice += productShippingPriceValue;
    totalOldShippingPrice += productOldShippingPriceValue;
    totalFeePrice += productFeePriceValue;
    totalPrice +=
      productPriceValue + productShippingPriceValue + productFeePriceValue;
    if (totalPrice < 0) {
      totalPrice = 0;
    } else {
      confirmShoppingCartBtn.disabled = false;
    }
  });

  // Set values to DOM
  const cartDetailsContainer = document.querySelector(
    '.cart-details'
  ) as HTMLDivElement;
  const valueHolders = cartDetailsContainer.querySelectorAll(
    '[data-type]'
  ) as NodeListOf<HTMLSpanElement>;
  valueHolders.forEach((element) => {
    const type = element.dataset.type as string;
    switch (type) {
      case 'products':
        element.innerHTML =
          totalProductPrice.toFixed(2) +
          ' <span class="product-currency">TL</span>';
        break;
      case 'shipment':
        // Must return the old value if there is a discount, old value must be striked and red colored
        if (totalOldShippingPrice > 0) {
          const totalDiscount = totalOldShippingPrice + totalShippingPrice;
          element.innerHTML =
            '<span title="Eski kargo fiyatı" class="old-price">' +
            totalDiscount.toFixed(2) +
            '</span> ' +
            totalShippingPrice.toFixed(2) +
            ' <span class="product-currency">TL</span>';
        } else {
          element.innerHTML =
            totalShippingPrice.toFixed(2) +
            ' <span class="product-currency">TL</span>';
        }
        break;
      case 'fee':
        element.innerHTML =
          totalFeePrice.toFixed(2) +
          ' <span class="product-currency">TL</span>';
        break;
      case 'total':
        element.innerHTML =
          totalPrice.toFixed(2) + ' <span class="product-currency">TL</span>';
        break;
    }
  });
}

function setRemoveFromCartBtns() {
  const removeFromCartBtns = cartContainer.querySelectorAll(
    '.remove-from-cart'
  ) as NodeListOf<HTMLButtonElement>;

  removeFromCartBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      const productId = (btn.closest('.product-in-cart') as HTMLDivElement)
        .dataset.id as string;
      removeFromLocalStorage(productId);
      initShoppingCart();
    });
  });
}

function removeFromLocalStorage(productId: string) {
  const cartItems = JSON.parse(localStorage.getItem('cart') || '[]');
  const index = cartItems.indexOf(productId);
  if (index > -1) {
    cartItems.splice(index, 1);
  }
  localStorage.setItem('cart', JSON.stringify(cartItems));

  // Update shopping cart
  if (cartItems.length < 1) {
    cartContainer.innerHTML +=
      '<div class="no-products"><h2><i class="fas fa-shopping-cart"></i> Sepetinizde ürün bulunmamaktadır.</h2></div>';
  }

  setNavbarCartItemCount();

  // Update the cart button

  resetShowcases(productId, 'cart');
}

function emptyShoppingCart() {
  const productIds = JSON.parse(localStorage.getItem('cart') || '[]');
  productIds.forEach((id: string) => {
    removeFromLocalStorage(id);
  });
  initShoppingCart();
}

emptyCartBtn.addEventListener('click', emptyShoppingCart);

async function checkIfLoggedIn() {
  const response = await axios.post(
    '/api/checkout/cart.php',
    {
      action: 'checkLogin',
    },
    {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'multipart/form-data',
      },
    }
  );
  return response.data;
}

const addressForm = document.querySelector('#address-form') as HTMLFormElement;

confirmShoppingCartBtn.addEventListener('click', async () => {
  const loggedIn = await checkIfLoggedIn();
  if (!loggedIn) {
    window.location.href = '/auth/login';
    return;
  }
  cartContainer.style.display = 'none';
  addressForm.style.display = 'flex';
  addressForm.classList.add('dynamic-content');
  confirmShoppingCartBtn.innerText = 'Adresi Onayla';
  confirmShoppingCartBtn.classList.add('dynamic-content');
});
