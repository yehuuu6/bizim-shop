import axios from "axios";

interface SearchProduct {
  body: string;
}

const searchInput = document.querySelector(
  "#search-products"
) as HTMLInputElement;

const searchResultContainer = document.querySelector(
  ".search-results"
) as HTMLDivElement;

const searchBtn = document.querySelector(".search-btn") as HTMLButtonElement;

searchBtn.addEventListener("click", () => {
  // Encode query string
  const query = encodeURIComponent(encodeURIComponent(searchInput.value));
  window.location.href = `/search?q=${query}`;
});

// Go to search?q=query when enter is pressed
searchInput.addEventListener("keyup", (event) => {
  if (event.key === "Enter") {
    event.preventDefault();
    searchBtn.click();
  }
});

async function getSearchProducts(query: string) {
  const response = await axios({
    url: "/api/main/search-results.php",
    method: "post",
    data: {
      search_query: query,
    },
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "multipart/form-data",
    },
  });
  return response.data;
}

function debounce(func: (...args: any[]) => any, wait: number) {
  let timeout: NodeJS.Timeout;
  return function executedFunction(...args: any[]) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

export function searchProducts() {
  searchInput.addEventListener(
    "input",
    debounce(async (event): Promise<void> => {
      const target = event.target as HTMLInputElement;
      const value = target.value;

      if (value.length == 0) {
        searchResultContainer.style.display = "none";
        searchResultContainer.innerHTML = "";
        return;
      }
      searchResultContainer.style.display = "flex";

      const products = await getSearchProducts(value);

      document.addEventListener("click", (event) => {
        const target = event.target as HTMLElement;
        if (!searchResultContainer.contains(target)) {
          searchResultContainer.style.display = "none";
          searchInput.value = "";
          searchResultContainer.innerHTML = "";
        }
      });

      if (products.length == 0) {
        searchResultContainer.innerHTML = `<div class="no-products"><h2><i class="fa-solid fa-magnifying-glass"></i> Aradığınız ürün bulunamadı.</h2></div>`;
      } else {
        searchResultContainer.innerHTML = "";
        products.forEach((product: SearchProduct) => {
          searchResultContainer.innerHTML += product.body;
        });
      }
    }, 250)
  );
}
