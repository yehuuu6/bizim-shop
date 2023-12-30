import {
  ManageUsersPage,
  currentUsers,
} from "@/control-center/dashboard/users";

export const rowNumberUsers = {
  value: 0,
};

export interface UserInterface {
  id: string;
  name: string;
  surname: string;
  userName: string;
  email: string;
  telephone: string;
  permission: string;
  [key: string]: string;
}

export default function createUserTable(user: UserInterface) {
  user.userName = user["name"] + " " + user["surname"];
  // Create table row
  const tr = document.createElement("tr");
  tr.innerHTML = `
        <td>${++rowNumberUsers.value}</td>
        <td>${user.userName}</td>
        <td>${user.email}</td>
        <td>${user.telephone}</td>
        <td class="table-form-td">
            <form class="table-form" data-id="${user.id}">
                <button data-action="upgrade" class="dashboard-btn edit-btn">Yükselt</button>
                <button data-action="ban" class="dashboard-btn delete-btn">Yasakla</button>
            </form>
        </td>
    `;
  const tableForm = tr.querySelector(".table-form") as HTMLElement;
  tableForm.addEventListener("click", (e) => {
    e.preventDefault();
    if ((e.target as HTMLElement).dataset.action == "upgrade") {
      // Get the id of the user
      let id = ((e.target as HTMLElement).parentElement as HTMLElement).dataset
        .id;
      // Get the user from the currentUsers array
      let user = currentUsers.value.find(
        (user: UserInterface) => user["id"] == id
      );
      ManageUsersPage.showMessage([
        "success",
        `${user?.userName} isimli kullanıcı yetkisi yükseltildi. (TODO)`,
        "none",
      ]);
    } else if ((e.target as HTMLElement).dataset.action == "ban") {
      // Get the id of the user
      let id = ((e.target as HTMLElement).parentElement as HTMLElement).dataset
        .id;
      // Get the plugin from the currentUsers array
      let user = currentUsers.value.find(
        (user: UserInterface) => user["id"] == id
      );
      ManageUsersPage.showMessage([
        "success",
        `${user?.userName} isimli kullanıcı yasaklandı. (TODO)`,
        "none",
      ]);
    }
  });

  return tr;
}
