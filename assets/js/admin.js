const booksbutton = document.getElementById('books');
const usersbutton = document.getElementById('users');
const shipmentsbutton = document.getElementById('shipments');
const walletsbutton = document.getElementById('wallets');

var books = document.getElementById("books-table");
var users = document.getElementById("users-table");
var shipments = document.getElementById("shipments-table");
var wallets = document.getElementById("wallets-table");

books.style.display = "flex";
users.style.display = "none";
shipments.style.display = "none";
wallets.style.display = "none";

booksbutton.addEventListener("click", () => {
    books.style.display = "flex";
    users.style.display = "none";
    shipments.style.display = "none";
    wallets.style.display = "none";
});

usersbutton.addEventListener("click", () => {
    books.style.display = "none";
    users.style.display = "flex";
    shipments.style.display = "none";
    wallets.style.display = "none";
});

shipmentsbutton.addEventListener("click", () => {
    books.style.display = "none";
    users.style.display = "none";
    shipments.style.display = "flex";
    wallets.style.display = "none";
});

walletsbutton.addEventListener("click", () => {
    books.style.display = "none";
    users.style.display = "none";
    shipments.style.display = "none";
    wallets.style.display = "flex";
});