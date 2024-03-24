import axios from 'axios';
import { setNavbarWishItemCount } from '@/pages/shop/wishlist/wishlistBtnsManager';
import { setNavbarCartItemCount } from '@/pages/shop/cart/cartBtnsManager';
import { searchProducts } from '@/pages/shop/home/searchProduct';

import './core.css';
import './utils.css';

setNavbarWishItemCount();
setNavbarCartItemCount();

searchProducts();

// Cookie consent

const cookieContainer = document.querySelector(
  '.cookie-container'
) as HTMLDivElement;
const cookieButton = document.querySelector('.cookie-btn') as HTMLButtonElement;
const scrollPosition = parseInt(
  sessionStorage.getItem('scrollPosition') || '0'
);

// Hide cookie banner if user has already accepted cookies
cookieButton.addEventListener('click', () => {
  cookieContainer.classList.remove('active');
  localStorage.setItem('cookies', 'true');
});

// Set cookie to active immediately if user is changing page
if (!isNaN(scrollPosition)) {
  if (!localStorage.getItem('cookies')) {
    cookieContainer.classList.add('active');
  }
} else {
  // Set cookie to active after 2 seconds if user loads page for the first time
  setTimeout(() => {
    if (!localStorage.getItem('cookies')) {
      cookieContainer.classList.add('active');
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

window.addEventListener('scroll', function () {
  const targetDiv = document.querySelector(
    '.maintenance-info'
  ) as HTMLDivElement;
  const placeHolder = document.querySelector('.placeholder') as HTMLDivElement;
  if (placeHolder && targetDiv && !isInViewport(placeHolder)) {
    targetDiv.classList.add('fixed');
    targetDiv.style.display = 'flex';
  }
  if (placeHolder && targetDiv && window.scrollY === 0) {
    targetDiv.classList.remove('fixed');
    targetDiv.style.display = 'none';
  }
});

// Category selector events

const categoryContainer = document.querySelector(
  '.categories-container'
) as HTMLDivElement;

const categoryLinks = categoryContainer.querySelectorAll(
  'a'
) as NodeListOf<HTMLAnchorElement>;

// On hover for each link, add active class to the link and remove it from the rest
categoryLinks.forEach((link) => {
  const linkParent = link.parentElement as HTMLLIElement;
  const dropDownMenu = linkParent.querySelector(
    '.sub-category-lister'
  ) as HTMLUListElement;

  link.addEventListener('mouseover', () => {
    if (dropDownMenu) {
      dropDownMenu.addEventListener('mouseover', () => {
        link.classList.add('active');
      });
    }
    categoryLinks.forEach((link) => {
      link.classList.remove('active');
    });
    link.classList.add('active');
  });

  linkParent.addEventListener('mouseout', () => {
    link.classList.remove('active');
  });
});

// TEST ZONE

const monitor = document.querySelector('#monitor') as HTMLDivElement;
const placeOrderBtn = document.querySelector(
  '#place-order-btn'
) as HTMLButtonElement;

if (placeOrderBtn) {
  placeOrderBtn.addEventListener('click', () => {
    const response = axios({
      url: '/api/utility/place-order.php',
      method: 'post',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'multipart/form-data',
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
