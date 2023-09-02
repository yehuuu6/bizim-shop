import PanelClass from "./classes/PanelClass";
import ConfirmationModal from "./models/Modal";
import { getApiResponse, clearAvatarInput } from "./utils/functions.usr";

import $ from "jquery";

const { modal, modalText, modalBtn } = ConfirmationModal();

const logger = document.querySelector(".logger") as HTMLParagraphElement;
const profileLoader = document.querySelector("#loader-profile") as HTMLParagraphElement;

const ProfilePage = new PanelClass(profileLoader);

const ResetPassword = new PanelClass(profileLoader);

const RemoveAvatar = new PanelClass(profileLoader);

  $(document).on("submit", "#profile-form", function (e) {
    e.preventDefault();
    getApiResponse(
      ProfilePage,
      "/api/dashboard/users/edit-profile.php",
      new FormData(this)
    );
  });
  $(document).on("click", "#password-reset", function (e) {
    e.preventDefault();
    getApiResponse(
      ResetPassword,
      "/api/dashboard/users/reset-password.php",
      new FormData()
    );
  });
  $(document).on("click", "#delete-avatar", function (e) {
    e.preventDefault();
    document.body.append(modal);
    modalText.innerText = "Profil resminizi silmek istediğinize emin misiniz?";
    modalBtn.addEventListener("click", function () {
      getApiResponse(
        RemoveAvatar,
        "/api/dashboard/users/delete-avatar.php",
        new FormData()
      );
      modalText.innerText = "";
      modal.remove();
      clearAvatarInput();
      (document.querySelector(".profile-image") as HTMLImageElement).src = "/global/imgs/nopp.png";
      $("#delete-avatar").remove();
    });
  });

// Exports

export { ProfilePage };
