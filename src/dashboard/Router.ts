import initStats from "./models/InitStats";

// Menubar animations
const menuToggle = document.querySelector("#menu-toggle") as HTMLInputElement;
const menu = document.querySelector(".left-bar") as HTMLDivElement;
const pages: NodeListOf<HTMLDivElement> =
  document.querySelectorAll(".page-content");
const loaders: NodeListOf<HTMLDivElement> =
  document.querySelectorAll(".loader");

// Store menu state in localStorage to keep it after page refresh
if (localStorage.getItem("menuState") === "active") {
  activateMenu();
  menuToggle.checked = true;
} else {
  deactivateMenu();
  menuToggle.checked = false;
}

menuToggle.addEventListener("change", () => {
  if (menu.classList.contains("hidden-menu")) {
    activateMenu();
  } else {
    deactivateMenu();
  }
});

function activateMenu() {
  localStorage.setItem("menuState", "active");
  menu.classList.remove("hidden-menu");
  menu.classList.add("active-menu");
  pages.forEach((page) => {
    page.classList.add("wide-page");
    page.classList.remove("narrow-page");
  });
  loaders.forEach((loader) => {
    if (loader.id !== "main-dashboard-loader") {
      loader.style.paddingLeft = "325px";
    }
  });
}

function deactivateMenu() {
  localStorage.setItem("menuState", "hidden");
  menu.classList.remove("active-menu");
  menu.classList.add("hidden-menu");
  pages.forEach((page) => {
    page.classList.remove("wide-page");
    page.classList.add("narrow-page");
  });
  loaders.forEach((loader) => {
    if (loader.id !== "main-dashboard-loader") {
      loader.style.paddingLeft = "0";
    }
  });
}

// Router
const menuBtns: NodeListOf<HTMLButtonElement> =
  document.querySelectorAll(".menu-btn");
const statPage = document.getElementById("statistics") as HTMLElement;

const productPage = document.getElementById("manage-products") as HTMLElement;
const createProduct = document.getElementById("add-product") as HTMLElement;
const userPage = document.getElementById("manage-users") as HTMLElement;

let sections = [statPage, productPage, userPage, createProduct];

interface RouterInterface {
  loadType: PageType;
  setPageContent(type: string, page: HTMLElement): void;
  loadPage(type: PageType, target: string): void;
}

type PageType = "hash" | "btn";

const mainLoader = document.querySelector(
  "#main-dashboard-loader"
) as HTMLDivElement;

export class Router implements RouterInterface {
  loadType: PageType;
  constructor() {
    setTimeout(() => {
      mainLoader.style.display = "none";
    }, 450);
    this.loadType = "hash";
    this.loadPage(this.loadType, Router.getHash());
  }

  static getHash(): string {
    return window.location.hash.substring(1);
  }

  /**
   * Just makes sure that the router is included in the bundle doesn't do anything
   */
  static initialize() {
    // do nothing
  }

  loadPage(type: PageType, target: string) {
    switch (target) {
      case "statistics":
        this.setPageContent(type, statPage);
        initStats();
        break;
      case "products":
        this.setPageContent(type, productPage);
        break;
      case "users":
        this.setPageContent(type, userPage);
        break;
      case "add-product":
        this.setPageContent(type, createProduct);
        break;
    }
  }

  setPageContent(type: PageType, page: HTMLElement) {
    // Scroll to top of the page
    window.scrollTo(0, 0);

    if (page !== statPage) {
      const url = page.dataset.url;
      if (typeof url === "string") {
        // Check if url is defined and is a string
        window.location.hash = url;
      }
    } else {
      window.location.hash = "";
    }

    document.title = `${page.dataset.title} - Bizim Shop Panel`;

    page.style.display = "flex";
    sections.forEach((section) => {
      if (section !== page) {
        section.style.display = "none";
      }
    });

    if (type == "hash") {
      menuBtns.forEach((btn) => {
        if (btn.dataset.name === Router.getHash()) {
          btn.classList.add("active");
        } else {
          btn.classList.remove("active");
        }
      });
    }
  }
}

const router = new Router();

menuBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    router.loadPage("btn", btn.dataset.name as string);
    // Remove active class from all menu-btns
    menuBtns.forEach((btn) => {
      btn.classList.remove("active");
    });
    // Add active class to clicked menu-btn
    btn.classList.add("active");
  });
});

export default router;
// Theme selector
const themeItems = document.querySelectorAll(
  ".theme-item"
) as NodeListOf<HTMLDivElement>;

themeItems.forEach((item) => {
  item.addEventListener("click", () => {
    mainLoader.style.display = "flex";
    // Remove active class from all theme items and add it to clicked item
    themeItems.forEach((item) => {
      item.classList.remove("active-theme");
      item.querySelector("input")!.checked = false;
    });
    item.classList.add("active-theme");
    item.querySelector("input")!.checked = true;
    localStorage.setItem("theme", item.dataset.theme as string);
    setTimeout(() => {
      mainLoader.style.display = "none";
    }, 450);
  });
});

document.addEventListener("DOMContentLoaded", () => {
  initStats();
  // Remove active class from all theme items
  themeItems.forEach((item) => {
    item.classList.remove("active-theme");
    item.querySelector("input")!.checked = false;
  });
  // Add active class to theme item that matches with localStorage theme
  themeItems.forEach((item) => {
    if (item.dataset.theme === localStorage.getItem("theme")) {
      item.classList.add("active-theme");
      item.querySelector("input")!.checked = true;
    }
  });
});
