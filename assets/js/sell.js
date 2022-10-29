const addBookOpen = document.getElementById("add-book-open");

const addBookClose1 = document.getElementById("add-book-close1");
const noISBN = document.getElementById("no-isbn-link");
const addBook1 = document.getElementById("add-book1");

const addBookClose2 = document.getElementById("add-book-close2");
const nextBtn = document.getElementById("next-btn1");
const addBook2 = document.getElementById("add-book2");

const addBookClose3 = document.getElementById("add-book-close3");
const addBook3 = document.getElementById("add-book3");

const noConfirm = document.getElementById("no-confirm");
const confirmBook = document.getElementById("confirm-book");

const yesConfirm = document.getElementById("yes-confirm");

addBookOpen.addEventListener("click", () => {
  addBook1.style.display = "flex";
});

addBookClose1.addEventListener("click", () => {
  addBook1.style.display = "none";
});

addBookClose2.addEventListener("click", () => {
  addBook2.style.display = "none";
});

addBookClose3.addEventListener("click", () => {
  addBook3.style.display = "none";
});

noISBN.addEventListener("click", () => {
  addBook1.style.display = "none";
  addBook2.style.display = "flex";
});

noConfirm.addEventListener("click", () => {
  confirmBook.style.display = "none";
  addBook2.style.display = "flex";
  document.getElementById("titolo").value = null;
  document.getElementById("autore").value = null;
});

yesConfirm.addEventListener("click", () => {
  confirmBook.style.display = "none";
  addBook3.style.display = "flex";
  // document.getElementById("sel-copertina").style.display = "none";
  // document.getElementById("sel-copertina").removeAttribute('required');
  // document.getElementById("immagine-libro").style.display = "block";
  document.getElementById("immagine-libro").src =
    document.getElementById("copertina").src;
  document.getElementById("foto").value =
    document.getElementById("copertina").src;
});

nextBtn.addEventListener("click", () => {
  const titoloNow = document.getElementById("titolo").value;
  const autoreNow = document.getElementById("autore").value;
  const elementToDisplay = document.getElementById("fail1");
  if (!titoloNow || !autoreNow) {
    elementToDisplay.style.display = "block";
  } else {
    addBook2.style.display = "none";
    addBook3.style.display = "flex";
  }
});

const getCashOpen = document.getElementById("get-cash-open");
const getCashClose = document.getElementById("get-cash-close");
const getCash = document.getElementById("get-cash");

getCashOpen.addEventListener("click", () => {
  getCash.style.display = "flex";
});

getCashClose.addEventListener("click", () => {
  getCash.style.display = "none";
});
