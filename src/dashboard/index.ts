// Other imports
import PanelClass from "./classes/PanelClass";
import ConfirmationModal from "./models/Modal";
import { getApiResponse, clearAvatarInput } from "./utils/functions.usr";
import { Router } from "./Router";
import getPerm from "./utils/authorize";

// CSS
import "../styles/dashboard.css";
import "../styles/utils.css";

// Activate dev tools if user is admin
getPerm().then((permLevel) => {
  if (permLevel === 1) {
    import("./dev")
      .then((module) => {
        const { initializeDevTools } = module;
        initializeDevTools();
      })
      .catch((err) => console.error(err));
  }
});

const settingsBtn = document.querySelector("#settings") as HTMLButtonElement;
// Settings container
const settingsContainer = document.querySelector(
  ".settings-container"
) as HTMLDivElement;

// If clicked something other than .settings, display none
settingsContainer.addEventListener("click", (e) => {
  if (e.target === settingsContainer) {
    settingsContainer.style.display = "none";
  }
});

// If clicked settings button, display block
settingsBtn.addEventListener("click", () => {
  settingsContainer.style.display = "flex";
});

Router.initialize();

const { modal, modalText, modalBtn } = ConfirmationModal();

const profileLoader = document.querySelector(
  "#loader-profile"
) as HTMLParagraphElement;

const ProfilePage = new PanelClass(profileLoader);

document.querySelector("#profile-form")!.addEventListener("submit", (e) => {
  e.preventDefault();
  getApiResponse(
    ProfilePage,
    "/api/dashboard/users/edit-profile.php",
    new FormData(document.querySelector("#profile-form") as HTMLFormElement)
  );
});

document.querySelector("#password-reset")!.addEventListener("click", (e) => {
  e.preventDefault();
  getApiResponse(
    ProfilePage,
    "/api/dashboard/users/reset-password.php",
    new FormData()
  );
});

// User avatar settings

const removeBtn = document.createElement("span");
removeBtn.classList.add("remove-image");
removeBtn.title = "Profil resmini kaldır";
removeBtn.id = "delete-avatar";
removeBtn.innerHTML = '<i class="fa-solid fa-trash-can"></i>';

interface DistrictInterface {
  id: string;
  district_name: string;
  city_id: string;
}

interface CityInterface {
  id: string;
  city_name: string;
}

interface ProfileInfoInterface {
  profile_image: string;
  district: string;
  city: string;
}

let myDistrict: string;
let myCity: string;

ProfilePage.sendApiRequest(
  "/api/dashboard/users/get-profile.php",
  new FormData()
).then((profile: ProfileInfoInterface) => {
  const profileImage = profile.profile_image;
  myDistrict = profile.district;
  myCity = profile.city;
  if (profileImage !== "nopp.png") imageContainer.append(removeBtn);
});

const imageContainer = document.querySelector(
  ".image-container"
) as HTMLDivElement;
const imageInput = document.getElementById("avatar-input") as HTMLInputElement;
const displayFile = document.querySelector(
  ".profile-image"
) as HTMLImageElement;

imageInput.addEventListener("change", function () {
  window.scrollTo({
    top: document.body.scrollHeight,
    behavior: "smooth",
  });
  const file = this.files![0];
  ProfilePage.showMessage([
    "warning",
    "Profil resminiz kaydedilmedi. Değişiklikleri kaydetmeden çıkarsanız profil resminiz değişmeyecektir.",
    "none",
  ]);
  if (file) {
    (
      document.querySelector("#avatar-input-displayer") as HTMLParagraphElement
    ).innerText = file.name;
    imageContainer.append(removeBtn);
    const reader = new FileReader();
    reader.addEventListener("load", function () {
      displayFile.setAttribute("src", this.result as string);
    });
    reader.readAsDataURL(file);
  }
});

removeBtn.addEventListener("click", (e) => {
  e.preventDefault();
  document.body.append(modal);
  modalText.innerText = "Profil resminizi silmek istediğinize emin misiniz?";
  modalBtn.addEventListener("click", function () {
    getApiResponse(
      ProfilePage,
      "/api/dashboard/users/delete-avatar.php",
      new FormData()
    );
    modalText.innerText = "";
    modal.remove();
    clearAvatarInput();
    (document.querySelector(".profile-image") as HTMLImageElement).src =
      "/global/imgs/nopp.png";
    removeBtn.remove();
  });
});

// Pull cities and districts from database

const citySelector = document.getElementById("city") as HTMLSelectElement;
const districtSelector = document.getElementById(
  "district"
) as HTMLSelectElement;

let cities: Array<CityInterface> = [];
let districts: Array<DistrictInterface> = [];

ProfilePage.sendApiRequest(
  "/api/dashboard/users/get-cities.php",
  new FormData()
).then((_cities: Array<CityInterface>) => {
  cities = _cities;
  cities.forEach(function (city) {
    var option = document.createElement("option");
    option.value = city.id;
    option.textContent = city.city_name;
    if (myCity == city.id) {
      option.selected = true;
    }
    citySelector.appendChild(option);
  });
});

ProfilePage.sendApiRequest(
  "/api/dashboard/users/get-districts.php",
  new FormData()
).then((_districts: Array<DistrictInterface>) => {
  districts = _districts;
  const cityId = citySelector.value;
  // Check if citySelector has a city selected
  if (cityId !== "") {
    // Enable district selector
    districtSelector.disabled = false;
    districts.forEach(function (district: DistrictInterface) {
      if (district.city_id === cityId) {
        var option = document.createElement("option");
        option.value = district.id;
        option.textContent = district.district_name;
        if (myDistrict == district.id) {
          option.selected = true;
        }
        districtSelector.appendChild(option);
      }
    });
  }
});

citySelector.addEventListener("change", function () {
  const cityId = citySelector.value;
  // İlçe seçimini temizle ve devre dışı bırak
  districtSelector.innerHTML = '<option value="">İlçe Seçiniz</option>';
  districtSelector.disabled = true;

  if (cityId !== "") {
    districts.forEach(function (district: DistrictInterface) {
      if (district.city_id === cityId) {
        var option = document.createElement("option");
        option.value = district.id;
        option.textContent = district.district_name;
        districtSelector.appendChild(option);
      }
    });
    districtSelector.disabled = false;
  }
});

const deleteNotificationBtn = document.querySelector(
  "#close-logger"
) as HTMLButtonElement;

deleteNotificationBtn.addEventListener("click", () => {
  ProfilePage.clearLogger();
});

// Exports

export { ProfilePage };
