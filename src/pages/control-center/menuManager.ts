// Menubar animations
const menuToggle = document.querySelector('#menu-toggle') as HTMLInputElement;
const menu = document.querySelector('.left-bar') as HTMLDivElement;
const pages: NodeListOf<HTMLDivElement> =
  document.querySelectorAll('.page-content');
const loaders: NodeListOf<HTMLDivElement> =
  document.querySelectorAll('.loader');

// Store menu state in localStorage to keep it after page refresh
if (localStorage.getItem('menuState') === 'active') {
  activateMenu();
  menuToggle.checked = true;
} else {
  deactivateMenu();
  menuToggle.checked = false;
}

export default function InitMenuManager() {
  menuToggle.addEventListener('change', () => {
    if (menu.classList.contains('hidden-menu')) {
      activateMenu();
    } else {
      deactivateMenu();
    }
  });
}

function activateMenu() {
  localStorage.setItem('menuState', 'active');
  menu.classList.remove('hidden-menu');
  menu.classList.add('active-menu');
  pages.forEach((page) => {
    page.classList.add('wide-page');
    page.classList.remove('narrow-page');
  });
  loaders.forEach((loader) => {
    if (loader.id !== 'main-loader') {
      loader.style.paddingLeft = '325px';
    }
  });
}

function deactivateMenu() {
  localStorage.setItem('menuState', 'hidden');
  menu.classList.remove('active-menu');
  menu.classList.add('hidden-menu');
  pages.forEach((page) => {
    page.classList.remove('wide-page');
    page.classList.add('narrow-page');
  });
  loaders.forEach((loader) => {
    if (loader.id !== 'main-loader') {
      loader.style.paddingLeft = '0';
    }
  });
}
