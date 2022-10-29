if (!localStorage.getItem('cookie-consent')) {
            document.getElementById("cookie-advice").style.display = 'block';
        }
        
        document.getElementById('accept-cookies').addEventListener("click", function() {
            document.getElementById("cookie-advice").style.display = 'none';
            localStorage.setItem("cookie-consent","true");
        });