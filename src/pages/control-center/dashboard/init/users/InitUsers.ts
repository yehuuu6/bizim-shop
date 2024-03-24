import createUserTable, { UserInterface, rowNumberUsers } from './UserTable';
import PanelClass from '@/classes/PanelController';
import { debounce } from '@/common/funcs/functions.usr';

// VARIABLES START

// User storage
const currentUsers: { value: UserInterface[] } = {
  value: [],
};

let sqlOffset = 0;
let userLimit = 30;

// Manage Users Page

const userMore = document.querySelector(
  '#load-more-users'
) as HTMLButtonElement;
const userTable = document.querySelector(
  '#users-table tbody'
) as HTMLTableSectionElement;
const userLoader = document.querySelector('#loader-users') as HTMLDivElement;
const userRefresh = document.querySelector(
  '#refresh-users'
) as HTMLButtonElement;
const searchInput = document.querySelector('#search-user') as HTMLInputElement;

const ManageUsersPage = new PanelClass(userLoader);

// VARIABLES END

// FUNCTIONS START

function runSearchUsers(searchUserInput: HTMLInputElement) {
  let userSearchInterval: any = null;
  // Set interval on focus to search input and clear it when it's not focused
  searchUserInput.addEventListener('focus', () => {
    if (!userSearchInterval) {
      userSearchInterval = setInterval(() => {
        getSearchUser();
      }, 300); // Throttle the calls to every 300 milliseconds
    }
  });

  searchUserInput.addEventListener('blur', () => {
    clearInterval(userSearchInterval);
    userSearchInterval = null; // Reset the interval variable
  });

  searchUserInput.addEventListener(
    'input',
    debounce(() => {
      getSearchUser();
    }, 300)
  ); // Debounce the input event to trigger after the user stops typing
}

let oldSearch = '';

function getSearchUser() {
  const search = searchInput.value.trim().toLowerCase();

  if (search === oldSearch) {
    return;
  } else if (search.length <= 0) {
    loadFirstUsers();
    oldSearch = search;
    return;
  }

  userMore.classList.add('disabled');
  userMore.disabled = true;

  sqlOffset = 0;

  oldSearch = search;

  const formData = new FormData();
  formData.append('search', search);
  formData.append('offset', '0');
  formData.append('limit', userLimit.toString());

  ManageUsersPage.sendApiRequest(
    '/api/dashboard/users/load-users.php',
    formData
  ).then((response) => {
    const users = response;
    if (users === undefined || users.length === 0) {
      userTable.innerHTML = `
        <tr>
          <td colspan="6" class="text-center">Kullanıcı bulunamadı.</td>
        </tr>
      `;
      return;
    }
    rowNumberUsers.value = 0;
    currentUsers.value = [];
    userTable.innerHTML = '';

    users.forEach((user: UserInterface) => {
      currentUsers.value.push(user);
      userTable.appendChild(createUserTable(user));
    });
  });
}

// FUNCTIONS END

async function loadFirstUsers() {
  sqlOffset = 0;
  rowNumberUsers.value = 0;
  searchInput.value = '';
  currentUsers.value = [];
  userMore.classList.remove('disabled');
  userMore.disabled = false;
  userTable.innerHTML = '';

  const formData = new FormData();
  formData.append('offset', '0');
  formData.append('limit', userLimit.toString());
  const response = await ManageUsersPage.sendApiRequest(
    '/api/dashboard/users/load-users.php',
    formData
  );

  const users = response;

  if (users === undefined || users.length === 0) {
    userTable.innerHTML = `
      <tr>
        <td colspan="6" class="text-center">Kullanıcı bulunamadı.</td>
      </tr>
    `;
    return;
  }

  if (users !== undefined || users.length !== 0) {
    users.forEach((user: UserInterface) => {
      currentUsers.value.push(user);
      userTable.appendChild(createUserTable(user));
    });
  }
}

function refreshUsers() {
  loadFirstUsers();
}

userRefresh.addEventListener('click', () => {
  refreshUsers();
});

(
  document.querySelector('div[data-name="users"]') as HTMLDivElement
).addEventListener('click', () => {
  refreshUsers();
});

userMore.addEventListener('click', function (e) {
  e.preventDefault();
  sqlOffset += userLimit;
  const formData = new FormData();
  formData.append('search', searchInput.value.trim().toLowerCase());
  formData.append('offset', sqlOffset.toString());
  formData.append('limit', userLimit.toString());
  ManageUsersPage.sendApiRequest(
    '/api/dashboard/users/load-users.php',
    formData
  ).then((response) => {
    let users = response;
    if (users === undefined || users.length === 0) {
      userMore.classList.add('disabled');
      userMore.disabled = true;
      sqlOffset -= userLimit;
      ManageUsersPage.showMessage([
        'error',
        'Daha fazla kullanıcı bulunamadı.',
        'none',
      ]);
    } else {
      for (let i = 0; i < users.length; i++) {
        let user = users[i];
        currentUsers.value.push(user);
        userTable.append(createUserTable(user));
        ManageUsersPage.showMessage([
          'success',
          `${userLimit} kullanıcı başarıyla yüklendi.`,
          'none',
        ]);
      }
    }
  });
});

// Exports

export default function InitUsers() {
  runSearchUsers(searchInput);
  loadFirstUsers();
}

export { currentUsers, getSearchUser, ManageUsersPage };
