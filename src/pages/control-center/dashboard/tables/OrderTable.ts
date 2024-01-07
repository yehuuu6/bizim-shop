import { setOrderStatus } from "@/common/funcs/functions.dev";
import {
  ManageOrdersPage,
  currentOrders,
} from "@/pages/control-center/dashboard/orders";

import { IOrder } from "@/common/interfaces/utility/IOrder";

export const rowNumberOrders = {
  value: 0,
};

export default function createOrderTable(order: IOrder) {
  // Create table row
  const tr = document.createElement("tr");

  // DOES NOT FCKING WORK
  tr.innerHTML = `
          <td>${++rowNumberOrders.value}</td>
          <td>${order.user_name}</td>
          <td>${order.product_name}</td>
          <td>₺${order.product_price}</td>
          <td>${setOrderStatus(order.status)}</td>
          <td class="table-form-td">
              <form class="table-form" data-id="${order.id}">
                  <button data-action="upgrade" class="dashboard-btn status-btn">İncele</button>
              </form>
          </td>
      `;
  const tableForm = tr.querySelector(".table-form") as HTMLElement;
  tableForm.addEventListener("click", (e) => {
    e.preventDefault();
    if ((e.target as HTMLElement).dataset.action == "upgrade") {
      // Get the id of the order
      let id = ((e.target as HTMLElement).parentElement as HTMLElement).dataset
        .id;
      // Get the order from the currentOrders array
      let order = currentOrders.value.find(
        (order: IOrder) => order["id"] == id
      );
      ManageOrdersPage.showMessage([
        "success",
        `${order?.id} isimli sipariş modalı yapılacak. (TODO)`,
        "none",
      ]);
    } else if ((e.target as HTMLElement).dataset.action == "ban") {
      // Get the id of the order
      let id = ((e.target as HTMLElement).parentElement as HTMLElement).dataset
        .id;
      // Get the plugin from the currentOrders array
      let order = currentOrders.value.find(
        (order: IOrder) => order["id"] == id
      );
      ManageOrdersPage.showMessage([
        "success",
        `${order?.id} isimli kullanıcı yasaklandı. (TODO)`,
        "none",
      ]);
    }
  });

  return tr;
}
