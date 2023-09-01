import PanelClass from "./classes/PanelClass";
import ConfirmationModal from "./models/Modal";
import { getApiResponse, clearAvatarInput } from "./utils/functions.usr";

const { modal, modalText, modalBtn } = ConfirmationModal();

const profileLogger: HTMLParagraphElement = document.querySelector("#logger-profile")!;
const profileLoader: HTMLDivElement = document.querySelector("#loader-profile")!;

const ProfilePage = new PanelClass(profileLogger, profileLoader);

const ResetPassword = new PanelClass(profileLogger, profileLoader);

const RemoveAvatar = new PanelClass(profileLogger, profileLoader);

  $(document).on("submit", "#profile-form", function (e) {
    e.preventDefault();
    getApiResponse(
      ProfilePage,
      "/api/dashboard/users/edit-profile.php",
      new FormData(this),
      profileLogger
    );
  });
  $(document).on("click", "#password-reset", function (e) {
    e.preventDefault();
    getApiResponse(
      ResetPassword,
      "/api/dashboard/users/reset-password.php",
      new FormData(),
      profileLogger
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
        new FormData(),
        profileLogger
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
