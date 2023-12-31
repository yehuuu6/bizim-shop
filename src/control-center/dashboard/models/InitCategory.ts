import axios from "axios";
import ICategory from "@/common/interfaces/ICategory";
import ISubCategory from "@/common/interfaces/ISubCategory";
import ConfirmationModal from "@/common/modals/confirmationModal";
import { ManageProductsPage } from "..";

const { modal, modalText, modalBtn } = ConfirmationModal();

const categoryWrapper = document.querySelector(
  ".category-wrapper"
) as HTMLDivElement;
const loaderSiteOptions = document.querySelector(
  "#loader-site-options"
) as HTMLDivElement;

/**
 * Initializes categories and renders them to the dom
 * @async
 * @returns void
 */
const initCategories = async () => {
  loaderSiteOptions.style.display = "flex";
  // Get data from api
  const categories_response = await axios({
    url: "/api/dashboard/category/categories.php",
    method: "post",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "multipart/form-data",
    },
  });
  const subcategories_response = await axios({
    url: "/api/dashboard/category/subcategories.php",
    method: "post",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "multipart/form-data",
    },
  });
  loaderSiteOptions.style.display = "none";
  const subcategories: ISubCategory[] = subcategories_response.data;
  const categories: ICategory[] = categories_response.data;
  categoryWrapper.innerHTML = "";
  for (const category of categories) {
    const categoryForList = createCategoryContainer(category, subcategories);
    categoryWrapper.appendChild(categoryForList);
  }
};

const createCategoryContainer = (category_data: any, subcategories: any) => {
  // Create a new element for category container
  const categoryContainer = document.createElement("div");
  categoryContainer.classList.add("category-container");
  categoryContainer.dataset.id = category_data.id.toString();

  const categoryTitleContainer = document.createElement("div");
  categoryTitleContainer.classList.add("category-title");

  const categoryTitle = document.createElement("h3");
  categoryTitle.innerText = category_data.name;

  const categoryBtnContainer = document.createElement("div");
  categoryBtnContainer.className = "category-btn-container";
  const addSubcategory = document.createElement("button");
  addSubcategory.className = "dashboard-btn small-btn success-btn";
  addSubcategory.innerHTML = `<i class="fa-solid fa-plus"></i>`;
  addSubcategory.title = "Alt Kategori Ekle";
  addSubcategory.id = "add-sub-btn";
  const editCategory = document.createElement("button");
  editCategory.className = "dashboard-btn small-btn edit-btn";
  editCategory.innerHTML = `<i class="fa-solid fa-pencil"></i>`;
  editCategory.title = "Kategoriyi Düzenle";
  editCategory.id = "edit-cat-btn";
  const deleteCategory = document.createElement("button");
  deleteCategory.className = "dashboard-btn small-btn delete-btn";
  deleteCategory.innerHTML = `<i class="fa-solid fa-trash"></i>`;
  deleteCategory.title = "Kategoriyi Sil";
  deleteCategory.id = "delete-cat-btn";
  categoryBtnContainer.appendChild(addSubcategory);
  categoryBtnContainer.appendChild(editCategory);
  categoryBtnContainer.appendChild(deleteCategory);

  editCategory.addEventListener("click", async () => {
    const categoryTitleInput = document.createElement("input");
    categoryTitleInput.type = "text";
    categoryTitleInput.className = "dashboard-input";
    categoryTitleInput.placeholder = "Yeni Kategori Adı";
    categoryTitleInput.value = category_data.name;
    categoryTitleInput.id = "update-category-name";

    const newCatCreator = document.createElement("div");
    newCatCreator.className = "category-btn-container width-100";
    const confirmBtn = document.createElement("button");
    confirmBtn.className = "dashboard-btn small-btn success-btn";
    confirmBtn.innerHTML = `<i class="fa-solid fa-check"></i>`;
    confirmBtn.title = "Onayla";
    const cancelBtn = document.createElement("button");
    cancelBtn.className = "dashboard-btn small-btn delete-btn";
    cancelBtn.innerHTML = `<i class="fa-solid fa-times"></i>`;
    cancelBtn.title = "İptal et";
    newCatCreator.appendChild(categoryTitleInput);
    newCatCreator.appendChild(confirmBtn);
    newCatCreator.appendChild(cancelBtn);

    categoryTitleContainer.replaceWith(newCatCreator);

    confirmBtn.addEventListener("click", async () => {
      const formData = new FormData();
      formData.append("id", category_data.id.toString());
      formData.append("name", categoryTitleInput.value);
      const response = await axios({
        url: "/api/dashboard/category/update-category.php",
        method: "post",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          "Content-Type": "multipart/form-data",
        },
        data: formData,
      });
      const [type, message, cause] = response.data;
      if (type === "success") {
        ManageProductsPage.showMessage(response.data);
        initCategories();
      } else {
        ManageProductsPage.showMessage(response.data);
      }
    });

    cancelBtn.addEventListener("click", () => {
      newCatCreator.replaceWith(categoryTitleContainer);
    });
  });

  addSubcategory.addEventListener("click", async () => {
    const subCategoryNameInput = document.createElement("input");
    subCategoryNameInput.type = "text";
    subCategoryNameInput.className = "dashboard-input";
    subCategoryNameInput.placeholder = "Yeni Alt Kategori";
    subCategoryNameInput.id = "new-subcategory-name";

    const newSubCatCreator = document.createElement("div");
    newSubCatCreator.className = "category-btn-container width-100";
    newSubCatCreator.style.padding = "10px";
    const confirmBtn = document.createElement("button");
    confirmBtn.className = "dashboard-btn small-btn success-btn";
    confirmBtn.innerHTML = `<i class="fa-solid fa-check"></i>`;
    confirmBtn.title = "Onayla";
    const cancelBtn = document.createElement("button");
    cancelBtn.className = "dashboard-btn small-btn delete-btn";
    cancelBtn.innerHTML = `<i class="fa-solid fa-times"></i>`;
    cancelBtn.title = "İptal et";
    newSubCatCreator.appendChild(subCategoryNameInput);
    newSubCatCreator.appendChild(confirmBtn);
    newSubCatCreator.appendChild(cancelBtn);

    categoryContainer.appendChild(newSubCatCreator);

    confirmBtn.addEventListener("click", async () => {
      const formData = new FormData();
      formData.append("name", subCategoryNameInput.value);
      formData.append("cid", category_data.id.toString());
      const response = await axios({
        url: "/api/dashboard/category/add-subcategory.php",
        method: "post",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          "Content-Type": "multipart/form-data",
        },
        data: formData,
      });
      const [type, message, cause] = response.data;
      if (type === "success") {
        ManageProductsPage.showMessage(response.data);
        initCategories();
      } else {
        ManageProductsPage.showMessage(response.data);
      }
    });

    cancelBtn.addEventListener("click", () => {
      newSubCatCreator.remove();
    });
  });

  deleteCategory.addEventListener("click", async () => {
    document.body.appendChild(modal);
    modalText.innerText = `"${category_data.name}" kategorisini ve onun alt kategorilerini silmek istediğinize emin misiniz?
    Bu kategorilere sahip ürünler "Kategorisiz" olarak listelenecektir.`;
    modalBtn.addEventListener("click", async () => {
      modal.remove();
      loaderSiteOptions.style.display = "flex";
      const formData = new FormData();
      formData.append("cid", category_data.id.toString());
      const response = await axios({
        url: "/api/dashboard/category/delete-category.php",
        method: "post",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          "Content-Type": "multipart/form-data",
        },
        data: formData,
      });
      const [type, message, cause] = response.data;
      if (type === "success") {
        ManageProductsPage.showMessage(response.data);
        categoryContainer.remove();
        loaderSiteOptions.style.display = "none";
      } else {
        ManageProductsPage.showMessage(response.data);
      }
    });
  });

  const seperator = document.createElement("hr");
  seperator.style.margin = "0";
  seperator.style.width = "100%";

  categoryTitleContainer.appendChild(categoryTitle);
  categoryTitleContainer.appendChild(categoryBtnContainer);

  categoryContainer.appendChild(categoryTitleContainer);
  categoryContainer.appendChild(seperator);

  if (
    subcategories.filter(
      (subcategory: any) => subcategory.cid === category_data.id
    ).length === 0
  ) {
    const noSubcategoriesMessage = document.createElement("p");
    noSubcategoriesMessage.innerText = "Alt kategori yok.";
    categoryContainer.appendChild(noSubcategoriesMessage);
  } else {
    // Add subcategories to the category container if there are any
    for (const subcategory of subcategories) {
      if (subcategory.cid === category_data.id) {
        const subcategoryContainer = document.createElement("div");
        subcategoryContainer.draggable = true;
        subcategoryContainer.classList.add("category-item");
        subcategoryContainer.dataset.id = subcategory.id.toString();
        subcategoryContainer.dataset.catId = subcategory.cid.toString();

        subcategoryContainer.addEventListener("dragstart", (event) => {
          event.dataTransfer?.setData("text/plain", subcategory.id.toString());
        });

        const subcategoryTitle = document.createElement("p");
        subcategoryTitle.classList.add("category-name");
        subcategoryTitle.innerText = subcategory.name;

        const subcategoryBtnContainer = document.createElement("div");
        subcategoryBtnContainer.className = "category-btn-container";

        const subcategoryEditBtn = document.createElement("button");
        subcategoryEditBtn.className = "dashboard-btn small-btn edit-btn";
        subcategoryEditBtn.innerHTML = `<i class="fa-solid fa-pencil"></i>`;
        subcategoryEditBtn.title = "Düzenle";
        subcategoryEditBtn.id = "edit-sub-btn";

        subcategoryEditBtn.addEventListener("click", async () => {
          const subCategoryNameInput = document.createElement("input");
          subCategoryNameInput.type = "text";
          subCategoryNameInput.className = "dashboard-input";
          subCategoryNameInput.placeholder = "Yeni Alt Kategori Adı";
          subCategoryNameInput.value = subcategory.name;
          subCategoryNameInput.id = "new-subcat-name";

          const newSubCatCreator = document.createElement("div");
          newSubCatCreator.className = "category-btn-container width-100";
          newSubCatCreator.style.padding = "10px";
          newSubCatCreator.style.border = "1px dashed #4026ff";
          const confirmBtn = document.createElement("button");
          confirmBtn.className = "dashboard-btn small-btn success-btn";
          confirmBtn.innerHTML = `<i class="fa-solid fa-check"></i>`;
          confirmBtn.title = "Onayla";
          const cancelBtn = document.createElement("button");
          cancelBtn.className = "dashboard-btn small-btn delete-btn";
          cancelBtn.innerHTML = `<i class="fa-solid fa-times"></i>`;
          cancelBtn.title = "İptal et";
          newSubCatCreator.appendChild(subCategoryNameInput);
          newSubCatCreator.appendChild(confirmBtn);
          newSubCatCreator.appendChild(cancelBtn);

          subcategoryContainer.replaceWith(newSubCatCreator);

          confirmBtn.addEventListener("click", async () => {
            const formData = new FormData();
            formData.append("id", subcategory.id.toString());
            formData.append("name", subCategoryNameInput.value);
            formData.append("cid", category_data.id.toString());
            const response = await axios({
              url: "/api/dashboard/category/update-subcat.php",
              method: "post",
              headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "multipart/form-data",
              },
              data: formData,
            });
            const [type, message, cause] = response.data;
            if (type === "success") {
              ManageProductsPage.showMessage(response.data);
              initCategories();
            } else {
              ManageProductsPage.showMessage(response.data);
            }
          });

          cancelBtn.addEventListener("click", () => {
            newSubCatCreator.replaceWith(subcategoryContainer);
          });
        });

        const subcategoryDeleteBtn = document.createElement("button");
        subcategoryDeleteBtn.className = "dashboard-btn small-btn delete-btn";
        subcategoryDeleteBtn.innerHTML = `<i class="fa-solid fa-trash"></i>`;
        subcategoryDeleteBtn.title = "Alt Kategoriyi Kaldır";
        subcategoryDeleteBtn.id = "delete-sub-btn";

        subcategoryDeleteBtn.addEventListener("click", async () => {
          document.body.appendChild(modal);
          modalText.innerText = `"${subcategory.name}" alt kategorisini silmek istediğinize emin misiniz?
          Bu kategorideki ürünler "Kategorisiz" olarak listelenecektir.`;
          modalBtn.addEventListener("click", async () => {
            modal.remove();
            const formData = new FormData();
            formData.append("id", subcategory.id.toString());
            const response = await axios({
              url: "/api/dashboard/category/delete-subcategory.php",
              method: "post",
              headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "multipart/form-data",
              },
              data: formData,
            });
            if (response) {
              ManageProductsPage.showMessage(response.data);
              // Remove the category container from the dom
              subcategoryContainer.remove();
              initCategories();
            } else {
              ManageProductsPage.showMessage([
                "error",
                "Bir hata oluştu!",
                "none",
              ]);
            }
          });
        });

        subcategoryContainer.appendChild(subcategoryTitle);
        subcategoryBtnContainer.appendChild(subcategoryEditBtn);
        subcategoryBtnContainer.appendChild(subcategoryDeleteBtn);
        subcategoryContainer.appendChild(subcategoryBtnContainer);

        categoryContainer.appendChild(subcategoryContainer);
      }
    }
  }

  const oldBorderStyle = categoryContainer.style.border;

  categoryContainer.addEventListener("dragover", (event) => {
    event.preventDefault();
    const draggedSubcategoryId = event.dataTransfer?.getData("text/plain");
    categoryContainer.style.border = "1px dashed #4026ff";
  });

  categoryContainer.addEventListener("dragleave", (event) => {
    event.preventDefault();
    categoryContainer.style.border = oldBorderStyle;
  });

  // Add drop event listener to handle the drop
  categoryContainer.addEventListener("drop", (event) => {
    event.preventDefault();
    categoryContainer.style.border = oldBorderStyle;
    const draggedSubcategoryId = event.dataTransfer?.getData(
      "text/plain"
    ) as string;
    const draggedSubcategory = document.querySelector(
      `.category-item[data-id="${draggedSubcategoryId}"]`
    ) as HTMLDivElement;
    if (draggedSubcategory) {
      // Append the dragged subcategory to the new category container
      categoryContainer.appendChild(draggedSubcategory);
      if (draggedSubcategory.dataset.catId !== category_data.id.toString()) {
        // Update the subcategory's cid
        updateSubCategory(
          parseInt(draggedSubcategoryId),
          parseInt(category_data.id),
          draggedSubcategory.querySelector(".category-name")?.textContent || ""
        );
      }
    }
  });

  return categoryContainer;
};

async function updateSubCategory(id: number, cid: number, name: string) {
  const formData = new FormData();
  formData.append("id", id.toString());
  formData.append("cid", cid.toString());
  formData.append("name", name);
  const response = await axios({
    url: "/api/dashboard/category/update-subcat.php",
    method: "post",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "multipart/form-data",
    },
    data: formData,
  });
  const [type, message, cause] = response.data;
  if (type === "success") {
    ManageProductsPage.showMessage(response.data);
    initCategories();
  } else {
    ManageProductsPage.showMessage(response.data);
  }
}

const newCategoryNameInput = document.querySelector(
  "#new-category-name"
) as HTMLInputElement;
const addNewCategoryBtn = document.querySelector(
  "#add-category-btn"
) as HTMLButtonElement;

addNewCategoryBtn.addEventListener("click", async () => {
  const newCategoryName = newCategoryNameInput.value;
  const formData = new FormData();
  formData.append("name", newCategoryName);
  const response = await axios({
    url: "/api/dashboard/category/add-category.php",
    method: "post",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "multipart/form-data",
    },
    data: formData,
  });
  const [type, message, cause] = response.data;
  if (type === "success") {
    ManageProductsPage.showMessage(response.data);
    newCategoryNameInput.value = "";
    initCategories();
  } else {
    ManageProductsPage.showMessage(response.data);
  }
});

export default initCategories;
