<?php 
require_once('../includes/session.php');
require_once('../includes/functions.php');

if (isset($_POST['confirm'])) {
    $password = clean_data($_POST['password0']);
    $password1 = clean_data($_POST['password1']);
    if ($password !== $password1) {
        header('location: ../index.php');
        die();
    }
    $password_hash = password_hash($password,PASSWORD_DEFAULT);    
    $email = clean_data($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>document.getElementById('failed').style.display = 'block';</script>";
        return;
    }
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $query = "
        UPDATE users 
        SET password = :password
        WHERE email = :email
        ";
        
    $check = $pdo->prepare($query);
    $check->bindParam(':password', $password_hash, PDO::PARAM_STR);
    $check->bindParam(':email', $email, PDO::PARAM_STR);
    $ok = $check->execute();
    
    
    if (!$ok) {  
        header("Location: ../index.php");
        die();
    }
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

                    <!--CONFERMA CAMBIO PASSWORD-->
                    <div id="pw-msg" class="form-cont">
                        <h1>Reset password</h1>
                        <span>La tua password è cambiata.<br>
                            Effettua il login.</span>
                        <div>
                            <a href="../login/"><button class="btn form-button click shadow-none"
                                    type="button">Login</button></a>
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