function getInfo() {
    var isbn = document.getElementById("isbn").value;
    if (isbn !== "") {
        
        var xhr = new XMLHttpRequest();
        var url = "https://www.googleapis.com/books/v1/volumes?q=isbn:"+isbn+"+&key=AIzaSyCa9kzvRulB3VeTXHN7iV3N3Eg5v_JtXFs";
        xhr.open("GET",url,true);

        xhr.onload = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {

                var response = JSON.parse(xhr.responseText);
        
                
                
                try {
                    let arrayCategorie = response["items"][0]["volumeInfo"]["categories"];  
                    var categorie = "";
                    if (arrayCategorie) {
                        for(let i = 0; i < arrayCategorie.length; i++){ 
                            categorie = categorie + arrayCategorie[i] + ", ";
                        }
                        categorie = categorie.slice(0, -2);
                    }
                } catch (e) {
                    console.error(e);
                }

                //cerco l'immagine
                try {
                    var image = response["items"][0]["volumeInfo"]["imageLinks"]["thumbnail"];
                    document.getElementById("add-book1").style.display = "none";
                    document.getElementById("confirm-book").style.display = "flex";
                    //document.getElementById("titolo").value = titolo;
                    document.getElementById("copertina").src = image;
                    //document.getElementById("autori").value = autori;
                    //document.getElementById("categoria").value = categorie;
                } catch (e) {
                    document.getElementById("add-book1").style.display = "none";
                    document.getElementById("add-book2").style.display = "flex";
                }

                //cerco il titolo
                try {
                    var titolo = response["items"][0]["volumeInfo"]["title"];
                    document.getElementById("titolo").value = titolo;
                } catch (e) {
                    console.error(e);
                }

                //cerco gli autori
                try {
                    let arrayAutori = response["items"][0]["volumeInfo"]["authors"];
                    var autori = "";
                    for(let i = 0; i < arrayAutori.length; i++){ 
                        autori = autori + arrayAutori[i] +", ";
                    }
                    var autore = autori.slice(0, -2)
                    document.getElementById("autore").value = autore;
                } catch (e) {
                    console.error(e);
                }

                //inserisco il valore dell'isbn
                document.getElementById("isbn1").value = isbn;
                
            }
        };


        xhr.onerror = function() {

            //console.error(xhr.status,xhr.statusText);
            document.getElementById("info").style.display = "block";


        };

        xhr.send();
        
    }
}


function passInfo() {
    var isbn = document.getElementById("isbn").value;
    var autore = document.getElementById("autore").value;
    var titolo = document.getElementById("titolo").value;

    if (!isbn || !autore || !titolo)  {
        alert("Inserisci le info richieste");
    }
}