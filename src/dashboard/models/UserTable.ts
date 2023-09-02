import { currentUsers } from "../admin";

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
        <td>${user.id}</td>
        <td>${user.userName}</td>
        <td>${user.email}</td>
        <td>${user.telephone}</td>
        <td class="table-form-td">
            <form class="table-form" data-id="${user.id}">
                <button data-action="upgrade" class="btn edit-btn">Yükselt</button>
                <button data-action="ban" class="btn delete-btn">Yasakla</button>
            </form>
        </td>
    `;
    const tableForm = tr.querySelector(".table-form") as HTMLElement;
    tableForm.addEventListener("click", (e) => {
      e.preventDefault();
      if ((e.target as HTMLElement).dataset.action == "upgrade") {
        // Get the id of the user
        let id = ((e.target as HTMLElement).parentElement  as HTMLElement).dataset.id;
        // Get the user from the currentUsers array
        let user = currentUsers.value.find((user: UserInterface) => user["id"] == id);
        console.log(`Upgrading ${user?.userName}`);
      } else if ((e.target as HTMLElement).dataset.action == "ban") {
        // Get the id of the user
        let id = ((e.target as HTMLElement).parentElement as HTMLElement).dataset.id;
        // Get the plugin from the currentUsers array
        let user = currentUsers.value.find((user: UserInterface) => user["id"] == id);
        console.log(`Banning ${user?.userName}`);
      }
    });
  
    return tr;
  }