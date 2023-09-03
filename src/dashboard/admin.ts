import createUserTable, { UserInterface, rowNumberUsers } from "./models/UserTable";
import PanelClass from "./classes/PanelClass";
import { runSearchUsers } from "./utils/functions.dev";

// VARIABLES START

// User storage
const currentUsers: { value: UserInterface[] } = {
  value: [],
};

let startVal = 5;

// Manage Users Page

const userMore = document.querySelector("#load-more-users") as HTMLButtonElement;
const userTable = document.querySelector("#users-table tbody") as HTMLTableSectionElement;
const userLoader = document.querySelector("#loader-users") as HTMLDivElement;
const userRefresh = document.querySelector("#refresh-users") as HTMLButtonElement;
const searchInput = document.querySelector("#search-user") as HTMLInputElement;

const ManageUsersPage = new PanelClass(userLoader);

// VARIABLES END

// FUNCTIONS START

function getSearchUser() {
  const search = searchInput.value.trim().toLowerCase();

  userTable.innerHTML = "";

  if (search.length > 0) {
    const matchingUsers = currentUsers.value.filter((user: UserInterface) =>
      user["userName"].toLowerCase().includes(search)
    );

    if (matchingUsers.length === 0) {
      userTable.innerHTML = `
        <tr>
          <td colspan="7">Hiçbir ürün bulunamadı</td>
        </tr>
      `;
    } else {
      matchingUsers.forEach((user) => {
        userTable.appendChild(createUserTable(user));
      });
    }
  } else {
    currentUsers.value.forEach((user) => {
      userTable.appendChild(createUserTable(user));
    });
  }
}

// FUNCTIONS END

async function loadFirstUsers() {
  currentUsers.value = [];
  userMore.classList.remove("disabled");
  userMore.disabled = false;
  userTable.innerHTML = "";

  const formData = new FormData();
  formData.append("start", "0");
  const response = await ManageUsersPage.sendApiRequest(
    "/api/dashboard/users/load-users.php",
    formData
  );

  const users = response;

  if (users !== undefined || users.length !== 0) {
    users.forEach((user: UserInterface) => {
      currentUsers.value.push(user);
      userTable.appendChild(createUserTable(user));
    });
  }
}

runSearchUsers(searchInput);

function refreshUsers() {
  loadFirstUsers();
  ManageUsersPage.clearLogger();
  searchInput.value = "";
  startVal = 5;
  rowNumberUsers.value = 0;
}

userRefresh.addEventListener("click", () => {
  refreshUsers();
});

(document
  .querySelector('div[data-name="users"]') as HTMLDivElement)
  .addEventListener("click", () => {
    refreshUsers();
  });
// Load first 5 users on page load
loadFirstUsers();

userMore.addEventListener("click", function (e) {
  e.preventDefault();
  const formData = new FormData();
  formData.append("start", startVal.toString());
  ManageUsersPage.sendApiRequest(
    "/api/dashboard/users/load-users.php",
    formData
  ).then((response) => {
    let users = response;
    if (users === undefined || users.length === 0) {
      userMore.classList.add("disabled");
      userMore.disabled = true;
      ManageUsersPage.showMessage([
        "error",
        "Daha fazla kullanıcı bulunamadı.",
        "none",
      ]);
    } else {
      for (let i = 0; i < users.length; i++) {
        let user = users[i];
        currentUsers.value.push(user);
        userTable.append(createUserTable(user));
        ManageUsersPage.showMessage([
          "success",
          "5 ürün başarıyla yüklendi.",
          "none",
        ]);
      }
    }
    startVal += 5;
  });
});

// Exports

export {
  currentUsers,
  getSearchUser,
  ManageUsersPage,
};

