import PanelClass from '@/classes/PanelController';
import { IOrder } from '@/common/interfaces/utility/IOrder';
import { setOrderStatus } from '@/common/funcs/functions.usr';

const rowNumberOrders = {
  value: 0,
};

const currentOrders: { value: IOrder[] } = {
  value: [],
};

let sqlOffset = 0;
let orderLimit = 30;

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

function createOrderTable(order: IOrder) {
  // Create table row
  const tr = document.createElement('tr');

  const date = new Date(order.date).toLocaleDateString('tr-TR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  });
  let price = parseFloat(order.price);
  // Calculate KDV and add it to the price
  price += price * 0.2;
  let readablePrice = price.toLocaleString('tr-TR', {
    minimumFractionDigits: 2,
  });
  tr.innerHTML = `
            <td>${++rowNumberOrders.value}</td>
            <td>${order.username}</td>
            <td>${order.product}</td>
            <td>₺${readablePrice}</td>
            <td>${setOrderStatus(order.status)}</td>
            <td>${date}</td>
            <td class="table-form-td">
                <form class="table-form" data-id="${order.guid}">
                    <button data-action="inspect" class="dashboard-btn status-btn">İncele</button>
                </form>
            </td>
        `;
  const tableForm = tr.querySelector('.table-form') as HTMLElement;
  tableForm.addEventListener('click', (e) => {
    e.preventDefault();
    if ((e.target as HTMLElement).dataset.action == 'inspect') {
      // Get the id of the order
      let guid = ((e.target as HTMLElement).parentElement as HTMLElement)
        .dataset.id;
      // Get the order from the currentOrders array
      let order = currentOrders.value.find(
        (order: IOrder) => order['guid'] == guid
      );
      ManageOrdersPage.showMessage([
        'success',
        `${order?.guid} ID'li sipariş modalı yapılacak. (TODO)`,
        'none',
      ]);
    }
  });

  return tr;
}

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
    '/api/dashboard/orders/load-orders.php',
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

function debounce(callback: any, delay: number) {
  let timer: any;
  return function () {
    clearTimeout(timer);
    timer = setTimeout(callback, delay);
  };
}

function runSearchOrders(searchOrderInput: HTMLInputElement) {
  let orderSearchInterval: any = null;
  // Set interval on focus to search input and clear it when it's not focused
  searchOrderInput.addEventListener('focus', () => {
    if (!orderSearchInterval) {
      orderSearchInterval = setInterval(() => {
        getSearchOrder();
      }, 300); // Throttle the calls to every 300 milliseconds
    }
  });

  searchOrderInput.addEventListener('blur', () => {
    clearInterval(orderSearchInterval);
    orderSearchInterval = null; // Reset the interval variable
  });

  searchOrderInput.addEventListener(
    'input',
    debounce(() => {
      getSearchOrder();
    }, 300)
  ); // Debounce the input event to trigger after the user stops typing
}

async function loadFirstOrders() {
  sqlOffset = 0;
  searchInput.value = '';
  rowNumberOrders.value = 0;
  currentOrders.value = [];
  orderTable.innerHTML = '';
  orderMore.classList.remove('disabled');
  orderMore.disabled = false;

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

function refreshOrders() {
  loadFirstOrders();
}

orderRefresh.addEventListener('click', refreshOrders);
(
  document.querySelector('div[data-name="orders"]') as HTMLDivElement
).addEventListener('click', () => {
  refreshOrders();
});

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

export default function InitOrders() {
  loadFirstOrders();
  runSearchOrders(searchInput);
}
