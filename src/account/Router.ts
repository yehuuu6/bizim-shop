import IRouter, { PageType } from "@/common/interfaces/IRouter";

// Router
const menuBtns: NodeListOf<HTMLButtonElement> =
  document.querySelectorAll(".menu-btn");

const editAccountPage = document.getElementById(
  "change-user-info"
) as HTMLElement;

let sections = [editAccountPage];

const mainLoader = document.querySelector("#main-loader") as HTMLDivElement;

export class Router implements IRouter {
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
      case "edit-profile":
        this.setPageContent(type, editAccountPage);
        break;
    }
  }

  setPageContent(type: PageType, page: HTMLElement) {
    // Scroll to top of the page
    window.scrollTo(0, 0);

    const url = page.dataset.url;
    if (page !== editAccountPage) {
      const url = page.dataset.url;
      if (typeof url === "string") {
        // Check if url is defined and is a string
        window.location.hash = url;
      }
    } else {
      window.location.hash = "";
    }

    document.title = `${page.dataset.title} - Bizim Shop Kontrol Merkezi`;

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
