import axios from "axios";
import IStats from "@/common/interfaces/utility/IStats";

/**
 * Initializes dashboard stats and renders them to the dom
 * @async
 * @returns void
 */
const initStats = async () => {
  // Get data from api
  const { data }: IStats = await axios({
    url: "/api/dashboard/stats.php",
    method: "post",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "multipart/form-data",
    },
  });
  // Get dom elements
  const totalUsers = document.getElementById("total-users") as HTMLSpanElement;
  const totalOrders = document.getElementById(
    "total-orders"
  ) as HTMLSpanElement;

  const { total_users, total_orders } = data;

  totalUsers.innerText = total_users.toString();
  totalOrders.innerText = total_orders.toString();
};

export default initStats;
