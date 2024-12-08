function getInfo() {
  const isbn = document.getElementById("isbn").value;
  if (isbn !== "") {
    const xhr = new XMLHttpRequest();
    const url =
      "https://www.googleapis.com/books/v1/volumes?q=isbn:" +
      isbn +
      "+&key=AIzaSyCa9kzvRulB3VeTXHN7iV3N3Eg5v_JtXFs";
    xhr.open("GET", url, true);

    xhr.onload = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        const response = JSON.parse(xhr.responseText);

        try {
          const arrayCategorie = response.items[0].volumeInfo.categories;
          let categorie = "";
          if (arrayCategorie) {
            for (let i = 0; i < arrayCategorie.length; i++) {
              categorie = categorie + arrayCategorie[i] + ", ";
            }
            categorie = categorie.slice(0, -2);
          }
        } catch (e) {
          console.error(e);
        }

        // cerco l'immagine
        try {
          const image = response.items[0].volumeInfo.imageLinks.thumbnail;
          document.getElementById("add-book1").style.display = "none";
          document.getElementById("confirm-book").style.display = "flex";
          // document.getElementById("titolo").value = titolo;
          document.getElementById("copertina").src = image;
          // document.getElementById("autori").value = autori;
          // document.getElementById("categoria").value = categorie;
        } catch (e) {
          document.getElementById("add-book1").style.display = "none";
          document.getElementById("add-book2").style.display = "flex";
        }

        // cerco il titolo
        try {
          const titolo = response.items[0].volumeInfo.title;
          document.getElementById("titolo").value = titolo;
        } catch (e) {
          console.error(e);
        }

        // cerco gli autori
        try {
          const arrayAutori = response.items[0].volumeInfo.authors;
          let autori = "";
          for (let i = 0; i < arrayAutori.length; i++) {
            autori = autori + arrayAutori[i] + ", ";
          }
          const autore = autori.slice(0, -2);
          document.getElementById("autore").value = autore;
        } catch (e) {
          console.error(e);
        }

        // inserisco il valore dell'isbn
        document.getElementById("isbn1").value = isbn;
      }
    };

    xhr.onerror = function () {
      // console.error(xhr.status,xhr.statusText);
      document.getElementById("info").style.display = "block";
    };

    xhr.send();
  }
}

function passInfo() {
  const isbn = document.getElementById("isbn").value;
  const autore = document.getElementById("autore").value;
  const titolo = document.getElementById("titolo").value;

  if (!isbn || !autore || !titolo) {
    alert("Inserisci le info richieste");
  }
}
