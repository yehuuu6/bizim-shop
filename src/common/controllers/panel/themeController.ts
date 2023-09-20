const themeItems = document.querySelectorAll(
  ".theme-item"
) as NodeListOf<HTMLDivElement>;

const mainLoader = document.querySelector("#main-loader") as HTMLDivElement;

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
