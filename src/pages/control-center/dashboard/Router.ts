import { setSubCategories } from '@/common/funcs/functions.dev';
import initStats from './init/InitStats';

// Router
const menuBtns: NodeListOf<HTMLButtonElement> =
  document.querySelectorAll('.menu-btn');

const statPage = document.getElementById('statistics') as HTMLElement;
const manageSite = document.getElementById('manage-site') as HTMLElement;
const productPage = document.getElementById('manage-products') as HTMLElement;
const createProduct = document.getElementById('add-product') as HTMLElement;
const userPage = document.getElementById('manage-users') as HTMLElement;
const ordersPage = document.getElementById('manage-orders') as HTMLElement;

let sections = [
  statPage,
  manageSite,
  productPage,
  userPage,
  createProduct,
  ordersPage,
];

interface RouterInterface {
  loadType: PageType;
  setPageContent(type: string, page: HTMLElement): void;
  loadPage(type: PageType, target: string): void;
}

type PageType = 'hash' | 'btn';

const mainLoader = document.querySelector('#main-loader') as HTMLDivElement;

export class Router implements RouterInterface {
  loadType: PageType;
  constructor() {
    setTimeout(() => {
      mainLoader.style.display = 'none';
    }, 450);
    this.loadType = 'hash';
    this.loadPage(this.loadType, Router.getHash());
  }

  static getHash(): string {
    return window.location.hash.substring(1);
  }

  loadPage(type: PageType, target: string) {
    switch (target) {
      case 'statistics':
        this.setPageContent(type, statPage);
        initStats();
        break;
      case 'manage-site':
        this.setPageContent(type, manageSite);
        break;
      case 'products':
        this.setPageContent(type, productPage);
        break;
      case 'users':
        this.setPageContent(type, userPage);
        break;
      case 'orders':
        this.setPageContent(type, ordersPage);
        break;
      case 'add-product':
        this.setPageContent(type, createProduct);
        setSubCategories();
        break;
    }
  }

  setPageContent(type: PageType, page: HTMLElement) {
    // Scroll to top of the page
    window.scrollTo(0, 0);
    const url = page.dataset.url;
    if (page !== statPage) {
      if (typeof url === 'string') {
        // Check if url is defined and is a string
        window.location.hash = url;
      }
    } else {
      window.location.hash = '';
    }

    document.title = `${page.dataset.title} - Bizim Shop Kontrol Merkezi`;

    page.style.display = 'flex';
    sections.forEach((section) => {
      if (section !== page) {
        section.style.display = 'none';
      }
    });

    if (type == 'hash') {
      menuBtns.forEach((btn) => {
        if (btn.dataset.name === Router.getHash()) {
          btn.classList.add('active');
        } else {
          btn.classList.remove('active');
        }
      });
    }
  }
}

const router = new Router();

menuBtns.forEach((btn) => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    router.loadPage('btn', btn.dataset.name as string);
    // Remove active class from all menu-btns
    menuBtns.forEach((btn) => {
      btn.classList.remove('active');
    });
    // Add active class to clicked menu-btn
    btn.classList.add('active');
  });
});

export default router;
