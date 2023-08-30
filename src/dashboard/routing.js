const menuBtns = document.querySelectorAll(".menu-btn");
const homePage = document.getElementById("home");
const profilePage = document.getElementById("change-user-info");

// Menubar animations
const menuToggle = document.querySelector("#menu-toggle");
const menu = document.querySelector(".left-bar");
const pages = document.querySelectorAll(".page-content");
const loaders = document.querySelectorAll(".loader");

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

try {
  var productPage = document.getElementById("manage-products");
  var createProduct = document.getElementById("add-product");
  var userPage = document.getElementById("manage-users");
} catch (e) {
  // Do nothing
}

let sections = [homePage, profilePage];

// Push userPage and productPage to sections array if they exist
if (userPage) {
  sections.push(userPage);
}
if (productPage) {
  sections.push(productPage);
}
if (createProduct) {
  sections.push(createProduct);
}

// Get the hash value from the URL
let hash = window.location.hash;

// Remove the '#' symbol from the hash
hash = hash.substring(1);

function activateMenu() {
  localStorage.setItem("menuState", "active");
  menu.classList.remove("hidden-menu");
  menu.classList.add("active-menu");
  pages.forEach((page) => {
    page.classList.add("wide-page");
    page.classList.remove("narrow-page");
  });
  loaders.forEach((loader) => {
    loader.style.paddingLeft = "325px";
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
    loader.style.paddingLeft = "0";
  });
}

export function setPageContent(type, page) {
  // Scroll to top of the page
  $("html, body").animate(
    {
      scrollTop: 0,
    },
    "slow"
  );

  if (page !== homePage) {
    window.location.hash = page.dataset.url;
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
      if (btn.dataset.name === hash) {
        btn.classList.add("active");
      } else {
        btn.classList.remove("active");
      }
    });
  }
}

switch (hash) {
  case "home":
    setPageContent("hash", homePage);
    break;
  case "profile":
    setPageContent("hash", profilePage);
    break;
  case "products":
    setPageContent("hash", productPage);
    break;
  case "users":
    setPageContent("hash", userPage);
    break;
  case "add-product":
    setPageContent("hash", createProduct);
    break;
}

menuBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    switch (btn.dataset.name) {
      case "home":
        setPageContent("btn", homePage);
        break;
      case "profile":
        setPageContent("btn", profilePage);
        break;
      case "store":
        setPageContent("btn", storePage);
        break;
      case "products":
        setPageContent("btn", productPage);
        break;
      case "users":
        setPageContent("btn", userPage);
        break;
      case "add-product":
        setPageContent("btn", createProduct);
        break;
    }

    // Remove active class from all menu-btns
    menuBtns.forEach((btn) => {
      btn.classList.remove("active");
    });
    // Add active class to clicked menu-btn
    btn.classList.add("active");
  });
});
