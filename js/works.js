const modal = document.querySelector(".modal");
const img00 = document.querySelector(".img00");
const img01 = document.querySelector(".img01");
const img02 = document.querySelector(".img02");
const img03 = document.querySelector(".img03");
const modal_img = document.querySelector(".modal_content");
const span = document.querySelector(".close");

img00.addEventListener("click", () => {
  modalDisplay("block");
  modal_img.src = img00.src;
});
img01.addEventListener("click", () => {
  modalDisplay("block");
  modal_img.src = img01.src;
});
img02.addEventListener("click", () => {
  modalDisplay("block");
  modal_img.src = img02.src;
});
img03.addEventListener("click", () => {
  modalDisplay("block");
  modal_img.src = img03.src;
});
span.addEventListener("click", () => {
  modalDisplay("none");
});
modal.addEventListener("click", () => {
  modalDisplay("none");
});

function modalDisplay(text) {
  modal.style.display = text;
}
