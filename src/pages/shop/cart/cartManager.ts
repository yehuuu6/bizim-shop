import { resetShowcases } from '.';
import { setNavbarCartItemCount } from '@/pages/shop/cart/cartBtnsManager';
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
      console.log(products);
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
      // Check if the localStorage has a product that is not in the database, if so remove it from the cart
      inCartIds.forEach((id: string) => {
        const product = cartContainer.querySelector(
          `[data-id="${id}"]`
        ) as HTMLDivElement;
        if (!product) {
          removeFromLocalStorage(id);
        }
      });
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
        let productText = totalProductPrice.toLocaleString('tr-TR', {
          minimumFractionDigits: 2,
        });
        element.innerHTML =
          productText + ' <span class="product-currency">TL</span>';
        break;
      case 'shipment':
        // Must return the old value if there is a discount, old value must be striked and red colored
        if (totalOldShippingPrice > 0) {
          const totalDiscount = totalOldShippingPrice + totalShippingPrice;
          let discountText = totalDiscount.toLocaleString('tr-TR', {
            minimumFractionDigits: 2,
          });
          let shippingText = totalShippingPrice.toLocaleString('tr-TR', {
            minimumFractionDigits: 2,
          });
          element.innerHTML =
            '<span title="Eski kargo fiyatı" class="old-price">' +
            discountText +
            '</span> ' +
            shippingText +
            ' <span class="product-currency">TL</span>';
        } else {
          let shippingText = totalShippingPrice.toLocaleString('tr-TR', {
            minimumFractionDigits: 2,
          });
          element.innerHTML =
            shippingText + ' <span class="product-currency">TL</span>';
        }
        break;
      case 'fee':
        let feeText = totalFeePrice.toLocaleString('tr-TR', {
          minimumFractionDigits: 2,
        });
        element.innerHTML =
          feeText + ' <span class="product-currency">TL</span>';
        break;
      case 'total':
        let totalPriceText = totalPrice.toLocaleString('tr-TR', {
          minimumFractionDigits: 2,
        });
        element.innerHTML =
          totalPriceText + ' <span class="product-currency">TL</span>';
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

  resetShowcases(productId);
}

function emptyShoppingCart() {
  const productIds = JSON.parse(localStorage.getItem('cart') || '[]');
  productIds.forEach((id: string) => {
    removeFromLocalStorage(id);
  });
  initShoppingCart();
}

emptyCartBtn.addEventListener('click', emptyShoppingCart);

async function postRequest(url: string, data: any) {
  return await axios.post(url, data, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'multipart/form-data',
    },
  });
}

async function checkIfLoggedIn() {
  const response = await postRequest('/api/checkout/cart.php', {
    action: 'checkLogin',
  });
  return response.data;
}

function showErrorAndRedirect(errorMessage: string, redirectUrl: string) {
  logger.style.display = 'flex';
  loggerText.innerText = errorMessage;
  setTimeout(() => {
    logger.style.display = 'none';
    loggerText.innerText = '';
    window.location.href = redirectUrl;
  }, 4000);
}

function displayError(errorMessage: string) {
  logger.style.display = 'flex';
  loggerText.innerText = errorMessage;
}

function indicateError(input: HTMLInputElement) {
  const oldBorder = input.style.border;
  if (oldBorder !== '1px solid red') {
    input.style.border = '1px solid red';
    setTimeout(() => {
      input.style.border = oldBorder;
      logger.style.display = 'none';
      loggerText.innerText = '';
    }, 4000);
  }
}

let checkoutState = 1;
const addressForm = document.querySelector('#address-form') as HTMLFormElement;
const confirmMyAddressBox = document.querySelector(
  '#confirm-address-box'
) as HTMLInputElement;
const inputForAddressConfirmation = confirmMyAddressBox.querySelector(
  'input'
) as HTMLInputElement;
const logger = document.querySelector('.error-logger') as HTMLDivElement;
const loggerText = logger.querySelector('.error-text') as HTMLSpanElement;

confirmShoppingCartBtn.addEventListener('click', async () => {
  if (checkoutState === 1) {
    const loggedIn = await checkIfLoggedIn();
    if (!loggedIn) {
      showErrorAndRedirect(
        'Alışverişinizi tamamlamak için giriş yapmanız gerekmektedir.',
        '/auth/login'
      );
      return;
    }
    cartContainer.style.display = 'none';
    confirmMyAddressBox.style.display = 'flex';
    addressForm.style.display = 'flex';
    addressForm.classList.add('dynamic-content');
    confirmShoppingCartBtn.innerText = 'Ödeme Yap';
    confirmShoppingCartBtn.classList.add('dynamic-content');
    checkoutState = 2;
    const addressFormData = new FormData(addressForm);
    confirmShoppingCartBtn.disabled = Array.from(
      addressFormData.values()
    ).includes('');
    if (confirmShoppingCartBtn.disabled) {
      displayError('Lütfen tüm alanları doldurunuz');
    }
  } else if (checkoutState === 2) {
    const addressFormData = new FormData(addressForm);
    const products = localStorage.getItem('cart') || '[]';
    if (!products) {
      window.location.href = '/';
    }
    addressFormData.append('products', products);
    addressFormData.append('action', 'finishCart');
    addressFormData.append(
      'confirm-address',
      inputForAddressConfirmation.checked ? '1' : '0'
    );
    const response = await postRequest(
      '/api/checkout/cart.php',
      addressFormData
    );
    const [status, message, cause] = response.data;
    if (status === 'success') {
      displayError(message);
      window.location.href = `/checkout?message=${encodeURIComponent(message)}`;
    } else {
      displayError(message);
      if (cause !== '') {
        indicateError(document.querySelector(`#${cause}`) as HTMLInputElement);
      }
    }
  }
});
