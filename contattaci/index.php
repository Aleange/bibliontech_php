<?php 

require_once('../includes/session.php');
if (!isset($_SESSION['user_token'])) {
    $logged = 0;
} else {
    $logged = 1;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>BiblionTech</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="../assets/css/account.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/form.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/typewriter.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center"
                href="https://bibliontech.it/"><span>BiblionTech</span></a><button data-bs-toggle="collapse" class="navbar-toggler"
                data-bs-target="#navcol-1"><span class="navbar-toggler-icon"><svg xmlns="http://www.w3.org/2000/svg"
                        width="1em" height="1em" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M22 18.0048C22 18.5544 21.5544 19 21.0048 19H12.9952C12.4456 19 12 18.5544 12 18.0048C12 17.4552 12.4456 17.0096 12.9952 17.0096H21.0048C21.5544 17.0096 22 17.4552 22 18.0048Z"
                            fill="currentColor"></path>
                        <path
                            d="M22 12.0002C22 12.5499 21.5544 12.9954 21.0048 12.9954H2.99519C2.44556 12.9954 2 12.5499 2 12.0002C2 11.4506 2.44556 11.0051 2.99519 11.0051H21.0048C21.5544 11.0051 22 11.4506 22 12.0002Z"
                            fill="currentColor"></path>
                        <path
                            d="M21.0048 6.99039C21.5544 6.99039 22 6.54482 22 5.99519C22 5.44556 21.5544 5 21.0048 5H8.99519C8.44556 5 8 5.44556 8 5.99519C8 6.54482 8.44556 6.99039 8.99519 6.99039H21.0048Z"
                            fill="currentColor"></path>
                    </svg></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/acquista/">Home</a></li>
                    <?php 
                
                if ($logged === 0) {

                    echo '
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/services/">Come funziona</a></li>
                    </ul><button class="btn nav-btn click" type="button" id="goToLogin"><a href="https://bibliontech.it/login/" style="color:white !important;"><i
                        class="far fa-user"></i></a></button>
                        
                    ';
                    

                } else {
                    echo '
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/acquisti/">Acquisti</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/vendite/">Vendite</a></li>
                    ';
                    echo "
                    </ul><a href='https://bibliontech.it/login/logout.php?token=$user_token'>Logout</a><a href='../my_account/' class='btn nav-btn click' type='button'>
                    <i class='far fa-user'></i></a>
                    ";
                }

                ?>


            </div>
        </div>
    </nav>
    <section>
        <div class="container flex-center">
            <div class="row">
                <div class="col">

                    <div id="mail-request" class="my-container">
                        <!--FORM PER RICHIESTA CAMBIO PASSWORD-->
                        <form class="form-cont" action="index.php" method="POST">
                            <div class="form-text">
                                <h1>Contattaci</h1>
                                <span id="invalidi" style="color:red;display:none;">Alcuni campi non sono validi</span>
                                <span id="compila" style="color:red;display:none;">Compila tutti i campi</span>
                            </div>
                            <input class="form-control" type="text" placeholder="Nome" required="true" name="nome"
                                id="nome">
                            <input class="form-control" type="email" placeholder="Email" required="true" name="email"
                                id="email">
                            <textarea class="form-control" required="true" placeholder="Testo del messaggio" name="testo" id="testo" maxlength="500" ></textarea>
                            <button class="btn form-button" type="submit" name="invia">Invia</button>
                        </form>
                        <!--FINE FORM-->
                    </div>

                    <div id="email-success" style="display: none" class="form-cont">
                        <h1>Contattaci</h1>
                        <span>
                           Email inviata con successo.
                        </span>
                    </div>
                    
                    <div id="email-failed" style="display: none" class="form-cont">
                        <h1>Contattaci</h1>
                        <span>
                           Abbiamo riscontrato un problema nell'invio della mail. Riprova più tardi.
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <?php require_once('../includes/footer.php'); ?>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/contattaci.js"></script>
    <script src="../assets/js/form.js"></script>
    <script src="../assets/js/review.js"></script>
    <script src="../assets/js/rotatebook.js"></script>
    <script src="../assets/js/sell.js"></script>
    <script src="../assets/js/typewriter.js"></script>
    <script src="../assets/js/ajaxFormLogin.js"></script>
    <script src="../assets/js/historyReplace.js"></script>
</body>

</html>
<?php 
require_once('../includes/functions.php');
if (isset($_POST['invia'])) {
    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $testo = $_POST['testo'];
    
    if (!isset($_POST['email']) || empty($email) || !isset($_POST['nome']) || empty($nome) || !isset($_POST['testo']) || empty($testo)) {
        echo "<script>document.getElementById('compila').style.display = 'block';</script>";
        die();
    }
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>document.getElementById('invalidi').style.display = 'block';</script>";
        die();
    }
    $nome = clean_data($nome);
    $nome = filter_var($nome, FILTER_SANITIZE_STRING);
    
    $testo = clean_data($testo);
    $testo = filter_var($testo, FILTER_SANITIZE_STRING);
    
    //invio email a postmaster da postmaster con nome, indirizzo email e testo inseriti dall'utente
    sendMail($nome,$email,$testo);
}

function sendMail($name,$mail,$text) {
    error_reporting(E_ALL);
    
    // Genera un boundary
    $mail_boundary = "=_NextPart_" . md5(uniqid(time()));
    
    $to = "postmaster@bibliontech.it";
    $subject = "Ricezione Email";
    $sender = "Nuova Email Ricevuta < postmaster@bibliontech.it >";
    
    
    $headers = "From: $sender\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/alternative;\n\tboundary=\"$mail_boundary\"\n";
    $headers .= "X-Mailer: PHP " . phpversion();
     
    // Corpi del messaggio nei due formati testo e HTML
    $text_msg = "messaggio in formato testo";
    $html_msg = "<b>messaggio</b> in formato <p><a href='http://www.aruba.it'>html</a><br><img src=\"http://hosting.aruba.it/image_top/top_01.gif\" border=\"0\"></p>";
     
    // Costruisci il corpo del messaggio da inviare
    $msg = "This is a multi-part message in MIME format.\n\n";
    $msg .= "--$mail_boundary\n";
    $msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
    $msg .= "Content-Transfer-Encoding: 8bit\n\n";
    $msg .= "Nuovo messaggio ricevuto! L'utente $name con indirizzo mail $mail ha scritto: $text";  // aggiungi il messaggio in formato text
     
    $msg .= "\n--$mail_boundary\n";
    $msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
    $msg .= "Content-Transfer-Encoding: 8bit\n\n";
    $msg .= "<h2>Nuovo messaggio ricevuto!</h2> <p>L'utente $name con indirizzo mail <a href='mailto:$mail'>$mail</a> ha scritto: <br><strong>$text</strong></p>";  // aggiungi il messaggio in formato HTML
     
    // Boundary di terminazione multipart/alternative
    $msg .= "\n--$mail_boundary--\n";
     
    // Imposta il Return-Path (funziona solo su hosting Windows)
    ini_set("sendmail_from", $sender);
     
    // Invia il messaggio, il quinto parametro "-f$sender" imposta il Return-Path su hosting Linux
    if (mail($to, $subject, $msg, $headers, "-f$sender")) { 
        echo "<script>document.getElementById('mail-request').style.display = 'none'</script>";
        echo "<script>document.getElementById('email-success').style.display = 'block'</script>";
        die();
    } else { 
        echo "<script>document.getElementById('mail-request').style.display = 'none'</script>";
        echo "<script>document.getElementById('email-failed').style.display = 'block'</script>";
        die();
    }
}

?>