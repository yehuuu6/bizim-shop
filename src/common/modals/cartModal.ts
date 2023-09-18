export default function CartModal(product: string) {
  const modal = document.createElement("div");
  modal.classList.add("cart-modal");
  const cartCon = document.createElement("div");
  cartCon.classList.add("cart-modal-content");
  const modTitle = document.createElement("h1");
  modTitle.innerText = "Ürün Sepete Eklendi";
  modTitle.classList.add("cart-modal-title");
  const lineBreak = document.createElement("hr");
  lineBreak.classList.add("cart-modal-line");
  const cartModProductContainer = document.createElement("div");
  cartModProductContainer.classList.add("cart-modal-product-container");
  cartModProductContainer.innerHTML = product;
  const cartModCon = document.createElement("button");
  cartModCon.className = "cart-modal-btn";
  cartModCon.innerText = "Sepete git";

  const closeModal = document.createElement("span");
  closeModal.classList.add("cart-modal-close");
  closeModal.innerHTML = "<i class='fas fa-times'></i>";
  cartCon.append(closeModal);
  closeModal.addEventListener("click", () => {
    modal.remove();
  });

  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.remove();
    }
  });

  cartCon.append(
    modTitle,
    cartModProductContainer,
    lineBreak.cloneNode(),
    cartModCon
  );

  modal.append(cartCon);

  return {
    modal: modal,
    modalBtn: cartModCon,
  };
}
