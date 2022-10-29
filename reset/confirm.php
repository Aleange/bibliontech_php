<?php
require_once('../includes/session.php');
if (isset($_SESSION['user_token'])) {
    header('location: ../login/logout.php?token='.$_SESSION['user_token']);
    die();
} else {
    require_once('../includes/functions.php');
}
if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"] === "reset")) {
    $curDate = date("Y-m-d H:i:s");
    $key = clean_data($_GET["key"]);
    $email = clean_data($_GET["email"]);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    } else {
        header('location: ../index.php');
        die();
    }
    $query = "
            SELECT * 
            FROM `password_reset_temp` 
            WHERE `chiave`=:key AND `email`=:email
            ";
    $check = $pdo->prepare($query);
    $check->bindParam(':key', $key, PDO::PARAM_STR);
    $check->bindParam(':email', $email, PDO::PARAM_STR);
    $check->execute();

    $row = $check->rowCount();
    if ($row === 0) {
        header('location: ../index.php');
        die();
    } else {
        $row = $check->fetch();
        $expDate = $row['expDate'];
        if ($expDate < $curDate) {
            header('location: ../index.php');
            die();
        }
    }
} else {
    header('location: ../index.php');
    die();
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
                    <div id="pw-request">

                        <!--FORM CONFERMA PASSWORD-->
                        <form class="form-cont" action="reset.php" method="post" onsubmit="return confirmPassword();">
                            <div class="form-text">
                                <h1>Reset password</h1>
                                <span>Ciao&nbsp;<span id="username">
                                        <strong><?php echo $email; ?></strong></span>,<br>inserisci una nuova
                                    password</span>
                                <span id="not-equals" style="color:red;display:none;">Le password non coincidono</span>
                            </div>

                            <input class="form-control" type="password" id="password-reg" name="password0"
                                placeholder="Password" required="true">

                            <input class="form-control" type="password" name="password1" id="password-reg1"
                                placeholder="Conferma password" required="true">

                            <input hidden name="email" value="<?php echo $email;?>" required="true" type="email"
                                id="email-reg">
                            <button class="btn form-button shadow-none click" type="submit"
                                name="confirm">Conferma</button>
                        </form>

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
    <script>
    function confirmPassword() {
        password0 = document.getElementById('password-reg').value;
        password1 = document.getElementById('password-reg1').value;
        email = document.getElementById('email-reg').value;

        pattern = /^[a-zA-Z0-9\_\*\-\+\!\?\,\:\;\.\xE0\xE8\xE9\xF9\xF2\xEC\x27]{8,20}/;
        if (!pattern.test(password0) || !pattern.test(password1)) {
            return false;
        }

        if (password0 !== password1) {
            document.getElementById('not-equals').style.display = 'block';
            return false;
        }

        pattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!email || !pattern.test(email)) {
            return false;
        }
        return true;
    }
    </script>
</body>

</html>