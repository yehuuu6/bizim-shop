import createOrderTable, { rowNumberOrders } from './tables/OrderTable';
import PanelClass from '@/classes/PanelController';
import { IOrder } from '@/common/interfaces/utility/IOrder';
import { runSearchOrders } from '@/common/funcs/functions.dev';

// VARIABLES START

// order storage
const currentOrders: { value: IOrder[] } = {
  value: [],
};

let sqlOffset = 0;
let orderLimit = 30;

// Manage orders Page

const orderMore = document.querySelector(
  '#load-more-orders'
) as HTMLButtonElement;
const orderTable = document.querySelector(
  '#orders-table tbody'
) as HTMLTableSectionElement;
const orderLoader = document.querySelector('#loader-orders') as HTMLDivElement;
const orderRefresh = document.querySelector(
  '#refresh-orders'
) as HTMLButtonElement;
const searchInput = document.querySelector('#search-order') as HTMLInputElement;

const ManageOrdersPage = new PanelClass(orderLoader);

// VARIABLES END

// FUNCTIONS START

let oldSearch = '';

function getSearchOrder() {
  const search = searchInput.value.trim().toLowerCase();

  if (search === oldSearch) {
    return;
  } else if (search.length <= 0) {
    loadFirstOrders();
    oldSearch = search;
    return;
  }

  orderMore.classList.add('disabled');
  orderMore.disabled = true;

  sqlOffset = 0;

  oldSearch = search;

  const formData = new FormData();
  formData.append('search', search);
  formData.append('offset', '0');
  formData.append('limit', orderLimit.toString());

  ManageOrdersPage.sendApiRequest(
    '/api/dashboard/orders/search-orders.php',
    formData
  ).then((response) => {
    let orders = response;
    if (orders === undefined || orders.length === 0) {
      orderTable.innerHTML = '';
      orderTable.innerHTML = `
        <tr>
          <td colspan="6">Sipariş bulunamadı.</td>
        </tr>
      `;
      return;
    }
    rowNumberOrders.value = 0;
    currentOrders.value = orders;
    orderTable.innerHTML = '';

    orders.forEach((order: IOrder) => {
      orderTable.appendChild(createOrderTable(order));
    });
  });
}

// FUNCTIONS END

async function loadFirstOrders() {
  sqlOffset = 0;
  searchInput.value = '';
  rowNumberOrders.value = 0;
  currentOrders.value = [];
  orderTable.innerHTML = '';
  orderMore.classList.remove('disabled');
  orderMore.disabled = false;
  orderTable.innerHTML = '';

  const formData = new FormData();
  formData.append('offset', '0');
  formData.append('limit', orderLimit.toString());
  const response = await ManageOrdersPage.sendApiRequest(
    '/api/dashboard/orders/load-orders.php',
    formData
  );

  const orders = response;

  if (orders === undefined || orders.length === 0) {
    orderTable.innerHTML = `
      <tr>
        <td colspan="6">Sipariş bulunamadı.</td>
      </tr>
    `;
    return;
  }

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
}

orderRefresh.addEventListener('click', () => {
  refreshOrders();
});

(
  document.querySelector('div[data-name="orders"]') as HTMLDivElement
).addEventListener('click', () => {
  refreshOrders();
});
// Load first 5 orders on page load
loadFirstOrders();

orderMore.addEventListener('click', function (e) {
  e.preventDefault();
  sqlOffset = orderLimit;
  const formData = new FormData();
  formData.append('search', searchInput.value.trim().toLowerCase());
  formData.append('offset', sqlOffset.toString());
  formData.append('limit', orderLimit.toString());
  ManageOrdersPage.sendApiRequest(
    '/api/dashboard/orders/load-orders.php',
    formData
  ).then((response) => {
    let orders = response;
    if (orders === undefined || orders.length === 0) {
      orderMore.classList.add('disabled');
      orderMore.disabled = true;
      ManageOrdersPage.showMessage([
        'error',
        'Daha fazla sipariş bulunamadı.',
        'none',
      ]);
    } else {
      for (let i = 0; i < orders.length; i++) {
        let order = orders[i];
        currentOrders.value.push(order);
        orderTable.append(createOrderTable(order));
        ManageOrdersPage.showMessage([
          'success',
          `${orderLimit} sipariş başarıyla yüklendi.`,
          'none',
        ]);
      }
    }
  });
});

// Exports

export { currentOrders, getSearchOrder, ManageOrdersPage };
