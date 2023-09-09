import axios from "axios";

interface IStats {
  data: {
    total_users: number;
    total_products: number;
  };
}

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
  const totalProducts = document.getElementById(
    "total-products"
  ) as HTMLSpanElement;

  const { total_users, total_products } = data;

  totalUsers.innerText = total_users.toString();
  totalProducts.innerText = total_products.toString();
};

export default initStats;
