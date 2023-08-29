// VARIABLES START

// User storage
let currentUsers = [];

let userSearchInterval;

// Manage Users Page
const userMore = document.querySelector("#load-more-users");
const userTable = document.querySelector("#users-table tbody");
const userLoader = document.querySelector("#loader-users");
const userRefresh = document.querySelector("#refresh-users");
const usersLogger = document.querySelector("#logger-users");

// VARIABLES END

// FUNCTIONS START

function createUserTable(user) {
  const userName = user["name"] + " " + user["surname"];
  // Create table form
  const tableForm = document.createElement("form");
  tableForm.classList.add("table-form");

  const upgradeBtn = document.createElement("button");
  upgradeBtn.setAttribute("data-action", "upgrade");
  upgradeBtn.classList.add("btn", "edit-btn");
  upgradeBtn.innerText = "Upgrade";

  const banBtn = document.createElement("button");
  banBtn.setAttribute("data-action", "ban");
  banBtn.classList.add("btn", "delete-btn");
  banBtn.innerText = "Yasakla";

  tableForm.append(upgradeBtn);
  tableForm.append(banBtn);
  tableForm.setAttribute("data-id", user["id"]);

  tableForm.addEventListener("click", (e) => {
    e.preventDefault();
    if (e.target.dataset.action == "upgrade") {
      // Get the id of the user
      let id = e.target.parentElement.dataset.id;
      // Get the user from the currentUsers array
      let user = currentUsers.find((user) => user["id"] == id);
      console.log(`Upgrading ${userName}`);
    } else if (e.target.dataset.action == "ban") {
      // Get the id of the user
      let id = e.target.parentElement.dataset.id;
      // Get the plugin from the currentUsers array
      let user = currentUsers.find((user) => user["id"] == id);
      console.log(`Banning ${userName}`);
    }
  });

  // Create table row
  const tr = document.createElement("tr");
  const td1 = document.createElement("td");
  const td2 = document.createElement("td");
  const td3 = document.createElement("td");
  const td4 = document.createElement("td");
  const td5 = document.createElement("td");
  td1.innerText = user["id"];
  td2.innerText = userName;
  td4.innerText = user["telephone"];
  td3.innerText = user["email"];
  td5.append(tableForm);
  td5.classList.add("table-form-td");
  tr.append(td1, td2, td3, td4, td5);

  return tr;
}

function searchUser() {
  let search = document.querySelector("#search-user").value;
  if (search.length > 0) {
    // Search for user inside currentUsers and remove all other users
    userTable.innerHTML = "";
    for (let i = 0; i < currentUsers.length; i++) {
      let user = currentUsers[i];
      const userName = user["name"] + "" + user["surname"];
      if (userName.toLowerCase().includes(search.toLowerCase())) {
        userTable.append(createUserTable(user));
      }
    }
    // If no users are found, display a message
    if (userTable.innerHTML === "") {
      let tr = document.createElement("tr");
      let td = document.createElement("td");
      td.innerText = "Kullanıcı bulunamadı";
      td.setAttribute("colspan", "7");
      tr.append(td);
      userTable.append(tr);
    }
  } else {
    // Load old users back
    userTable.innerHTML = "";
    for (let i = 0; i < currentUsers.length; i++) {
      let user = currentUsers[i];
      userTable.append(createUserTable(user));
    }
  }
}

// FUNCTIONS END

// Set interval on focus to search input and clear it when it's not focused
document.getElementById("search-user").addEventListener("focus", () => {
  userSearchInterval = setInterval(() => {
    searchUser();
  }, 100);
});
document.getElementById("search-user").addEventListener("blur", () => {
  clearInterval(userSearchInterval);
});

function loadFirstUsers() {
  currentUsers = [];
  userMore.classList.remove("disabled");
  userMore.disabled = false;
  userTable.innerHTML = "";
  usersLogger.className = "logger";
  usersLogger.innerHTML = "";
  userLoader.style.display = "flex";
  $.ajax({
    url: "/api/dashboard/users/load-users.php",
    type: "POST",
    data: {
      start: 0,
    },
    success: function (data) {
      let users = JSON.parse(data);
      for (let i = 0; i < users.length; i++) {
        let user = users[i];
        currentUsers.push(user);
        userTable.append(createUserTable(user));
      }
      userLoader.style.display = "none";
    },
  });
}

$(document).ready(function () {
  userRefresh.addEventListener("click", () => {
    loadFirstUsers();
    document.getElementById("search-user").value = "";
    document.querySelector("#start-val-users").value = 5;
  });
  // Load first 5 users on page load
  loadFirstUsers();
  $("#load-users").submit(function (e) {
    e.preventDefault();
    const startVal = document.querySelector("#start-val-users");
    userLoader.style.display = "flex";
    const formData = new FormData(this);
    $.ajax({
      url: "api/dashboard/users/load-users.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (data) {
        userLoader.style.display = "none";
        ShowMessage(
          usersLogger,
          "Kullanıcılar başarıyla yüklendi.",
          "success",
          "none"
        );
        let users = JSON.parse(data);
        for (let i = 0; i < users.length; i++) {
          let user = users[i];
          currentUsers.push(user);
          userTable.append(createUserTable(user));
        }
        // Scroll to load-more button
        $("html, body").animate(
          {
            scrollTop: $(userMore).offset().top,
          },
          1000
        );
        // Disable load-more button if no more plugins
        if (users.length < 5) {
          userMore.disabled = true;
          ShowMessage(
            usersLogger,
            "Daha fazla kullanıcı bulunamadı.",
            "error",
            "none"
          );
          userMore.classList.add("disabled");
        }
      },
    });
    // Increment start and end values
    startVal.value = parseInt(startVal.value) + 5;
  });
});
