import createOrderTable, { rowNumberOrders } from "./tables/OrderTable";
import PanelClass from "@/classes/PanelController";
import { IOrder } from "@/common/interfaces/utility/IOrder";
import { runSearchOrders } from "@/common/funcs/functions.dev";

// VARIABLES START

// order storage
const currentOrders: { value: IOrder[] } = {
  value: [],
};

let sqlOffset = 5;

// Manage orders Page

const orderMore = document.querySelector(
  "#load-more-orders"
) as HTMLButtonElement;
const orderTable = document.querySelector(
  "#orders-table tbody"
) as HTMLTableSectionElement;
const orderLoader = document.querySelector("#loader-orders") as HTMLDivElement;
const orderRefresh = document.querySelector(
  "#refresh-orders"
) as HTMLButtonElement;
const searchInput = document.querySelector("#search-order") as HTMLInputElement;

const ManageOrdersPage = new PanelClass(orderLoader);

// VARIABLES END

// FUNCTIONS START

function getSearchOrder() {
  rowNumberOrders.value = 0;
  const search = searchInput.value.trim().toLowerCase();

  orderTable.innerHTML = "";

  if (search.length > 0) {
    const matchingOrders = currentOrders.value.filter(
      (order: IOrder) =>
        order["product_name"].toLowerCase().includes(search) ||
        order["user_name"].toLowerCase().includes(search)
    );

    if (matchingOrders.length === 0) {
      orderTable.innerHTML = `
          <tr>
            <td colspan="7">Hiçbir sipariş bulunamadı.</td>
          </tr>
        `;
    } else {
      matchingOrders.forEach((order) => {
        orderTable.appendChild(createOrderTable(order));
      });
    }
  } else {
    currentOrders.value.forEach((order) => {
      orderTable.appendChild(createOrderTable(order));
    });
  }
}

// FUNCTIONS END

async function loadFirstOrders() {
  currentOrders.value = [];
  orderMore.classList.remove("disabled");
  orderMore.disabled = false;
  orderTable.innerHTML = "";

  const formData = new FormData();
  formData.append("start", "0");
  const response = await ManageOrdersPage.sendApiRequest(
    "/api/dashboard/orders/load-orders.php",
    formData
  );

  const orders = response;

  if (orders !== undefined || orders.length !== 0) {
    orders.forEach((order: IOrder) => {
      currentOrders.value.push(order);
      orderTable.appendChild(createOrderTable(order));
    });
  }
}

runSearchOrders(searchInput);

function refreshOrders() {
  loadFirstOrders();
  ManageOrdersPage.clearLogger();
  searchInput.value = "";
  sqlOffset = 5;
  rowNumberOrders.value = 0;
}

orderRefresh.addEventListener("click", () => {
  refreshOrders();
});

(
  document.querySelector('div[data-name="orders"]') as HTMLDivElement
).addEventListener("click", () => {
  refreshOrders();
});
// Load first 5 orders on page load
loadFirstOrders();

orderMore.addEventListener("click", function (e) {
  e.preventDefault();
  const formData = new FormData();
  formData.append("start", sqlOffset.toString());
  ManageOrdersPage.sendApiRequest(
    "/api/dashboard/orders/load-orders.php",
    formData
  ).then((response) => {
    let orders = response;
    if (orders === undefined || orders.length === 0) {
      orderMore.classList.add("disabled");
      orderMore.disabled = true;
      ManageOrdersPage.showMessage([
        "error",
        "Daha fazla sipariş bulunamadı.",
        "none",
      ]);
    } else {
      for (let i = 0; i < orders.length; i++) {
        let order = orders[i];
        currentOrders.value.push(order);
        orderTable.append(createOrderTable(order));
        ManageOrdersPage.showMessage([
          "success",
          "5 ürün başarıyla yüklendi.",
          "none",
        ]);
      }
    }
    sqlOffset += 5;
  });
});

// Exports

export { currentOrders, getSearchOrder, ManageOrdersPage };
