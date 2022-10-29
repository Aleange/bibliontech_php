<?php 
require_once('../includes/session.php');
if (isset($_SESSION['user_token'])) {
    header('location: ../my_account/');
    die('effettua logout');
} else {
    require_once('../includes/functions.php');
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
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/services/">Come funziona</a></li>
                </ul><button class="btn nav-btn click" type="button" id="goToLogin"><i
                        class="far fa-user"></i></button>
            </div>
        </div>
    </nav>
    <section>
        <div class="container flex-center">
            <div class="row">
                <div class="col">

                    <div id="pw-request" class="my-container">
                        <!--FORM PER RICHIESTA CAMBIO PASSWORD-->
                        <form class="form-cont" action="index.php" method="POST">
                            <div class="form-text">
                                <h1>Reset password</h1>
                                <span>Inserisci la tua e-mail</span>

                            </div>
                            <input class="form-control" type="email" placeholder="Email" required="true" name="email"
                                id="email-reg">
                            <button class="btn form-button" type="submit" name="reset">Conferma</button>
                        </form>
                        <!--FINE FORM-->
                    </div>

                    <div id="pw-msg" style="display: none" class="form-cont">
                        <h1>Reset password</h1>
                        <span>Controlla la tua mail.<br>
                            Ti abbiamo inviato un link per effettuare il reset della password.
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <?php require_once('../includes/footer.php'); ?>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/form.js"></script>
    <script src="../assets/js/review.js"></script>
    <script src="../assets/js/rotatebook.js"></script>
    <script src="../assets/js/sell.js"></script>
    <script src="../assets/js/typewriter.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../assets/js/ajaxFormLogin.js"></script>
    <script src="../assets/js/historyReplace.js"></script>
</body>

</html>

<?php 

if (isset($_POST['reset'])) {
    $user_email = $_POST['email'];
    if(filter_var($user_email, FILTER_VALIDATE_EMAIL) && !empty($user_email)) {
        $user_email = filter_var($user_email, FILTER_SANITIZE_EMAIL);
        //VERIFICO CHE LA MAIL ESISTA NEL DATABASE
        $query = "
            SELECT *
            FROM users
            WHERE email = :email
        ";
        
        $check = $pdo->prepare($query);
        $check->bindParam(':email', $user_email, PDO::PARAM_STR);
        $check->execute();
        
        $user = $check->fetchAll(PDO::FETCH_ASSOC);

        if ($check->rowCount() === 1)  {

            //se l'email è presente creo una riga nel database con
            //la sua mail una chiave e la data di scadenza del link
            $expFormat = mktime(
                date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
                );
                $expDate = date("Y-m-d H:i:s",$expFormat);
                $key = md5($email);
                $addKey = substr(md5(uniqid(rand(),1)),3,10);
                $key = $key . $addKey;
             // Insert Temp Table
             $query = "
            INSERT INTO `password_reset_temp` VALUES
            (:email,:chiave,:expDate)
            ";
        
            $check = $pdo->prepare($query);
            $check->bindParam(':email', $user_email, PDO::PARAM_STR);
            $check->bindParam(':chiave', $key, PDO::PARAM_STR);
            $check->bindParam(':expDate', $expDate, PDO::PARAM_STR);
            
            if ($check->execute()) {
                sendMail($user_email,$key);
                echo "<script>document.getElementById('pw-request').style.display = 'none';</script>";
                echo "<script>document.getElementById('pw-msg').style.display = 'block';</script>";
                die();
            }
            
        } else {
            echo "<script>document.getElementById('pw-request').style.display = 'none';</script>";
            echo "<script>document.getElementById('pw-msg').style.display = 'block';</script>";
            die();
        }

    }
    else {
        die();
    }
}

function sendMail($emailTo,$chiave) {
    error_reporting(E_ALL);
    
    // Genera un boundary
    $mail_boundary = "=_NextPart_" . md5(uniqid(time()));
    
    $to = $emailTo;
    $subject = "Recupera password";
    $sender = "Password dimenticata < postmaster@bibliontech.it >";
    
    
    $headers = "From: $sender\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/alternative;\n\tboundary=\"$mail_boundary\"\n";
    $headers .= "X-Mailer: PHP " . phpversion();
    $activate_link = "https://bibliontech.it/reset/confirm.php?email=".$emailTo."&key=".$chiave."&action=reset";
     
    // Corpi del messaggio nei due formati testo e HTML
    $text_msg = "messaggio in formato testo";
    $html_msg = "<b>messaggio</b> in formato <p><a href='http://www.aruba.it'>html</a><br><img src=\"http://hosting.aruba.it/image_top/top_01.gif\" border=\"0\"></p>";
     
    // Costruisci il corpo del messaggio da inviare
    $msg = "This is a multi-part message in MIME format.\n\n";
    $msg .= "--$mail_boundary\n";
    $msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
    $msg .= "Content-Transfer-Encoding: 8bit\n\n";
    $msg .= "Per recuperare la password clicca sul seguente link: ".$activate_link;  // aggiungi il messaggio in formato text
     
    $msg .= "\n--$mail_boundary\n";
    $msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
    $msg .= "Content-Transfer-Encoding: 8bit\n\n";
    $msg .= "<p>Per recuperare la password clicca sul seguente link : <a href='".$activate_link."'>$activate_link</a></p>";  // aggiungi il messaggio in formato HTML
     
    // Boundary di terminazione multipart/alternative
    $msg .= "\n--$mail_boundary--\n";
     
    // Imposta il Return-Path (funziona solo su hosting Windows)
    ini_set("sendmail_from", $sender);
     
    // Invia il messaggio, il quinto parametro "-f$sender" imposta il Return-Path su hosting Linux
    if (mail($to, $subject, $msg, $headers, "-f$sender")) { 
        return true;
    } else { 
        return false;
    }
}


?>