import { getCategory, setStatus } from "../utils/functions.js";
import { currentProducts } from "../dev.js";

export default function CreateProductTable(product) {
    // Create table form
    const tableForm = document.createElement("form");
    tableForm.classList.add("table-form");
  
    const statusBtn = document.createElement("button");
    statusBtn.setAttribute("data-action", "status");
  
    const editBtn = document.createElement("button");
    editBtn.setAttribute("data-action", "edit");
    editBtn.classList.add("btn", "edit-btn");
    editBtn.innerText = "Düzenle";
  
    const deleteBtn = document.createElement("button");
    deleteBtn.setAttribute("data-action", "delete");
    deleteBtn.classList.add("btn", "delete-btn");
    deleteBtn.innerText = "Sil";
  
    tableForm.append(statusBtn);
    tableForm.append(editBtn);
    tableForm.append(deleteBtn);
    tableForm.setAttribute("data-id", product["id"]);
  
    statusBtn.innerText = product["status"] == "1" ? "Listeleme" : "Listele";
    product["status"] == "1"
      ? (statusBtn.className = "btn status-btn")
      : (statusBtn.className = "btn success-btn");
  
    tableForm.addEventListener("click", (e) => {
      e.preventDefault();
      let id = e.target.parentElement.dataset.id;
      // Get the product from the currentProducts array
      let product = currentProducts.find((product) => product["id"] == id);
      if (e.target.dataset.action == "edit") {
        editProduct(product);
      } else if (e.target.dataset.action == "delete") {
        deleteProduct(product);
      } else if (e.target.dataset.action == "status") {
        productLoad.style.display = "flex";
        $.ajax({
          url: "/api/dashboard/product/change-status.php",
          type: "POST",
          data: {
            id: product["id"],
            status: product["status"] == "1" ? "0" : "1",
          },
          success: function (data) {
            let phpArray = JSON.parse(data);
            let status = phpArray[0];
            let message = phpArray[1];
            // Scroll to logger
            $("html, body").animate(
              {
                scrollTop: $(productLogger).offset().top,
              },
              1000
            );
            if (status == "success") {
              product["status"] = product["status"] == "1" ? "0" : "1";
              e.target.innerText =
                product["status"] == "1" ? "Listeleme" : "Listele";
              e.target.parentElement.parentElement.parentElement.querySelector(
                "[data-mission='status']"
              ).innerText = setStatus(product["status"]);
              product["status"] == "1"
                ? (statusBtn.className = "btn status-btn")
                : (statusBtn.className = "btn success-btn");
            }
            ShowMessage(productLogger, message, status, "none");
            productLoad.style.display = "none";
          },
        });
      }
    });
  
    // Create table row
    const tr = document.createElement("tr");
    const td1 = document.createElement("td");
    const td2 = document.createElement("td");
    const td3 = document.createElement("td");
    const td4 = document.createElement("td");
    td4.dataset.mission = "status";
    const td5 = document.createElement("td");
    const td6 = document.createElement("td");
    td1.innerText = product["id"];
    td2.innerText = product["name"];
    td3.innerText = getCategory(product["category"]);
    td4.innerText = setStatus(product["status"]);
    td6.innerText = `₺${product["price"]}`;
    td5.append(tableForm);
    td5.classList.add("table-form-td");
    tr.append(td1, td2, td3, td6, td4, td5);
  
    return tr;
  }