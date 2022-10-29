<?php 
require_once('../includes/session.php');
if (isset($_SESSION['user_token'])) {
    header('Location: ../my_account/');
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
                </ul>
                <button class="btn nav-btn click" id="goToLogin" type="button"><i
                        class="far fa-user"></i></button>
            </div>
        </div>
    </nav>

    <section>
        <div class="container flex-center">
            <div class="row">
                <div class="col">
                    <div id="external-form-container" class="external-form-container">
                        <div id="SignUp-form" class="form-container sign-up-container">
                            <!--FORM REGISTRAZIONE-->
                            <form id="form-registrazione" action="index.php" onsubmit="return regSubmit()"
                                method="POST">
                                <h1>Crea account</h1>

                                <label style="display:none;color:red;" id="username-no-valid">Username già
                                    utilizzato</label>
                                <label style="display:none;color:red;" id="email-no-valid">Email già utilizzata</label>

                                <input class="form-control" type="text" id="username-reg" name="username-reg"
                                    placeholder="Username">


                                <input class="form-control" type="email" id="email-reg" name="email-reg"
                                    placeholder="Email">


                                <input class="form-control date-input" id="birthdate-reg" name="birthdate-reg"
                                    type="text" placeholder="Data di Nascita" onfocus="(this.type='date')">


                                <input class="form-control" type="password" id="password-reg" name="password-reg"
                                    placeholder="Password">

                                <button class="btn form-button shadow-none click" name="submit-reg"
                                    type="submit">Registrati</button>
                                <a id="acc-link" href="#">o Accedi</a>
                            </form>
                        </div>


                        <!--FORM LOGIN -->
                        <div id="SignIn-form" class="form-container sign-in-container">
                            <form method="post" action="index.php">
                                <h1>Accedi</h1>

                                <label id="failed" style="display: none;color:red;">Credenziali errate</label>

                                <input class="form-control" type="text" id="username-log" placeholder="Username"
                                    required="true" name="username-log">

                                <input class="form-control" type="password" id="password-log" placeholder="Password"
                                    required="true" name="password-log">

                                <a href="../reset/">Hai dimenticato la password?</a>

                                <button class="btn form-button shadow-none click" type="submit"
                                    name="submit-login">Accedi</button>
                                <a id="reg-link" href="#">o Registrati</a>
                            </form>
                        </div>


                        <div id="overlay-panel" class="overlay-container">
                            <div class="overlay gradient-background">
                                <div class="overlay-panel overlay-left">
                                    <h1>Bentornato!</h1>
                                    <p>Per connetterti al servizio, accedi usando le tue credenziali.</p><button
                                        class="btn ghost shadow-none click" id="signIn" type="button">Accedi</button>
                                </div>
                                <div class="overlay-panel overlay-right">
                                    <h1>Benvenuto!</h1>
                                    <p>Inserisci le tue informazioni personali ed accedi al servizio!<br></p><button
                                        class="btn ghost shadow-none click" id="signUp"
                                        type="button">Registrati</button>
                                </div>
                            </div>
                        </div>

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

require_once('../includes/functions.php');

/*ACTION REGISTRATION */
if (isset($_POST['submit-reg'])) {
    $birthdate = clean_data($_POST['birthdate-reg']) ?? '';
    $email = clean_data($_POST['email-reg']) ?? '';
    if (!$email = filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die();
    }
    $username = clean_data($_POST['username-reg']) ?? '';
    $password = clean_data($_POST['password-reg']) ?? '';
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $query = "
        SELECT id
        FROM users
        WHERE username = :username
    ";
    $query1 = "
        SELECT id
        FROM users
        WHERE email = :email
    ";
    
    $check = $pdo->prepare($query);
    $check1 = $pdo->prepare($query1);
    $check->bindParam(':username', $username, PDO::PARAM_STR);
    $check1->bindParam(':email', $email,PDO::PARAM_STR);
    $check->execute();
    $check1->execute();

    $user = $check->fetchAll(PDO::FETCH_ASSOC);
    $mail = $check1->fetchAll(PDO::FETCH_ASSOC);
        
    if (count($user) > 0) {
        echo '<script type="text/javascript">
    container.classList.add("right-panel-active");
    document.getElementById("username-no-valid").style.display = "block";
    document.getElementById("username-reg").classList.add("is-invalid");
    document.getElementById("username-reg").classList.add("border-red");
    </script>';
    echo '<script>container.classList.add("right-panel-active");</script>';
    die();
    } elseif(count($mail) > 0) {
        echo '<script type="text/javascript">
        container.classList.add("right-panel-active");
    document.getElementById("email-no-valid").style.display = "block";
    document.getElementById("email-reg").classList.add("is-invalid");
    document.getElementById("email-reg").classList.add("border-red");

    </script>';
    echo '<script>container.classList.add("right-panel-active");</script>';
    die();
    } else {
        $profileImageDefault = "https://icon-library.com/images/default-user-icon/default-user-icon-8.jpg";
        
        $query = "
            INSERT INTO users ( username, birthdate, email,profile_image, password, activation_code)
            VALUES (:username,:birthdate,:email, :profile_image, :password, :activation_code)
        ";
    
        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
        $check->bindParam(':email', $email, PDO::PARAM_STR);
        $check->bindParam(':profile_image',$profileImageDefault,PDO::PARAM_STR);
        $check->bindParam(':password', $password_hash, PDO::PARAM_STR);
        $code = uniqid();
        $check->bindParam(':activation_code', $code, PDO::PARAM_STR);
        $check->execute();

        $query21 = "
            SELECT id from users where email = :user_email
        ";
        $check21 = $pdo->prepare($query21);
        $check21->bindParam(':user_email', $email, PDO::PARAM_STR);
        $check21->execute();
        $ids = $check21->fetchAll();
        $newId = $ids[0]['id'];

        $query31 = "
            INSERT INTO address ( user_id, cap, indirizzo)
            VALUES (:user_id, 0, '')
        ";
    
        $check31 = $pdo->prepare($query31);
        $check31->bindParam(':user_id', $newId, PDO::PARAM_STR);
        $check31->execute();

        $query41 = "
            INSERT INTO saldo (user_id,lordo,commissione,netto,ricevuto)
            VALUES (:user_id,0,0,0,0)
        ";
    
        $check41 = $pdo->prepare($query41);
        $check41->bindParam(':user_id', $newId, PDO::PARAM_STR);
        $check41->execute();

        //creo la directory per l'user
        createDir($username,$newId);
        //error_reporting(E_ALL);

        //CREO LA SESSIONE
        
        session_regenerate_id();
        $_SESSION['session_id'] = session_id();
        $userToken = bin2hex(openssl_random_pseudo_bytes(24));
        //assign the token to a session variable.
        $_SESSION['user_token'] = $userToken;
        $_SESSION['session_user'] = $newId;
        $_SESSION['session_username'] = $username;
        $_SESSION['session_email'] = $email;
        $_SESSION['active'] = false;
        $mailSent = sendMail($email,$code,$username);
        header("Location: https://bibliontech.it/my_account/");
        die();
        
        }
    }

    /*ACTION LOGIN*/

    if (isset($_POST['submit-login'])) {
        $username = $_POST['username-log'] ?? '';
        $password = $_POST['password-log'] ?? '';
        
    
    if (empty($username) || empty($password)) {
        echo '<script type="text/javascript">
        document.getElementById("failed").style.display = "block";
        </script>';
        die();
    } else {
        $query = "
            SELECT id,username, password,activation_code
            FROM users
            WHERE username = :username
        ";
        
        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->execute();
        
        
        $user = $check->fetch(PDO::FETCH_ASSOC);
        
        $activation_code = $user['activation_code'];

        if ($activation_code !== 'activated') {
            $active = false;
        } else {
            $active = true;
        }
        
        if (!$user || password_verify($password, $user['password']) === false) {
            echo '<script type="text/javascript">
        document.getElementById("failed").style.display = "block";
        </script>';
        die();
        } else {
            $_SESSION['session_id'] = session_id();
            $userToken = bin2hex(openssl_random_pseudo_bytes(24));
            //assign the token to a session variable.
            $_SESSION['user_token'] = $userToken;
            $_SESSION['session_user'] = $user['id'];
            $_SESSION['session_username'] = $user['username'];
            $_SESSION['session_email'] = $user['email'];
            $_SESSION['active'] = $active;
            header('location: ../my_account/');
            die();
        }
    }
    
    }

function createDir($userName,$id) {
    $filename = "../users/".$userName."/";
    mkdir($filename,0700);
    if (!$fp = fopen("../users/".$userName."/index.php", "w+")) {
        exit;
    }
    $testo = '<?php $user = '.$id.'; require_once("../user.php"); ?>';

    if (fwrite($fp,$testo) === FALSE) {
    exit;
    }
    fclose($fp);
}

function sendMail($emailX,$codeX,$usernameX) {
    error_reporting(E_ALL);
    
    // Genera un boundary
    $mail_boundary = "=_NextPart_" . md5(uniqid(time()));
    
    $to = $emailX;
    $subject = "Attivazione account";
    $sender = "BiblionTech < postmaster@bibliontech.it >";
    
    
    $headers = "From: $sender\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/alternative;\n\tboundary=\"$mail_boundary\"\n";
    $headers .= "X-Mailer: PHP " . phpversion();
    $activate_link = "https://bibliontech.it/activate_account/?email=".$emailX."&code=".$codeX;
     
    // Corpi del messaggio nei due formati testo e HTML
    $text_msg = "messaggio in formato testo";
    $html_msg = "<b>messaggio</b> in formato <p><a href='http://www.aruba.it'>html</a><br><img src=\"http://hosting.aruba.it/image_top/top_01.gif\" border=\"0\"></p>";
     
    // Costruisci il corpo del messaggio da inviare
    $msg = "This is a multi-part message in MIME format.\n\n";
    $msg .= "--$mail_boundary\n";
    $msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
    $msg .= "Content-Transfer-Encoding: 8bit\n\n";
    $msg .= "Benvenuto in BiblionTech! Clicca sul seguente link per attivare il tuo account: ".$activate_link;  // aggiungi il messaggio in formato text
     
    $msg .= "\n--$mail_boundary\n";
    $msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
    $msg .= "Content-Transfer-Encoding: 8bit\n\n";
    
    
    
    
    $msg .= '<section style="margin-top: 100px;
            margin-bottom: 50px;
            display: flex;
            justify-content: center;
            text-align: center;
            min-height: 90vh;">
                <div style="display: flex;
            justify-content: center;
            align-items: center;
            text-align: center; width: 100%;
            padding-right: var(--bs-gutter-x, .75rem);
            padding-left: var(--bs-gutter-x, .75rem);
            margin-right: auto;
            margin-left: auto;">
                        
                        <div>
                            <h1 style="font-weight: bold;
                            font-size: 30px;" >Benvenuto in <strong style="font-size: 30px;padding: 0; 
                            font-weight: 600;
                            font-size: calc(3rem + 1.5vw);
                            padding: 20px;
                            line-height: 100%;
                            letter-spacing: -2px;
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            animation: gradient 10s ease-in-out infinite;
                            -moz-animation: gradient 10s ease-in-out infinite;
                            -webkit-animation: gradient 10s ease-in-out infinite;">
                            BiblionTech</strong>&nbsp;<strong>'.$usernameX.'</strong>!
                            </h1>
                            
                            <span>Per continuare con la registrazione ed accedere ai nostri servizi, conferma la tua identità!<br></span>
                
                            <a href="'.$activate_link.'">
                            
                            <button  type="button" style="font-size: 15px; border-radius: 10rem;
                            background-color: #0b0a07;
                            color: #ffffff;
                            font-size: 15px;
                            font-weight: bold;
                            padding: 12px 45px;
                            margin: 20px 20px 0 20px; box-shadow: none!important; cursor: pointer;">
                            Conferma
                            </button>
                            
                            </a>
                        
                        </div>
                    
                    </div>
            
            
            </section>';
    
    
    
    
    
    
    
    
    
    
    //$msg .= "<h2>Benvenuto in BiblionTech!</h2> <p>Clicca sul seguente link per attivare il tuo account: <a href='".$activate_link."'>$activate_link</a></p>";  // aggiungi il messaggio in formato HTML
     
    // Boundary di terminazione multipart/alternative
    $msg .= "\n--$mail_boundary--\n";
     
    // Imposta il Return-Path (funziona solo su hosting Windows)
    ini_set("sendmail_from", $sender);
     
    // Invia il messaggio, il quinto parametro "-f$sender" imposta il Return-Path su hosting Linux
    if (mail($to, $subject, $msg, $headers, "-f$sender")) { 
        echo "Mail inviata correttamente!<br><br>Questo di seguito è il codice sorgente usato per l'invio della mail:<br><br>";
        return true;
    } else { 
        echo "<br><br>Recapito e-Mail fallito!";
        return false;
    }
}

?>